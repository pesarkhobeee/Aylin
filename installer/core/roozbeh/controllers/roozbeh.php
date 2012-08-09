<?php
class Roozbeh extends CI_Controller{
	
	function __construct(){
	
		parent::__construct();
		
		   $this->load->library('Z_auth');
            $this->z_auth->login_check();
					if(!$this->z_auth->acl_check($this->uri->segment(1)))
						redirect('/welcome/login', 'refresh');
		
		/* Load libraries */
		$this->load->library(array('form_validation','jalali','session'));
		
		/* Load language */
		$this->lang->load('roozbeh', 'persian');
		
		//$this->output->enable_profiler(TRUE);
		
		/* Load helpers */
		$this->load->helper('form');
		$this->load->helper('text');
		$this->load->helper('html');
		
		/* Load models */
		$this->load->model('RoozbehModel','roozbeh',true);

		/* Init */
		$this->create_tables_menu();
	}
	/***************************************************************/
	function index(){
		
		$this->roozbeh->empty_top_breadcrumb_menu();
		
		$data['top_menu'] = $this->create_top_breadcrumb_menu(current_url(),"صفحه اصلی");
		$data['right_menu'] = $this->create_main_menu(-1);
		
		$this->load->view('roozbehview', $data);
	}
	/***************************************************************/
	function create_top_breadcrumb_menu($address='', $label=''){
		$items = "\n";
		$items .= '<div class="breadcrumb">'."\n";
		$items .= '<span class="right"></span>'."\n";
		$items .= '<ul>'."\n";
		
		if($address != '')
			$this->roozbeh->set_top_breadcrumb_menu_items($address, $label);

		$result = $this->roozbeh->get_top_breadcrumb_menu_items();
		$active_item = count($result)-1;
		
		$i=0;
		foreach($result as $menu_item){
			if($i == $active_item){
				$items .= '<li>'.'<a class="active"><span>'.$menu_item->label.'</span></a>'.'</li>'."\n";
			}
			else {
			$items .= '<li>'.anchor($menu_item->address,
									'<span>'.$menu_item->label.'</span>').'</li>'."\n";
			}
			$i++;
		}
				
		$items .= '</ul>'."\n";
		$items .= '<span class="left"></span>'."\n";
		$items .= '</div>'."\n";
		
		return $items;
	}
	/***************************************************************/
	function create_main_menu($active_item = -1){
		$items = "\n";
		$class = NULL;
		$items .= '<ul class="right-menu">';
		
		/* prepend item to start of menu*/
		foreach($this->roozbeh->get_main_menu_items(PREPEND) as $menu_item){
			$items .= '<li>'.anchor($menu_item->address,
									'<span>'.$menu_item->label.'</span>').'</li>';
		}
		
		if($active_item == 1)
			$class = 'active';
		$items .= '<li>'.anchor('roozbeh/tables_page/',
								'<span>'.$this->lang->line('roozbeh_tables').'</span>',
								(($class) ? array('class'=>$class):'')).'</li>';

		$class = NULL;
		if($active_item == 2)
			$class = 'active';
		$items .= '<li>'.anchor('roozbeh/settings_page/',
								'<span>'.$this->lang->line('roozbeh_rmenu_settings').'</span>',
								(($class) ? array('class'=>$class):'')).'</li>';
				
		/* Append item to end of menu*/
		foreach($this->roozbeh->get_main_menu_items(APPEND) as $menu_item){
			$items .= '<li>'.anchor($menu_item->address,'<span>'.$menu_item->label.'</span>').'</li>';
		}
		


		$items .= '</ul>';

		return $items;
	}
	/***************************************************************/
	function create_tables_menu($active_item = -1){
		$items = "\n";
		$class = NULL;
		$items .= '<ul class="right-menu">';
		
		$items .= '<li>'.anchor('roozbeh/settings_page/','<span>'.$this->lang->line('roozbeh_rmenu_settings').'</span>',
								(($class) ? array('class'=>$class):'')).'</li>';
								
		/* Insert Name of tables */
		foreach ($this->roozbeh->get_tables_list() as $table){
			if(!$this->roozbeh->get_table_view_permission($table))
				continue;
			
			$id = $this->roozbeh->register_tables_menu_item($table);
			if($id == $active_item)
				$class = 'active';

			$items .= '<li>'.anchor('roozbeh/view_table/'.$id,
							'<span>'.$this->roozbeh->get_table_label($table,$table).'</span>',
							(($class) ? array('class'=>$class):'')).'</li>';
			$class = NULL;
		}

		$items .= '</ul>';

		return $items;
	}
	/***************************************************************/
	function create_settings_menu($active_item = -1){
		//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
			
		$items = "\n";
		$class = NULL;
		$items .= '<ul class="right-menu">';

		if($active_item == 1)
			$class = 'active';
		$items .= '<li>'.anchor('roozbeh/tables_settings/',
								'<span>'.$this->lang->line('roozbeh_tables').'</span>',
								(($class) ? array('class'=>$class):'')).'</li>';
		
		$class = NULL;
		if($active_item == 2)
			$class = 'active';
		$items .= '<li>'.anchor('roozbeh/users_settings/',
								'<span>'."کاربران".'</span>',
								(($class) ? array('class'=>$class):'')).'</li>';

		$class = NULL;
		if($active_item == 3)
			$class = 'active';
		$items .= '<li>'.anchor('roozbeh/main_menu_settings/',
								'<span>'."فهرست اصلی".'</span>',
								(($class) ? array('class'=>$class):'')).'</li>';
								
		$items .= '</ul>';

		return $items;
	}
	/***************************************************************/
	function tables_settings($offset=0,$message=NULL){
		
		//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
			
		$uri_segment = 3;
		$limit = 10;
		
		$tables_list = $this->roozbeh->get_tables_list($limit,$offset);
		
		$save_limit = $limit;
		$save_offset = $offset;
		
		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('roozbeh/tables_settings/');
 		$config['total_rows'] = $this->roozbeh->get_tables_count();
 		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->library('table');
		$tmpl = array ( 'table_open'  => '<table class="table table-striped">');
		$this->table->set_template($tmpl);
		$this->table->set_empty('&nbsp;');
					
		
		$header = array();
		
		$header[] =array('content' => $this->lang->line('roozbeh_set_t_No'),
						 'scope'=>'col',
						 'class' => 'rounded-no');
		
		$header_labels = array( $this->lang->line('roozbeh_set_t_name'),
								$this->lang->line('roozbeh_set_t_label'),
								$this->lang->line('roozbeh_set_t_view'));
								
		foreach($header_labels as $label){
			$header[] = array(	'content' => $label, 
								'scope'=>'col',
								'class' => 'rounded-q1');
		}
		
		$header[] =array('content' => $this->lang->line('roozbeh_set_t_options'), 
						 'scope'=>'col',
						 'class' => 'rounded-q4');
		
		$this->table->set_heading($header);
		

		$hidden_inputs = array();

		foreach ($tables_list as $table){
			
			$hidden_inputs[] = form_hidden($table, $table);
			
			$cells = array();
			/* Row number */
			$cells[] = array('content' => ++$offset,
							 'style' => 'text-align:center;');
			
			/* Table name and link to its structure */
			$cells[]['content'] = anchor('roozbeh/fields_settings/'.$table,
										 $table,
										 array('title' => $this->roozbeh->get_table_comment($table),
										 	   'class'=>'view'));
			
			
			/* Label input */
			$cells[]['content'] = form_input(array(	'name'       => $table.'-label',
													'id'         => $table.'-label',
													'value'      => $this->roozbeh->get_table_label($table),
													'class'		 => 'table_text',
													'maxlength'  => '300',
													'size'       => '20'
													));
			/* Table view permission */
			$cells[] = array('content' => form_checkbox(array(	'name'    => $table.'-permission',
														'id'      => $table.'-permission',
														'value'   => '1',
														'checked' => $this->roozbeh->get_table_view_permission($table)
														)),
								'style' => 'text-align:center;'); 
			/* Options */
			$cells[]['content'] = '&nbsp';
			
			/* Insert cells to a row of table*/
			$this->table->add_row($cells);
		}

		$submit_data = array(
			  'value'		=> $this->lang->line('roozbeh_set_t_submit'),
			  'name'		=> 'add_row_submit',
		      'style'       => 'width:120px;margin:0px 5px 0px 5px',
		    );

		$reset_data = array(
		  'value'		=> $this->lang->line('roozbeh_set_t_reset'),
		  'name'		=> 'add_row_reset',
	      'style'       => 'width:120px;margin:0px 5px 0px 5px',
	    );
		
		$footer = array();	
		$footer[] = array('content' => form_submit($submit_data).' '.form_reset($reset_data),
						  'colspan' => count($header_labels)+1, 'class' => 'rounded-foot-left');
		$footer[] = array('content' => '', 'class' => 'rounded-foot-right');
		$this->table->add_row($footer);
		
		$this->roozbeh->delete_top_breadcrumb_menu_items(site_url('roozbeh/settings_page'), FALSE);
		
		/**** Common ****/
		$data['title'] = $this->lang->line('roozbeh_set_t_config');
		//$data['top_menu'] = $this->create_top_breadcrumb_menu(site_url('roozbeh/tables_settings').'/'.$save_offset,$this->lang->line('roozbeh_tables'));
		//$data['right_menu'] = $this->create_settings_menu(1);
		
		/* Table */
		$data['table'] = $this->table->generate();

		/* Form */
		$data['hidden_inputs'] = $hidden_inputs;
		$data['action'] = site_url('roozbeh/save_tables_settings/'.$save_limit.'/'.$save_offset);
		$data['message'] = $message;
	

		$this->load->view('roozbehview',$data);
	}
	/***************************************************************/
	public function users_settings($offset=0)
    {
    	//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
		
    	$uri_segment = 3;
		$limit = 10;
		
		$this->load->model('UsersModel', 'usersmodel', true);
		
		$users_list = $this->usersmodel->get_users_paged_list($limit,$offset);

		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('roozbeh/users_settings/');
 		$config['total_rows'] = count($users_list);
 		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->library('table');
		$tmpl = array ( 'table_open'  => '<table class="table table-striped">');
		$this->table->set_template($tmpl);
		$this->table->set_empty('&nbsp;');
					
		
		$header = array();
		
		$header[] =array('content' => $this->lang->line('roozbeh_set_t_No'),
						 'scope'=>'col',
						 'class' => 'rounded-no');
		
		$header_labels = array( "شناسه", "نام", "کلمه عبور", "نوع", "وضعیت");
								
		foreach($header_labels as $label){
			$header[] = array(	'content' => $label, 
								'scope'=>'col',
								'class' => 'rounded-q1');
		}
		
		$header[] =array('content' => $this->lang->line('roozbeh_set_t_options'), 
						 'scope'=>'col',
						 'class' => 'rounded-q4');
		
		$this->table->set_heading($header);

		foreach ($users_list as $user){
					
			$cells = array();
			/* Row number */
			$cells[] = array('content' => ++$offset,
							 'style' => 'text-align:center;');
			
			
			/* ID */
			$cells[]['content'] = $user['userId'];
			
			/* User name */
			$cells[]['content'] = $user['userEmail'];
			
			/* Password */
			$cells[]['content'] = $user['userPassword'];
			
			/* Type */
			$cells[]['content'] = $user['userType'];
			
			/* Status */
			$cells[]['content'] = $user['userStatus'];
			
			/* Options */
			$cells[] = array('content' => anchor('roozbeh/users_form/'.$user['userId'],'ویرایش',array('class'=>'btn btn-success')));
			
			/* Insert cells to a row of table*/
			$this->table->add_row($cells);
		}

		$submit_data = array(
			  'value'		=> $this->lang->line('roozbeh_set_t_submit'),
			  'name'		=> 'add_row_submit',
		      'style'       => 'width:120px;margin:0px 5px 0px 5px',
		    );

		$reset_data = array(
		  'value'		=> $this->lang->line('roozbeh_set_t_reset'),
		  'name'		=> 'add_row_reset',
	      'style'       => 'width:120px;margin:0px 5px 0px 5px',
	    );
		
		$footer = array();
		$footer[] = array('content' => anchor('roozbeh/users_form','افزودن کاربر جدید',array('class'=>'btn btn-success')),
						  						  'colspan' => count($header_labels)+1, 'class' => 'rounded-foot-left');
		$footer[] = array('content' => '', 'class' => 'rounded-foot-right');

		$this->table->add_row($footer);
		
		$this->roozbeh->delete_top_breadcrumb_menu_items(site_url('roozbeh/settings_page'), FALSE);
		
		/**** Common ****/
		$data['title'] = "تنظیمات کاربران";
		$data['top_menu'] = $this->create_top_breadcrumb_menu(site_url('roozbeh/users_settings'),"کاربران");
		$data['right_menu'] = $this->create_settings_menu(2);
		
		/* Table */
		$data['table'] = $this->table->generate();

		$this->load->view('roozbehview',$data);
    }
    /***************************************************************/
    function users_form($user_id=NULL){
    	//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
		
		$this->load->model('UsersModel', 'usersmodel', true);
		$user = $this->usersmodel->get_user_by_id($user_id);
	
		$form = form_open(site_url('roozbeh/save_users_settings'), array('class' => 'fields-settings-form'))."\n";

		$form .= form_fieldset()."\n";
		
		$form .= form_hidden('user_id', $user['userId']);
		
		$form .= '<div class="grid_4">'."\n";
		$form .= form_label("نام کاربری", 'user_name')."<br/>"."\n";
		$form .= form_input(array(	'name'  => 'user_name',
									'id'    => 'user_name',
									'value' => $user['userEmail'],
									'class' => 'ltr-text',
									'maxlength'  => '300',
									'size'       => '20'));
		$form .= '</div>'."\n";
		
		$form .= '<div class="grid_4">'."\n";
		$form .= form_label("کلمه عبور", 'user_password')."<br/>"."\n";
		$form .= form_password(array(	'name'   => 'user_password',
														'id'         => 'user_password',
														'value'      => '',
														'class'		 => 'ltr-text',
														'maxlength'  => '300',
														'size'       => '20'
														));
        $form .= '</div>'."\n";
        
        $form .= '<div class="grid_4">'."\n";
		$form .= form_label("نوع کاربر", 'user_type')."<br/>"."\n";
        $form .= form_dropdown('user_type',
												array('user' => 'user', 'admin' => 'admin'),
												$user['userType'],
												'class="ltr-menu"');
        $form .= '</div>'."\n";
        
        $form .= '<div class="grid_4">'."\n";
		$form .= form_label("وضعیت", 'user_status')."<br/>"."\n";
        $form .= form_checkbox(array(	'name'    => 'user_status',
										'id'      => 'user_status',
										'value'   => '1',
										'checked' => ($user['userStatus'] == 'active') ? 'checked' : '',
										'style' => 'text-align:center;'));
        $form .= '</div>'."\n";
        
        $form .= '<div class="clear"></div>'."\n";
		////$form .= '<hr style="margin:0px 0px 15px 0px;border-top:solid #b3b3b3 1px"/>'."\n";
		$form .= '<div class="clear"></div>'."\n";
		$form .= '<div class="grid_16" align="left">'."\n";
		
        $submit_data = array(
		  'value'		=> $this->lang->line('roozbeh_set_f_submit'),
		  'name'		=> 'add_user_submit',
          'class'		=> 'btn btn-success'
        );
        
        $form .= '<div style="text-align: left">'."\n";
		$form .= form_submit($submit_data)."\n";
		
		$reset_data = array(
		  'value'		=> $this->lang->line('roozbeh_set_f_reset'),
		  'name'		=> 'add_user_reset',
          'class'		=> 'btn btn-success'
        );
		$form .= form_reset($reset_data)."\n";
		$form .= '</div>'."\n";
		$form .= '</div>'."\n";
		
		$form .= form_fieldset_close()."\n";
		$form .= form_close()."\n";
    	
    	// set common properties
		$data['title'] = 'افزودن کاربر جدید';
			
		$data['form'] = $form;
		
		$data['top_menu'] = $this->create_top_breadcrumb_menu('roozbeh/users_form/'.$user['userId'],$user['userEmail'].$user['userId']);
		//$data['right_menu'] = $this->create_settings_menu(2);

		// load view
		$this->load->view('roozbehview',$data);
    }
    /***************************************************************/
	function save_users_settings(){
		//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
		
		$this->load->model('UsersModel', 'usersmodel', true);
		// save data
		$config = array('userId' => $this->input->post('user_id'),
						'userEmail' => $this->input->post('user_name'),
						'userPassword' => $this->input->post('user_password'),
						'userType' => $this->input->post('user_type'),
						'userStatus' => $this->input->post('user_status'));
		$save_id = $this->usersmodel->save_users_config($config);

		
		$this->users_form($save_id);
		// set user message
		echo '<div class="success">عملیات با موفقیت انجام شد!</div>';
	}
	/***************************************************************/
	public function main_menu_settings($offset=0)
    {
    	//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
		
    	$uri_segment = 3;
		$limit = 10;
		
		
		$main_menu_list = $this->roozbeh->get_main_menu_paged_list($limit,$offset);

		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('roozbeh/main_menu_settings/');
 		$config['total_rows'] = count($main_menu_list);
 		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->library('table');
		$tmpl = array ( 'table_open'  => '<table class="table table-striped">');
		$this->table->set_template($tmpl);
		$this->table->set_empty('&nbsp;');
					
		
		$header = array();
		
		$header[] =array('content' => $this->lang->line('roozbeh_set_t_No'),
						 'scope'=>'col',
						 'class' => 'rounded-no');
		
		$header_labels = array( "محل افزودن", "نشانی", "برچسب", "اولویت");
								
		foreach($header_labels as $label){
			$header[] = array(	'content' => $label, 
								'scope'=>'col',
								'class' => 'rounded-q1');
		}
		
		$header[] =array('content' => $this->lang->line('roozbeh_set_t_options'), 
						 'scope'=>'col',
						 'class' => 'rounded-q4');
		
		$this->table->set_heading($header);

		foreach ($main_menu_list as $item){
					
			$cells = array();
			/* Row number */
			$cells[] = array('content' => ++$offset,
							 'style' => 'text-align:center;');
			
		
			/* Insert place */
			$cells[]['content'] = $item['insert_place'];
			
			/* Address */
			$cells[]['content'] = $item['address'];
			
			/* Label */
			$cells[]['content'] = $item['label'];
			
			/* Priority */
			$cells[]['content'] = $item['priority'];
			
			/* Options */
			$cells[] = array('content' => anchor('roozbeh/main_menu_form/'.$item['ID'],'ویرایش',array('class'=>'update')).'&nbsp&nbsp&nbsp'.
				anchor('roozbeh/delete_main_menu_item/'.$item['ID'],'حذف',array('class'=>'delete','onclick'=>"return confirm('آیا قصد دارید این آیتم را حذف کنید؟')")), 'width' => '60px');
			
			/* Insert cells to a row of table*/
			$this->table->add_row($cells);
		}

		$submit_data = array(
			  'value'		=> $this->lang->line('roozbeh_set_t_submit'),
			  'name'		=> 'add_item_submit',
		      'style'       => 'width:120px;margin:0px 5px 0px 5px',
		    );

		$reset_data = array(
		  'value'		=> $this->lang->line('roozbeh_set_t_reset'),
		  'name'		=> 'add_item_reset',
	      'style'       => 'width:120px;margin:0px 5px 0px 5px',
	    );
		
		$footer = array();
		$footer[] = array('content' => anchor('roozbeh/main_menu_form','افزودن آیتم جدید',array('class'=>'add')),
						  						  'colspan' => count($header_labels)+1, 'class' => 'rounded-foot-left');
		$footer[] = array('content' => '', 'class' => 'rounded-foot-right');

		$this->table->add_row($footer);
		
		$this->roozbeh->delete_top_breadcrumb_menu_items(site_url('roozbeh/settings_page'), FALSE);
		
		/**** Common ****/
		$data['title'] = "تنظیمات کاربران";
		$data['top_menu'] = $this->create_top_breadcrumb_menu(site_url('roozbeh/main_menu_settings'),"فهرست اصلی");
		$data['right_menu'] = $this->create_settings_menu(3);
		
		/* Table */
		$data['table'] = $this->table->generate();

		$this->load->view('roozbehview',$data);
    }
    /***************************************************************/
    function main_menu_form($item_id=NULL){
    	//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
		
		$item = $this->roozbeh->get_main_menu_by_id($item_id);
	
		$form = form_open(site_url('roozbeh/save_main_menu_settings'), array('class' => 'fields-settings-form'))."\n";

		$form .= form_fieldset()."\n";
		
		$form .= form_hidden('ID', $item['ID']);
		
		$form .= '<div class="grid_4">'."\n";
		$form .= form_label("محل افزودن", 'insert_place')."<br/>"."\n";
		$form .= form_dropdown('insert_place',
									array('prepend' => 'prepend', 'append' => 'append'),
									$item['insert_place'],
									'class="ltr-menu"');
		
		$form .= '</div>'."\n";
		
		$form .= '<div class="grid_4">'."\n";
		$form .= form_label("نشانی", 'address')."<br/>"."\n";
		$form .= form_input(array(	'name'   => 'address',
														'id'         => 'address',
														'value'      => $item['address'],
														'class'		 => 'ltr-text',
														'maxlength'  => '300',
														'size'       => '20'
														));
        $form .= '</div>'."\n";
        
        $form .= '<div class="grid_4">'."\n";
		$form .= form_label("برچسب", 'label')."<br/>"."\n";
        $form .= form_input(array(	'name'  => 'label',
									'id'    => 'label',
									'value' => $item['label'],
									'class' => 'text',
									'maxlength'  => '300',
									'size'       => '20'));
        $form .= '</div>'."\n";
        
        $form .= '<div class="grid_4">'."\n";
		$form .= form_label("اولویت", 'priority')."<br/>"."\n";
        $form .= form_input(array(	'name'  => 'priority',
									'id'    => 'priority',
									'value' => $item['priority'],
									'class' => 'numeric',
									'maxlength'  => '300',
									'size'       => '20',
									'onkeypress' => 'return isNumberKey(event)'));
        $form .= '</div>'."\n";
        
        $form .= '<div class="clear"></div>'."\n";
		//$form .= '<hr style="margin:0px 0px 15px 0px;border-top:solid #b3b3b3 1px"/>'."\n";
		$form .= '<div class="clear"></div>'."\n";
		$form .= '<div class="grid_16" align="left">'."\n";
		
        $submit_data = array(
		  'value'		=> $this->lang->line('roozbeh_set_f_submit'),
		  'name'		=> 'add_item_submit',
          'class'		=> 'btn btn-success'
        );
        
        $form .= '<div style="text-align: left">'."\n";
		$form .= form_submit($submit_data)."\n";
		
		$reset_data = array(
		  'value'		=> $this->lang->line('roozbeh_set_f_reset'),
		  'name'		=> 'add_item_reset',
          'class'		=> 'btn btn-success'
        );
		$form .= form_reset($reset_data)."\n";
		$form .= '</div>'."\n";
		$form .= '</div>'."\n";
		
		$form .= form_fieldset_close()."\n";
		$form .= form_close()."\n";
    	
    	// set common properties
		$data['title'] = 'افزودن آیتم جدید';
			
		$data['form'] = $form;
		
		$data['top_menu'] = $this->create_top_breadcrumb_menu('roozbeh/main_menu_form/'.$item['ID'],$item['label']);
		//$data['right_menu'] = $this->create_settings_menu(2);

		// load view
		$this->load->view('roozbehview',$data);
    }
    /***************************************************************/
	function save_main_menu_settings(){
		//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
		
		// save data
		$config = array('ID' => $this->input->post('ID'),
						'insert_place' => $this->input->post('insert_place'),
						'address' => $this->input->post('address'),
						'label' => $this->input->post('label'),
						'priority' => $this->input->post('priority'));
		$save_id = $this->roozbeh->save_main_menu_config($config);

		
		$this->main_menu_form($save_id);
		// set user message
		echo '<div class="success">عملیات با موفقیت انجام شد!</div>';
	}
    /***************************************************************/
	function delete_main_menu_item($item_id){
		//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
		
		$this->roozbeh->set_default_table('_main_menu');
		$this->roozbeh->delete($item_id);

		// redirect to projects list page
		redirect('roozbeh/main_menu_settings/','refresh');
	}
	/***************************************************************/
	function create_fields_menu($table,$active_item = ''){
		//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
			
		$items = "\n";
		$class = NULL;
		$items .= '<ul style="list-style-type:none;" id="roozbeh_menu">';
				
		/* Insert Name of tables */
		foreach ($this->db->list_fields($table) as $field){
			if($field == $active_item)
				$class = 'active';

			$items .= '<li>'.anchor('roozbeh/fields_settings/'.$table.'/'.$field.'/',
							'<span>'.$field.'</span>',
							(($class) ? array('class'=>$class):'')).'</li>';
			$class = NULL;
		}
		
		$items .= '</ul>';

		return $items;
	}
	/***************************************************************/
	function fields_settings($table,$field=''){
	    //if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
			
		$this->roozbeh->set_default_table($table);
		if($field == '')
			$field = $this->roozbeh->get_table_pk();
		
		$form = form_open(site_url('roozbeh/save_fields_settings/'.$table.'/'.$field.'/'), array('class' => 'fields-settings-form'))."\n";

		$form .= form_fieldset()."\n";	
		
		$form .= '<div >'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_label'), $field.'-label')."&nbsp;"."\n";
		$form .= form_input(array(
			'name'        => $field.'-label',
			'id'          => $field.'-label',
			'value'       => $this->roozbeh->get_field_label($table.'.'.$field),
			'maxlength'   => '300',
			'size'        => '20',
			'class'       => 'text'
        ));
		$form .= '</div>'."\n";
		
		$form .= '<div class="grid_4">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_label_form_attr'), $field.'-label-form-attributes')."&nbsp;"."\n";
		$form .= form_input(array(
			'name'        => $field.'-label-form-attributes',
			'id'          => $field.'-label-form-attributes',
			'value'       => $this->roozbeh->get_field_attributes($table.'.'.$field,'label_form_attributes'),
			'maxlength'   => '300',
			'size'        => '20',
			'class'       => 'ltr-text'
        ));		
        $form .= '</div>'."\n";
        
        $form .= '<div class="grid_4">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_label_table_attr'), $field.'-label-table-attributes')."&nbsp;"."\n";
        $form .= form_input(array(
			'name'        => $field.'-label-table-attributes',
			'id'          => $field.'-label-table-attributes',
			'value'       => $this->roozbeh->get_field_attributes($table.'.'.$field,'label_table_attributes'),
			'maxlength'   => '300',
			'size'        => '20',
			'class'       => 'ltr-text'
        ));
        $form .= '</div>'."\n";
        
        $form .= '<div class="grid_4">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_label_view_attr'), $field.'-label-view-attributes')."&nbsp;"."\n";
        $form .= form_input(array(
			'name'        => $field.'-label-view-attributes',
			'id'          => $field.'-label-view-attributes',
			'value'       => $this->roozbeh->get_field_attributes($table.'.'.$field,'label_view_attributes'),
			'maxlength'   => '300',
			'size'        => '20',
			'class'       => 'ltr-text'
        ));
		$form .= '</div>'."\n";
		
		$form .= '<div class="grid_4">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_input'),$field.'-input')."&nbsp;"."\n";
		$form .= form_dropdown($field.'-input',
											$this->roozbeh->get_input_type_list(),
											$this->roozbeh->get_field_input_type($table.'.'.$field),
											'class="ltr-menu"');
		$form .= '</div>'."\n";
		
		$form .= '<div class="grid_4">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_input_attr'),$field.'-input-attributes')."&nbsp;"."\n";
		$form .= form_input(array(
			'name'        => $field.'-input-attributes',
			'id'          => $field.'-input-attributes',
			'value'       => $this->roozbeh->get_field_attributes($table.'.'.$field,'input_attributes'),
			'maxlength'   => '300',
			'size'        => '20',
			'class'       => 'ltr-text'
        ));
		$form .= '</div>'."\n";
		
		$form .= '<div class="grid_4">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_content_table_attr'), $field.'-content-table-attributes')."&nbsp;"."\n";
        $form .= form_input(array(
			'name'        => $field.'-content-table-attributes',
			'id'          => $field.'-content-table-attributes',
			'value'       => $this->roozbeh->get_field_attributes($table.'.'.$field,'content_table_attributes'),
			'maxlength'   => '300',
			'size'        => '20',
			'class'       => 'ltr-text'
        ));
        $form .= '</div>'."\n";
        
        $form .= '<div class="grid_4">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_content_view_attr'), $field.'-content-view-attributes')."&nbsp;"."\n";
        $form .= form_input(array(
			'name'        => $field.'-content-view-attributes',
			'id'          => $field.'-content-view-attributes',
			'value'       => $this->roozbeh->get_field_attributes($table.'.'.$field,'content_view_attributes'),
			'maxlength'   => '300',
			'size'        => '20',
			'class'       => 'ltr-text'
        ));
		$form .= '</div>'."\n";
		
		$form .= '<div class="clear"></div>'."\n";
		
		$form .= '<div class="grid_4">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_char_limit'),$field.'-character-limit')."&nbsp;"."\n";
		$form .= form_input(array(
			'name'        => $field.'-character-limit',
			'id'          => $field.'-character-limit',
			'value'       => $this->roozbeh->get_field_attributes($table.'.'.$field,'character_limit'),
			'maxlength'   => '300',
			'size'        => '5',
			'class'       => 'numeric'
        ));
        $form .= '</div>'."\n";
        
        //$form .= '<div class="clear"></div>'."\n";
        
		$permissions = $this->roozbeh->get_field_view_permissions($table.'.'.$field);
		
		$form .= '<div class="grid_2">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_form'),$field.'-form')."<br/>"."\n";
		$form .= form_checkbox(array(
			'name'        => $field.'-form',
			'id'          => $field.'-form',
			'value'       => '1',
			'checked'     => $permissions['form'],
			'class'       => 'checkbox'
			)); 
		$form .= '</div>'."\n";
		
		$form .= '<div class="grid_2">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_full_view'),$field.'-full-view')."<br/>"."\n";
		$form .= form_checkbox(array(
			'name'        => $field.'-full-view',
			'id'          => $field.'-full-view',
			'value'       => '1',
			'checked'     => $permissions['full_view'],
			'class'       => 'checkbox'
			)); 
		$form .= '</div>'."\n";
		
		$form .= '<div class="grid_2">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_main_table'),$field.'-main-table')."<br/>"."\n";
		$form .= form_checkbox(array(
			'name'        => $field.'-main-table',
			'id'          => $field.'-main-table',
			'value'       => '1',
			'checked'     => $permissions['main_table'],
			'class'       => 'checkbox'
			)); 
		$form .= '</div>'."\n";
		
		$form .= '<div class="grid_2">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_other_tables'),$field.'-other-tables')."<br/>"."\n";
		$form .= form_checkbox(array(
			'name'        => $field.'-other-tables',
			'id'          => $field.'-other-tables',
			'value'       => '1',
			'checked'     => $permissions['other_tables'],
			'class'       => 'checkbox'
			));
		$form .= '</div>'."\n";
		
		$form .= '<div class="grid_2">'."\n";
		$form .= form_label($this->lang->line('roozbeh_set_f_index'), $field.'-index')."<br/>"."\n";
		$form .= form_checkbox(array(
			'name'        => $field.'-index',
			'id'          => $field.'-index',
			'value'       => '1',
			'checked'     => $permissions['index'],
			'class'       => 'checkbox'
			));
		$form .= '</div>'."\n";
		
		$form .= '<div class="clear"></div>'."\n";
		//$form .= '<hr style="margin:0px 0px 15px 0px;border-top:solid #b3b3b3 1px"/>'."\n";
		$form .= '<div class="clear"></div>'."\n";
		$form .= '<div class="grid_16" align="left">'."\n";
		
		$data = array(
		  'value'		=> $this->lang->line('roozbeh_set_f_submit'),
		  'name'		=> 'add_row_submit',
          'class'		=> 'btn btn-success'
        );
        
        $form .= '<div style="text-align: left">'."\n";
		$form .= form_submit($data)."\n";
		
		$data = array(
		  'value'		=> $this->lang->line('roozbeh_set_f_reset'),
		  'name'		=> 'add_row_reset',
          'class'		=> 'btn btn-success'
        );
		$form .= form_reset($data)."\n";
		$form .= '</div>'."\n";
		$form .= '</div>'."\n";
		
		$form .= form_fieldset_close()."\n";
		$form .= form_close()."\n";
		
		// set common properties
		$data['title'] = 'افزودن داده جدید';
		//$data['message'] = '';
		//$data['action'] = site_url('roozbeh/add_row/'.$table_id.'/');
		$data['link_back'] = anchor('roozbeh/tables_settings/','بازگشت',array('class'=>'back'));
			
		$data['form'] = $form;
		
		//$data['top_menu'] = $this->create_top_breadcrumb_menu('roozbeh/fields_settings/'.$table,$table);
		$data['right_menu'] = $this->create_fields_menu($table,$field);

		// load view
		$this->load->view('roozbehview',$data);
	}
	/***************************************************************/
	function save_tables_settings($limit,$offset){
		//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
		
		// save data
		foreach ($this->roozbeh->get_tables_list($limit,$offset) as $table){
			$config = array('name' => $this->input->post($table),
							'label' => $this->input->post($table.'-label'),
							'view' => $this->input->post($table.'-permission'));
			$this->roozbeh->save_tables_config($config);
		}
		
		$message = 'عملیات با موفقیت انجام شد!';
		$this->tables_settings($offset,$message);
		// set user message
		
	}
	/***************************************************************/
	function save_fields_settings($table, $field){
		//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
			
		// save data
		$configs = array('name' => $table.'.'.$field,
						'label' => $this->input->post($field.'-label'),
						'label_form_attributes' => $this->input->post($field.'-label-form-attributes'),
						'label_table_attributes' => $this->input->post($field.'-label-table-attributes'),
						'label_view_attributes' => $this->input->post($field.'-label-view-attributes'),
						'input' => $this->input->post($field.'-input'),
						'input_attributes' => $this->input->post($field.'-input-attributes'),
						'content_table_attributes' => $this->input->post($field.'-content-table-attributes'),
						'content_view_attributes' => $this->input->post($field.'-content-view-attributes'),
						'character_limit' => $this->input->post($field.'-character-limit'),
						'form' => $this->input->post($field.'-form'),
						'full_view' => $this->input->post($field.'-full-view'),
						'main_table' => $this->input->post($field.'-main-table'),
						'other_tables' => $this->input->post($field.'-other-tables'),
						'index' => $this->input->post($field.'-index'));
						
		$this->roozbeh->save_fields_config($configs);

		
		$this->fields_settings($table, $field);
		// set user message
		echo '<div class="success">عملیات با موفقیت انجام شد!</div>';
	}
	/***************************************************************/
	function tables_page(){
		$data['top_menu'] = $this->create_top_breadcrumb_menu(current_url(),$this->lang->line('roozbeh_tables'));
		$data['right_menu'] = $this->create_tables_menu();
		
		$this->load->view('roozbehview', $data);
	}
	/***************************************************************/
	function settings_page(){
		//if($this->session->userdata('user_type') != 'admin')
			//header('Location: '.site_url('roozbeh'));
			
		$data['top_menu'] = $this->create_top_breadcrumb_menu(current_url(),$this->lang->line('roozbeh_rmenu_settings'));
		$data['right_menu'] = $this->create_settings_menu();
		
		$this->load->view('roozbehview', $data);
	}
	/***************************************************************/
	function view_table($table_id,$offset=0){
		$table = $this->roozbeh->id_to_item($table_id);
		
		// offset
		$uri_segment = 4;
		$limit = 10;
		
		// load data
		$this->roozbeh->set_default_table($table);
		$rows = $this->roozbeh->get_join_paged_list($limit,$offset);

		// generate pagination
		$this->load->library('pagination');
		$config['base_url'] = site_url('roozbeh/view_table/'.$table_id.'/');
 		$config['total_rows'] = $this->roozbeh->get_rows_count();
 		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		
		// generate table data
		$this->load->library('table');
		$tmpl = array ( 'table_open'  => '<table class="table table-striped">');
		$this->table->set_template($tmpl);
		$this->table->set_empty('&nbsp;');
		
		$header = array();
		
		$header[] =array('content' => 'ردیف', 'scope'=>'col', 'class' => 'rounded-no');
		
		$header_labels = $this->roozbeh->get_join_fields_list('','main_table');
		foreach($header_labels as $field){
			$header[] = array('content' => $this->roozbeh->get_field_label($field,$field),
							  'scope' => 'col',
							  'class' => 'rounded-q1',
							  'attributes' => $this->roozbeh->get_field_attributes($field,'label_table_attributes'));
		}
		
		$header[] =array('content' => 'امکانات', 'scope'=>'col', 'class' => 'rounded-q4');
		
		$this->table->set_heading($header);
		
		$pkn = $this->roozbeh->get_table_pk();
		$permissions = $this->roozbeh->get_field_view_permissions($table.'.'.$pkn);
		foreach ($rows as $row){
			
			$cells = array();
			
			$cells[] = array('content' => ++$offset, 'width' => '20px');
			
			$i = 0;
			foreach($row as $key => $cell){
				if($key == $table.'.'.$pkn && !$permissions['main_table'])
					continue;

				$pk = $row[$table.'.'.$pkn];
				$input_type = $this->roozbeh->get_field_input_type($header_labels[$i]);
				$cell_value = (($cell != '') ? $cell : 'NULL');
				if($cell_value != 'NULL' && $input_type == 'jalali')
					$cell_value = $this->jalali->convert_to_jalali($cell_value);
				$cl = $this->roozbeh->get_field_attributes($header_labels[$i],'character_limit');
				if($cl > 0)
					$cell_value = character_limiter($cell_value, $cl);
				$cell_value = strip_tags($cell_value);
				$cell_value = ($cell_value == '') ? ' ' : $cell_value;
				$cells[] = array('content' => anchor('roozbeh/view_row/'.$this->roozbeh->item_to_id($table).'/'.$pk,
													 $cell_value,
													 'class="view"'.' '.$this->roozbeh->get_field_attributes($header_labels[$i],'content_table_attributes')));
				$i++;
			}
			
			$cells[] = array('content' => anchor('roozbeh/create_form/'.$this->roozbeh->item_to_id($table).'/'.$pk,'ویرایش',array('class'=>'btn btn-success')).'&nbsp&nbsp&nbsp'.
				anchor('roozbeh/delete_row/'.$this->roozbeh->item_to_id($table).'/'.$pk,'حذف',array('class'=>'btn btn-danger','onclick'=>"return confirm('آیا قصد دارید این سطر را حذف کنید؟')")));
			
			
			$this->table->add_row($cells);
		}
		
		$footer = array();	
		$footer[] = array('content' => anchor('roozbeh/create_form/'.$this->roozbeh->item_to_id($table),'افزودن سطر جدید',array('class'=>'btn btn-success')),
						  'colspan' => count($header_labels)+1, 'class' => 'rounded-foot-left');
		$footer[] = array('content' => '', 'class' => 'rounded-foot-right');
		$this->table->add_row($footer);
				
		$this->roozbeh->delete_top_breadcrumb_menu_items(site_url('roozbeh/tables_page'), FALSE);

		/* Common*/
		$data['title'] = 'پیکربندی فیلدها';
		//$data['top_menu'] = $this->create_top_breadcrumb_menu(current_url(),$this->roozbeh->get_table_label($table,$table));
		//$data['right_menu'] = $this->create_tables_menu($table_id);
		
		/* Table */
		$data['table'] = $this->table->generate();

		/* Form */
		$data['action'] = site_url('roozbeh/save_tables_settings');

		$this->load->view('roozbehview',$data);
	}
	/***************************************************************/
	function view_row($table_id, $pk){
	
		$table = $this->roozbeh->id_to_item($table_id);
		
		// get table details
		$this->roozbeh->set_default_table($table);
		$row = $this->roozbeh->get_join_row_by_pk($pk);
		$fields = $this->roozbeh->get_join_fields_list('','full_view');
		
		$this->load->library('table');
		$tmpl = array ( 'table_open'  => '<table class="table table-striped">');
		$this->table->set_template($tmpl);
		$this->table->set_empty('&nbsp;');
		
		$header = array();
		
		$header[] =array('content' => 'عنوان', 'scope'=>'col', 'class' => 'rounded-no');
		$header[] =array('content' => 'شرح', 'scope'=>'col', 'class' => 'rounded-q4');
		
		$this->table->set_heading($header);
		
		foreach($row as $cell){
			$cells = array();
			$field = current($fields);
			$cells[] = array('content' => $this->roozbeh->get_field_label($field,$field),
							 'attributes' => $this->roozbeh->get_field_attributes($field,'label_view_attributes'));
			
			$input_type = $this->roozbeh->get_field_input_type($field);
			$cell_value = (($cell != '') ? $cell : 'NULL');
			if($cell_value != 'NULL' && $input_type == 'jalali')
				$cell_value = $this->jalali->convert_to_jalali($cell_value);
			
			$cells[] = array('content' => $cell_value,
							 'attributes' => $this->roozbeh->get_field_attributes($field,'content_view_attributes'));
			
			$this->table->add_row($cells);
			
			next($fields);
		}
		
		$footer = array();	
		$footer[] = array('content' => '',
						  'colspan' => 0, 'class' => 'rounded-foot-left');
		$footer[] = array('content' => '', 'class' => 'rounded-foot-right');
		$this->table->add_row($footer);
		
		/* Common*/
		$data['title'] = 'جزئیات جدول';
		//$data['top_menu'] = $this->create_top_breadcrumb_menu(current_url(),$this->roozbeh->get_table_label($table,$table));
		//$data['right_menu'] = $this->create_tables_menu($table_id);
		$data['link_back'] = anchor('roozbeh/view_table/'.$table_id,'بازگشت',array('class'=>'back'));
		
		/* Table */
		$data['table'] = $this->table->generate();

		$this->load->view('roozbehview',$data);
	}
	/***************************************************************/
	function delete_row($table_id, $pk){
		// delete table
		$table = $this->roozbeh->id_to_item($table_id);
		$this->roozbeh->set_default_table($table);
		$this->roozbeh->delete($pk);

		// redirect to projects list page
		redirect('roozbeh/view_table/'.$table_id,'refresh');
	}
	/***************************************************************/
	function create_form($table_id, $pk=NULL, $message=NULL){
		
		$table = $this->roozbeh->id_to_item($table_id);
		$this->roozbeh->set_default_table($table);

		if($pk)
			$site_url = 'roozbeh/update_row/'.$table_id.'/'.$pk.'/';
		else
			$site_url = 'roozbeh/add_row/'.$table_id.'/';

		$form = form_open(site_url($site_url), array('class' => 'form-horizontal'))."\n";

		$form .= form_fieldset('<b>« '.$this->roozbeh->get_table_label($table,$table).' »</b>')."\n";

		foreach($this->roozbeh->get_fields_list() as $field){
			$de = false;

			$label = $this->roozbeh->get_field_label($table.'.'.$field,$field);
			$label_attr = $this->roozbeh->get_field_attributes($table.'.'.$field,'label_form_attributes');
			
			$input_attr = $this->roozbeh->get_field_attributes($table.'.'.$field,'input_attributes');

			$permissions = $this->roozbeh->get_field_view_permissions($table.'.'.$field);

			$result = $this->roozbeh->get_field_value_by_pk($pk,$field);

			$field_type = $this->roozbeh->get_field_type($field);
			$input_type = $this->roozbeh->get_field_input_type($table.'.'.$field);
		/* 
			if($this->roozbeh->is_field_fk($table,$table.'.'.$field)){
				$referenced_table = $this->roozbeh->get_fk_referenced_table($table,$table.'.'.$field);				
				
				if($this->roozbeh->is_system_table($referenced_table))
					continue;

				$referenced_table_form = '/roozbeh/create_form/'.
											$this->roozbeh->item_to_id($referenced_table);
				
				$form .= '<div class="grid_4">'."\n";
				$form .=  form_label($label, $field,$label_attr)."<br/>"."\n";
				$form .= form_fk_dropdown($field, $this->roozbeh->get_fk_values_list($table, $table.'.'.$field),
											(array_key_exists($field, $result) ? $result->$field : ''),
											$input_attr,
											$referenced_table_form)."\n";
				$form .= '</div>'."\n"; 
			}
			else 
			*/
			if(stripos($field_type, 'enum') === 0){
				$field_type = substr($field_type,5,-1);
				$items = preg_split('/,/',$field_type);
				
				$data = array();
				foreach($items as $item){
					$v = substr($item,1,-1);
					$data += array($v => $v);
				}
				
				$form .= '<div class="grid_4">'."\n";
				$form .=  form_label($label, $field, $label_attr)."<br/>"."\n";
				$form .= form_dropdown($field, $data,
											(array_key_exists($field, $result) ? $result->$field : ''), $input_attr)."\n";
				$form .= '</div>'."\n";
				
			}
			
			else if(stripos($field_type, 'set') === 0){
				$field_type = substr($field_type,4,-1);
				$items = preg_split('/,/',$field_type);
				
				$form .= '<div class="grid_'.(count($items)+1).'">'."\n";
				$form .=  form_label($label, $field, $label_attr)."<br/>"."\n";
				
				$checked = FALSE;
				$vs = array();
				
				if(array_key_exists($field, $result)){
					$vs = preg_split('/,/',$result->$field);
				}
				
				$data = array();
				foreach($items as $item){
					$v = substr($item,1,-1);
					
					if(array_key_exists($field, $result)){
						$checked = in_array($v, $vs);
					}
					
					$form .= form_checkbox($field.'[]', $v, $checked, $input_attr);
					$form .= $v."\n";
				}
				$form .= '</div>'."\n";
				
			}

			else if($permissions['form']){
				$form .= '<div >'."\n";

				$input_data = array('name'        => $field,
									'id'          => $field,
									'maxlength'   => '100',
									'size'        => '28',
									'class'       => 'text',
									'value'		=> (array_key_exists($field, $result) ? $result->$field : '')
									);
				
				switch ($input_type) {
					case 'input' :
						$form .= form_label($label, $field, $label_attr)."&nbsp;"."\n";
						$form .= form_input($input_data,'',$input_attr)."\n";
						break;
					
					case 'jalali' :
						$form .=  form_label($label, $field, $label_attr)."&nbsp;"."\n";
						if($input_data['value'] != '')
							$input_data['value'] = $this->jalali->convert_to_jalali($input_data['value']);
						$form .= form_jalali_date_input($input_data,'',$input_attr)."\n";
						break;
					
					case 'ltr_input' :
						$form .= form_label($label, $field, $label_attr)."&nbsp;"."\n";
						$form .= form_ltr_input($input_data,'',$input_attr)."\n";
						break;
						
					case 'user_id' :
						$form .= form_label($label, $field, $label_attr)."&nbsp;"."\n";
						$form .= form_user_id($input_data,'',$input_attr)."\n";
						break;
						
					case 'upload' :
						$form .= form_label($label, $field, $label_attr)."&nbsp;"."\n";
						$form .= form_upload($input_data,'',$input_attr)."\n";
						break;

					case 'numeric' :
						$form .= form_label($label, $field, $label_attr)."&nbsp;"."\n";
						$form .= form_numeric_input($input_data,'',$input_attr)."\n";
						break;

					case 'password' :
						$form .= form_label($label, $field, $label_attr)."&nbsp;"."\n";
						$form .= form_password($input_data,'',$input_attr)."\n";
						break;

					case 'tinymce' :
						if(!$de){
							$form .= '</div>'."\n";
							$de = true;
						}
						$form .= '<div class="clear"></div>'."\n";
						$form .= form_label($label, $field, $label_attr)."&nbsp;"."\n";
						$form .= form_tinymce_editor($input_data,'',$input_attr)."\n";
						$form .= '<div class="clear"></div>'."\n";
						break;
						
					case 'forigen_key' :
									if($this->roozbeh->is_field_fk($table,$table.'.'.$field)){
											$referenced_table = $this->roozbeh->get_fk_referenced_table($table,$table.'.'.$field);				
											
											if($this->roozbeh->is_system_table($referenced_table))
												continue;

											$referenced_table_form = '/roozbeh/create_form/'.
																		$this->roozbeh->item_to_id($referenced_table);
											
											$form .= '<div class="grid_4">'."\n";
											$form .=  form_label($label, $field,$label_attr)."&nbsp;"."\n";
											$form .= form_fk_dropdown($field, $this->roozbeh->get_fk_values_list($table, $table.'.'.$field),
																		(array_key_exists($field, $result) ? $result->$field : ''),
																		$input_attr,
																		$referenced_table_form)."\n";
											$form .= '</div>'."\n"; 
										}
						break;
				}
				(!$de) ? $form .= '</div>'."\n" : $form .= '';
			}
		}
		
		$form .= '<div class="clear"></div>'."\n";
		//$form .= '<hr style="margin:0px 0px 15px 0px;border-top:solid #b3b3b3 1px"/>'."\n";
		$form .= '<div class="clear"></div>'."\n";
		$form .= '<div class="grid_16" align="left">'."\n";
		$data = array(
		  'value'		=> 'درج',
		  'name'		=> 'add_row_submit',
          'style'       => 'width:120px;margin:0px 5px 0px 5px',
          'class'       => 'btn btn-success'
        );
        $form .= '<div style="text-align: left">'."\n";
		$form .= form_submit($data)."\n";
		$data = array(
		  'value'		=> 'بازیابی',
		  'name'		=> 'add_row_reset',
          'style'       => 'width:120px;margin:0px 5px 0px 5px',
          'class'       => 'btn btn-success'
        );
		$form .= form_reset($data)."\n";
		$form .= '</div>'."\n";
		$form .= '</div>'."\n";
		
		$form .= form_fieldset_close()."\n";
		$form .= form_close()."\n";
		// set common properties
		$data['title'] = 'افزودن داده جدید';
		$data['message'] = $message;
		
		$data['form'] = $form;
		
		//$data['top_menu'] = $this->create_top_breadcrumb_menu('/roozbeh/create_form/'.$table_id,$this->roozbeh->get_table_label($table,$table));

		// load view
		$this->load->view('roozbehview',$data);
	}
	/***************************************************************/
	function add_row($table_id){
		$table = $this->roozbeh->id_to_item($table_id);
		
		$this->roozbeh->set_default_table($table);
		
		$post_data = '';
		$data = array();
		foreach($this->roozbeh->get_fields_list() as $field){
			$field_type = $this->roozbeh->get_field_type($field);

			if(stripos($field_type, 'set') === 0){
				foreach($this->input->post($field) as $v){
					$post_data .= $v.',';
				}
			}
			else if($this->roozbeh->get_fk_referenced_field('',$table.'.'.$field) == '_system_users.userId'){
				$post_data = $this->session->userdata('user_id');
			}
			else {
				$input_type = $this->roozbeh->get_field_input_type($table.'.'.$field);
				$post_data = $this->input->post($field);
				if($input_type == 'jalali' && $post_data != '')
					$post_data = $this->jalali->convert_to_gregorian($post_data);
			}
			
			$data = array_merge($data, array($field => $post_data));
			$post_data = '';
		}
		$id = $this->roozbeh->insert($data);
	
		$message= 'عملیات با موفقیت انجام شد!';
		$this->create_form($table_id,$id,$message);
	}
	/***************************************************************/
	function update_row($table_id,$id){
		$table = $this->roozbeh->id_to_item($table_id);
		
		$this->roozbeh->set_default_table($table);
		
		$post_data = '';
		$data = array();
		foreach($this->roozbeh->get_fields_list() as $field){
			$field_type = $this->roozbeh->get_field_type($field);

			if(stripos($field_type, 'set') === 0){
				foreach($this->input->post($field) as $v){
					$post_data .= $v.',';
				}
			}
			else if($this->roozbeh->get_fk_referenced_field('',$table.'.'.$field) == '_system_users.userId'){
				$post_data = $this->session->userdata('user_id');
			}
			else {
				$input_type = $this->roozbeh->get_field_input_type($table.'.'.$field);
				$post_data = $this->input->post($field);
				if($input_type == 'jalali' && $post_data != '')
					$post_data = $this->jalali->convert_to_gregorian($post_data);
			}
							
			$data = array_merge($data, array($field => $post_data));
			$post_data = '';
		}
		$this->roozbeh->update($id,$data);
	
		$message= 'عملیات با موفقیت انجام شد!';
		$this->create_form($table_id,$id,$message);

	}
	/***************************************************************/
	
}

?>
