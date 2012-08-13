<ul style="direction:rtl;list-style-type:none;">
<?php
	echo form_open('users/register_finish');
	echo("<li>");
	echo form_label('نام کاربری *باید از آدرس پست الکترونیکی خود استفاده کنید ', 'username');
	echo form_input(array('id'=>'username','name'=>'username'));
	echo("</li><li>");
	echo form_label('کلمه عبور  ', 'password');
	echo form_password(array('id'=>'password','name'=>'password'));
	echo("</li><li>");
	echo form_label('تکرار کلمه عبور  ', 're_password');
	echo form_password('re_password');
	echo("</li><li>");
	echo form_label('نام  ', 'cd_name');
	echo form_input('cd_name');
	echo("</li><li>");
	echo form_label('نام خانوادگی  ', 'cd_family');
	echo form_input('cd_family');
	echo("</li><li>");
	echo form_label('شرکت  ', 'cd_company');
	echo form_input('cd_company');
	echo("</li><li>");
	echo form_label('آدرس  ', 'cd_address');
	echo form_input('cd_address');
	echo("</li><li>");
	echo form_label('شهر  ', 'cd_city');
	echo form_input('cd_city');
	echo("</li><li>");
	echo form_label('استان  ', 'cd_state');
	echo form_input('cd_state');
	echo("</li><li>");
	echo form_label('کد پستی ', 'cd_postal_code');
	echo form_input('cd_postal_code');
	echo("</li><li>");
	echo form_label('تلفن همراه  ', 'cd_mobile');
	echo form_input('cd_mobile');
	echo("</li><li>");
	echo form_label('تلفن ثابت  ', 'cd_telphone');
	echo form_input('cd_telphone');
	echo("</li><li>");
	echo form_label('کد ملی  ', 'cd_national_code');
	echo form_input('cd_national_code');
	echo("</li><li>");
	echo form_label('توضیحات  ', 'cd_description');
	echo form_input('cd_description');
	echo("</li><li>");
	echo("<input type='submit' value='ثبت' class='btn' />");
	echo '<input type="hidden" name="cd_users_id" value="0" />';
	echo("</li>");
	echo form_close();
?>

</ul>
<script src="<?php echo base_url("assets/js/jquery.validate.js"); ?>" type="text/javascript"> </script>
<script language="javascript">
	
	            /* <![CDATA[ */
	      jQuery(function(){

            jQuery("#username").validate({
                    expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",live:false,
                    message: "&nbsp; لطغا آدرس پست الکترونیکی وارد کنید &nbsp;"
                });
             jQuery("#password").validate({
                    expression: "if (VAL!='') return true; else return false;",live:false,
                    message: "&nbsp;لطفا این فیلد را پر کنید&nbsp;"                 
                });
                    });
            /* ]]> */
    </script>        
