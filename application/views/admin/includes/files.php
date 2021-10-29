<?php
$files['common']['css']		=	array(
								'assets/plugins/ladda/ladda-themeless.min.css',
								'assets/plugins/form_validator/css/validationEngine.jquery.css',
								'assets/plugins/lobibox/lobibox.css'
								);
$files['common']['js']		=	array(
								array('position'=>'top','file'=>'assets/plugins/lobibox/lobibox.min.js'),
								array('position'=>'top','file'=>'assets/plugins/ladda/spin.min.js'),
								array('position'=>'top','file'=>'assets/plugins/ladda/ladda.min.js'),
								array('position'=>'top','file'=>'assets/plugins/form_validator/js/languages/jquery.validationEngine-en.js'),
								array('position'=>'top','file'=>'assets/plugins/form_validator/js/jquery.validationEngine.js'),
								array('position'=>'top','file'=>'assets/js/jquery.form.min.js'),
								array('position'=>'top','file'=>'assets/js/functions.js'),
								array('position'=>'top','file'=>'assets/plugins/noty/packaged/jquery.noty.packaged.js'),
								
								);

$lobibox['js']		=	array(array('position'=>'top','file'=>'assets/plugins/lobibox/lobibox.min.js'));
$lobibox['css']		=	array('assets/plugins/lobibox/lobibox.css');
$sweetalert['js']	=	array(array('position'=>'top','file'=>'assets/plugins/sweetalert/sweet-alert.min.js'));
$sweetalert['css']	=	array( 'assets/plugins/sweetalert/sweet-alert.css' );

$datatables['js']	=	array(
						array('position'=>'bottom','file'=>'assets/plugins/datatables/jquery.dataTables.min.js',),
						array('position'=>'bottom','file'=>'assets/plugins/datatables/dataTables.bootstrap.min.js',),
						);
$datatables['css']	=	array( 'assets/plugins/datatables/dataTables.bootstrap.css' );

$moment['js']		=	array(
						array('position'=>'top','file'=>'assets/plugins/moment/moment.min.js'),
						);					

$date_range_picker['js']	=	array(
								array('position'=>'bottom','file'=>'assets/plugins/date_range_picker/daterangepicker.js'),
								);	

$date_range_picker['css']		=	array( 'assets/plugins/date_range_picker/daterangepicker.css' );	

/*------------------------------------------------------------------------------------------------*/	
$files[ 'company/group' ]	=	array( 'datatables' );