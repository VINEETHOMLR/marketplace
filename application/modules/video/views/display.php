<?php
echo '<div class="row">';
foreach ($videos as $k => $v) {
	$url = $v[ 'video_name' ];
	parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
	$vidID = $my_array_of_vars['v'];
	?>
	<div class="col-md-3 " style="margin:10px">
        <a class="showvideo" href="http://www.youtube.com/watch?v=<?=$vidID?>">
                 <img src="http://img.youtube.com/vi/<?=$vidID?>/maxresdefault.jpg" alt="" class="animated fadeInUp  img-responsive"   data-animation-type="fadeInUp" style="animation-duration: 1s; visibility: visible;">
        </a>
    </div>
	<?php
}	
echo '</div>';