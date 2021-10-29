<?php
$image	=	$astrologer[ 'image' ] ? $astrologer[ 'image' ] : 'deafault';
$rating	=	array(
	'min' => .5,
	'max' => 5,
	'step' => .5,
	'size'=>'xs',
	'showCaption' => false,
	'showClear'=> false,
	'readonly' => true
	);
$rating	= json_encode($rating);
?>
<div class="booking-item-payment">
  <header class="clearfix"> <a class="booking-item-payment-img" href="#"> <img src="<?=$this->base.'assets/uploads/users/'.$image?>" alt="Image Alternative text" title="hotel 1"> </a>
    <h5 class="booking-item-payment-title">
    <?=$astrologer[ 'first_name' ].' '.$astrologer[ 'last_name' ]?>
    </h5>
    <input type="number"  class="star-rating rating-loading" value="<?=$astrologer[ 'rating' ]?>" data-rating-config=<?=$rating?> >
  </header>
  <div class="mt30 ml30">
  <ul class="list booking-item-raiting-list">
  <li>
    <div class="booking-item-raiting-list-title">Overall Rating</div>
    <input type="number"  class="star-rating rating-loading" value="<?=$astrologer[ 'rating_knowledge' ]?>" data-rating-config=<?=$rating?> >
  </li>
  <li>
    <div class="booking-item-raiting-list-title">Knowledge in the subject</div>
    <input type="number"  class="star-rating rating-loading" value="<?=$astrologer[ 'rating_knowledge' ]?>" data-rating-config=<?=$rating?> >
  </li>
  <li>
    <div class="booking-item-raiting-list-title">Communication skill</div>
    <input type="number"  class="star-rating rating-loading" value="<?=$astrologer[ 'rating_communication' ]?>" data-rating-config=<?=$rating?> >
  </li>
  <li>
    <div class="booking-item-raiting-list-title">How Quick</div>
    <input type="number"  class="star-rating rating-loading" value="<?=$astrologer[ 'rating_speed' ]?>" data-rating-config=<?=$rating?> >
  </li>
</ul>
  </div>
</div>
