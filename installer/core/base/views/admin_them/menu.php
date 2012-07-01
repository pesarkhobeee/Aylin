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
		$this->db->where("menu_section","admin");	
		$query = $this->db->get('menu');
		foreach ($query->result() as $row)
		{
			if($row->menu_url==$uri_arr)
				echo "<li class='active'>".anchor($row->menu_url,$row->menu_name)."</li>";
			else	
				echo "<li>".anchor($row->menu_url,$row->menu_name)."</li>";
		}
		echo '<li>'.anchor("/users/logout", "خروج").'</li>';
	}else{
		$this->db->where("menu_section","user");	
		$query = $this->db->get('menu');
		foreach ($query->result() as $row)
		{
			if($uri!=$row->menu_url)	
				echo "<li>".anchor($row->menu_url,$row->menu_name)."</li>";
			else	
				echo "<li class='active'>".anchor($row->menu_url,$row->menu_name)."</li>";
		}
	?>
	<li><?php echo anchor("welcome/login", 'ورود ', 'title=login'); ?></li>
	<?php
	}
	?>
</ul>
