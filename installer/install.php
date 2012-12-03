<?php
	include_once("functions.php");

	if(isset($_POST["codeigniter"])){
		extractor("./core/CodeIgniter_2.1.3.zip","../");	
		smartCopy("../CodeIgniter_2.1.3/","..");
		rrmdir("../CodeIgniter_2.1.3");
		replace_in_file("['helper'] = array();","['helper'] = array('url');","../application/config/autoload.php");
		replace_in_file("['base_url']	= ''","['base_url']	= '".$_POST["base_url"]."'","../application/config/config.php");
		replace_in_file("['encryption_key'] = '';","['encryption_key'] = '".GenerateKey()."';","../application/config/config.php");
		replace_in_file("['helper'] = array();","['helper'] = array('url');","../application/config/autoload.php");
		replace_in_file("['libraries'] = array();","['libraries'] = array('database', 'session');","../application/config/autoload.php");
		replace_in_file("['default']['hostname'] = ''","['default']['hostname'] = '".$_POST["db_host"]."'","../application/config/database.php");
		replace_in_file("['default']['username'] = ''","['default']['username'] = '".$_POST["db_username"]."'","../application/config/database.php");
		replace_in_file("['default']['password'] = ''","['default']['password'] = '".$_POST["db_password"]."'","../application/config/database.php");
		replace_in_file("['default']['database'] = ''","['default']['database'] = '".$_POST["db_name"]."'","../application/config/database.php");
		replace_in_file("['default']['dbdriver'] = ''","['default']['dbdriver'] = '".$_POST["db_driver"]."'","../application/config/database.php");		
	}

	if(isset($_POST["grocery"])){
		extractor("./core/grocery_CRUD-1.3.2.zip","../");
		replace_in_file('$config[\'grocery_crud_default_language\']	= \'english\';','$config[\'grocery_crud_default_language\']	= \'persian\';',"../application/config/grocery_crud.php");
	}

	if(isset($_POST["bootstrap"])){
		extractor("./core/bootstrap.zip","../");
		smartCopy("../bootstrap/","../assets");
		rrmdir('../bootstrap');
	}
	
	if(isset($_POST["aylin"])){
		extractor("./core/base.zip","../application/");
		smartCopy("../application/assets/","../assets");
		rrmdir('../application/assets/');
		import_db_file("../application/db.sql");
		import_db_file("../application/data.sql");
		replace_in_file("['libraries'] = array('database', 'session');","['libraries'] = array('database', 'session','aylin');","../application/config/autoload.php");
		replace_in_file('$config[\'global_xss_filtering\'] = FALSE;','$config[\'global_xss_filtering\'] = TRUE;',"../application/config/config.php");
		replace_in_file('$config[\'sess_use_database\']	= FALSE;','$config[\'sess_use_database\']	= TRUE;',"../application/config/config.php");
		replace_in_file("<?php","<?php ini_set('date.timezone', 'Asia/tehran');","../index.php");
		$db_data=array("name"=>"users_register","value"=>$_POST["users_register"],"group"=>"config_site");
		auto_generate_insert("meta_data",$db_data);
		$db_data=array("name"=>"title","value"=>$_POST["title"],"group"=>"config_site");
		auto_generate_insert("meta_data",$db_data);
		$db_data=array("name"=>"smtp_host","value"=>$_POST["smtp_host"],"group"=>"config_mail");
		auto_generate_insert("meta_data",$db_data);
		$db_data=array("name"=>"smtp_port","value"=>$_POST["smtp_port"],"group"=>"config_mail");
		auto_generate_insert("meta_data",$db_data);
		$db_data=array("name"=>"smtp_user","value"=>$_POST["smtp_user"],"group"=>"config_mail");
		auto_generate_insert("meta_data",$db_data);
		$db_data=array("name"=>"smtp_pass","value"=>$_POST["smtp_pass"],"group"=>"config_mail");
		auto_generate_insert("meta_data",$db_data);
		$db_data=array("name"=>"smtp_mail","value"=>$_POST["smtp_mail"],"group"=>"config_mail");
		auto_generate_insert("meta_data",$db_data);
		$db_data=array("name"=>"widgets","value"=>$_POST["widgets"],"group"=>"config_site");
		auto_generate_insert("meta_data",$db_data);
	}
	
	if(isset($_POST["roozbeh"])){
		extractor("./core/roozbeh.zip","../application/");
		smartCopy("../application/assets/","../assets");
		rrmdir('../application/assets/');
		import_db_file("../application/db.sql");
		import_db_file("../application/data.sql");
	}
	
	if(isset($_POST["content"])){
		extractor("./core/sub_systems/content.zip","../application/");
		smartCopy("../application/assets/","../assets");
		rrmdir('../application/assets/');
		import_db_file("../application/data.sql");
	}
	
	
	if(isset($_POST["newsletter"])){
		extractor("./core/sub_systems/newsletter.zip","../application/");
		import_db_file("../application/db.sql");
		import_db_file("../application/data.sql");
	}

	if(isset($_POST["news"])){
		extractor("./core/sub_systems/news.zip","../application/");
		import_db_file("../application/db.sql");
		import_db_file("../application/data.sql");
	}
	
	if(isset($_POST["links"])){
		extractor("./core/sub_systems/links.zip","../application/");
		import_db_file("../application/db.sql");
		import_db_file("../application/data.sql");
	}

	if(isset($_POST["poll"])){
		extractor("./core/sub_systems/poll.zip","../application/");
		import_db_file("../application/db.sql");
		import_db_file("../application/data.sql");
	}

    if(isset($_POST["ajaxfilemanager"])){
        extractor("./core/sub_systems/ajaxfilemanager.zip","../application/");
  		smartCopy("../application/ajaxfilemanager/","../assets");
		rrmdir('../application/ajaxfilemanager/');      
    }   
	
	if(isset($_POST["message"])){
		extractor("./core/sub_systems/message.zip","../application/");
		import_db_file("../application/db.sql");
		import_db_file("../application/data.sql");
	}
	?>
	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>نصاب آیلین</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 0.21" />
	<link href="assets/bootstrap.min.css" rel="stylesheet">
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<style>
		body{
			direction:rtl;
		}
		input{
			direction:ltr;
		}
	</style>

<body>
	<div class="fade in alert alert-success">
		<a class="close" data-dismiss="alert">×</a>
		<strong>تبریک میگوییم</strong>
		نصب آیلین با موفقیت به پایان رسید.
		<br>
		نام کاربری و کلمه عبور پیش فرض admin است 
	</div>
	<div class="fade in alert alert-error">
		<a class="close" data-dismiss="alert">×</a>
		<strong>توجه</strong>
		هر چه سریعتر پوشه install را پاک کنید
	</div>
</body>

</html>

