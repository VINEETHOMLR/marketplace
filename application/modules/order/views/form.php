<style>
.typeahead {
	z-index: 1051;
}
.bootstrap-tagsinput {
	width: 100%;
	border-radius: 0px;
}
.trumbowyg-box{
  
}
</style>
<script>
  var base='<?= $this->base?>';
</script>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
  var uploadurl=base+'blog/blog/tinymce_upload';
  
  tinymce.init({
  selector: 'textarea',
  height: 100,
  theme: 'modern',
 // plugins:'code image',
  plugins: [
    'advlist autolink lists  image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc code image'
  ],
   toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image code',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',

  //toolbar:'undo redo | image code',
  
setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }

 });</script>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title"><?=isset( $order[ 'order_id' ] ) ? 'Order Details' : 'Order Details'?> </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="category_form" method="post" action="<?=$this->base?>category/admin_category/update" enctype="multipart/form-data" >
  	<?php
    if( isset( $order[ 'category_id' ] )  && trim( $order[ 'category_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"category_id\" value=\"{$order[ 'category_id' ]}\">";
	}
	?>
    
    <div class="box-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="category_title">Order Id</label>
            <input type="text" name="category_name" value="<?=isset( $order[ 'order_id' ] ) ? $order[ 'order_id' ]: ''?>" class="form-control" id="category_title" disabled required>
          </div>




         <!--  <div class="form-group">
            <label for="category_title">Customer Name</label>
            <input type="text" name="category_name" value="<?=isset( $order[ 'customer_first_name' ] ) ? $order[ 'customer_first_name' ].' '.$order[ 'customer_last_name' ]: ''?>" class="form-control" id="category_title" disabled required>
          </div> -->

         

        
          

          
         

      <div class="form-group ">
        <label for="category_title">Order Details</label>
        <?php if(!empty($orderDetails)){ ?>
        <table border="2" width="100%">
          <tr>
            <th>Slno</th>
            <th>Product</th>
            <th>Count</th>
            <th>Price</th>
            <th>Total</th>
          </tr>
          <?php foreach($orderDetails as $k=>$v){
            $color = !empty($v['product_color']) ? $v['product_color'] : "";
            $size = !empty($v['product_size']) ? $v['product_size'] : "";
            ?>
            <tr>
              <td><?= $k+1?></td>
              <td><?= $v['product_name']?>
              <?php if(!empty($color)) { ?>
                  <input type="color" id="favcolor" name="favcolor" value="<?= $color?>" disabled>
              <?php }?>

              <?php if(!empty($size)) { ?>
                  Size : <?= $size ?>
              <?php }?>



            </td>
            <td><?= $v['product_code']?> </td>
            <td><a href="<?= $v['product_image']?>" target="_blank"><img src="<?= $v['product_image']?>" height="100px" width="100px"></a></td>
              <td><?= $v['product_count']?></td>
              <td><?= $v['price']?></td>
              <td><?= $v['total_price']?></td>
                
            </tr>
          <?php } ?>  
          <tr>
             <td colspan="5"></td>
             <td><b>Subtotal(Rs)</b></td>
             <td><b><?= $order['sub_total'] ?></b></td>
            <!-- <td colspan="3">Sum: $180</td> -->
          </tr>

          <tr>
             <td colspan="5"></td>
             <td><b>Tax(Rs)</b></td>
             <td><b><?= $order['tax'] ?></b></td>
            <!-- <td colspan="3">Sum: $180</td> -->
          </tr>

          <tr>
             <td colspan="5"></td>
             <td><b>Delivery charges(Rs)</b></td>
             <td><b><?= $order['delivery_charges'] ?></b></td>
            <!-- <td colspan="3">Sum: $180</td> -->
          </tr>

          <tr>
             <td colspan="5"></td>
             <td><b>Grand Total(Rs)</b></td>
            <td><b><?= $order['grand_total'] ?></b></td>
            <!-- <td colspan="3">Sum: $180</td> -->
          </tr>
        </table>
        <?php } ?>
      </div>  
          
          
        </div>
        <div class="col-md-6">
          <div class="form-group ">
          <label for="category_title">Customer Details</label>
          <table border="2" width="100%">
            <tr>
              <td>First Name</td>
              <td><?= $order['customer_first_name']?></td>
            </tr>
            <tr>
              <td>Last Name</td>
              <td><?= $order['customer_last_name']?></td>
            </tr>
            <tr>
              <td>Delivery Address</td>
              <td><?= $customerAddress['address']?></td>
            </tr>
            <tr>
              <td>Landmark</td>
              <td><?= $customerAddress['landmark']?></td>
            </tr><tr>
              <td>Pincode</td>
              <td><?= $customerAddress['pincode']?></td>
            </tr>
          </table> 
          </div> 
         </div>
        
      </div>
      
         

       
    </div>
    <!-- /.box-body -->
    
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right ladda-button">Save</button>
    </div>
  </form>
</div>

