		<?php
			if(isset($massege)){echo "<div class='fade in alert alert-success'>
        <a data-dismiss='alert' class='close'>×</a>
        <strong>Well done!</strong> $massege</div>";}
		?>
		
			<?php
			if(isset($alert)){echo "<div class='fade in alert alert-error'>
        <a data-dismiss='alert' class='close'>×</a>
         $alert</div>";}
		?>	
		
		

    <div class="modal fade" id="user">
    	<div class="modal-header">
    		<a class="close" data-dismiss="modal">×</a>
   		 <h3 style="direction:rtl">ایجاد کاربر</h3>
   	</div>
    	<div class="modal-body">

	<ul id="task">
		<?php
			echo form_open('users/show_users',array('id'=>'user_form'));
			echo("<li>");
			echo form_label('نام کاربری  ', 'username');
			echo form_input('username');
			echo("</li><li>");
			echo form_label('کلمه عبور  ', 'password');
			echo form_input('password');
			echo("</li><li>");
			echo form_label('گروه  ', 'user_group');
			foreach ($query_groups->result() as $groups)
			{
				echo $groups->g_name."&nbsp;";
				echo form_radio('user_group', $groups->g_name);
				echo "<br>";
			}
			echo form_hidden('active', 1);
			echo("</li>");
			echo form_close();
		?>
		</ul>

  	</div>
    <div class="modal-footer" style="direction:rtl">
    	 <a href="#" onclick="document.getElementById('user_form').submit()" class="btn btn-primary">ثبت</a>
   	 <a href="#" class="btn" data-dismiss="modal">بستن پنجره جاری</a>
    </div>
    </div>

		
   <div class="modal fade" id="update">
    	<div class="modal-header">
    		<a class="close" data-dismiss="modal">×</a>
   		 <h3 style="direction:rtl">تغییر کلمه عبور</h3>
   	</div>
    	<div class="modal-body">

	<ul id="task">
		<?php
			echo form_open('users/show_users',array('id'=>'update_user'));
			echo "<input type='hidden' name='userid' id='userid' />";
			echo("<li>");
			echo form_label('کلمه عبور جدید  ', 'password');
			echo form_password('password');
			echo("</li><li>");
			echo form_label('تکرار کلمه عبور جدید  ', 're_password');
			echo form_password('re_password');
			echo("</li>");
			echo form_close();
		?>
		</ul>

  	</div>
    <div class="modal-footer" style="direction:rtl">
    	 <a href="#" onclick="document.getElementById('update_user').submit()" class="btn btn-primary">ثبت</a>
   	 <a href="#" class="btn" data-dismiss="modal">بستن پنجره جاری</a>
    </div>
    </div>
	
		
		
		<?php
				$table_act="<th>&nbsp;</th>";
				if($this->session->userdata('user_group')=="root")
				{
					$table_act="<th>".anchor('#user', '<i class="icon-pencil"></i>', array('class' => 'btn','data-toggle'=>'modal','rel'=>'tooltip','data-original-title'=>'ایجاد کاربر'))."&nbsp;".anchor('users/customer_detail', '<i class="icon-user"></i>', array('class' => 'btn','rel'=>'tooltip','data-original-title'=>'جزئیات کاربران'))."&nbsp;".anchor('users/groups', '<i class="icon-list-alt"></i>', array('class' => 'btn','rel'=>'tooltip','data-original-title'=>'سطوح کاربری'))."&nbsp;"."</th>";
				}
			echo  "<table class='table table-striped' width='100%' id='hosts'>
				<tr>
				".$table_act."
				<th>نام کاربری</th>
				<th>گروه</th>
				<th>وضعیت</th>
				</tr>
				";
				
			foreach ($query_users->result() as $row)
			{
				if($row->active==0)
				{
					$tmp = anchor('users/show_users/active/'.$row->id,"<i class='icon-remove-sign'></i>");
				}
				else
				{
					$tmp = anchor('users/show_users/diactive/'.$row->id,"<i class='icon-ok-sign'></i>");
				}
				echo "<tr>";
				echo "<td>".anchor('users/show_users/duser/'.$row->id, '<i class="icon-remove"></i>', array('class' => 'btn','tooltip'=>'Delete','rel'=>'tooltip','data-original-title'=>'حذف کاربر','onclick'=>'return confirm(\'آیا قصد دارید این سطر را حذف کنید؟\')'))."&nbsp;<a href='#update' class='btn' rel='tooltip' data-original-title='بروزرسانی کلمه عبور'  data-toggle='modal' onclick='document.getElementById(\"userid\").value=".$row->id."'><i class='icon-pencil' ></i></a>&nbsp;".anchor('users/show_user/'.$row->id, '<i class="icon-eye-open"></i>',array('class' => 'btn','rel'=>'tooltip','data-original-title'=>'اطلاعات تکمیلی','tooltip'=>'Show Detail'))."</td>";
				echo "<td>".$row->username."</td>";
				echo "<td>".$row->user_group."</td>";
				echo "<td>".$tmp."</td>";
				echo "</tr>";
			}
			
			echo "<table>";
		?>

