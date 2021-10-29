
  <section class="hotels-section-main inner-page-hotels text-center wow fadeInUp">
    <div class="container">
      <div class="section-title wow fadeInDown">
        <h2>Related Packages</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
      </div>
    </div>
    <div class="packages-listings-main">
      <div class="container">
        <div class="row">
		<?php foreach($tours as $k=>$v){?>
          <div class="col-lg-4 col-md-6 package-section wow fadeInDown">
            <div class="package-image">
                <figure style="background-image: url(<?= $this->base.'assets/uploads/tour/'.$v['main_image']?>);"></figure>
                <div class="package-price">
                  <h4><i class="flaticon-rupee-indian"></i> <?= $v['tour_price']?>/-</h4>
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
                      <a href="<?= $this->base.'tours/'.$v['tour_uri']?>" class="pack-more hvr-bounce-to-right">View Details  <i class="flaticon-right"></i></a>
                    </div>
                  </div>
                </div>
              </div> 
          </div>
		<?php }?>
         
          
        </div>
      </div>
    </div>
  </section>