		</div>
	
</div>
	</div><!-- end of befor_footer -->
      <hr/>

      <footer>
        <p>&copy;&nbsp;<a href="http://aylincms.com/">Powered By AylinCMS</p>
        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url("assets/js/bootstrap.js"); ?>" type="text/javascript"> </script>
<script src="<?php echo base_url("assets/js/bootstrap-transition.js"); ?>" type="text/javascript"> </script>
<script src="<?php echo base_url("assets/js/bootstrap-tooltip.js"); ?>" type="text/javascript"> </script>
<script src="<?php echo base_url("assets/js/bootstrap-carousel.js"); ?>" type="text/javascript"> </script>


<script>
$(document).ready(function(){
	$('#myModal').modal('hide');
	$('#chang_owner').modal('hide');

		// carousel 
	    $('#myCarousel').carousel();


	 // tooltip demo
	$('.btn').tooltip()

    //$('.duble_date').popover()

    // popover demo
    $("a[rel=popover]")
      .popover()
      .click(function(e) {
        e.preventDefault()
      })
});
   </script>
</body>
</html>
