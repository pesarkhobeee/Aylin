<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	  
	public function index($pagename="Home"){
		$this->db->where('content_title', $pagename);
		$data["contents"]= $this->db->get('content');
		$key="";
		foreach($data["contents"]->result() as $tmp){
			$key .= $tmp->content_tag;
		}
			$header["meta"] = "<meta name='keywords' content='".$key."' >";
			$this->load->view('header',$header);
			$this->load->view('welcome/show',$data);
			$this->load->view('footer');	
		
	}
	
	
	
	public function publicuser(){
		$this->load->view('header');
		$this->load->view('public_page');
		$this->load->view('footer');	
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
	


    function send_contact()
    {

		if($_POST["6_letters_code"]=="10")
		{
			$content="";
			unset($_POST["6_letters_code"]);
			unset($_POST["submit"]);
			foreach($_POST as $item=>$val)
			{
				$content.="<fieldset>
				<legend>$item</legend>$val</fieldset>";
			}
			$data["msg"]="کاربر گرامی پیغام شما با موفقیت ارسال گردید";
		}
		else
		{
			$data["msg"]="شما پاسخ اشتباه به سوال امنیتی داده اید. خواهشا دوباره سعی کنید";
		}
		
		$this->load->view('header');
		 $this->load->view('contactus',$data);
		$this->load->view('footer');
      
       
    }
}

	
	


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
