		<?php
			if(isset($massege)){echo "<div class='fade in alert alert-success'>
        <a data-dismiss='alert' class='close'>×</a>
        <strong>Well done!</strong> $massege</div>";}
		?>

    <div class="modal fade" id="user">
    	<div class="modal-header">
    		<a class="close" data-dismiss="modal">×</a>
   		 <h3 style="direction:rtl;">جزئیات کاربران</h3>
   	</div>
    	<div class="modal-body">

	<ul id="task" style="direction:rtl;">
		<?php
			echo form_open('users/customer_detail',array('id'=>'user_form'));
			echo("<li>");
			echo form_label('نام','cd_name');
			echo form_input('cd_name');
			echo("</li><li>");
			echo form_label( 'نام خانوادگی','cd_family');
			echo form_input('cd_family');
			echo("</li><li>");
			echo form_label( 'شرکت','cd_company');
			echo form_input('cd_company');
			echo("</li><li>");
			echo form_label('آدرس','cd_address');
			echo form_input('cd_address');
			echo("</li><li>");
			echo form_label('شهر','cd_city');
			echo form_input('cd_city');
			echo("</li><li>");
			echo form_label('استان','cd_state');
			echo form_input('cd_state');
			echo("</li><li>");
			echo form_label('کد پستی','cd_postal_code');
			echo form_input('cd_postal_code');
			echo("</li><li>");
			echo form_label('تلفن همراه','cd_mobile');
			echo form_input('cd_mobile');
			echo("</li><li>");
			echo form_label('تلفن ثابت','cd_telphone');
			echo form_input('cd_telphone');
			echo("</li><li>");
			echo form_label('کد ملی','cd_national_code');
			echo form_input('cd_national_code');
			echo("</li><li>");
			echo form_label('توضیحات','cd_description');
			echo form_input('cd_description');
			echo("</li><li>");
			echo form_label('نام کاربری','users' );
			echo '<select name="cd_users_id">';
  			foreach($userlist as $username=>$userid){
  				echo "<option value='$userid'>$username</option>";
  				}	  	
			echo '</select>';
			echo("</li>");
			echo form_close();
		?>
		</ul>

  	</div>
    <div class="modal-footer" style="direction:rtl;">
    	 <a href="#" onclick="document.getElementById('user_form').submit()" class="btn btn-primary">ثبت</a>
   	 <a href="#" class="btn"  data-dismiss="modal">بستن پنجره جاری</a>
    </div>
    </div>

		
		
		
		
		<?php
			echo  "<table class='table table-striped' width='100%' id='hosts'>
				<tr>
				<th>&nbsp;</th>
				<th>نام</th>
				<th>نام خانوادگی</th>
				<th>شرکت</th>
				<th>آدرس</th>
				<th>شهر</th>
				<th>استان</th>
				<th>کد پستی</th>
				<th>تلفن همراه</th>
				<th>تلفن ثابت</th>
				<th>کد ملی</th>
				<th>توضیحات</th>
				<th>".anchor('#user', '<i class="icon-user"></i>', array('class' => 'btn','data-toggle'=>'modal'))."&nbsp;</th>
				</tr>
				";
				
			foreach ($query_customer_detail->result() as $row)
			{
				echo "<tr>";
				echo "<td>".anchor('users/customer_detail_update/'.$row->cd_users_id,'<i class="icon-edit"></i>').anchor('users/customer_detail/duser/'.$row->cd_id, '<i class="icon-remove"></i>', array('tooltip'=>'Delete','onclick'=>'return confirm(\'آیا قصد دارید این سطر را حذف کنید؟\')'))."&nbsp;"."</td>";
				echo "<td>".$row->cd_name."</td>";
				echo "<td>".$row->cd_family."</td>";
				echo "<td>".$row->cd_company."</td>";
				echo "<td>".$row->cd_address."</td>";
				echo "<td>".$row->cd_city."</td>";
				echo "<td>".$row->cd_state."</td>";
				echo "<td>".$row->cd_postal_code."</td>";
				echo "<td>".$row->cd_mobile."</td>";
				echo "<td>".$row->cd_telphone."</td>";
				echo "<td>".$row->cd_national_code ."</td>";
				echo "<td>".$row->cd_description."</td>";
				echo "<td>".$row->username."</td>";
				echo "</tr>";
			}
			
			echo "<table>";
		?>
