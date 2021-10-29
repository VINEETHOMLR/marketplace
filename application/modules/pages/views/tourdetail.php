<section class="inner-banner-main wow fadeInUp">
      <div class="inner-banner" style="background-image: url(<?= $this->base.'assets/uploads/tour/'.$tours['main_image']?>);">
        <div class="inner-banner-area">
          <div class="container">
            <div class="row inner-banner-caption">
              <div class="col-lg-6 col-sm-12 col-12 destination-name">
                <h3><?=$tours['tour_title']?></h3>
                <h6><?=$tours['tour_days']?></h6>
              </div>
              <div class="col-lg-6 col-sm-12 col-12 breadcrump text-right">
                <ul>
                  <li><a href="<?= $this->base.'home'?>">Home</a></li>
                  <li><a href=""><?= $tours['category_title']?></a></li>
                  <li><?= $tours['tour_title']?></li>
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
                <h5>Package Details</h5>
              </div>
              <div class="packages-places">
                <ul>
                  <li><?= $tours['tour_location']?> </li>
                 
                </ul>
              </div>
              <div id="discription">
                <div class="destination-content">
                  <?=$tours['tour_description']?>
                </div>
              </div>
              <div class="aminities-main">
                <h5>Itinerary</h5>
                
                <!-- Accordion end -->
                <div id="accordion">
				<?php 

         $itinerary=$tours['itenery'];
       
				
				foreach($itinerary as $k=>$v){
					
				?>
                  <div class="card">
                    <div class="card-header" id="headingOne">
                      <button class="btn btn-link acco-head" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <!--<h3>Day 1 | <span class="acco-places">Cochin – Munnar</span></h3>-->
					  <h3><?=$v['title']?></h3>
                      </button>
                    </div>
                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="card-body">
                        <p><?=$v['description']?></p>
						
						
		
                        <div class="hotels">
                          <ul>
                            <li>
                              <div class="hotel-strip-name">
                                <i class="fa fa-building-o" aria-hidden="true"></i> <?= $v['name']?>
                              </div>
                              <div class="hotel-strip-location">
                                <a href="<?= $this->base.'hotels/'.$v['uri']?>" class="hvr-bounce-to-right book-now-btn">View Details <i class="flaticon-right"></i></a>
                              </div>
                            </li>
                            <?php foreach($v['images'] as $ki=>$vi){
                                 //echo "<pre>";
                                 //print_r($vi);die();
                              ?>

                            <li><img src="<?= $this->base.'assets/uploads/hotel/'.$vi->image_name?>" alt=""></li>
                            <?php }?>
                            
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
				<?php }?>
				  
                 
                  
                </div>
                <!-- Accordion begin -->
              </div>
              <div class="hotel-images-slider-main">
                <h5>Image Gallery</h5>
                <div class="hotel-images-slider">
                  <div class="demo">
                    <ul id="lightSlider">
					<?php foreach($tours['images'] as $k=>$v){?>
                      <li data-thumb="<?= $this->base.'assets/uploads/tour/'.$v['image_name']?>">
                        <img src="<?= $this->base.'assets/uploads/tour/'.$v['image_name']?>" />
                      </li>
					  <?php }?>
                      
                     
                      
                      
                      
                      
                     
                    </ul>
                  </div>
                </div>
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
  <?= Modules::run('pages/widgets/relatedpackages')?>

