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
		echo '<li class="active">'. anchor("/", "خانه", "title=HOME") .'</li>';
	else
		echo '<li>'.anchor("/", "خانه", "title=HOME").'</li>';

	
	if($this->session->userdata('user_group')){
		
		$str = $this->aylin->get_menu_list($this->session->userdata('user_group'),$uri_arr);	
		$str =  preg_replace('/class="child"/','class="nav"',$str,1);
		echo $str;
		echo '<li>'.anchor("/users/logout", "خروج").'</li>';
		
	}else{
		$str =  $this->aylin->get_menu_list("public",$uri_arr);	
		$str =  preg_replace('/class="child"/','class="nav"',$str,1);
		echo $str;
	?>
	<li><?php echo anchor("users/login", 'ورود ', 'title=login'); ?></li> 
	<?php
	}
	?>
</ul>
