<!-- Widget: user widget style 1 -->

<div class="box box-widget widget-user"> 
  <!-- Add the bg color to the header using any of the bg-* classes -->
  <div class="widget-user-header bg-aqua-active">
    <h3 class="widget-user-username"><?=$user[ 'name' ].' '.$user[ 'name_last' ]?></h3>
    <h5 class="widget-user-desc">GravityINC <?=$user[ 'designation' ]?></h5>
  </div>
  <div class="widget-user-image"> <img class="img-circle" src="<?=$this->base?>assets/img/users/<?=$user[ 'image' ]?>" alt="User Avatar"> </div>
  <div class="box-footer bg-gray">
    <div class="row">
      <div class="col-sm-4 border-right">
        <div class="description-block">
          <h5 class="description-header">3,200</h5>
          <span class="description-text">SALES</span> </div>
        <!-- /.description-block --> 
      </div>
      <!-- /.col -->
      <div class="col-sm-4 border-right">
        <div class="description-block">
          <h5 class="description-header">13,000</h5>
          <span class="description-text">FOLLOWERS</span> </div>
        <!-- /.description-block --> 
      </div>
      <!-- /.col -->
      <div class="col-sm-4">
        <div class="description-block">
          <h5 class="description-header">35</h5>
          <span class="description-text">PRODUCTS</span> </div>
        <!-- /.description-block --> 
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
  </div>
</div>
<!-- /.widget-user --> 
