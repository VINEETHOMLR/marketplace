
places=jQuery.parseJSON(places);
$('.tagsinput-typeahead').tagsinput({
	
  typeahead: {
    source: places.map(function(item) { return item.tag_name }),
    afterSelect: function(item) {
    	this.$element[0].value = '';
    	
    }
    
  }
})  

/*$('#blog_tags').on('keypress', function(e) {
    console.log( e.which );
    if($('#blog_tags').val().length == 0){
        var k = e.which;
        var ok = k >= 65 && k <= 90 || // A-Z
            k >= 97 && k <= 122 || // a-z
            k >= 48 && k <= 57; // 0-9
        
        if (!ok){
            e.preventDefault();
        }
    }
}); */


$(document).ready(function(){
    $("#category").keyup(function(e){
	alert();
   // var keyCode = e.which;
 
    /* 
    48-57 - (0-9)Numbers
    65-90 - (A-Z)
    97-122 - (a-z)
    8 - (backspace)
    32 - (space)
    */
    // Not allow special 
  /*  if ( !( (keyCode >= 48 && keyCode <= 57) 
      ||(keyCode >= 65 && keyCode <= 90) 
      || (keyCode >= 97 && keyCode <= 122) ) 
      && keyCode != 8 && keyCode != 32) {
      e.preventDefault();
    }*/
  });
});