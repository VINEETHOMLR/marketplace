<section class="inner-banner-main wow fadeInUp">
      <div class="inner-banner" style="background-image: url(<?= $this->base.'themes/public/'?>img/tours-banner.jpg);">
        <div class="inner-banner-area">
        <div class="container">
          <div class="row inner-banner-caption">
            <div class="col-lg-6 col-sm-12 col-12 destination-name">
              <h3>Tour Packages</h3>
            </div>
            <div class="col-lg-6 col-sm-12 col-12 breadcrump text-right">
              <ul>
                <li><a href="<?= $this->base.'home'?>">Home</a></li>
                
                <li>Tour Packages</li>
                <li><?= $category?></li>
              </ul>
            </div>
          </div>
        </div>
        </div>
      </div>
    </section>

    
    <section class="packages-section text-center wow fadeInUp">
      <div class="container">
        <div class="section-title wow fadeInDown">
          <h2>Tour Packages</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>
        <div class="packages-listings-main">
          <div class="row">
		  <?php foreach($tours as $k=>$v){?>
            <div class="col-lg-4 col-md-6 package-section wow fadeInDown">
              <div class="package-image">
                <figure style="background-image: url(<?= $this->base.'assets/uploads/tour/'.$v['main_image']?>);"></figure>
                <div class="package-price">
                  <h4><img src="img/rupees.svg" alt=""> <?= $v['tour_price']?>/-</h4>
                </div>
              </div>
              <div class="package-details-main">
                <div class="row">
                  <div class="col-md-3 col-sm-2 col-xs-2 icons-main">
                    <ul>
                        <li><a href="" data-toggle="tooltip" data-placement="left" title="Bed"><i class="flaticon-bed"></i></a></li>
                        <li><a href="" data-toggle="tooltip" data-placement="left" title="Breakfast"><i class="flaticon-dinner"></i></a></li>
                        <li><a href="" data-toggle="tooltip" data-placement="left" title="Sightseeing"><i class="flaticon-binoculars"></i></li>
                        <li><a href="" data-toggle="tooltip" data-placement="left" title="Cars"><i class="flaticon-taxi"></i></a></li>
                    </ul>
                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-5 package-details">
                    <div class="days"><?= $v['tour_days']?></div>
                    <div class="package-name"><?= $v['tour_title']?></div>
                    <div class="package-places"><?= $v['tour_location']?></div>
                    <div class="pack-more">
                      <a href="<?= $this->base.'tours/'.$v['tour_uri']?>" class="pack-more hvr-bounce-to-right">View Details <i class="flaticon-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
		  <?php  }?>
            
            
          </div>
        </div>
      </div>
    </section>