		<?php 
			if(isset($msg) && $msg!=""){
					echo "<div class='fade in alert alert-error'>
        <a data-dismiss='alert' class='close'>×</a>
        $msg</div>";
				}

		?>
		
		
<form action="" method="post">

			<div style="text-align:center;">
				
					<input  class="control-group error" type="text" name="username"   placeholder="username"/>
				
				<br>
					<input  class="control-group error" type="password" name="password"  placeholder="password"/> 
				
				<br>
					<input type="submit" value="login" style="width:218px;"/>
				
			</div>
</form> 
	

<div style="text-align:center;">
	<br>
	<p>
		<?php
			if($this->aylin_config->config("users_register","config_site")==1)
			{
				echo anchor("users/register", "ثبت نام کاربر جدید");
				
			}
		
		?>
	</p>
</div>
