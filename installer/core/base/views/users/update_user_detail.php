<?php
	if(isset($msg))
		echo $msg;
?>
<ul style="direction:rtl;list-style-type:none;">
<?php
	echo form_open('users/customer_detail_update_finish');
	echo("<li>");
	echo form_label('نام  ', 'cd_name');
	echo form_input('cd_name',$row->cd_name);
	echo("</li><li>");
	echo form_label('نام خانوادگی  ', 'cd_family');
	echo form_input('cd_family',$row->cd_family);
	echo("</li><li>");
	echo form_label('شرکت  ', 'cd_company');
	echo form_input('cd_company',$row->cd_company);
	echo("</li><li>");
	echo form_label('آدرس  ', 'cd_address');
	echo form_input('cd_address',$row->cd_address);
	echo("</li><li>");
	echo form_label('شهر  ', 'cd_city');
	echo form_input('cd_city',$row->cd_city);
	echo("</li><li>");
	echo form_label('استان  ', 'cd_state');
	echo form_input('cd_state',$row->cd_state);
	echo("</li><li>");
	echo form_label('کد پستی ', 'cd_postal_code');
	echo form_input('cd_postal_code',$row->cd_postal_code);
	echo("</li><li>");
	echo form_label('تلفن همراه  ', 'cd_mobile');
	echo form_input('cd_mobile', $row->cd_mobile);
	echo("</li><li>");
	echo form_label('تلفن ثابت  ', 'cd_telphone');
	echo form_input('cd_telphone', $row->cd_telphone);
	echo("</li><li>");
	echo form_label('کد ملی  ', 'cd_national_code');
	echo form_input('cd_national_code', $row->cd_national_code);
	echo("</li><li>");
	echo form_label('توضیحات  ', 'cd_description');
	echo form_input('cd_description', $row->cd_description);
	echo("</li><li>");
	echo("<input type='submit' value='بروزرسانی' class='btn' />");
	echo '<input type="hidden" name="cd_users_id" value="'.$row->cd_users_id.'" />';
	echo("</li>");
	echo form_close();
?>

</ul>
    
