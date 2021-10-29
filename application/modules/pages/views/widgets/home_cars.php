<section class="transportation-section brush-vectors text-center wow fadeInUp">
      <div class="container">
        <div class="section-title wow fadeInDown">
          <h2>South Indian Transportation</h2>
          <p>” JEEVA TOURS AND TRAVELS ” Was conceived when a few technocrats gave hands together from the industry. Using innovative technology we now arrange quick and better hassle free holidays.</p>
          <p>A leading car rental operator in south Indian tourism sector. We own a wide range of vehicles that are well maintained and GPS enabled. Also all our drivers are professionally trained for the TRAVEL industry</p>
        </div>
        <div class="clearfix"></div>
        <div class="car-slider">
          <div class="car-carousel owl-carousel owl-theme wow fadeInDown">
           <?php foreach($cars as $k=>$v){?>
            <div class="item car-section car-area">
              <figure style="background-image: url(<?= $this->base.'assets/uploads/car/'.$v['car_image']?>);"></figure>
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
            <?php } ?>

            
           
           
           
          </div>
            <div class="col-md-12">
              <div class="cars-more">
                <a href="<?= $this->base.'cars'?>" class="pack-more hvr-bounce-to-right">View All Cars  <i class="flaticon-right"></i></a>
              </div>
        </div>

      </div>
    </section>