<section class="inner-banner-main wow fadeInUp">
      <div class="inner-banner" style="background-image: url(<?= $this->base.'assets/uploads/hotel/'.$hotels['main_image']?>);">
        <div class="inner-banner-area">
          <div class="container">
            <div class="row inner-banner-caption">
              <div class="col-lg-6 col-sm-12 col-12 destination-name">
                <h3><?= $hotels['hotel_title']?></h3>
                <h6><i class="flaticon-maps-and-flags" aria-hidden="true"></i> <?= $hotels['hotel_address']?></h6>
              </div>
              <div class="col-lg-6 col-sm-12 col-12 breadcrump text-right">
                <ul>
                  <li><a href="<?= $this->base.'home'?>">Home</a></li>
                  <li><a href="#">Hotels</a></li>
                  <li><?= $hotels['hotel_title']?></li>
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
          <div class="col-lg-8 col-md-7 col-sm-12 col-12 package-details-page">
            <div>
              <div class="hotel-head">
                <!-- <h5>Package Details</h5> -->
              </div>
              <div id="discription">
                <div class="destination-content">
				<?= $hotels['hotel_description']?>
                  </div>
              </div>
              <div class="aminities-main">
                <h5>Amenities</h5>
				
                <ul class="room-aminities">
				<?php foreach($hotels['amenities'] as $k=>$v){ ?>
                  <li><i class="<?=$v['amenities_icon']?>"></i> <?= $v['amenities_title']?></li>
                <?php }?>  
                </ul>
              </div>
              <div class="hotel-images-slider-main">
                <div class="hotel-images-slider">
                  <div class="demo">
                    <ul id="lightSlider">
					  <?php foreach($hotels['images'] as $k=>$v){ ?>
                      <li data-thumb="<?= $this->base.'assets/uploads/hotel/'.$v['image_name']?>">
                        <img src="<?= $this->base.'assets/uploads/hotel/'.$v['image_name']?>" />
                      </li>
					  <?php }?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="room-type-main">
                <div class="room-type">
                  <h5>Room Type</h5>
				  <?php $roomtype=json_decode($hotels['hotel_roomtype']);
				 
				  foreach($roomtype as $k=>$v){
				  ?>
				  
                  <p><strong><?= $v->roomtype ?> :-</strong> <?= $v->description ?></p>
				  <?php } ?>
                </div>
              </div>
              <div class="hotel-location-main">
                <div class="room-type hotel-location">
                  <h5>Locaton</h5>
                   <div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="100%" id="gmap_canvas" src="<?= $hotels['hotel_location_iframe']?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div><style>.mapouter{text-align:right;height:300px;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:300px;width:100%;}</style><small><a href="#" rel="nofollow"></a></small></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-5 col-sm-12 col-12 destination-right-section">
            <div class="right-section-main">
            <?php include 'includes/right-fixed.php' ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?= Modules::run('pages/widgets/relatedhotels')?>