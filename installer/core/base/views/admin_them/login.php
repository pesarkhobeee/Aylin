		<?php 
			if(isset($msg) && $msg!=""){
					echo "<div class='fade in alert alert-error'>
        <a data-dismiss='alert' class='close'>×</a>
        $msg</div>";
				}

		?>
		
		
<?php echo form_open(); ?>

			<div style="text-align:center;">
				
					<input  class="control-group error" type="text" name="username"   placeholder="username"/>
				
				<br>
					<input  class="control-group error" type="password" name="password"  placeholder="password"/> 
				
				<br>
					<input type="submit" value="login" style="width:218px;"/>
				
			</div>
<?php echo form_close(); ?>
	

<div style="text-align:center;">
	<br>
	<p>
		<?php

			echo anchor("users/remember_password", "بازیابی کلمه عبور");
			echo "<br>";
		
			if($this->aylin->config("users_register","config_site")==1)
			{
				echo anchor("users/register", "ثبت نام کاربر جدید");
				
			}
		
		?>
	</p>
</div>
