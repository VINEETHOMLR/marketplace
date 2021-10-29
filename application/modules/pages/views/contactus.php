<section class="inner-banner-main wow fadeInUp">
      <div class="inner-banner" style="background-image: url(<?= $this->base.'themes/public/'?>img/contact-banner.jpg);">
        <div class="inner-banner-area">
          <div class="container">
            <div class="row inner-banner-caption">
              <div class="col-lg-6 col-sm-12 col-12 destination-name">
                <h3>Contact Us</h3>
              </div>
              <div class="col-lg-6 col-sm-12 col-12 breadcrump text-right">
                <ul>
                  <li><a href="<?= $this->base.'home'?>">Home</a></li>
                  <li>Contact Us</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="contact-section wow fadeInUp">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-76 col-sm-12 col-12 offset-lg-2">
            <div class="contact-form">
              <h4>Send Enquiry</h4>
              <div class="booking-form">
                <form action="<?= $this->base.'pages/send_query'?>" class="row mvform1"  method="POST">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Name :" name="first_name">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Last Name :" name="last_name">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <input type="email" class="form-control" placeholder="Email :" name="email">
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Phone :" name="phone">
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group">
                      <textarea  id="" cols="30" rows="10" class="form-control" placeholder="Messages :" name="message"></textarea>
                    </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="form-group contact-btn-main">
                      <button type="submit" class="hvr-bounce-to-right book-now-btn">Send Message</button>
                    </div>
                  </div>
				  <div class="mvresult"></div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="contact-location">
      <div class="hotel-location-map">
        <div class="location-address">
          <div class="contact-address">
              <h5>For Any Enquiry</h5>
              <p><i class="flaticon-map" aria-hidden="true"></i> Jeeva Tours and Travels Jeeva Towers Athani P.O. PIN : 683585 Ernakulam, Kerala India.</p>
            </div>
            <div class="contact-numbers">
              <strong>Tour/package Enquiry: </strong> <a href="tel:+91-9544703000">+91 9544 70 3000</a>
            </div>
            <div class="contact-numbers">
              <strong>Reservations: </strong> <a href="tel:+91-9207729412">+91 9207 72 9412</a>
            </div>
            <div class="contact-numbers">
              <strong>Office : </strong> <a href="tel:04842475433">0484 247 54 33</a>
            </div>
            <div class="contact-email">
              <p><a href="mailto:info@jeevatours.in"><i class="flaticon-message" aria-hidden="true"></i> info@jeevatours.in</a></p>
            </div>
            <div class="contact-email">
              <p><a href="http:\\www.jeevatours.in"><i class="flaticon-internet" aria-hidden="true"></i> www.jeevatours.in</a></p>
            </div>
        </div>
        <div class="mapouter"><div class="gmap_canvas"><iframe width="100%" height="350" id="gmap_canvas" src="https://maps.google.com/maps?q=jeeva%20tours%20and&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe></div><style>.mapouter{text-align:right;height:100%;width:100%;}.gmap_canvas {overflow:hidden;background:none!important;height:100%;width:100%;}</style><small></small></div>
      </div>
    </section>