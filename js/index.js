'use strict';

//upper and down icon

$.material.init();
function toggleChevron(e) {
    $(e.target)
        .prev('.panel-heading')
        .find("i.indicator")
        .toggleClass('mdi-hardware-keyboard-arrow-down mdi-hardware-keyboard-arrow-up');
}
$('.accordiona').on('hidden.bs.collapse', toggleChevron);
$('.accordiona').on('shown.bs.collapse', toggleChevron);

$('#secondAccordion').on('hidden.bs.collapse', toggleChevron);
$('#secondAccordion').on('shown.bs.collapse', toggleChevron);


//owl carousel
 $("#team-slider").owlCarousel({

      autoPlay: 3000, //Set AutoPlay to 3 seconds

      items : 4,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3],
      afterInit : function(elem){
      var that = this;
      that.owlControls.prependTo(elem)
    }

  });
  //owl carousel
 $("#logo-sec").owlCarousel({

      autoPlay: 3000, //Set AutoPlay to 3 seconds

      items : 4,
      itemsDesktop : [1199,3],
      itemsDesktopSmall : [979,3],
      afterInit : function(elem){
      var that = this;
      that.owlControls.prependTo(elem)
    }

  });



