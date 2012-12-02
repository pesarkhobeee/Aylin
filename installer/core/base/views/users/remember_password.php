 <?php
			if(isset($msg)){echo "<div class='fade in alert alert-success'>
        <a data-dismiss='alert' class='close'>×</a>
         $msg</div>";}
?>

<?php
			if(isset($alert)){echo "<div class='fade in alert alert-warning'>
        <a data-dismiss='alert' class='close'>×</a>
       $alert</div>";}
?>

 
 <?php echo validation_errors();
 if(!isset($msg) && !isset($msg))
 {
  ?>
 <div style="text-align:center;">
 <?php
 echo form_open('users/remember_password_submit');
 echo '<ul id="remember_password" style="list-style-type:none;">';
 echo '<li>'.form_label('پست الکترونیک خود را وارد کنید', 'mail').form_input(array("name"=>"mail","id"=>"mail"))."</li>";
 echo '<li>'.form_submit(array('class'=>'btn btn-primary'), 'بازیابی رمز عبور').'</li></ul>';
echo form_close();
?>
</div>
<?php
}
?>
