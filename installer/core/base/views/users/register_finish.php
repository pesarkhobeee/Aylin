<?php
	if(isset($massege))
	{echo "<div style='direction:rtl;text-align:right;' class='fade in alert alert-success'>
        <a data-dismiss='alert' class='close'>×</a>
         $massege</div>";
  ?>
  
  <div style='direction:rtl;text-align:right;' class='fade in alert alert-success'>
        <a data-dismiss='alert' class='close'>×</a>
        کاربر گرامی برای فعال سازی حساب خود بر روی لینکی که به پست الکترونیکی شما فرستاده شد کلیک کنید
        </div>
  <?php       
         
         }
?>

<?php
	if(isset($error))
	{echo "<div style='direction:rtl;text-align:right;' class='fade in alert alert-error'>
        <a data-dismiss='alert' class='close'>×</a>
         $error</div>";}
?> 
