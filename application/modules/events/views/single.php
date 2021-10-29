<!--Banner Wrap Start-->
<?php
$image=	$blog[ 'blog_image' ] != ''  ? $blog[ 'blog_image' ] : 'default.jpg';
?>
<div class="kf_inr_banner">
  <div class="container">
    <div class="row">
      <div class="col-md-12"> 
        <!--KF INR BANNER DES Wrap Start-->
        <div class="kf_inr_ban_des">
          <div class="inr_banner_heading">
            <h3>Blog Detail</h3>
          </div>
          <div class="kf_inr_breadcrumb">
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">Blog Detail</a></li>
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
  <section>
    <div class="container">
      <div class="row">
        <div class="col-md-8"> 
          
          <!--KF_BLOG DETAIL_WRAP START-->
          <div class="kf_blog_detail_wrap"> 
            
            <!-- BLOG DETAIL THUMBNAIL START-->
            <div class="blog_detail_thumbnail">
              <figure> <img src="<?=$this->base.'assets/uploads/blog/'.$image?>" alt=""/>
                <figcaption><a href="#">spyrosys</a></figcaption>
              </figure>
            </div>
            <!-- BLOG DETAIL THUMBNAIL END--> 
            
            <!--KF_BLOG DETAIL_DES START-->
            <div class="kf_blog_detail_des">
              <div class="blog-detl_heading">
                <h5><?=$blog[ 'blog_name' ]?></h5>
              </div>
              <ul class="blog_detail_meta">
                <li><i class="fa fa-calendar"></i><a href="#"><?=date_readable($blog[ 'blog_join_date' ])?></a></li>
              </ul>
              <?=$blog[ 'blog_description' ]?>
            </div>
            <!--KF_BLOG DETAIL_DES END--> 
            
          </div>
          <!--KF_BLOG DETAIL_WRAP END--> 
        </div>
        
        <!--KF_EDU_SIDEBAR_WRAP START-->
        <div class="col-md-4">
          <div class="kf-sidebar"> 
            
            <!--KF SIDEBAR RECENT POST WRAP START-->
            <div class="widget widget-recent-posts">
              <h2>Recent Posts</h2>
              <ul class="sidebar_rpost_des">
                <!--LIST ITEM START-->
                <?php
                foreach( $recent as $v )
				{
					$image	=	$v[ 'blog_image' ] != ''  ? $v[ 'blog_image' ] : 'default.jpg';
					$link	=	$this->base.'blog/'.$v[ 'blog_id' ].'/'.url_title( $v[ 'blog_name' ] );
					?>
					<li>
                      <figure> <img src="<?=$this->base.'assets/uploads/blog/'.$image?>" alt="">
                        <figcaption><a href="<?=$link?>">Read Blog</a></figcaption>
                      </figure>
                      <div class="kode-text">
                        <h6><a href="<?=$link?>"><?=$v[ 'blog_name' ]?></a></h6>
                        <span><i class="fa fa-clock-o"></i>10 <?=date_readable($v[ 'blog_join_date' ])?></span> </div>
                    </li>
					<?php
				}
				?>
                
                <!--LIST ITEM START--> 
                              </ul>
            </div>
            <!--KF SIDEBAR RECENT POST WRAP END--> 
            
          </div>
        </div>
        <!--KF EDU SIDEBAR WRAP END--> 
        
      </div>
    </div>
  </section>
</div>
<!--Content Wrap End--> 
