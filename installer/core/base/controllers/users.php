<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class users extends CI_Controller {

	public function __construct()
       {
      
            parent::__construct();
                   // Your own constructor code
            $this->load->library('Z_auth');
            $this->z_auth->login_check();
					if(!$this->z_auth->acl_check($this->uri->segment(1)))
						redirect('/users/login', 'refresh');
						
			$this->load->helper('form');

       }
       
  

	public function show_user($user_id){
	
	
		$this->db->select('*');
		$this->db->from('customer_detail');
		$this->db->join('users', 'customer_detail.cd_users_id = users.id'); 
		$this->db->where('cd_id', $user_id);
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
		
		
		if(isset($_POST["username"])){
			
			$_POST["password"]=md5($_POST["password"]);
			if($this->db->insert('users', $_POST))
				$data['massege'] = 'New User Successfully Added';
		}
		
		
		
		if($this->uri->segment(3)!=""){
			if($this->db->delete('users', array('id' => $this->uri->segment(4))))
				$data['massege'] = 'User Successfully Deleted';
		}

		$data['query_users'] = $this->db->get("users");
		$this->load->view('admin_them/header');
		$this->load->view('/users/users',$data);
		$this->load->view('admin_them/footer');
	}

	
	function logout(){
		$this->session->sess_destroy();
		redirect('/welcome/login/', 'refresh');
	}

}
