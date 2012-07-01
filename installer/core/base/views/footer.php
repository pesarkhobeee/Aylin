		</div>
	
</div>

      <hr/>

      <footer>
        <p>&copy;&nbsp;<a href="http://www.mahestan.info/">Mahestan</a>&nbsp;2012 -&nbsp;Aylin 0.5
</p>
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
$('#myModal').modal('hide');
$('#chang_owner').modal('hide');

        // carousel 
    $('#myCarousel').carousel();


 // tooltip demo
    $('.tooltip-demo.well').tooltip({
      selector: "a[rel=tooltip]"
    })

    $('.tooltip-test').tooltip()
    $('.popover-test').popover()

    // popover demo
    $("a[rel=popover]")
      .popover()
      .click(function(e) {
        e.preventDefault()
      })
   </script>
</body>
</html>
