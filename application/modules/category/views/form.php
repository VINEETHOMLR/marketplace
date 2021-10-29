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
/*.varient-option {*/
/*    margin: 10px 0px;*/
/*}*/
.varientoption{
    margin: 10px 0px;
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
    <h3 class="box-title"><?=isset( $category[ 'category_id' ] ) ? 'Edit category' : 'Add New category'?> </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="category_form" method="post" action="<?=$this->base?>category/admin_category/update" enctype="multipart/form-data" >
  	<?php
    if( isset( $category[ 'category_id' ] )  && trim( $category[ 'category_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"category_id\" value=\"{$category[ 'category_id' ]}\">";
	}
	?>
    
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="category_title">Category  Title</label>
            <input type="text" name="category_name" value="<?=isset( $category[ 'category_name' ] ) ? $category[ 'category_name' ]: ''?>" class="form-control" id="category_title" placeholder="Enter category  Title" required>
          </div>

         

          
          <div class="form-group">
            <label for="category_image">category Image</label>
            
            <?php
            if( isset( $category[ 'category_image' ] )  && trim( $category[ 'category_image' ] ) != '' )
        			{
        				echo "<input type=\"hidden\" name=\"category_image_last\" value=\"{$category[ 'category_image' ]}\">";
        				echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/category/{$category[ 'category_image' ]}\" class=\"img-responsive pad\" ></div>";
        			}
        			?>
            
            <input type="file" id="category_image" name="category_image"  data-error="Please upload an image for the portfolio" <?=isset( $category[ 'category_image' ] )  && trim( $category[ 'category_image' ] ) != '' ? '' : 'required'?>>
            <p class="help-block with-errors"></p>
          </div>
        
          

          
          <?php
          if( Modules::run( 'login/is_admin' ) )
		  {
				?>
				<div class="form-group">
                    <label for="category_status">Status</label>
                    <select class="form-control" id="category_status" name="category_status">
                      <?php
                      foreach( commonStatus::getDropDown() as $k => $v )
                      {
                            $selected	=	isset( $category[ 'category_status' ] ) && $category[ 'category_status' ] == $k ? 'selected' : '';
                            echo "<option value=\"$k\" $selected>$v</option>"; 
                      }
                      ?>
                    </select>
                  </div>
				<?php 
		  }
		  ?>
          
          
        </div>
        <div class="col-md-6 varient-portion"> 
            <label for="">Category Variant</label>
            <?php 
            if(isset($varient) && count($varient) > 0){
                    $i = 0;
                    foreach($varient as $k => $v){
                        
                        ?>
                        <div class="varient varient-<?= $i ?>">
                            <div class="row">
                                <div class="col-md-10  col-xs-9">
                                    <input type="text" placeholder="Variant Name" value="<?= $v->varient_name ?>" class="form-control" name="variant[<?= $v->id ?>][name]">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-info" type="button" onclick="add_varient(this)"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="varient-option">
                                <?php if(isset($v->options)){ 
                                    $j = 1;
                                    foreach($v->options as $kk => $vv){
                                ?>
                                    <div class="row varient-option-<?= $kk ?> varientoption" >
                                        <div class="col-md-8  col-xs-7">
                                            <input type="text" placeholder="Variant Option Name"value="<?= $vv->option_name  ?>"  class="form-control" name="variant[<?= $v->id ?>][<?= $vv->id ?>]">
                                        </div>
                                        <div class="col-md-4  col-xs-5">
                                            <?php //if(count($v->options) == $j){ ?>
                                            <button class="btn btn-success" type="button" onclick="add_varient_option(<?= $v->id ?>,this)"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                            <?php //}else{ ?>
                                            <!--<button class="btn btn-danger" type="button" onclick="remove_varient_option(<?= $v->id ?>,this)"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>-->
                                            <?php //} ?>
                                        </div>
                                    </div>
                                <?php $j++; } }else{ ?>
                                    <div class="row varient-option-1 varientoption">
                                        <div class="col-md-8">
                                            <input type="text" placeholder="Variant Option Name" class="form-control" name="variant[<?= $v->id ?>][new0]">
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-success" type="button" onclick="add_varient_option(<?= $v->id ?>,this)"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                <?php } ?>
                                 
                            </div>
                        </div>
                        <?php
                        $i++;
                    }
                }else{
            ?>
                <div class="varient varient-1>">
                    <div class="row">
                        <div class="col-md-10 col-xs-9">
                            <input type="text" placeholder="Variant Name" class="form-control" name="variant[new0][name]">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-info" type="button" onclick="add_varient(this)"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="varient-option">
                        <div class="row varient-option-1 varientoption"  data-no="new0">
                            <div class="col-md-8  col-xs-7">
                                <input type="text" placeholder="Variant Option Name" class="form-control" name="variant[new0][new0]">
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success" type="button" onclick="add_varient_option(0,this)"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        
      </div>
    </div>
    <!-- /.box-body -->
    
    <div class="box-footer">
      <button type="submit" class="btn btn-primary pull-right ladda-button">Save</button>
    </div>
  </form>
</div>
<script>
    function add_varient(e){
        var varno = $(".varient").length;
        var htm = "";
        htm += '<div class="varient varient-1">';
            htm += '<div class="row">';
                htm += '<div class="col-md-10 col-xs-9">';
                    htm += '<input type="text" placeholder="Variant Name" class="form-control" name="variant[new'+varno+'][name]">';
                htm += '</div>';
                htm += '<div class="col-md-2">';
                    htm += '<button class="btn btn-info" type="button" onclick="add_varient(this)"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';
                htm += '</div>';
            htm += '</div>';
            htm += '<div class="varient-option">';
                 htm += '<div class="row varient-option-1 varientoption" data-no="new'+varno+'">';
                    htm += '<div class="col-md-8 col-xs-7">';
                        htm += '<input type="text" placeholder="Variant Option Name" class="form-control" name="variant[new'+varno+'][new0]">';
                    htm += '</div>';
                    htm += '<div class="col-md-4 col-xs-4">';
                        htm += '<button class="btn btn-success" type="button" onclick="add_varient_option(0,this)"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';
                    htm += '</div>';
                htm += '</div>';
            htm += '</div>';
        htm += '</div>';
         $(".varient-portion").append(htm);
    }
    function add_varient_option(id,e){
        var varno = $(e).parent().parent().parent().parent().find(".varientoption").length;
        var no = $(e).parent().parent().parent().parent().find(".varientoption").attr("data-no");
       

        var htm = "";
        htm += '<div class="row varient-option-'+varno+' varientoption">';
            htm += '<div class="col-md-8 col-xs-7">';
            if(id == 0){
                htm += '<input type="text" placeholder="Variant Option Name" class="form-control" name="variant['+no+'][new'+varno+']">';
            }else{
                htm += '<input type="text" placeholder="Variant Option Name" class="form-control" name="variant['+id+'][new'+varno+']">';
            }
            htm += '</div>';
            htm += '<div class="col-md-4 col-xs-4">';
                htm += '<button class="btn btn-success" type="button" onclick="add_varient_option('+id+',this)"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>';
            htm += '</div>';
        htm += '</div>';
        
        $(e).parent().parent().parent().parent().find(".varient-option").append(htm);
        // $(e).parent().parent().parent().parent().find(".btn-success").replaceWith( '<button class="btn btn-danger" type="button" onclick="remove_varient_option('+varno+',this)"><i class="fa fa-minus-circle" aria-hidden="true"></i></button>' );
    }
</script>
