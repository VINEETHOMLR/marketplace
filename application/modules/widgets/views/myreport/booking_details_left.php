<?php
$image	=	$astrologer[ 'image' ] ? $astrologer[ 'image' ] : 'default.png';
$my_report_services		=	$this->config->item( 'my_report_services' );
?>

<div class="booking-item-payment">
  <header class="clearfix"> <a class="booking-item-payment-img" href="#"> <img src="<?=$this->base?>assets/uploads/users/<?=$image?>" alt="Astrologer Image"  > </a>
    <h5 class="booking-item-payment-title"><a href="#">
      <?=$astrologer[ 'first_name' ].' '.$astrologer[ 'last_name' ]?>
      </a></h5>
    <ul class="icon-group booking-item-rating-stars">
      <li><i class="fa fa-star"></i> </li>
      <li><i class="fa fa-star"></i> </li>
      <li><i class="fa fa-star"></i> </li>
      <li><i class="fa fa-star"></i> </li>
      <li><i class="fa fa-star"></i> </li>
    </ul>
  </header>
  <ul class="booking-item-payment-details">
  <?php
  foreach( $bookings as $v )
  {
  	?>
	 <li>
      <h5>My Reoprt ( <?=$my_report_services[ $v[ 'service_id' ] ][ 'text' ]?> )</h5>
      Service Charge : <?=$service_rate?>
    </li>
	<?php
  }
  ?>
   
  </ul>
  <p class="booking-item-payment-total">Total charge: <span><?=sizeof( $bookings )*$service_rate?></span> </p>
</div>
