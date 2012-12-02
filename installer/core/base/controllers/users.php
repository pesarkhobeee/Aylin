<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users extends CI_Controller {

	public function __construct()
       {
      
            parent::__construct();
                   // Your own constructor code
						
			$this->load->helper('form');

       }
  
  	function login(){
		$this->load->helper('form');
		$data["msg"]="";
		
		if(isset($_POST["username"])){
				if($this->aylin->login($_POST["username"],$_POST["password"])){
					redirect('/users/show_users', 'refresh');
				}else{
					$data["msg"]="Username Or Password is Wrong";
				}
		}
		
		$this->load->view('admin_them/header');
		$this->load->view('admin_them/login',$data);
		$this->load->view('admin_them/footer');
		
	}
  

	public function show_user($user_id){
		
		$this->aylin->login_check();
		if(!$this->aylin->acl_check("users"))
			redirect('/users/login', 'refresh');
						
		
		$this->db->select('*');
		$this->db->from('customer_detail');
		$this->db->join('users', 'customer_detail.cd_users_id = users.id'); 
		$this->db->where('id', $user_id);
		$data["query"] = $this->db->get();
		$this->load->view('admin_them/header');
		$this->load->view('/users/show_user',$data);
		$this->load->view('admin_them/footer');
	}

	
	function index(){
		$this->load->library('aylin');
		$this->aylin->login_check();
		
	}
	
	function customer_detail(){
		
		$this->aylin->login_check();
		if(!$this->aylin->acl_check("users"))
			redirect('/users/login', 'refresh');
		
		if(isset($_POST["cd_name"])){
			
			if($this->db->insert('customer_detail', $_POST))
				$data['massege'] = 'New User Detail Successfully Added';
		}
		
		if($this->uri->segment(3)!=""){
			if($this->db->delete('customer_detail', array('cd_id' => $this->uri->segment(4))))
				$data['massege'] = 'User Detail Successfully Deleted';
		}
		
		
		$query = $this->db->get('users');
		foreach ($query->result() as $row)
			{
	   		$userlist[$row->username] = $row->id;
			}
		$data["userlist"]=$userlist;

		$this->db->select('*');
		$this->db->from('customer_detail');
		$this->db->join('users', 'customer_detail.cd_users_id = users.id');
		//$this->db->where('done', 0);
		//$this->db->where('todo_list.users_id', $this->session->userdata("id"));
		//$this->db->order_by("id", "desc"); 

		$data['query_customer_detail'] = $this->db->get();
		$this->load->view('admin_them/header');
		$this->load->view('/users/customer_detail',$data);
		$this->load->view('admin_them/footer');
	}

	function show_users(){
		
	$this->aylin->login_check();
	if(!$this->aylin->acl_check("users"))
		redirect('/users/login', 'refresh');	
		

		if(isset($_POST["re_password"]))
		{
			if($_POST["re_password"]==$_POST["password"])
			{
				$data = array(
				   'password' => MD5($_POST["password"]),
				);
				$this->db->where('id', $_POST["userid"]);
				$this->db->update('users', $data); 
				$data['massege'] = 'Password Successfully Chenged';
			}else{
				$data['alert'] = 'Password and Re Pasword do not match';
			}
		}

	if($this->session->userdata('user_group')=="root")
	{		
		if(isset($_POST["username"])){
			$this->db->from('users');
			$this->db->where('username', $_POST["username"]);
			$query= $this->db->get();
			if($query->num_rows()==0)
			{
				$_POST["password"]=md5($_POST["password"]);
				if($this->db->insert('users', $_POST))
					$data['massege'] = 'New User Successfully Added';
			}
			else
			{
				$data['alert'] = 'نام کاربری وارد شده قبلا ثبت شده است';
			}
		}
		
		
		
		if($this->uri->segment(3)!=""){
			if($this->uri->segment(3)=="duser")
				if($this->db->delete('users', array('id' => $this->uri->segment(4))))
					$data['massege'] = 'User Successfully Deleted';
					
			if($this->uri->segment(3)=="active")
			{
				$this->db->where("id",$this->uri->segment(4));				
				if($this->db->update('users', array("active"=>1)))
					$data['massege'] = 'User Successfully Actived';	
			}
			
			if($this->uri->segment(3)=="diactive")
			{
				$this->db->where("id",$this->uri->segment(4));				
				if($this->db->update('users', array("active"=>0)))
					$data['massege'] = 'User Successfully Disabled';	
			}
										
		}
	}
		if($this->session->userdata('user_group')!="root")
		{
			$this->db->where('id', $this->session->userdata('id'));
		}
		$data['query_users'] = $this->db->get("users");
		$data['query_groups'] = $this->db->get("users_groups");
		
		$this->load->view('admin_them/header');
		$this->load->view('/users/users',$data);
		$this->load->view('admin_them/footer');
	}

	function groups(){
	
		$this->aylin->login_check();
		if(!$this->aylin->acl_check("users_root"))
			redirect('/users/login', 'refresh');
			
		if(isset($_POST["g_id"])){
				$this->db->where('g_id', $_POST["g_id"]);
				$this->db->update('users_groups', $_POST);
					$data['massege'] = 'Group Successfully Updated';
		}elseif(isset($_POST["g_name"])){
				if($this->db->insert('users_groups', $_POST))
					$data['massege'] = 'New Group Successfully Added';
		}
		
		if($this->uri->segment(3)!="")
			if($this->uri->segment(3)=="d")
				if($this->db->delete('users_groups', array('g_id' => $this->uri->segment(4))))
					$data['massege'] = 'Group Successfully Deleted';
		
				
		$data['query_users'] = $this->db->get("users_groups");
		$this->load->view('admin_them/header');
		$this->load->view('/users/groups',$data);
		$this->load->view('admin_them/footer');
	}
	
	function acl(){	
	
	$this->aylin->login_check();
	if(!$this->aylin->acl_check("users_root"))
		redirect('/users/login', 'refresh');	
		
		if(isset($_POST["id"])){
				$this->db->where('id', $_POST["id"]);
				$this->db->where('group','acl');
				$this->db->update('meta_data', $_POST);
					$data['massege'] = 'ACL Successfully Updated';
		}elseif(isset($_POST["name"])){
				$_POST["group"]="acl";
				if($this->db->insert('meta_data', $_POST))
					$data['massege'] = 'New ACL Successfully Added';
		}
		
		
		if($this->uri->segment(3)!="")
			if($this->uri->segment(3)=="d")
				if($this->db->delete('meta_data', array('id' => $this->uri->segment(4))))
					$data['massege'] = 'ACL Successfully Deleted';
		
		$this->db->where('group','acl');		
		$data['query'] = $this->db->get("meta_data");
		$this->load->view('admin_them/header');
		$this->load->view('/users/acl',$data);
		$this->load->view('admin_them/footer');
	}
	
	
public function register_active($id){	
	if($this->aylin->config("users_register","config_site")==1)
	{
			if($this->uri->segment(3)!="")
			{
				$this->db->where("id",$id);				
				if($this->db->update('users', array("active"=>1)))
				{
					$data['massege'] = 'کاربر گرامی حساب شما با موفقیت فعال شد<br>';	
							$this->load->view('header');
							$this->load->view('users/register_active',$data);
							$this->load->view('footer');
				}
			}
	}
}

public function register_finish(){
	if($this->aylin->config("users_register","config_site")==1)
	{

if(strtolower($_POST["captcha_word"])==strtolower($this->session->userdata('captcha_word')))
{
		if(isset($_POST["username"]))
		{
			
			
			$this->db->from('users');
			$this->db->where('username', $_POST["username"]);
			$query= $this->db->get();
			if($query->num_rows()==0)
			{
					
				if($_POST["password"]==$_POST["re_password"])
				{	
					$_POST["password"]=md5($_POST["password"]);
					$user=array("username"=>$_POST["username"],"password"=>$_POST["password"],"user_group"=>"public");
					if($this->db->insert('users', $user))
					{
						$data['massege'] = 'ثبت نام شما با موفقیت به پایان رسید';
						$to=$_POST["username"];
						unset($_POST["username"]);
						unset($_POST["password"]);
						unset($_POST["re_password"]);
						unset($_POST["captcha_word"]);
						$_POST['cd_users_id'] = $this->db->insert_id();
						if(!$this->db->insert('customer_detail', $_POST))
						{
							$data['error'] = 'متاسفانه ثبت نام شما کامل انجام نشد';
						}
						else
						{
							$content="<div style='direction:rtl;text-align:center;'>
								<p>ثبت نام شما با موفقیت به پایان رسیده است، برای فعال سازی اکانت خود لطفا بر روی لینک زیر کلیک کنید.</p>
								<a href='".base_url()."index.php/users/register_active/".$_POST['cd_users_id']."'>Active Your Account</a>
							</div>";
							if(!$this->aylin->send_mail("فعال سازی",$content,$to))
							{
								$data['error'] ="متاسفانه در ارسال ایمیل فعال سازی با مشکل مواجح شدیم، با مدیر سایت تماس بگیرین";
							}
						}
					}
				}
				else
				{
					$data['error'] = 'کلمه عبور های وارد شده با هم همخوانی ندارمد';
				}
			}
			else
			{
				$data['error'] = 'نام کاربری وارد شده قبلا ثبت شده است';
			}
		}
}
else
{
				$data['error'] = 'کد تصویر وارد شده صحیح نمیباشد';
}		
		$this->load->view('header');
		$this->load->view('users/register_finish',$data);
		$this->load->view('footer');
	}

}
	
	public function register(){
		if($this->aylin->config("users_register","config_site")==1)
		{
		$this->load->helper('captcha');
		$vals = array(
		    'img_path' => './assets/captcha/',
		    'img_url' => base_url('/assets/captcha/')."/",
		    'img_width' => '150',
		    'img_height' => 30
		    );

		$cap = create_captcha($vals);
		$this->session->set_userdata(array('captcha_word' => $cap['word']));
			

			$this->load->helper('form');
			$this->load->view('header');
			$this->load->view('users/register',$cap);
			$this->load->view('footer');
		}
	}
	
	
	public function remember_password()
	{
			$this->load->helper('form');
			$this->load->view('header');
			$this->load->view('users/remember_password');
			$this->load->view('footer');				
	}
	
	private function  GenerateKey($random_string_length = 16) {
		
		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
		 $string = '';
		 for ($i = 0; $i < $random_string_length; $i++) {
		      $string .= $characters[rand(0, strlen($characters) - 1)];
		 }

		return $string;
	}
	
	public function remember_password_submit()
	{
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('mail', 'Email', 'trim|required|valid_email');
		if ($this->form_validation->run() == FALSE)
		{
			$data["alert"]="متاسفانه در روند بازیابی پسورد شما مشکلی پیش آمد، خواهشا با مدیر سایت تماس بگیرید";
		}
		else
		{
			$random_str = $this->GenerateKey();
			$to = $this->input->post("mail");
			$subject="بازیابی رمز عبور";
			
			$data = array(
			   'urp_emil' => $to ,
			   'urp_random_string' => $random_str
			);

			if($this->db->insert('users_remember_password', $data))
			{
				$content="<p>برای بازیابی رمز خود بر روی لینک زیر کلیک کنید<br><a href='".base_url("index.php/users/remember_password_action/".$random_str)."'>بازیابی رمز عبور</a></p>";
				$this->aylin->send_mail($subject,$content,$to);
				$data["msg"]="لطفا پست الکترونیکی خود را چک کنید";
			}
			else
			{
				$data["alert"]="متاسفانه در روند بازیابی پسورد شما مشکلی پیش آمد، خواهشا با مدیر سایت تماس بگیرید";
			}
		}
		
		
			
			$this->load->helper('form');
			$this->load->view('header');
			$this->load->view('users/remember_password',$data);
			$this->load->view('footer');				
	}	
	
	public function remember_password_action($random_str="")
	{
		if($random_str=="")
			$data["alert"]="دسترسی مستقیم به این صفحه بی معنی است!";
		
		$random_str2 = $this->GenerateKey();
		
		$this->db->from("users_remember_password");
		$this->db->where('urp_random_string', $random_str);
		$query= $this->db->get();	
		$row = $query->row();
		$to = $row->urp_emil; 
		
		
		
		
		$subject="رمز عبور جدید";
		
		$data = array('password' => md5($random_str2));	
		$this->db->where('username', $to);

		if($this->db->update('users', $data))
		{
			$content="<p><br>رمز عبور جدید<br>".$random_str2."</p>";
			$this->aylin->send_mail($subject,$content,$to);
			$data["msg"]="لطفا پست الکترونیکی خود را چک کنید";
			$this->db->delete('users_remember_password', array('urp_emil' => $to));

		}
		else
		{
			$data["alert"]="متاسفانه در روند بازیابی پسورد شما مشکلی پیش آمد، خواهشا با مدیر سایت تماس بگیرید";
		}
		
	
		$this->load->helper('form');
		$this->load->view('header');
		$this->load->view('users/remember_password',$data);
		$this->load->view('footer');	
	}
	
	
	function logout(){
		$this->session->sess_destroy();
		redirect('/welcome/login/', 'refresh');
	}

}
