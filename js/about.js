'use strict';

//circliful
$( document ).ready(function() {
    $('#myStat').circliful();
    $('#myStat2').circliful();
    $('#myStat3').circliful();
    $('#myStat4').circliful();
    $('#myStat5').circliful();

});
//owl carousel
$("#meet-owl-sec").owlCarousel({

    //Set AutoPlay to 3 seconds

    items : 4,
    itemsDesktop : [1199,3],
    itemsDesktopSmall : [979,3],
    afterInit : function(elem){
        var that = this;
        that.owlControls.prependTo(elem)
    }

});

//quickview
$(".boxer").boxer();






