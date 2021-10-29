 <section class="inner-banner-main wow fadeInUp">
      <div class="inner-banner" style="background-image: url(<?= $this->base.'assets/uploads/car/'.$cars['car_image']?>);">
        <div class="inner-banner-area">
          <div class="container">
            <div class="row inner-banner-caption">
              <div class="col-lg-6 col-sm-12 col-12 destination-name">
                <h3><?= $cars['car_title'] ?></h3>
                <!-- <h6><i class="flaticon-maps-and-flags" aria-hidden="true"></i> G.V. Raja Vattapara Road, Trivandrum, 695527 Kovalam, India</h6> -->
              </div>
              <div class="col-lg-6 col-sm-12 col-12 breadcrump text-right">
                <ul>
                  <li><a href="<?= $this->base.'home'?>">Home</a></li>
                  <li><a href="#">Cars</a></li>
                  <li><?= $cars['car_title'] ?></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="destinations-content-main wow fadeInUp">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-7 col-sm-12 col-12">
            <div>
              <div class="hotel-head">
                <!-- <h5>Package Details</h5> -->
              </div>
              <div id="discription" class="car-detail-main">
                <div class="car-big-img">
                  <img src="<?= $this->base.'assets/uploads/car/'.$cars['car_image']?>" alt="">
                </div>
				<?= $cars['car_description'] ?>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-5 col-sm-12 col-12 destination-right-section">
            <div class="right-section-main">
              <?php include 'right-fixed.php' ?>
             
              <?php include ('book-now-form.php') ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="hotels-section-main inner-page-hotels text-center wow fadeInUp">
    <div class="container">
      <div class="section-title wow fadeInDown">
        <h2>Other Cars</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
      </div>
    </div>
    <div class="container">
      <div class="car-slider">
        <div class="car-carousel owl-carousel owl-theme wow fadeInDown">
		<?php foreach($car as $k=>$v){?>
          <div class="item car-section car-area ">
            <div class="overlay-main">
              <div class="overlay"><span><a href="<?= $this->base.'cars/'.$v['car_uri']?>" class=" hvr-bounce-to-right">View Details<i class="flaticon-right"></i></a></span></div>
              <figure style="background-image: url(<?= $this->base.'assets/uploads/car/'.$v['car_image']?>);"></figure>
            </div>
            <div class="car-name-main">
              <div class="car-name">
                <?= $v['car_title']?>
                <div class="clearfix"></div>
                <span class="car-category">
                  <?= $v['car_type']?>
                </span>
                <span class="car-price">
                  <i class="flaticon-rupee-indian"></i> <?= $v['car_rate']?>
                </span>
              </div>
            </div>
          </div>
		<?php } ?>
		  
         
          
        
      
    
</div>
<div class="col-md-12">
  <div class="cars-more">
    <a href="<?= $this->base.'cars'?>" class="pack-more hvr-bounce-to-right">View All Cars  <i class="flaticon-right"></i></a>
  </div>
</div>
</div>
</section>