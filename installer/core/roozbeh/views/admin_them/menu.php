 <ul class="nav">
<?php
	$this->load->helper('url');
    $this->load->library('session');
	$uri= uri_string();
	$uri_arr=explode("/",$uri);
        if($uri!="")
		if(isset($uri_arr[1]))
			$uri_arr=$uri_arr[0]."/".$uri_arr[1];
		else
			$uri_arr="";
	else
		$uri_arr="";
	if($uri==""||$uri=="welcome/welcome")
		echo '<li class="active">'. anchor("welcome/welcome", "خانه", "title=HOME") .'</li>';
	else
		echo '<li>'.anchor("welcome/welcome", "خانه", "title=HOME").'</li>';

	
	if(($this->router->fetch_class()!="welcome" && $this->uri->segment(1)!="")||$this->session->userdata('user_group')){
		
		$str = $this->aylin_config->get_menu_list($this->session->userdata('user_group'),$uri_arr);	
		$str =  preg_replace('/class="child"/','class="nav"',$str,1);
		echo $str;
		echo $this->aylin_config->create_tables_menu();
		echo '<li>'.anchor("/users/logout", "خروج").'</li>';
		
	}else{
		$str =  $this->aylin_config->get_menu_list("public",$uri_arr);	
		$str =  preg_replace('/class="child"/','class="nav"',$str,1);
		echo $str;
	?>
	<li><?php echo anchor("welcome/login", 'ورود ', 'title=login'); ?></li> 
	<?php
	}
	?>
</ul>



