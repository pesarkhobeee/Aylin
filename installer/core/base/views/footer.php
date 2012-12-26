		</div>
	
</div>
<?php
if($this->aylin->config("widgets","config_site")==1)
 	include("widgets.php"); 
?>
      <hr />


</div><!-- end of befor_footer -->

      <footer>
        <p>&copy;&nbsp;<a href="http://www.mahestan.info/">Mahestan</a>&nbsp;2012 -&nbsp;Aylin 1.0
</p>
        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds
        <br>
        Today Visitor Count : <?php  echo $this->aylin->visitor_show(date("Y-m-d")); ?> , Total Visitor : <?php  echo $this->aylin->visitor_show(); ?>
        </p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url("assets/js/bootstrap.js"); ?>" type="text/javascript"> </script>
<script src="<?php echo base_url("assets/js/bootstrap-transition.js"); ?>" type="text/javascript"> </script>
<script src="<?php echo base_url("assets/js/bootstrap-tooltip.js"); ?>" type="text/javascript"> </script>
<script src="<?php echo base_url("assets/js/bootstrap-carousel.js"); ?>" type="text/javascript"> </script>
<script src="<?php echo base_url("assets/js/jquery.validate.js"); ?>" type="text/javascript"> </script>
<script language="javascript">
	
	            /* <![CDATA[ */
	      jQuery(function(){

            jQuery("#nm_mail").validate({
                    expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",live:false,
                    message: "&nbsp; لطغا آدرس پست الکترونیکی وارد کنید &nbsp;"
                });
                
             jQuery("#mail").validate({
                    expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",live:false,
                    message: "&nbsp; لطغا آدرس پست الکترونیکی وارد کنید &nbsp;"
                });               
               
             jQuery("#nm_name").validate({
                    expression: "if (VAL!='') return true; else return false;",live:false,
                    message: "&nbsp;لطفا این فیلد را پر کنید&nbsp;"                 
                });
                    });
            /* ]]> */
    </script>
<script>
$(document).ready(function(){
	$('#myModal').modal('hide');
	$('#chang_owner').modal('hide');

        // carousel 
    $('#myCarousel').carousel();
 });


   </script>
</body>
</html>
