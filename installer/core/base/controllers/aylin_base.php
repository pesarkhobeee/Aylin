<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aylin_base extends CI_Controller {

	public function __construct()
	{
	            parent::__construct();
	            // Your own constructor code
	            $this->load->helper(array('form', 'url'));
	     
	}

	public function config(){

		$this->aylin->login_check();
		if(!$this->aylin->acl_check($this->uri->segment(1)))
			redirect('/users/login', 'refresh');
		
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
		
		$this->aylin->login_check();
		if(!$this->aylin->acl_check($this->uri->segment(1)))
			redirect('/users/login', 'refresh');
		
		$this->load->view('admin_them/header');
		$this->load->view('aylin/upload_form', array('error' => ' ' ));
		$this->load->view('admin_them/footer');
	}
	
	
	function do_upload()
	{

		$this->aylin->login_check();
		if(!$this->aylin->acl_check($this->uri->segment(1)))
			redirect('/users/login', 'refresh');
		
		
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



	public function backup_dl(){
		
		$this->aylin->login_check();
		if(!$this->aylin->acl_check($this->uri->segment(1)))
			redirect('/users/login', 'refresh');
	
		$filename = "./assets/backup/".date("Y-m-d_H:i:s").'.gz';
		
		// Load the DB utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup();

		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file($filename, $backup);

		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download($filename, $backup); 
	}
	
	public function backup_mail()
	{
		$filename = "./assets/backup/".date("Y-m-d_H:i:s").'.gz';
		
		// Load the DB utility class
		$this->load->dbutil();

		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup();

		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file($filename, $backup);

		
		
		$content ="<p style='direction:rtl'>";
		$content .= "Backup UP :" . $filename;
		$content .="</p>";
		

		$to = $this->aylin->config("backup_mail","config_mail");
		
		$this->aylin->send_mail("پشتیبان گیری خودکار",$content,$to,"normal",$filename);
		
		delete_files("./assets/backup/");
		
	}
	
	

	
}

