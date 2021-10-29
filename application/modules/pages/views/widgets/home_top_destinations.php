<section class="destinations-section text-center wow fadeInUp">
      <div class="container">
        <div class="section-title wow fadeInUp">
          <h2>Top Destinations</h2>
          <h6>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h6>
        </div>

        <div class="destinations-main">
          <?php $i=1;foreach($destinations as $k=>$v){
            
            if($i==3)
            {
             $i=1;
            }
            ?>

          <div class="destination wow <?php  if($i==1){ echo "fadeInLeft"; }else{ echo "fadeInRight";}?>" style="background-image:url(<?= $this->base.'assets/uploads/destinationcategory/'.$v['category_image']?>);">
            <div class="overlay"><span><a href="<?= $this->base.'destinations/'.$v['category_uri']?>" class=" hvr-bounce-to-right">View Details <i class="flaticon-right"></i></a></span></div>
            <div class="destination-title">
              <h4><?= $v['category_title'] ?></h4>
              <p>Incredible India</p>
            </div>
          </div>


          
          <?php $i=$i+1; }?>

          

        </div>
      </div>
    </section>