<?php 

$destination_category=Modules::run('pages/destination_category_dropdown');
$tour_categories=Modules::run('pages/tour_dropdown');


?>
<nav class="navbar fixed-top navbar-expand-lg " id="main-nav">
  <div class="container">
    <a class="navbar-brand" href="<?= $this->base.'home'?>"><img src="<?= $this->base.'themes/public/'?>img/logo.png" alt="" class="logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="toggler-bar"></span>
    <span class="toggler-bar"></span>
    <span class="toggler-bar"></span>
    </button>
    <div class="collapse navbar-collapse mobile-nav" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto nav-list">
        <li class="nav-item active"><a class="nav-link" href="<?= $this->base.'home'?>">HOME</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="<?= $this->base.'destinations'?>" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Destinations</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">

            <!-- <a class="dropdown-item dropdown" href="destination-detail.php">South India</a> -->
            <?php foreach($destination_category as $k=>$v){?>
            <a class="dropdown-item" href="<?= $this->base.'destination/'.$v['category_uri']?>"><?= $v['category_title']?></a>
            <?php  } ?>
            

          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="<?= $this->base.'tours'?>" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tours</a>
          <div class="dropdown-menu" aria-labelledby="dropdown01">
            <?php foreach($tour_categories as $k=>$v){?>
            <a class="dropdown-item"  href="<?= $this->base.'tour/'.$v['category_uri']?>"><?= $v['category_title']?></a>
            <?php  }?>
            
          </div>
        </li>
        <li class="nav-item"><a class="nav-link" href="<?= $this->base.'hotels'?>">Hotels</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $this->base.'cars'?>">Cars</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $this->base.'contact'?>">Contact Us</a></li>
      </ul>
    </div>
    <div class="menu">
      <ul>
        <li><a href="<?= $this->base.'home'?>">Home</a></li>
        <li><a href="<?= $this->base.'destinations'?>">Destinations <i class="flaticon-down"></i></a>
        <ul>
        <?php foreach($destination_category as $k=>$v){?>
          <li>
            <ul>
              <li>
                <a href="<?= $this->base.'destination/'.$v['category_uri']?>">
                  <figure style="background-image: url(<?= $this->base.'assets/uploads/destinationcategory/'.$v['category_image']?>);"></figure>
                  <span class=""><?= $v['category_title']?></span><br>
                  <p><?= $v['category_description']?></p>
                  <span class="pack-more hvr-bounce-to-right">View Destinations  <i class="flaticon-right"></i></span>
                </a>
              </li>
            </ul>
          </li>
          <?php } ?>

        
          
        </ul>
      </li>
      <li><a href="<?= $this->base.'tours'?>">Tours <i class="flaticon-down"></i></a>
      <ul>
        <?php foreach($tour_categories as $k=>$v){?>
        <li><a href="<?= $this->base.'tour/'.$v['category_uri']?>"><?= $v['category_title']?></a></li>
        <?php  }?>
        
      </ul>
     </li>
    <li><a href="<?= $this->base.'hotels'?>">Hotels</a></li>
    <li><a href="<?= $this->base.'cars'?>">Cars</a></li>
    <li><a href="<?= $this->base.'contact'?>">Contact</a></li>
  </ul>
</div>
</div>
</nav>