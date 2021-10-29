 <section class="testimonial-section brush-vectors text-center wow fadeInUp">
      <div class="container">
        <div class="section-title wow fadeInDown">
          <h2>What Our Clients Say</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>
      <?php foreach($testimonials as $k=>$v){?>
        <div class="testimonials-main wow fadeInDown">
          <div class="testimonial-slider owl-carousel owl-theme wow fadeInDown">

            <div class="item testi-section">
              <div class="testi-image"><img src="<?= $this->base.'assets/uploads/users/'.$v['testimonial_user_image']?>" alt=""></div>
              <div class="testi-cont">
                <p><?= $v['testimonial_description']?></p>
              </div>
              <div class="testi-name">
                <h4><span class="testi-brackets"><?= $v['testimonial_name']?></span> <?= $v['testimonial_position']?></h4>
              </div>
            </div>
            <?php }?>

            

          </div>
        </div>
      </div>
    </section>
    