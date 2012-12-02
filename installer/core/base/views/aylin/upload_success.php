
<h3>Your file was successfully uploaded!</h3>
<?php if($_POST["roozbeh"]== 0){ ?>
<ul>
<?php
 foreach ($upload_data as $item => $value):?>
<li><?php echo $item;?>: <?php echo $value;?></li>
<?php endforeach; ?>
<li><a href="<?php echo base_url().'assets/uploads/'.$upload_data["file_name"]; ?>">Upload File</a></li>
</ul>
<p><?php echo anchor('aylin_base/upload', 'Upload Another File!'); ?></p>
<?php }else{ ?>
<img src='<?php echo base_url().'assets/uploads/'.$upload_data["file_name"]; ?>' />
<script language="javascript">
function upload_finish(){
	
	window.opener.document.getElementById("upload").value=document.getElementById("upload").value;
	window.close();
	
}
</script>
 <input type="hidden" value="<?php echo $upload_data["file_name"];  ?>" name="upload" id="upload" />
 <br>
<input class="btn btn-success" type="button" value="تایید" onclick="upload_finish();" />
<?php } ?>
