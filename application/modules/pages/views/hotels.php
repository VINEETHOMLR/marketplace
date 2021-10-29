<section class="inner-banner-main wow fadeInUp">
      <div class="inner-banner" style="background-image: url(<?= $this->base.'themes/public/'?>img/hotels-banner.jpg);">
        <div class="inner-banner-area">
          <div class="container">
            <div class="row inner-banner-caption">
              <div class="col-lg-6 col-sm-12 col-12 destination-name">
                <h3>OUR HOTELS</h3>
              </div>
              <div class="col-lg-6 col-sm-12 col-12 breadcrump text-right">
                <ul>
                  <li><a href="<?= $this->base.'home'?>">Home</a></li>
                  <li><a href="#">Hotels</a></li>
                  
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    
      <section class="hotels-section-main hotels-detail text-center wow fadeInUp">
        <div class="container">
        <div class="row hotels-list">
		     <?php foreach($hotels as $k=>$v){?>
            <div class="col-lg-4 col-md-6 col-ms-6 col-12 hotel-section wow fadeInDown">
              <div class="hotel-sec">
                <div class="overlay-main">
              <div class="overlay"><span><a href="<?= $this->base.'hotels/'.$v['hotel_uri']?>" class=" hvr-bounce-to-right">View Details<i class="flaticon-right"></i></a></span></div>
                <figure style="background-image: url(<?= $this->base.'assets/uploads/hotel/'.$v['main_image']?>);"></figure>
              </div>
                <div class="hotel-title">
                  <h4><?= $v['hotel_title']?></h4>
                  <p><span><?= $v['hotel_location']?></span></p>
                  <p class="hotel-address"> <strong>Address :</strong><?= $v['hotel_address']?></p>
                </div>
              </div>
            </div>
			 <?php }?>
			
           
            
            
            
           
        
           
            
            
           
        </div>
        </div>
      </section>