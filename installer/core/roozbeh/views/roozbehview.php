<?php
/****** Data of page ******/
$passed_data = array('title','message','link_back','top_menu','right_menu','header','form','table','footer','pagination','hidden_inputs','action','scripts');
$defined_vars = array_keys(get_defined_vars());

foreach($passed_data as $pd){
	if(!in_array($pd, $defined_vars)){
		$$pd = NULL;
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="fa">

<head>
	<title><?php echo $title; ?></title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link href="<?php echo base_url("assets/css/bootstrap-responsive.css"); ?>" rel="stylesheet">
  	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
   	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/main.css"); ?>" />
	
	
	
	 <script type="text/javascript" src="<?php echo base_url(); ?>assets/tiny_mce/tiny_mce.js"></script>

	
	<!-- Table stylesheet -->
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>styles/table/style.css" />

	<!-- Jalali popup calendar -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/calendar/skins/aqua/theme.css" />
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/calendar/jalali.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/calendar/calendar.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/calendar/lang/calendar-fa.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/calendar/calendar-setup.js"></script>
	
	
	<?php if($scripts) echo $scripts;?>
	<script type="text/javascript">
	<!--
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
    //-->
	</script>
	
	<!-- Main stylesheet -->
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url(); ?>styles/style.css" />
	
	<style>
		form{
			text-align:right;
			direction:rtl;
		}
		
		#roozbeh_menu li{
			display:inline;
			margin-right:15px;
		}
		
		label {
			display: inline;
			float: right;
			margin-bottom: 5px;
			margin-left: 5px;
		}
		
		div.jdate-box .jdate-entry ,input.ltr-text, select.ltr-menu, input.numeric, input.table_ltr_text, select.table_ltr_menu {
			direction:ltr;
			font-family:Tahoma, verdana,helvetica,arial,sans-serif;
		}

	</style>
</head>

<body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">

          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#"><?php echo $this->aylin_config->config("title","config_site"); ?></a>
          <div class="nav-collapse">
		<?php include("menu.php"); ?>
          </div><!--/.nav-collapse -->
        </div>
      </div>

    </div>
    
	<?php
	if($right_menu){
		echo '<br><br><br><div >';
		echo $right_menu;
		echo '</div>';
	}
	?>
    <div class="container">
		<br><br><br>
			
		<div align="center">
			<?php 	
			if($message){
				echo'<div class="fade in alert alert-success">
        <a class="close" data-dismiss="alert">×</a>';
				echo $message; 
				echo '</div><br/><br/>';
			}
			?>
		</div>
	   

		<?php
	
	
		if($table){
			if($hidden_inputs){
				echo form_open($action);
				foreach($hidden_inputs as $hi)
					echo $hi;
			}

			echo $table;

			if($pagination){
				echo '<div class="paging" >';
				echo $pagination;
				echo '</div>';
			}
			
			if($hidden_inputs)
				echo form_close();
			echo '<br/><br/><br/>';
		}
	
		if($form){
			echo $form;
		}
	
		?>
	
	</div>
	
</div>
</body>
</html>
