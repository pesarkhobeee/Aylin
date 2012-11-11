<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class aylin{


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




	function config($name,$group){
		$CI =& get_instance();
		$CI->load->database();
		$CI->db->where('group', $group); 
		$CI->db->where('name', $name); 
		$query = $CI->db->get("meta_data");
		return $query->row("value");
	}
	
	public function get_menu_list($menu_section,$uri_arr=NULL,$parent=NULL) {
		
		$CI =& get_instance();
		$CI->load->helper('url');
		$CI->load->database();
		
		if($parent===NULL)
			$query = $CI->db->query('SELECT * FROM  menu WHERE menu_section="'.$menu_section.'" AND  parent IS NULL');
		else
			$query = $CI->db->query('SELECT * FROM  menu WHERE menu_section="'.$menu_section.'" AND parent = '.$parent);
		
		
		$items = array();	
		foreach ($query->result() as $row)
		{
			if($row->menu_url==$uri_arr)
				$items[] = '<li class="active">'.anchor($row->menu_url,$row->menu_name).$this->get_menu_list($menu_section,$uri_arr,$row->menu_id).'</li>';
			else
				$items[] = '<li>'.anchor($row->menu_url,$row->menu_name).$this->get_menu_list($menu_section,$uri_arr,$row->menu_id).'</li>';
		}
		
		
		
		if(count($items)) {
			return '<ul class="child">'.implode('', $items).'</ul>';
		} else {
			return '';
		}
	
	}
	
	function create_tables_menu($active_item = -1){
		
		$CI =& get_instance();
		$CI->load->model('roozbehmodel','roozbeh', TRUE);
 


		$items = "\n";
		$class = NULL;
		$items .= '<li><a href="#">
		جداول
		</a>
		<ul class="child">';
		
		$items .= '<li>'.anchor('roozbeh/tables_settings','<span>تنظیمات</span>',
								(($class) ? array('class'=>$class):'')).'</li>';
								
		/* Insert Name of tables */
		foreach ($CI->roozbeh->get_tables_list() as $table){
			if(!$CI->roozbeh->get_table_view_permission($table))
				continue;
			
			$id = $CI->roozbeh->register_tables_menu_item($table);
			if($id == $active_item)
				$class = 'active';

			$items .= '<li>'.anchor('roozbeh/view_table/'.$id,
							'<span>'.$CI->roozbeh->get_table_label($table,$table).'</span>',
							(($class) ? array('class'=>$class):'')).'</li>';
			$class = NULL;
		}
		

		$items .= '</ul></li>';

		return $items;
	}
	
	
	public function send_mail($subject , $content , $to ,$send_mode="normal")
	{

  $CI =& get_instance();
		
    	$CI->load->library('email');
    	$CI->load->helper('file');
	$string = read_file('./assets/others/signature.html');
	$content.="<br><br>".$string;
	
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = $CI->aylin->config("smtp_host","config_mail");
        $config['smtp_port']    = $CI->aylin->config("smtp_port","config_mail");
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = $CI->aylin->config("smtp_user","config_mail");
        $config['smtp_pass']    = $CI->aylin->config("smtp_pass","config_mail");
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not      


		

        $CI->email->initialize($config);

        $CI->email->from($CI->aylin->config("smtp_mail","config_mail"), $subject );
        
        if($send_mode=="normal")
        {
			$CI->email->to($to); 
		}elseif($send_mode=="bcc"){
			$CI->email->bcc($to);
		}else{
			$CI->email->cc($to);
		}
			

        $CI->email->subject($subject );
        $CI->email->message($content);  

        if($CI->email->send())
			return true;
		else
			return false;

       //echo $CI->email->print_debugger();


	}
	
	
	function search_box()
	{
		$CI =& get_instance();
		$CI->load->helper('form');	
		$search_box= form_open('news/search');
		$search_box.= '<div>'.form_input('keyword').'</div>';
		$search_box.= '<div>'.form_submit(array('class'=>'btn btn-primary'), 'جستجو').'</div>';
		$search_box.= form_close();
		return $search_box;
	}


	function subject_archive($class="subject_archive")
	{
		
		$CI =& get_instance();
		$CI->load->database();
		$query = $CI->db->get("news_group");
		
		$subject_archive="<ul class='$class' >";
		foreach ($query->result() as $row)
		{
			$subject_archive.="<li>".anchor('news/subject_archive/'.$row->ng_id, $row->ng_name)."</li>";
		}
		$subject_archive.="</ul>";
		return $subject_archive;
	}
	
	function links($group="" , $class="links")
	{
		
		$CI =& get_instance();
		$CI->load->database();
		
		$CI->db->join('links_group', 'links.lg_id = links_group.lg_id', 'left');
		if($group != "")
			$CI->db->where("lg_name",$group);
		$query = $CI->db->get("links");
		
		$links="<ul class='$class' >";
		foreach ($query->result() as $row)
		{
			$links.="<li>".anchor($row->l_url, $row->l_name,'title ='.$row->l_name)."</li>";
		}
		$links.="</ul>";
		return $links;
	}
	
	function logos($group="" , $class="logos")
	{
		
		$CI =& get_instance();
		$CI->load->database();
		
		$CI->db->join('links_group', 'links_logo.lg_id = links_group.lg_id', 'left');
		if($group != "")
			$CI->db->where("lg_name",$group);
			
		$CI->db->where("lg_name !=","slide");
		$query = $CI->db->get("links_logo");
		
		$links="<ul class='$class' >";
		foreach ($query->result() as $row)
		{
			$links.="<li>".anchor($row->ll_url, "<img  src='".base_url("assets/uploads/files")."/".$row->ll_img_url."'/>",'title ='.$row->ll_title)."</li>";
		}
		$links.="</ul>";
		return $links;
	}
	
	
	function slides(){	
		
		$CI =& get_instance();
		$CI->load->database();
		
		$CI->db->join('links_group', 'links_logo.lg_id = links_group.lg_id', 'left');	
		$CI->db->where("lg_name","slide");
		$query = $CI->db->get("links_logo");


	$slide='
	<div style="height:400px;" class="span12">	
		<div id="myCarousel" class="carousel slide">
            <div class="carousel-inner">
		';				
				          
   		foreach ($query->result() as $row)
		{          
			$slide.= "<div class='item'>
			<a href='".$row->ll_url."'><img  src='".base_url("assets/uploads/files/") ."/".$row->ll_img_url."' /></a>
			<div class='carousel-caption' style='direction:rtl;'>
			<h4>".$row->ll_title."</h4>
			</div>
			</div>";              
		}
		
	$slide.='
            </div>
            <!-- Carousel nav -->
			<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
			<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
        </div>		
	</div>';

	return $slide;
	}	
	
	
	function newsletter()
	{	
		$CI =& get_instance();
		$CI->load->helper('form');	
		$newsletter_box= form_open('newsletter/submit');
		$newsletter_box.= '<ul id="newsletter"><li>'.form_label('نام', 'nm_name').form_input(array("id"=>"nm_name","name"=>"nm_name"))."</li>";
		$newsletter_box.= '<li>'.form_label('پست الکترونیکی', 'nm_mail').form_input(array("name"=>"nm_mail","id"=>"nm_mail"))."</li>";
		$newsletter_box.= '<li>'.form_submit(array('class'=>'btn btn-primary'), 'ثبت نام در خبرنامه').'</li></ul>';
		$newsletter_box.= form_close();
		    
		return $newsletter_box;
	}
}
