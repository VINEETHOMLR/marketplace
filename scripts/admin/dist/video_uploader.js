'use strict'
var $wrap = $('#videoUploaderWrap');
var $template = $('#videoUploaderTemplate').html();
$('#videoUploaderTemplate').remove();
//$wrap.html('');
$('#addVideo').on('click',function(){
	addUploader();
});
var count = 0;
$wrap.find('.uploaderWrap').each(function(i,el){
	count++;
	$(el).find('.videosrc').on('change',function(){
		createThumbnail( $(el) );
	});
	createThumbnail( $(el) );
});
console.log(count)
if( count < 3 ){
	var fillCount = 3 - count;
	for (var i = fillCount ; i > 0; i--) {
		addUploader();
	}
}

function addUploader(){
	var newEl = $($template);
	$wrap.append(newEl);
	newEl.find('.videosrc').on('change',function(){
		createThumbnail( newEl );
	});
}

function createThumbnail( $el ){

	$el.find('.delete-img').on('click',function(e){
		e.preventDefault();
		if(confirm('are you sure to remove this ?')){
			$el.remove();
		}
	})


	var iframe_src = $el.find('.videosrc').val();
	console.log(iframe_src)
	if($.trim(iframe_src)=='' || $.trim(iframe_src) == 'NULL' ) return;
	var youtube_video_id = iframe_src.match(/youtube\.com.*(\?v=|\/embed\/)(.{11})/).pop();
	if (youtube_video_id.length == 11) {
	    var img = "//img.youtube.com/vi/"+youtube_video_id+"/0.jpg";
	    $el.find('.img-preview img').attr('src',img);
	}
}