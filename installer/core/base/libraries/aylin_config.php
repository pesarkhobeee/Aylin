<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class aylin_config {

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

}
