<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <?php  $this->aylin->visitor_counter(); ?>
    <title><?php echo $this->aylin->config("title","config_site"); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="">
	<meta name="description" content="<?php echo $this->aylin->config("description","config_site"); ?>">	
	<?php 
	if(isset($meta))
	{
		echo $meta;
	}
	?>
   	
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .f1{
		  list-style-type: none;
		  }
    </style>
    <link href="<?php echo base_url("assets/css/bootstrap-responsive.css"); ?>" rel="stylesheet">
       	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/bootstrap.css"); ?>" />
   	<link rel="stylesheet" type="text/css" href="<?php echo base_url("assets/css/main.css"); ?>" />
   	

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/assets/img/favicon.ico">

<?php 
if(isset($css_files) && isset($js_files)){
?>
	<?php 
		foreach($css_files as $file): ?>
			<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php endforeach; ?>
	<?php foreach($js_files as $file): ?>
		<script src="<?php echo $file; ?>"></script>
	<?php endforeach; ?>
<?php }else{ ?>
	<script src="<?php echo base_url("assets/js/jquery-1.7.1.min.js"); ?>" type="text/javascript"> </script>
<?php } ?>
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
          <a class="brand" href="#"><?php echo $this->aylin->config("title","config_site"); ?></a>
          <div class="nav-collapse">
		<?php include("menu.php"); ?>
          </div><!--/.nav-collapse -->
        </div>
      </div>

    </div>

    <div class="container">
	<div style='min-height:700px;'> <!-- start of befor_footer -->
	<?php
	 
		if($this->aylin->config("slide_show","config_links") == 1)
			if($this->aylin->config("show_just_in_homepage","config_links") == 1)
			{
				if($this->uri->segment(1)=="")
					echo $this->aylin->slides();
			}
			else
			{
				echo $this->aylin->slides(); 
			}
	?>

      <!-- Example row of columns -->
      <div class="row">
        <div class="span12" id="main_content">
