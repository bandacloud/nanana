(function($){

$(document).ready(function(){

	$('nav#menu_mobile').mmenu();

	/********/

	$.fn.get_max_height = function() {
	    var heights = [];
	    this.each(function(){
	    	$(this).css({height:'auto'});
	    	heights.push($(this).height());
	    });

	    var maxHeight = Math.max.apply(0, heights);
	    return maxHeight;
	}

	$.fn.equalHeights = function() {
	    var heights = [];
	    this.each(function(){
	    	$(this).css({height:'auto'});
	    	heights.push($(this).height());
	    });

	    var maxHeight = Math.max.apply(0, heights);
	    this.height(maxHeight);
	}

	$.fn.equalHeights_inrow = function(options) {

	    // This is the easiest way to have default options.
		var settings = $.extend({
		// These are the defaults.
			numItem_inrow: ""
		}, options );

		var tep = this.length;
		for (var i = 0; i <= tep/settings.numItem_inrow; i++) {
			this.slice(i*settings.numItem_inrow,i*settings.numItem_inrow+settings.numItem_inrow).equalHeights();
		};
	}

	/***********/

	// init owl-carousel for home page
	/*$('#content .owl-recent-posts.latest_news').owlCarousel({
	    loop:true,
	    margin:40,
	    nav:true,
	    navText: ['<i class="fa fa-angle-left">','<i class="fa fa-angle-right">'],
	    dots: false,
	    mouseDrag: true,
	    items:3,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:2
	        },
	        991:{
	            items:2
	        },
	        1200:{
	            items:3
	        },
	        1600:{
	            items:3
	        }
	    },
		autoplay:true,
		autoplayTimeout:2500,
		autoplayHoverPause:true,
	    onInitialize: function(){

	    }
	});*/

	// init owl-carousel for home page
	$('#content .popular-artists .recent-posts').owlCarousel({
	    loop:true,
	    margin:40,
	    nav:true,
	    //navText: ['<i class="fa fa-angle-left">','<i class="fa fa-angle-right">'],
	    dots: false,
	    mouseDrag: true,
	    items:4,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:2
	        },
	        991:{
	            items:3
	        },
	        1200:{
	            items:4
	        },
	        1600:{
	            items:4
	        }
	    },
		autoplay:false,
		autoplayTimeout:3000,
		autoplayHoverPause:true,
	    onInitialize: function(){

	    }
	});

	/************************/

	$('#header .custom_menu > li').hover(
		function(){
			$(this).find('.sub-menu').stop(true, true).slideDown(500);
		},
		function(){
			$(this).find('.sub-menu').stop(true, true).delay(500).slideUp(500);
		}
	);

	/***********/

	window.onload = function(){

		$('a[href$=".jpg"], a[href$=".png"]').fancybox();

		/********************/

	    // IZOTOPE
	    $('#isotope-items').isotope({
		  	// options
		  	itemSelector: '.element',	
		  	percentPosition: true,	  			  	
		  	masonry: {
		  		gutter:10,
		      	columnWidth: '.grid-sizer'
		    }
		});

  


	    // filter items on button click
		$('#filters').on( 'click', 'a', function() {
			var el = $(this);
			$('#filters a').removeClass('active');
			el.addClass('active');

			var filterValue = el.data('option-value');
			if ( filterValue == '*' ) {
				$('#isotope-items').isotope({ filter: filterValue});
			}
			else {
				$('#isotope-items').isotope({ filter: 'li[data-filter*="'+filterValue+'"]'});
			}	
			return false;
		});	
	    


	} // end of onload


	/*******/

	window.onresize = function(){

	} // end of onresize


	/*************/


    //Chrome Smooth Scroll
    try {
        $.browserSelector();
        if($("html").hasClass("chrome")) {
            $.smoothScroll();
        }
    } catch(err) {

    };




});    /* end ready */

/*  ******************* END OF FILE***************************/
})(jQuery);