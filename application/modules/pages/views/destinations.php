
    <section class="inner-banner-main wow fadeInUp">
      <div class="inner-banner" style="background-image: url(<?= $this->base.'themes/public/'?>img/destination-banner.jpg);">
        <div class="inner-banner-area">
          <div class="container">
            <div class="row inner-banner-caption">
              <div class="col-lg-6 col-sm-12 col-12 destination-name">
                <h3>Destinations</h3>
              </div>
              <div class="col-lg-6 col-sm-12 col-12 breadcrump text-right">
                <ul>
                  <li><a href="<?= $this->base.'home'?>">Home</a></li>
                  <?php if($detail==0){?>
                  <li>Destinations</li>
                  <?php }?>
                  
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
        <div class="row">
          <?php foreach($destinations as $k=>$v){?>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12 wow fadeInDown">
            <div class="destination-area-main" style="background-image: url(<?= $this->base.'assets/uploads/destination/'.$v['main_image']?>);">
            <div class="destination-area">
              <h6><i class="flaticon-maps-and-flags" aria-hidden="true"></i> <?= $v['destination_location']?></h6>
              <div class="hotels-more">
                <a href="<?= $this->base.'destinations/'.$v['destination_uri']?>" class="pack-more hvr-bounce-to-right">View Destinations</a>
              </div>
            </div>
          </div>
          </div>
          <?php }?>


        </div>
      </div>
    </section>

    