<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {
	
public function __construct()
       {
            parent::__construct();
            // Your own constructor code
            $this->load->library('Z_auth');
            $this->z_auth->login_check();
					if(!$this->z_auth->acl_check($this->uri->segment(1)))
						redirect('/welcome/login', 'refresh');

       }
	
public function index(){
    $this->load->library('grocery_CRUD');	
    $crud = new grocery_CRUD();
    $crud->set_table('menu')
    ->set_subject('menu')
    ->display_as('menu_name','نام منو')
    ->display_as('menu_url','آدرس منو')
    ->display_as('menu_section','قسمت');
    
    $output = $crud->render();
    
    	$this->load->view('admin_them/header');
    	$this->load->view('crud',$output);
    	$this->load->view('admin_them/footer');
}



}
