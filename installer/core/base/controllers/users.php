<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users extends CI_Controller {

	public function __construct()
       {
      
            parent::__construct();
                   // Your own constructor code
						
			$this->load->helper('form');

       }
       
  public function auth($groupname=NULL){
	        $this->load->library('Z_auth');
            $this->z_auth->login_check();
            if($groupname===NULL)
            {
				if(!$this->z_auth->acl_check($this->uri->segment(1)))
					redirect('/users/login', 'refresh');
			}
			else
			{
				if(!$this->z_auth->acl_check($groupname))
					redirect('/users/login', 'refresh');
			}
  }

	public function show_user($user_id){
	
		$this->auth("users_root");
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
		$this->load->library('Z_auth');
		$this->z_auth->login_check();
		
	}
	
	function customer_detail(){
		$this->auth();
		
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
	$this->auth();	
	if($this->session->userdata('user_group')=="root")
	{
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
				$data['massege'] = 'Password and Re Pasword do not match';
			}
		}
		
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
				$data['massege'] = 'نام کاربری وارد شده قبلا ثبت شده است';
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
	$this->auth("users_root");	

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
	$this->auth("users_root");	
		
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
	if($this->aylin_config->config("users_register","config_site")==1)
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
	if($this->aylin_config->config("users_register","config_site")==1)
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
					$user=array("username"=>$_POST["username"],"password"=>$_POST["password"],"user_group"=>"user");
					if($this->db->insert('users', $user))
					{
						$data['massege'] = 'ثبت نام شما با موفقیت به پایان رسید';
						$to=$_POST["username"];
						unset($_POST["username"]);
						unset($_POST["password"]);
						unset($_POST["re_password"]);
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
							if(!$this->aylin_config->send_mail("فعال سازی",$content,$to))
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
		
		$this->load->view('header');
		$this->load->view('users/register_finish',$data);
		$this->load->view('footer');
	}
}
	
	public function register(){
		if($this->aylin_config->config("users_register","config_site")==1)
		{
			$this->load->helper('form');
			$this->load->view('header');
			$this->load->view('users/register');
			$this->load->view('footer');
		}
	}
	
	
	
	
	
	function logout(){
		$this->session->sess_destroy();
		redirect('/welcome/login/', 'refresh');
	}

}
