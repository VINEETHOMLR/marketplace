<?php
$themeurl=$this->base."themes/public/";
?>
<?= Modules::run('pages/widgets/breadcrumb')?>
 <!--menu-bar closed-->
    <!-- Inner Banner -->
    <div class="inner-banner policy-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 pull-right inner-ban-img"><img src="<?= $this->base.'assets/uploads/pages/'.$pagedata['page_image']?>" alt="" class="img-responsive wow fadeInUp"></div>
            <div class="col-md-5 col-sm-6 col-xs-12 inner-ban-cont terms-ban-cont">
                <h1 class="wow fadeInDown"><?= $pagedata['page_name']?></h1>
                <p class="wow fadeInUp"><?= $pagedata['page_cms']?></p>
            </div>
            </div>
        </div>
    </div>    
    <!-- Inner Banner -->

    <!--section4 meet our team-->
    <section class="meet poliy-main" id="team">
        <div class="container">
            <div class="row">
                <?= $pagedata['page_cms2']?>
        </div>
    </section>