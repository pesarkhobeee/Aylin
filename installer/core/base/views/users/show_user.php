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
				<th>نام کاربری</th>
				</tr>
				";
			
			foreach ($query->result() as $row)
			{
				echo "<tr>";
				echo "<td>".anchor('users/customer_detail/duser/'.$row->cd_id, '<i class="icon-remove"></i>', array('class' => 'btn','tooltip'=>'Delete','rel'=>'tooltip','data-original-title'=>'Default tooltip','onclick'=>'return confirm(\'آیا قصد دارید این سطر را حذف کنید؟\')'))."&nbsp;"."</td>";
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
