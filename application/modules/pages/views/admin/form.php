<style>
.typeahead {
	z-index: 1051;
}
.bootstrap-tagsinput {
	width: 100%;
	border-radius: 0px;
}
</style>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({
  selector: 'textarea',
  height: 200,
  theme: 'modern',

  //relative_urls : false,
//remove_script_host : false,
//convert_urls : true,

  verify_html: false,
  valid_children : "+a[div|span|h1|h2|h3|h4|h5|h6|p|#text]",

  relative_urls : false,
  remove_script_host : true,
  document_base_url :'<?= $this->base?>',
  allow_script_urls: true,
  
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
  ],
  toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
   //'//www.tinymce.com/css/codepen.min.css',
    '<?= $this->base?>themes/public/css/layout.css'
  ],
setup: function (editor) {
        editor.on('change', function () {
            editor.save();
        });
    }
 });</script>
<div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">
      <?=isset( $page[ 'page_id' ] ) ? 'Edit Page' : 'Add New Page'?>
      Image size : 580*520px
    </h3>
  </div>
  <!-- /.box-header --> 
  <!-- form start -->
  <form role="form" class="mvform" id="page_form" method="post" action="<?=$this->base?>pages/admin_pages/update" enctype="multipart/form-data" >
    <?php
    if( isset( $page[ 'page_id' ] )  && trim( $page[ 'page_id' ] ) != '' )
	{
		echo "<input type=\"hidden\" name=\"page_id\" value=\"{$page[ 'page_id' ]}\">";
	}
	?>
    <div class="box-body">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="page_name">Page  Title</label>
            <input type="text" name="page_name" value="<?=isset( $page[ 'page_name' ] ) ? $page[ 'page_name' ]: ''?>" class="form-control" id="page_name" placeholder="Enter Page  Title" required>
          </div>
          <div class="form-group">
            <label for="page_name">Page  Breadcrumb</label>
            <input type="text" name="page_breadcrumb" value="<?=isset( $page[ 'page_breadcrumb' ] ) ? $page[ 'page_breadcrumb' ]: ''?>" class="form-control" id="page_breadcrumb" placeholder="Enter Page  breadcrumb" required>
          </div>

          
          <div class="form-group">
            <label for="page_image">Page Image</label>
            <?php
            if( isset( $page[ 'page_image' ] )  && trim( $page[ 'page_image' ] ) != '' )
			{
				echo "<input type=\"hidden\" name=\"page_image_last\" value=\"{$page[ 'page_image' ]}\">";
				echo "<div class=\"img-preview\"><img src=\"{$this->base}assets/uploads/pages/{$page[ 'page_image' ]}\" class=\"img-responsive pad\" ></div>";
			}
			?>
            <input type="file" id="page_image" name="page_image"  data-error="Please upload an image for the page" <?=isset( $page[ 'page_image' ] )  && trim( $page[ 'page_image' ] ) != '' ? '' : ''?>>
            <p class="help-block with-errors"></p>
          </div>
          
        </div>
        <div class="col-md-8">
        
          <!-- <div class="form-group">
            <label for="link">Link</label>
            <input type="text" name="link" value="<?=isset( $page[ 'link' ] ) ? $page[ 'link' ]: ''?>" class="form-control" id="link" placeholder="Enter link" >
          </div>-->

          <div class="form-group">
            <label for="exampleInputFile">Upper Page HTML</label>
            <textarea name="page_cms" class="form-control tinymce" ><?=isset( $page[ 'page_cms' ] ) ? $page[ 'page_cms' ]: ''?>
            </textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">Lower Page HTML</label>
            <textarea name="page_cms2" class="form-control tinymce" ><?=isset( $page[ 'page_cms2' ] ) ? $page[ 'page_cms2' ]: ''?>
            </textarea>
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
