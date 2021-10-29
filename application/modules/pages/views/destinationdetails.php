
    <section class="inner-banner-main wow fadeInUp">
      <div class="inner-banner" style="background-image: url(<?= $this->base.'assets/uploads/destination/'.$detail['main_image']?>);">
        <div class="inner-banner-area">
          <div class="container">
            <div class="row inner-banner-caption">
              <div class="col-lg-6 col-sm-12 col-12 destination-name">
                <h3><?=$detail['destination_title']?></h3>
                <h6><i class="flaticon-maps-and-flags" aria-hidden="true"></i> <?=$detail['destination_location']?></h6>
              </div>
              <div class="col-lg-6 col-sm-12 col-12 breadcrump text-right">
                <ul>
                  <li><a href="<?= $this->base.'home'?>">Home</a></li>
                  
                  <li><a href="#">Destinations</a></li>
                  <li><a href="#"><?=$detail['category_title']?></a></li>
                  <li><?=$detail['destination_location']?></li>
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
          <div class="col-lg-8 col-md-8 col-sm-12 col-12">
            <div id="horizontalTab">
              <ul class="destinations-tab">
                <li><a href="#discription"><i class="flaticon-binoculars" aria-hidden="true"></i> Description</a></li>
                <li><a href="#locations"><i class="flaticon-pin" aria-hidden="true"></i> Location</a></li>
                <!-- <li><a href="#destination-images"><i class="fa fa-picture-o" aria-hidden="true"></i> Images</a></li> -->
                <li><a href="#videos"><i class="flaticon-video-player" aria-hidden="true"></i> Videos</a></li>
              </ul>
              <div id="discription">
                <div class="destination-content">
                  <?=$detail['destination_description']?>
                  <div class="hotel-images-slider">
                    <div class="demo">
                      <ul id="lightSlider">
                      <?php foreach($detail['images'] as $k=>$v){?>
                        <li data-thumb="<?= $this->base.'assets/uploads/destination/'.$v['image_name']?>">
                          <img src="<?= $this->base.'assets/uploads/destination/'.$v['image_name']?>" />
                        </li>
                        <?php } ?>
                        
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
                <div id="locations">
                <div class="destination-location-map">
                  <div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="100%" id="gmap_canvas" src="<?= $detail['destination_location_iframe'] ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div><style>.mapouter{text-align:right;height:300px;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:100%;}</style><small><a href="#" rel="nofollow"></a></small></div>
                </div>
              </div>
              <div id="videos">
              
              <?php foreach($detail['videos'] as $k=>$v){?>
                <div class="video-section">
                  <iframe width="100%" height="100%" src="<?= $v['video_name']?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
                <?php }?>
                
              </div>
            </div>
          </div>
          <?= Modules::run('pages/widgets/featured_tours')?>
        </div>
      </div>
    </section>