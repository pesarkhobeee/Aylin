<?php
class RoozbehModel extends  CI_Model {

	private $default_table = '';
	private $pk = 'ID';

	function __construct(){
		parent::__construct();
		
		define("PREPEND", "prepend");
		define("APPEND", "append");
		
		$this->load->database();
		//$this->create_necessary_tables();
		$this->create_temporary_tables();
		
		$tables = $this->get_tables_list();
		$this->set_default_table($tables[0]);
	}
	
	function create_necessary_tables(){	
		$this->db->trans_start();
		$this->db->query('CREATE TABLE IF NOT EXISTS `_tables_config` (
							`name` VARCHAR( 100 ) NOT NULL PRIMARY KEY,
							`label` VARCHAR( 300 ) NOT NULL ,
							`view` BOOLEAN NOT NULL) ENGINE = InnoDB 
							COMMENT = \'This table is for store some informations about tables of this db\';');

		$this->db->query('CREATE TABLE IF NOT EXISTS `_fields_config` (
							`name` VARCHAR(200) NOT NULL PRIMARY KEY,
							`label` VARCHAR(300),
							`label_form_attributes` VARCHAR(300),
							`label_table_attributes` VARCHAR(300),
							`label_view_attributes` VARCHAR(300),
							`input` VARCHAR(300) NOT NULL,
							`input_attributes` VARCHAR(300),
							`content_table_attributes` VARCHAR(300),
							`content_view_attributes` VARCHAR(300),
							`character_limit` INT NOT NULL DEFAULT "0",
							`form` BOOLEAN NOT NULL,
							`full_view` BOOLEAN NOT NULL,
							`main_table` BOOLEAN NOT NULL,
							`other_tables` BOOLEAN NOT NULL,
							`index` BOOLEAN NOT NULL) ENGINE = InnoDB
							COMMENT = \'This table is for store some informations about fields of tables of this db\';');

		$this->db->query('CREATE TABLE IF NOT EXISTS `_main_menu` (
							`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
							`insert_place` ENUM( "prepend", "append" ),
							`address` VARCHAR(300),
							`label` VARCHAR(300),
							`priority` INT) ENGINE = InnoDB;');
		
		$this->db->query('CREATE TABLE IF NOT EXISTS `_top_breadcrumb_menu` (
							`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
							`address` VARCHAR(300),
							`label` VARCHAR(300),
							`session_id` VARCHAR(40)  NOT NULL) ENGINE = InnoDB;');
		$this->db->trans_complete();

	}
	
	function create_temporary_tables() {
		$this->db->trans_start();
		$this->db->query('DROP TABLE IF EXISTS _tables_menu;');
		$this->db->query('CREATE  TABLE IF NOT EXISTS _tables_menu(
							`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
							`name` VARCHAR(300) NOT NULL,
							`session_id` VARCHAR(40)  NOT NULL) ENGINE = MEMORY;');
		$this->db->trans_complete();
	}
	
	function get_input_type_list(){
		return array('input' => 'input',
					 'jalali' => 'jalali',
					 'ltr_input' => 'ltr_input',
					 'numeric' => 'numeric',
					 'upload' => 'upload',
					 'user_id' => 'user_id',
					 'password' => 'password',
				     'tinymce' => 'tinyMCE',
				     'forigen_key' => 'forigen_key'
				     );
	}
		
	function delete_top_breadcrumb_menu_items($item, $delete_self=TRUE){
		$table = '_top_breadcrumb_menu';
		$id_field = 'ID';
		$address_field = 'address';
		
		$this->db->flush_cache();
		
		$this->db->trans_start();
		$this->db->where('session_id', $this->session->userdata('session_id'));		
		$query = $this->db->get($table);
		$this->db->trans_complete();
		$result = $query->result_array();
		
		$flag = FALSE;
		foreach($result as $r){
			if($item == $r['address']){
				$flag = TRUE;
				break;
			}
		}

		if(!$flag)
			return;

		$result = array_reverse($result);
		
		foreach($result as $row){
			$address = $row[$address_field];
			
			if($address == $item && !$delete_self){
				break;				
			}
			$this->db->flush_cache();
			
			$this->db->trans_start();
			$this->db->where('session_id', $this->session->userdata('session_id'));
			$this->db->where($address_field, $address);
			$this->db->delete($table);
			$this->db->trans_complete();
			
			if($address == $item){
				break;				
			}
		}
		
	}
	
	function empty_top_breadcrumb_menu(){
		$this->db->flush_cache();
		$this->db->select('session_id');
		$query = $this->db->get('_ci_sessions');
		$sessions = array();
		foreach($query->result() as $row){
			$sessions[] = $row->{'session_id'};
		}
		unset($row);
		
		$this->db->flush_cache();
		$this->db->select();
		$query = $this->db->get('_top_breadcrumb_menu');
		$garbage_sessions = array();
		foreach($query->result() as $row){
			if(!in_array($row->{'session_id'}, $sessions))
				$garbage_sessions[] = $row->{'ID'};
		}
		
		foreach($garbage_sessions as $gs){
			$this->db->flush_cache();
			$this->db->where('ID', $gs);
			$this->db->delete('_top_breadcrumb_menu');
		}
		
		$this->db->flush_cache();
		$this->db->where('session_id', $this->session->userdata('session_id'));
		$this->db->delete('_top_breadcrumb_menu');
	}
	
	function get_top_breadcrumb_menu_items(){
		$this->db->flush_cache();
		
		$this->db->where('session_id', $this->session->userdata('session_id'));
		$this->db->order_by('ID','asc');
		$query = $this->db->get('_top_breadcrumb_menu');
		$result = $query->result();

		return $result;
	}
	
	function set_top_breadcrumb_menu_items($address, $label){
		$this->db->flush_cache();
		$table = '_top_breadcrumb_menu';
		$id_field = 'ID';
		$address_field = 'address';
		$label_field = 'label';
		
		$this->delete_top_breadcrumb_menu_items($address);
		
		$this->db->flush_cache();
		$this->db->insert($table, array($id_field => 0,
									    $address_field => $address,
										$label_field => $label,
										'session_id' => $this->session->userdata('session_id')));
		return $this->db->insert_id();
	}
	
	function get_main_menu_items($insert_place){
		$this->db->flush_cache();
		$this->db->where('insert_place', $insert_place);
		$this->db->order_by('priority','asc');
		return $this->db->get('_main_menu')->result();
	}
	
	function empty_tables_menu(){
		$this->db->flush_cache();
		$this->db->where('session_id', $this->session->userdata('session_id'));
		$this->db->delete('_tables_menu');
	}
	
	function clean_tables_menu_garbages(){
		$this->db->flush_cache();
		$this->db->select('session_id');
		$query = $this->db->get('_ci_sessions');
		$sessions = array();
		foreach($query->result() as $row){
			$sessions[] = $row->{'session_id'};
		}
		unset($row);
		
		$this->db->flush_cache();
		$this->db->select();
		$query = $this->db->get('_tables_menu');
		$garbage_sessions = array();
		foreach($query->result() as $row){
			if(!in_array($row->{'session_id'}, $sessions))
				$garbage_sessions[] = $row->{'ID'};
		}
		
		foreach($garbage_sessions as $gs){
			$this->db->flush_cache();
			$this->db->where('ID', $gs);
			$this->db->delete('_tables_menu');
		}
	}
	
	function register_tables_menu_item($item){		
		$menu_table = '_tables_menu';
		$id_field = 'ID';
		$name_field = 'name';
		$sessionid_field = 'session_id';
		
		$this->db->flush_cache();
		$this->db->where($name_field, $item);
		$this->db->where('session_id', $this->session->userdata('session_id'));
		$query = $this->db->get($menu_table);
		//echo $this->db->_compile_select().'<br />';
		
		if ($query->num_rows() > 0){
			$this->db->update($menu_table, array($name_field => $item), array($name_field => $item,
																			'session_id'=> $this->session->userdata('session_id')));
		}
		else{
			$this->db->insert($menu_table, array($id_field => 0, 
												 $name_field => $item,
												 $sessionid_field => $this->session->userdata('session_id')));
		}		
		
		$this->db->flush_cache();
		$this->db->select($id_field);
		$this->db->where($name_field, $item);
		$this->db->where('session_id', $this->session->userdata('session_id'));
		$row = $this->db->get($menu_table)->row();
		
		return $row->ID;
	}
	
	function id_to_item($id){
		$menu_table = '_tables_menu';
		
		$this->db->select();
		$this->db->where('ID', $id);
		$this->db->where('session_id', trim($this->session->userdata('session_id')));
		$row = $this->db->get($menu_table)->row();
		//echo $this->db->last_query();
		return $row->name;
	}

	function item_to_id($item){
		$menu_table = '_tables_menu';
		
		$this->db->select();
		$this->db->where('name', $item);
		$this->db->where('session_id', $this->session->userdata('session_id'));
		$row = $this->db->get($menu_table)->row();
		return $row->ID;
	}
	
	function get_main_menu_paged_list($limit = 10, $offset = 0){
		$this->db->flush_cache();
		
		$this->db->order_by('ID','asc');
		$this->db->limit($limit, $offset);
		$result = $this->db->get('_main_menu')->result_array();
		return $result;
	}
	
	function get_main_menu_by_id($item_id){
		$this->db->flush_cache();
		
		$this->db->select();
		$this->db->where('ID', $item_id);
		$row = $this->db->get('_main_menu')->row_array();
		
		if(array_key_exists('ID', $row))
			return $row;
		else {
			return array('ID' => '',
						'insert_place' => '',
						'address' => '',
						'label' => '',
						'priority' => '');
		}
	}
	
	function save_main_menu_config($config){
		$this->db->flush_cache();
		$this->db->where('ID',$config['ID']);
		$query = $this->db->get('_main_menu');
		
		if ($query->num_rows() > 0){			
			$this->db->flush_cache();
			$this->db->where('ID', $config['ID']);
			$this->db->update('_main_menu', $config);
		}
		else
			$this->db->insert('_main_menu', $config);
			
		return $config['ID'];
	}
	
	function get_table_label($table,$alter_label=''){
		$this->db->select('label');
		$this->db->from('_tables_config');
		$this->db->where('name', $table);
		$row = $this->db->get()->row();
		if(array_key_exists('label', $row) && $row->label != '')
			return $row->label;
		else
			return $alter_label;
	}
	
	function get_table_comment($table = ''){
		$table = ($table == '') ? $this->default_table : $table;
		
		$query = $this->db->query('SELECT 
									TABLE_COMMENT AS "table_comment"
									FROM
									INFORMATION_SCHEMA.TABLES
									WHERE
									TABLE_NAME="'.$table.'";');
		
		$row = $query->row();

		return $row->table_comment;

	}
	
	function save_tables_config($config){
		$this->db->where('name',$config['name']);
		$query = $this->db->get('_tables_config');
		if ($query->num_rows() > 0){
			$this->db->update('_tables_config', $config, array('name' => $config['name']));
		}
		else{
			$this->db->insert('_tables_config', $config);
		}
	}
	
	function get_table_view_permission($table = ''){
		$table = ($table == '') ? $this->default_table : $table;

		$this->db->select('view');
		$this->db->where('name', $table);
		$row = $this->db->get('_tables_config')->row();
		if(array_key_exists('view', $row)){
			if($row->view == 0)
				return false;
			elseif($row->view == 1)
				return true;
		}
		else
			return true;
	}
	
	function get_field_input_type($field){
		$this->db->select('input');
		$this->db->from('_fields_config');
		$this->db->where('name', $field);
		$row = $this->db->get()->row();
		if(array_key_exists('input', $row) && $row->input != '')
			return $row->input;
			
		return 'input';
	}
	
	function get_field_label($field,$alter_label=''){
		$this->db->select('label');
		$this->db->from('_fields_config');
		$this->db->where('name', $field);
		$row = $this->db->get()->row();
		if(array_key_exists('label', $row) && $row->label != '')
			return $row->label;
		else
			return $alter_label;
	}
	
	function get_field_attributes($field,$attribute){
		$this->db->select();
		$this->db->from('_fields_config');
		$this->db->where('name', $field);
		$row = $this->db->get()->row();
		if(array_key_exists($attribute, $row))
			return $row->$attribute;
		else
			return '';
	}
	
	function save_fields_config($config){
		$this->db->where('name',$config['name']);
		$query = $this->db->get('_fields_config');
		if ($query->num_rows() > 0){
			$this->db->update('_fields_config', $config, array('name' => $config['name']));
		}
		else{
			$this->db->insert('_fields_config', $config);
		}
		return $config['name'];
	}
	
	function get_field_view_permissions($field){
		$this->db->select('form,full_view,main_table,other_tables,index');
		$this->db->where('name', $field);
		$result = $this->db->get('_fields_config');
		if($result->num_rows() > 0){
			$row = $result->row();
			return array('form' =>	(($row->form == 1) ? true : false),
						'full_view' =>	(($row->full_view == 1) ? true : false),
						'main_table' => (($row->main_table == 1) ? true : false),
						'other_tables' => (($row->other_tables == 1) ? true : false),
						'index' => (($row->index == 1) ? true : false));
		}
		return array('form' =>	true , 'full_view' => true ,'main_table' => true,'other_tables' => true,'index' => true);
	}
	
	// set table name and pk
	function set_default_table($table){
		$this->default_table = $table;
		$this->pk = $this->get_table_pk();
	}
	
	function get_table_pk($table = ''){
		$table = ($table == '') ? $this->default_table : $table;

		$query = $this->db->query('SHOW INDEX FROM '.$table);
		
		foreach ($query->result() as $row){
			if($row->Key_name == 'PRIMARY')
				return $row->Column_name;	
		}
		
		return false;
	}
	
	function get_table_fks_list($table = ''){
		$table = ($table == '') ? $this->default_table : $table;
		
		$query = $this->db->query('SELECT 
									CONCAT(TABLE_NAME, \'.\', COLUMN_NAME) AS "Foreign_Key",  
									REFERENCED_TABLE_NAME AS "Ref_Table",
									CONCAT(REFERENCED_TABLE_NAME, \'.\', REFERENCED_COLUMN_NAME) AS "Ref_Column"
									FROM
									INFORMATION_SCHEMA.KEY_COLUMN_USAGE
									WHERE
									REFERENCED_TABLE_NAME IS NOT NULL
									AND
									TABLE_NAME="'.$table.'";');
		
		

		return $query->result();
	}
	
	function is_field_fk($table = '', $field){
		$table = ($table == '') ? $this->default_table : $table;

		foreach($this->get_table_fks_list($table) as $row){
			if($field == $row->Foreign_Key)
				return true;
		}
		
		return false;
	}
	
	function get_fk_referenced_field($table = '', $field){
		$table = ($table == '') ? $this->default_table : $table;
		
		foreach($this->get_table_fks_list($table) as $row){
			if($field == $row->Foreign_Key)
				return $row->Ref_Column;
		}
		
		return '';
	}
	
	function get_fk_referenced_table($table = '', $field){
		$table = ($table == '') ? $this->default_table : $table;
		
		foreach($this->get_table_fks_list($table) as $row){
			if($field == $row->Foreign_Key)
				return $row->Ref_Table;
		}
		
		return '';
	}
	
	function is_system_table($table){
		if($table[0] == '_')
			return TRUE;
		else
			return FALSE;
	}
	
	// get list of tables in database	
	function get_tables_list($limit = 0, $offset = 0){
		$all_tables = $this->db->list_tables();
		$tables_list = array();
		
		foreach($all_tables as $table){
			if(!$this->is_system_table($table))
				$tables_list[] = $table;
		}
		
		$tables_count = count($tables_list);
		
		if($limit == 0)
			$last_index = $tables_count;
			
		else if(($offset+$limit) <= $tables_count)
			$last_index = $offset+$limit;
			
		else
			$last_index = $tables_count;
		
		$limited_list = array();
		
		for($i=$offset; $i<$last_index; $i++)
			$limited_list[] = $tables_list[$i];
		
		return $limited_list;
	}
	
	function get_tables_count(){
		return count($this->get_tables_list());
	}
	
	// get list of fields in table
	function get_fields_list($table = '', $full_name = FALSE){
		$table = ($table == '') ? $this->default_table : $table;
		
		$fields = array();
		$query = $this->db->query('SELECT * FROM '.$table);

		foreach ($query->list_fields() as $field)
		   $fields[] = ($full_name) ? $table.'.'.$field : $field;
		
		return $fields;
	}
	
	function get_fk_values_list($table, $field){
		foreach($this->get_table_fks_list($table) as $row){
			if($field == $row->Foreign_Key){
				$values = array();
				$select = '';
				foreach($this->get_join_fields_list($row->Ref_Table,'index') as $rfield){
					$select .= $rfield.' AS '.'"'.$rfield.'"'.', ';
				}
				
				$this->db->select($select);
				$this->db->from($row->Ref_Table);
				$this->get_join_table_fks_list($row->Ref_Table);
				$result = $this->db->get()->result_array();

				$opt = '';
				$pkn = $this->get_table_pk($row->Ref_Table);
				
				$this->db->select($pkn);
				$pks = $this->db->get($row->Ref_Table)->result_array();
				
				
				
				$j = 0;
				foreach($result as  $row){
					$i = 0;
					foreach($row as $key => $cell){
						
						$pk= $pks[$j][$pkn];

						if($i > 0)
							$opt .= ' | ';
						
						$input_type = $this->get_field_input_type($key);
						if($cell != 'NULL' && $input_type == 'jalali')
							$cell = $this->jalali->convert_to_jalali($cell);
							
						$opt .= strip_tags($cell);
						$i++;
					}
					
					$values += array($pk => $opt);
					$opt = '';
					$j++;
				}
				
				return $values;
			}
		}
	}
	
	// get type of field
	function get_field_type($field){
		$query = $this->db->query('SHOW COLUMNS FROM '.$this->default_table.' WHERE Field="'.$field.'"');
		
		$row = $query->row();
		
		if(isset($row))
			return $row->Type;

		return false;
	}
	
	// get number of rows in table
	function get_rows_count(){
		return $this->db->count_all($this->default_table);
	}
	
	// get rows with paging
	function get_paged_list($limit = 10, $offset = 0){
		$this->db->order_by($this->pk,'asc');
		$this->db->limit($limit, $offset);
		return $this->db->get($this->default_table);
	}
	
	function get_join_fields_list($table = '', $view_location){
		$table = ($table == '') ? $this->default_table : $table;
		
		$join_fields = array();
		$flag = false;
		
		foreach($this->get_fields_list($table, TRUE) as $local_field){
			$permissions = $this->get_field_view_permissions($local_field);
			
			if($permissions[$view_location] && !$this->is_field_fk($table,$local_field))
				$join_fields[] = $local_field;

			foreach($this->get_table_fks_list($table) as $row){
				if($local_field == $row->Foreign_Key){
					$join_fields = array_merge($join_fields,
											   $this->get_join_fields_list($row->Ref_Table, ($view_location=='index')?'index':'other_tables'));
				}
			}
		}
		
		return $join_fields;	
	
	}
	
	function get_join_table_fks_list($table = ''){
		$table = ($table == '') ? $this->default_table : $table;

		foreach($this->get_table_fks_list($table) as $row){
			$this->db->join($row->Ref_Table, $row->Ref_Column.'='.$row->Foreign_Key, 'LEFT');
			$this->get_join_table_fks_list($row->Ref_Table);
		}
		
	}
	
	// get rows with paging
	function get_join_paged_list($limit = 10, $offset = 0){
		$select = '';
		
		$pk_field = $this->default_table.'.'.$this->get_table_pk();
		$permissions = $this->get_field_view_permissions($pk_field);
		if(!$permissions['main_table'])
			$select .= $pk_field.' AS '.'"'.$pk_field.'"'.', ';

		foreach($this->get_join_fields_list('','main_table') as $field){
			$select .= $field.' AS '.'"'.$field.'"'.', ';
		}
		
		$this->db->select($select);
		$this->db->from($this->default_table);
		$this->get_join_table_fks_list($this->default_table);
		$this->db->order_by($this->default_table.'.'.$this->pk,'asc');
		$this->db->limit($limit, $offset);
		//echo $this->db->_compile_select();
		$query = $this->db->get();		
		return $query->result_array();
	}
	
	function get_join_row_by_pk($pk){
		$this->db->select($this->get_join_fields_list('','full_view'));
		$this->db->from($this->default_table);
		$this->get_join_table_fks_list($this->default_table);
		$this->db->where($this->default_table.'.'.$this->pk, $pk); 
		return $this->db->get()->row();
	}
	
	// get row by id
	function get_row_by_pk($pk){
		$this->db->where($this->pk, $pk);
		return $this->db->get($this->default_table);
	}
	
	function get_field_value_by_pk($pk,$field){
		$this->db->select($field);
		$this->db->where($this->pk, $pk);
		$query = $this->db->get($this->default_table);
		return $query->row();
	}
	
	// insert new row
	function insert($rows){
		$this->db->insert($this->default_table, $rows);
		return $this->db->insert_id();
	}
	
	// update row by id
	function update($id, $rows){
		$this->db->update($this->default_table, $rows, array($this->pk => $id));
	}
	
	// delete row by id
	function delete($id){
		$this->db->where($this->pk, $id);
		$this->db->delete($this->default_table);
	}

}

?>
