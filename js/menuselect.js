
	$(document).ready(function() {
		setNavigation();
    	$( ".add-nav li a" ).click(function(  ) {
  var path=$(this).attr('href');
  	$( ".add-nav li a" ).each(function(  ) {
  var href=$(this).attr('href');
 if(path==href){
  $('.nav_menu.active').removeClass('active');	
$(this).closest('li').addClass('active');
 }
});
});


	});
	function setNavigation(){
		var path=window.location;
		
		$( ".nav_menu a" ).each(function(  ) {
  var href=$(this).attr('href');
 if(path==href){
 	
 	 $('.nav_menu.active').removeClass('active');
$(this).closest('li').addClass('active');
 }
});
		
	}

