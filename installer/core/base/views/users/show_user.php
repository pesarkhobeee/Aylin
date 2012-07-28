<?php
			echo  "<table class='table table-striped' width='100%' id='hosts'>
				<tr>
				<th>&nbsp;</th>
				<th>Name</th>
				<th>Family</th>
				<th>Company</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Postal Code</th>
				<th>Mobile</th>
				<th>Telephone</th>
				<th>Nathonal Code</th>
				<th>Description</th>
				<th>Username</th>
				</tr>
				";
				
			foreach ($query->result() as $row)
			{
				echo "<tr>";
				echo "<td>".anchor('users/customer_detail/duser/'.$row->cd_id, '<i class="icon-remove"></i>', array('class' => 'btn','tooltip'=>'Delete'))."&nbsp;"."</td>";
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