<section class="inner-banner-main wow fadeInUp">
      <div class="inner-banner" style="background-image: url(<?= $this->base.'themes/public/'?>img/car-banner.jpg);">
        <div class="inner-banner-area">
          <div class="container">
            <div class="row inner-banner-caption">
              <div class="col-lg-6 col-sm-12 col-12 destination-name">
                <h3>Cars</h3>
              </div>
              <div class="col-lg-6 col-sm-12 col-12 breadcrump text-right">
                <ul>
                  <li><a href="<?= $this->base.'home'?>">Home</a></li>
                  <li><a href="#">Cars</a></li>
                  
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
    <section class="cat-section-main wow fadeInUp">
      <div class="container">
        <div class="clearfix"></div>
        <div class="row car-slider">
		<?php foreach($cars as $k=>$v){?>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 car-section car-area wow fadeInDown">
            <div class="overlay-main">
              <div class="overlay"><span><a href="<?= $this->base.'cars/'.$v['car_uri']?>" class=" hvr-bounce-to-right">View Details <i class="flaticon-right"></i></a></span></div>
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
                  <i class="fa fa-inr" aria-hidden="true"></i> <?= $v['car_rate']?>
                </span>
              </div>
            </div>
          </div>
		<?php }?>
		  
      </div>
      </div>
    </section>