
<?php
$base	=	base_url();
?>
</div>
 <!-- Common scripts -->
<?php
if(!empty($js))
foreach($js as $v)
{
	if($v['position']=='bottom')
	{
		echo "\n\t\t\t";
		?><script src="<?=$base.$v['file']?>"></script><?php
	}
	
} 

?>


<!-- Bootstrap 3.3.6 -->
<script src="<?=$base?>themes/crm/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?=$base?>themes/crm/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=$base?>themes/crm/dist/js/app.min.js"></script>
<!-- Sparkline -->
<script src="<?=$base?>themes/crm/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?=$base?>themes/crm/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?=$base?>themes/crm/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- SlimScroll 1.3.0 -->
<script src="<?=$base?>themes/crm/plugins/slimScroll/jquery.slimscroll.min.js"></script>

<script>
$(document).ready(function(){
	<?php if($msg = $this->session->flashdata('msg')){ ?>
	lobMsg( '<?=$msg[ 'type' ]?>' , '<?=$msg[ 'msg' ]?>' );
	<?php } ?>
	});

</script>

</body>
</html>


