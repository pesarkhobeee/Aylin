      <!-- widgets-->
		<div class="row">
			<div class="span4 widget">
				<h3>جستجو</h3>
				<?php echo $this->aylin->search_box(); ?>
			</div>
			<div class="span4 widget">
				<h3>آرشیو</h3>
				<?php echo $this->aylin->subject_archive(); ?>
				
			</div>
			<div class="span4 widget">
				<h3>فهرست</h3>
					<?php echo $this->aylin->links(); ?>
			</div>
			<div class="span4 widget">
				<a href="<?php echo base_url("index.php/news/rss"); ?>"><img alt="RSS" src="<?php echo base_url("/assets/img/RSS.png"); ?>" /></a>
			</div>
			<div class="span8 widget">
				<?php echo $this->aylin->newsletter(); ?>
			</div>
			<div class="span12 widget">
				<?php echo $this->aylin->logos(); ?>
			</div>
		</div>
