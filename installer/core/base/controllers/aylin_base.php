<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aylin_base extends CI_Controller {

	public function __construct()
	{
	            parent::__construct();
	            // Your own constructor code
	            $this->load->helper(array('form', 'url'));
	           
	            $this->aylin->login_check();
						if(!$this->aylin->acl_check($this->uri->segment(1)))
							redirect('/users/login', 'refresh');
	}

	public function config(){
		$key=true;
		if(isset($_POST["group"])){
			for($i=0;$i<count($_POST["group"]);$i++)
			{
		
				$tmp_array = array("value"=>$_POST["value"][$i]);
				
				$this->db->where('group', $_POST["group"][$i]);
				$this->db->where('name', $_POST["name"][$i]);
				
				if(!$this->db->update('meta_data', $tmp_array)){
					$data["massege"]=" <div class='fade in alert alert-error'>
						               <a data-dismiss='alert' class='close'><i class='icon-remove'></i></a>
						                 <strong>Sorry!</strong> Operation Failed.
					                      </div>";
					$key=false;
				}
			}

			if($key==true)
			{
					$data["massege"]="<div class='fade in alert alert-success'>
					<a data-dismiss='alert' class='close'><i class='icon-remove'></i></a>
					<strong>Well done!</strong> Field Successfully Updated</div>";
			}

		}
		
		
		$this->db->like('group', 'config', 'after'); 
		$this->db->select('group');
		$this->db->distinct();
		$data["groups"]= $this->db->get('meta_data');
		
		
		$this->load->view('admin_them/header');
		$this->load->view('aylin/config',$data);
		$this->load->view('admin_them/footer');
	}
	
	
		function upload()
	{
		$this->load->view('admin_them/header');
		$this->load->view('aylin/upload_form', array('error' => ' ' ));
		$this->load->view('admin_them/footer');
	}
	
	
		function do_upload()
	{
		$config['upload_path'] = './assets/uploads/';
		$config['allowed_types'] = 'gif|jpg|png|pdf|zip';
		//$config['max_size']	= '100';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$this->load->view('admin_them/header');
			$this->load->view('aylin/upload_form', $error);
			$this->load->view('admin_them/footer');
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$this->load->view('admin_them/header');
			$this->load->view('aylin/upload_success', $data);
			$this->load->view('admin_them/footer');
		}
	}

	public function send_mail($subject , $content , $to)
	{
		

    
  
		
    	$this->load->library('email');
    	$this->load->helper('file');
	$string = read_file('./assets/others/signature.html');
	$content.="<br><br>".$string;
	
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = $this->aylin->config("smtp_host","config_mail");
        $config['smtp_port']    = $this->aylin->config("smtp_port","config_mail");
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = $this->aylin->config("smtp_user","config_mail");
        $config['smtp_pass']    = $this->aylin->config("smtp_pass","config_mail");
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      

        $this->email->initialize($config);

        $this->email->from($this->aylin->config("smtp_mail","config_mail"), $subject );
        $this->email->to($to); 

        $this->email->subject('ContactUs');
        $this->email->message($content);  

        if($this->email->send())
			return true;
		else
			return false;

       //echo $this->email->print_debugger();


	}
	
}

