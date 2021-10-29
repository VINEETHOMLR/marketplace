<div class="kf_inr_banner">
  <div class="container">
    <div class="row">
      <div class="col-md-12"> 
        <!--KF INR BANNER DES Wrap Start-->
        <div class="kf_inr_ban_des">
          <div class="inr_banner_heading">
            <h3>Blog </h3>
          </div>
          <div class="kf_inr_breadcrumb">
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">Blog </a></li>
            </ul>
          </div>
        </div>
        <!--KF INR BANNER DES Wrap End--> 
      </div>
    </div>
  </div>
</div>

<!--Banner Wrap End--> 

<!--Content Wrap Start-->
<div class="kf_content_wrap"> 
  
  <!--BLOG 3 PAGE START-->
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="kf_edu2_heading2">
            <h3>Our Blog</h3>
          </div>
        </div>
        
        <?php
		$i =	0;
        foreach( $blogs as $v )
		{
			$image	=	$v[ 'blog_image' ] != ''  ? $v[ 'blog_image' ] : 'default.jpg';
			$link	=	$this->base.'blog/'.$v[ 'blog_id' ].'/'.url_title( $v[ 'blog_name' ] );
			?>
			<div class="col-md-4"> 
          <!--BLOG 3 WRAP START-->
          <div class="blog_3_wrap"> 
            <!--BLOG 3 SIDE BAR START-->
            <ul class="blog_3_sidebar">
              <li> <a href="javscript:void(0)"> <?=date( 'd' , strtotime( $v[ 'blog_join_date' ] ) )?> <span><?=date( 'M' , strtotime( $v[ 'blog_join_date' ] ) )?></span> </a> </li>
            </ul>
            <!--BLOG 3 SIDE BAR END--> 
            <!--BLOG 3 DES START-->
            <div class="blog_3_des">
              <figure> <img src="<?=$this->base?>assets/uploads/blog/<?=$image?>" alt="">
                <figcaption><a href="<?=$link?>">Read blog</a></figcaption>
              </figure>
              <ul>
                <li><a href="#"><?=$v[ 'first_name' ]?></a><?=date_readable($v[ 'blog_join_date' ])?></li>
              </ul>
              <h5><?=$v[ 'blog_name' ]?></h5>
              <p>
              <?=substr($v[ 'blog_description' ],0,220)?>
              </p>
              <a class="readmore" href="<?=$link?>"> read more <i class="fa fa-long-arrow-right"></i> </a> </div>
            <!--BLOG 3 DES END--> 
          </div>
          <!--BLOG 3 WRAP END--> 
        </div>
			
			<?php
			$i++; if( $i%3 == 0 ) echo '<div class="clearfix"></div>';
		} 
		?>
        
        <!--<div class="col-md-12"> 
          <div class="kf_edu_pagination_wrap">
            <ul class="pagination">
              <li> <a href="#" aria-label="Previous"> <span aria-hidden="true"><i class="fa fa-angle-left"></i>PREV</span> </a> </li>
              <li class="active"><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">4</a></li>
              <li><a href="#">5</a></li>
              <li> <a href="#" aria-label="Next"> <span aria-hidden="true">Next<i class="fa fa-angle-right"></i></span> </a> </li>
            </ul>
          </div>
        </div>-->
      </div>
    </div>
  </section>
</div>
