<div class="partners-main">
        <div class="container">
          <div class="section-title wow fadeInDown">
            <h2>Our Partners</h2>
          </div>
          <div class="partners-list">
            <div class="partners-slider owl-carousel owl-theme wow fadeInDown">
              <?php foreach($clients as $k=>$v){?>
              <div class="item partners-section">
                <div class="partners-sec"><img src="<?= $this->base.'assets/uploads/clients/'.$v['client_image']?>" alt="Hotel">
                </div>
              </div>
              <?php } ?>

            </div>
          </div>
        </div>
      </div>
    </section>