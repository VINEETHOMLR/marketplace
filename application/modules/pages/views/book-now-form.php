<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content booking-form">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Book Now</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= $this->base.'pages/book_now'?>" class="row mvform1" method="POST">
          <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Name :" name="name">
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
          <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="No of Persons :" name="noofpersons">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <input type="text" class="form-control datepicker" placeholder="From :" name="from">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="form-group">
              <input type="text" class="form-control datepicker" placeholder="To :" name="to">
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <textarea name="message" id="" cols="30" rows="10" class="form-control" placeholder="Messages :"></textarea>
            </div>
          </div>
          <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
              <button type="submit" class="hvr-bounce-to-right book-now-btn">Book Now</button>
              <div class="mvresult"></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>