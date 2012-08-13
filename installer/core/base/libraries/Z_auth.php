<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Z_auth {
	
	function login_check(){
		$CI =& get_instance();
		$CI->load->library('session');
		if($CI->session->userdata('user_group')==""){
			redirect('/welcome/login', 'refresh');
		}
	}
		
	function acl_check($pagename_or_groupname)
	{
		$CI =& get_instance();
		$CI->load->library('session');
		$CI->load->database();
		$CI->db->from('meta_data');
		//$CI->db->where('name', $pagename_or_groupname);
		//$CI->db->where('value', $CI->session->userdata('user_group'));
		//$CI->db->or_where('value','*');
		$CI->db->where('group', 'acl');
		$where = "name ='".$pagename_or_groupname."' AND value='".$CI->session->userdata('user_group')."' OR name ='".$pagename_or_groupname."' AND  value='*'";
		$CI->db->where($where);
		$CI->db->where('group', 'acl');
		$query= $CI->db->get();
		// echo $CI->db->last_query();
		 
		if($query->num_rows()==1){		
			return true;
		}else{
			return false;
		}
	}

	function login($username,$password)
	{
			$CI =& get_instance();
			$CI->load->database();
			$CI->db->from('users');
			$CI->db->where('username', $username);
			$CI->db->where('password', md5($password));
			$query= $CI->db->get();
			if($query->num_rows()==1){
				
				$row = $query->row();
				$CI->load->library('session');
				$newdata = array(
					   'id'     => $row->id,
					   'username'  => $row->username,
					   'user_group' => $row->user_group
				   );
				$CI->session->set_userdata($newdata);

				return true;
			}else{
				return false;
			}
		
	}
/* End of file Z_auth.php */
}
