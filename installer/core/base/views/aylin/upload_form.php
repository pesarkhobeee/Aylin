

<?php echo $error;?>

<?php echo form_open_multipart('aylin_base/do_upload');?>

<input type="file" name="userfile" size="20" />
<input type="hidden" name="roozbeh" value="<?php if($this->uri->segment(3) === FALSE){echo "0";}else{echo "1";}  ?>" />
<br /><br />

<input class="btn btn-success" type="submit" value="upload" />

</form>


