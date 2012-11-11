

<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style>
		.flexigrid {
			direction:rtl;	
		}
		
		.text-left {
			text-align:right;
		}
		
		.form-display-as-box {
			float:right;
			direction:rtl;
		}
		
		.chzn-single{
			direction:ltr;
		}

		#groceryCrudTable{
			direction:rtl;
		}
			
</style>

	<div style='height:20px;'></div>  
    <div>
		<?php echo $output; ?>
    </div>

