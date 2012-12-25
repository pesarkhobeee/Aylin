<?php
/*
 * index.php
 * 
 * Copyright 2012 zanjanhost <info@zanjanhost.com>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>نصاب آیلین</title>
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
</head>

<body>
	<form action="install.php" method="post" >
	<fieldset>
    <legend>گام اول</legend>
		<table class="table table-striped">
			<tr>
				<td>عنوان سایت</td>
				<td><input type="text" name="title" /></td>		
			</tr>
			<tr>
				<td>توضیح</td>
				<td><input type="text" name="description" /></td>		
			</tr>
			<tr>
				<td>فعال سازی ثبت نام کاربران</td>
				<td>
					بله <input type="radio" value="1" name="users_register">
					<br>
						خیر <input type="radio" value="0" name="users_register">
				</td>		
			</tr>
			<tr>
				<td>آدرس پایه</td>
				<td><input type="text" name="base_url" value="<?php 
					$base_url= "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					$base_url= str_replace("/installer/","",$base_url);
					echo trim($base_url);
				?>" /></td>		
			</tr>
			<tr>
				<td>نمایش widget ها</td>
				<td>

					بله <input type="radio" value="1" name="widgets">
					<br>
						خیر <input type="radio" value="0" name="widgets">
				

</td>
			</tr>
			<tr>
				<td>smtp Host</td>
				<td><input type="text" name="smtp_host" /></td>		
			</tr>
			<tr>
				<td>smtp Port</td>
				<td><input type="text" name="smtp_port" value="25" /></td>		
			</tr>
			<tr>
				<td>smtp username</td>
				<td><input type="text" name="smtp_user" /></td>		
			</tr>
			<tr>
				<td>smtp Password</td>
				<td><input type="text" name="smtp_pass" /></td>		
			</tr>
			<tr>
				<td>smtp Defualt Emil Address</td>
				<td><input type="text" name="smtp_mail" /></td>		
			</tr>					
		</table>
	</fieldset>
	<fieldset>
    <legend>گام دوم</legend>
		<table class="table table-striped">
			<tr>
				<td>درایور پایگاه داده</td>
				<td><input type="text" name="db_driver" value="mysql" /></td>		
			</tr>
			<tr>
				<td>هاست پایگاه داده</td>
				<td><input type="text" name="db_host" value="localhost" /></td>		
			</tr>
			<tr>
				<td>نام پایگاه داده</td>
				<td><input type="text" name="db_name" /></td>		
			<tr>
				<td>نام کاربری پایگاه داده</td>
				<td><input type="text" name="db_username" /></td>		
			</tr>
			<tr>
				<td>کلمه عبور پایگاه داده</td>
				<td><input type="text" name="db_password" /></td>		
			</tr>
		</table>
	</fieldset>
	<fieldset>
    <legend>گام سوم</legend>
		<table class="table table-striped">
			<tr>
				<td><input type="checkbox" name="codeigniter" value="codeigniter"  checked="checked"/></td>
				<td><img src="assets/code_igniter.jpeg" /></td>
				<td>CodeIgniter 2.1.3</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="grocery" value="grocery" checked="checked" /></td>
				<td><img src="assets/grocery.png" /></td>	
				<td>Grocery CRUD 1.3.2</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="bootstrap" value="bootstrap" checked="checked" /></td>
				<td><img src="assets/bootstrap.jpeg" /></td>	
				<td>Bootstrap 2.2.1</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="aylin" value="aylin" checked="checked" /></td>
				<td><img src="assets/aylin.jpg" /></td>
				<td>Aylin</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="roozbeh" value="roozbeh"  /></td>
				<td><img src="assets/roozbeh.jpg" /></td>
				<td>Roozbeh</td>
			</tr>
		</table>
		</fieldset>
		<fieldset>
		<legend>گام چهارم</legend>
			<table class="table table-striped">
				<tr>
					<td><input type="checkbox" name="content" value="content"  checked="checked"/></td>
					<td> سیستم مدیریت محتوا بهمراه CKEditor 3.6.2</td>
				</tr>
				<tr>
					<td><input type="checkbox" name="newsletter" value="newsletter"  checked="checked"/></td>
					<td>سیستم خبرنامه</td>
				</tr>
				<tr>
					<td><input type="checkbox" name="news" value="news"  checked="checked"/></td>
					<td>سیستم اخبار</td>
				</tr>
				<tr>
					<td><input type="checkbox" name="links" value="links"  checked="checked"/></td>
					<td>سیستم لینک ها و لوگو ها</td>
				</tr>
				<tr>
					<td><input type="checkbox" name="poll" value="poll"  checked="checked"/></td>
					<td>سیستم نظرسنجی</td>
				</tr>
				<tr>
					<td><input type="checkbox" name="ajaxfilemanager" value="ajaxfilemanager"  checked="checked"/></td>
					<td>سیستم مدیریت فایل</td>
				</tr>
				<tr>
					<td><input type="checkbox" name="message" value="message"  checked="checked"/></td>
					<td>سیستم مدیریت پیغام ها</td>
				</tr>
			</table>
		</fieldset>
		
		<input type="submit" value="نصب" class="btn btn-primary" style="width:100%;"/>
	</form>

	
</body>

</html>

