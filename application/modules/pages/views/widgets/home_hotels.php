
   
    <section class="hotels-section-main text-center wow fadeInUp">
      <div class="container">
        <div class="section-title wow fadeInDown">
          <h2>Our Hotels</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>
      </div>

      <div class="hotels-list">
        <div class="hotel-slider owl-carousel owl-theme wow fadeInDown">
        <?php foreach($hotels as $k=>$v){?>
          <div class="item hotel-section">
            <div class="hotel-sec">
            <div class="overlay-main">
              <div class="overlay"><span><a href="<?= $this->base.'hotels/'.$v['hotel_uri']?>" class=" hvr-bounce-to-right">View Details<i class="flaticon-right"></i></a></span></div>
                <figure style="background-image: url(<?= $this->base.'assets/uploads/hotel/'.$v['main_image']?>);"></figure>
              </div>
              <div class="hotel-title">
                <h4><?=$v['hotel_title']?></h4>
                <p><span><?=$v['hotel_location']?></span></p>
                 
              </div>
            </div>
          </div>
          <?php } ?>


          
          
        </div>
      </div>
      