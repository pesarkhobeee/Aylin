<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
	
public function __construct()
       {
            parent::__construct();
            // Your own constructor code
           
            $this->aylin->login_check();
					if(!$this->aylin->acl_check($this->uri->segment(1)))
						redirect('/welcome/login', 'refresh');

       }
	
public function index(){
	
		if($this->uri->segment(3)!="")
			if($this->db->delete('menu', array('menu_id' => $this->uri->segment(3))))
				$data['massege'] = 'menu Successfully Deleted';
		
		if(isset($_POST["parent"]))	
			if($_POST["parent"]=="NULL")
				$_POST["parent"]=NULL;
			
		if(isset($_POST["menu_id"])){
	
		$data = array(
               	'menu_name' => $_POST["menu_name"],
               	'menu_url' => $_POST["menu_url"],
               	'menu_section' => $_POST["menu_section"],
               	'parent' => $_POST["parent"]
            	);

		$this->db->where('menu_id', $_POST["menu_id"]);
		$this->db->update('menu', $data); 
		$data['massege'] = 'Menu Successfully Updated';
		
		}elseif(isset($_POST["menu_name"])){
			
			if($this->db->insert('menu', $_POST))
				$data['massege'] = 'New Menu Successfully Added';
		}
		 
		$data['query']  = $this->db->get("menu_display");

		
    	$this->load->view('admin_them/header');
    	$this->load->view('menu/index',$data);
    	$this->load->view('admin_them/footer');
}

public function add(){
		$this->load->helper('form');
		$this->db->select('menu_id,menu_name');
		$data['query']  = $this->db->get("menu");
		$data['query_groups'] = $this->db->get("users_groups");
				
		$this->load->view('admin_them/header');
    	$this->load->view('menu/add',$data);
    	$this->load->view('admin_them/footer');
}

public function edit($id){
		$this->load->helper('form');
		$data['query_groups'] = $this->db->get("users_groups");
		$this->db->where('menu_id', $id); 
		$data['query']  = $this->db->get("menu");
		$this->db->select('menu_id,menu_name');
		$data['parents']  = $this->db->get("menu");
		$this->load->view('admin_them/header');
		$this->load->view('menu/edit', $data);
		$this->load->view('admin_them/footer');
}

}
