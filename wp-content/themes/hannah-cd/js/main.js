
/*****************************************************************/
/* GLOBAL IS MOBILE DETECT */
/*****************************************************************/

var isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
	Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
	},
	any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	}
};

( function($) {
  'use strict';	
	
	/*****************************************************************/
	/* JS MEDIA QUERY MOBILE CHECK */
	/*****************************************************************/
	
	$(document).ready(function() {
		
		// run test on initial page load
		$(window).on("load", function() {
			checkSize();
			checkSizeFitToFullscreen();
            checkSizeGridInfo();
		});
		
		// run test on resize an scroll of the window
		$(window).resize(checkSize);
		$(window).scroll(checkSize);
		$(window).resize(checkSizeFitToFullscreen);
		$(window).scroll(checkSizeFitToFullscreen);
		$(window).resize(checkSizeGridInfo);
		$(window).scroll(checkSizeGridInfo);
		
	});
	
	checkSize();
	checkSizeFitToFullscreen();
	checkSizeGridInfo();
	
	
	/*****************************************************************/
	/* ADOBE TYPEKIT */
	/*****************************************************************/

	try{Typekit.load({ async: true });}catch(e){}
	
	
	/*****************************************************************/
	/* ANIMATED HOVER EFFECTS */
	/*****************************************************************/

	$('.btn-ico.iframe-lightbox').hover(
		function(){
			$('.btn-ico.iframe-lightbox i').toggleClass('animated zoomIn');
		}
	);

	$('.navbar-icons .nav-icon').hover(
		function(){
			$(this).find('i').toggleClass('animated bounceIn');
		}
	);


	/*****************************************************************/
	/* TOP SEARCH */
	/*****************************************************************/

    $('.top-search').on("click", function(){
    	$('.top-search-form').show();
		$('.top-search-form input[type="search"]').focus();
			
        $('.top-search-form').on("click", function(){
            $(".top-search-form").hide();
        });	
        
        $('.top-search-form .search-form').on("click", function(e){
            e.stopPropagation();
        });	
	});
		

	/*****************************************************************/
	/* SCROLL TO TOP */
	/*****************************************************************/
	
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('.scrolltop').fadeIn();
			} else { 
				$('.scrolltop').fadeOut();
			}
		});
		
		$('.scrolltop').click(function () { 
			$('body,html').animate({
				scrollTop: 0
			}, 500); return false;
		});
	});


	/*****************************************************************/
	/* SOCIAL SHARE BAR */
	/*****************************************************************/
	
	if ( $('.social-share-bar').length ) {
	
		var element;
		var elementStart;
		var maximumTop;		
		var scrollTop;
		var top;

		element = $('.social-share-bar');
		elementStart = $('.post-main-content');
		maximumTop = elementStart.offset().top + elementStart.outerHeight() - element.outerHeight() - element.offset().top;
	
		/* switch for scroll position */ 
		
		$(element).affix({
			offset: {
				top: elementStart.offset().top
			}
		});
		
		/* get top position on scroll event */ 

		$(window).on('scroll', function() {
			scrollTop = $(window).scrollTop(); 

			if ( $('.social-share-bar.affix').length ) {
				top = scrollTop - elementStart.offset().top + $( '#wpadminbar' ).outerHeight() + $(".navbar").outerHeight() + 40;
				if ( top >= maximumTop ) {
					top = maximumTop;
				}
			} else {
				top = 10;
			}

			if($(window).innerWidth() < 1360) { element.css('top', 'auto'); } else { element.css({ top: top }); }
		});

		$(window).resize(function() {
			if($(window).innerWidth() < 1360) { element.css('top', 'auto'); } else { element.css({ top: top }); }
		});	
		
	}


	/*****************************************************************/
	/* SOCIAL PROFILE SIDEBAR */
	/*****************************************************************/
	
	// set vertical align for social profile sidebar
	
	var socialbarVerticalAlign = $('.social-profile-sidebar').outerHeight() / 2;	
	$('.social-profile-sidebar').css('margin-top', - socialbarVerticalAlign);
	

	/*****************************************************************/
	/* LOGO OVERLAY */
	/*****************************************************************/
	
	if ( $('.header-owl.owl-carousel').length || $('.masonry').length  ) { 
		$(window).on("load", function(){
			$('.logo-overlay').fadeOut();
		});
	} else {
		$(document).ready(function() {
			$('.logo-overlay').fadeOut();
		});
	}
	
	/*****************************************************************/
	/* ANIMATE CSS */
	/*****************************************************************/
	
	$(window).on("load", function(){
		var wow = new WOW ({
		    offset: 50,          
		    mobile: false
		});
		wow.init();
	});
	
	
	/*****************************************************************/
	/* BOOTSTRAP STICKY MENU */
	/*****************************************************************/
	
    var bodyTopSpacing;	
	var wpAdminBarHeight;
    var topWrapperHeight;    
	var topLayerHeight;
	var topBarHeight;
	var logoHeight;
	var navBarHeight;
	var navBarHeaderHeight;
	var topSumHeight;
    
    var navbarHeightStart;
    var navbarHeightSticky;
    var navbarHeightDiff;
    
    navbarHeightStart = $('.navbar').outerHeight();
	
	// function to check css rules
	
	function checkSize() {        
        
        navbarHeightSticky = $('.navbar.affix').outerHeight();
        
        // get the navbar height difference after becoming sticky
        if( $( '.navbar.affix' ).length ) { 
            navbarHeightDiff = navbarHeightStart - navbarHeightSticky;
        } else {
            navbarHeightDiff = 0;
        }
        
        wpAdminBarHeight = $('#wpadminbar').outerHeight();
        topWrapperHeight = $('.top-wrapper').outerHeight();
        topLayerHeight = $('.top-layer').outerHeight();
        topBarHeight = $('.topbar').outerHeight();
        logoHeight = $('.main-logo').outerHeight();                   
        navBarHeight = $('.navbar').outerHeight() + navbarHeightDiff;
        navBarHeaderHeight = $('.navbar-header').outerHeight();	
        bodyTopSpacing = navBarHeight;
        
        // mobile-desktop switch        
		var mobile_768_less = $( '.mobile-check' ).css( 'display' ) === 'none';
		var mobile_768_more = $( '.mobile-check' ).css( 'display' ) === 'block';
				
		/*****************************************************************/
		/* GLOBAL (if media query < 768 px) */
		/*****************************************************************/
		
		if( mobile_768_less ) {
			
            topSumHeight = wpAdminBarHeight + topBarHeight + navBarHeaderHeight;
            
			// newsletter subscription switch button label to icon
			$(".mc4wp-form input[type=submit]").addClass("fa").val("\uf0e0");
			$(".widget_wysija_cont .wysija-submit").addClass("fa").val("\uf0e0");
			$(".tnp-subscription .tnp-field input[type=submit]").addClass("fa").val("\uf0e0");		
			
		/*****************************************************************/
		/* GLOBAL (if media query > 768 px) */
		/*****************************************************************/
			
		} else if( mobile_768_more ) {
			
            topSumHeight = wpAdminBarHeight + topLayerHeight + topBarHeight + logoHeight + navBarHeight;
            
			// handle mobile navbar classes after resizing the window			
			$(".navbar-nav li.menu-item-has-children").removeClass('open');
			$(".navbar.navbar-fixed-top.affix-top").removeClass('affix');
			$(".collapse.navbar-collapse").removeClass('in');
				
		} 
        
        // manage header spacing by scroll down after switching from static menu to sticky menu
        // [ static content header spacing ] and [ post carousel header spacing ]   
        $( '.full-page .content-box' ).css( 'margin-top' , topSumHeight );
		
	}


	/*****************************************************************/
	/* BOOTSTRAP AFFIX */
	/*****************************************************************/

	var navbar = $('.navbar');
	var navbarAffixHeight = topWrapperHeight;
	
	navbar.affix({
		offset: {
	    	top: navbarAffixHeight,
	  	}
	});

    /* This event fires immediately before the element has been affixed. */
	navbar.on('affix.bs.affix', function() {
	
		if (!navbar.hasClass('affix')) {
		
			navbar.addClass('animated slideInDown');
			
			$(".topbar").fadeTo( 0 , 0.0 );
			
			/* affix body spacing */
			
			$("body").css( "padding-top", bodyTopSpacing );
			$("body.full-page").css( "padding-top", 0 );
			
		}
		
	});

    /* This event fires immediately before the element has been affixed-top */
	navbar.on('affix-top.bs.affix', function() {
	  	
		navbar.removeClass('animated slideInDown');
		
	  	$('.navbar-collapse').collapse('hide');
		
		/* affix header remove */
		
		$("body").css( "padding-top", 0 );
		
		$(".topbar").fadeTo( 0 , 1.0 );
		
	});

    /* This event fires immediately when the show instance method is called. */
	$('.navbar-collapse').on('show.bs.collapse', function () {
		navbar.addClass('affix');
	});

    /* This event is fired immediately when the hide method has been called. */
	$('.navbar-collapse').on('hide.bs.collapse', function () {
		if (navbar.hasClass('affix-top')) {
			navbar.removeClass('affix');
		}
	});
	
	/* Close mobile menu if clicking outside */
    
    $(document).on('click touchstart', function(e) {
        $('.navbar.affix').on("click", function(e){
            // stop closing the menu
            e.stopPropagation();
        });
        if( ! $(e.target).is('a') ) {
            $('.navbar-collapse.collapse.in').collapse('hide');        
        }
    });
    
    /* show or hide the mobile menu */
    
	$('.navbar-toggle').on("click", function(){
        $('.navbar-collapse.collapse.in').collapse('hide'); 
    });
    
    $('.navbar-toggle.collapsed').on("click", function(){
        $('.navbar-collapse.collapse').collapse('show');  
    });
    
	/* set classes for mobile submenu collapse */
	
	$('.navbar-nav li.menu-item-has-children a').addClass('dropdown-toggle');
	$('.navbar-nav .sub-menu').addClass('dropdown-menu');
	
	/* submenu collapse on click */
						
	$('.navbar a.dropdown-toggle').on('click', function() {
		// open or close the submenu
		$(this).parent("li").toggleClass('open');

		// close all submenu with exception of the active submenu
		$('.nav li.open').not($(this).parents("li")).removeClass("open");
	});
	

	/*****************************************************************/
	/* SMOOTH SCROLL */
	/*****************************************************************/

	$('.section-scroll').on('click', function() {
        var target = $(this.hash);
        if (target.length) {
            $('html,body').animate({
                scrollTop: (target.offset().top - navbarAffixHeight + 20)
            }, 1000);
            return false;
        }
    });
	

	/*****************************************************************/
	/* BOOTSTRAP TAB MENU */
	/*****************************************************************/

	// --> add active class by first tab element on page load
	
	$('.nav-tabs li:nth-of-type(1)').addClass('active');
	
	$('.tab-content div:nth-of-type(1)').addClass(' in active');

	// --> add bootstrap needed tab attributes
	
	$('.nav.nav-tabs').attr('data-tabs', 'tabs');
	$('.nav.nav-tabs li a').attr('data-toggle', 'tab');
	
	
	/*****************************************************************/
	/* BOOTSTRAP ACCORDION MENU */
	/*****************************************************************/

	// --> add active class by first accordion element on page load
	
	$('.panel-group.accordion .panel:nth-of-type(1) .panel-collapse').addClass(' in');

	// --> add bootstrap needed tab attributes
	
	$('.panel-group.accordion .panel-title a').attr('data-toggle', 'collapse');
	
	
	/*****************************************************************/
	/* BOOTSTRAP TOGGLE MENU */
	/*****************************************************************/
	
	// --> add bootstrap needed attributes

	$('.panel-group.toggle-menu .panel-title a').attr('data-toggle', 'collapse');
	
	
	/*****************************************************************/
	/* BOOTSTRAP TABLE */
	/*****************************************************************/

	// --> add bootstrap classes to content tables
	
	$('.content table').addClass('table table-hover table-striped');
	
	
	/*****************************************************************/
	/* BOOTSTRAP MODAL POPUP */
	/*****************************************************************/
	
	function reposition() {
        var modal = $(this);
		var dialog = modal.find('.modal-dialog');
        modal.css('display', 'block');

        // Dividing by two centers the modal exactly, but dividing by three 
        // or four works better for larger screens.
        dialog.css("margin-top", Math.max(0, ( $(window).height() - dialog.height()) / 2) );
    }
	
    // Reposition when a modal is shown
    $('.modal').on('show.bs.modal', reposition);
    $('.modal').on('shown.bs.modal', reposition);
    
	// Reposition when the window is resized
    $(window).on('resize', function() {
        $('.modal:visible').each(reposition);
    });
	
	/*****************************************************************/
	/* SCROLLSPY FOR LANDINGPAGE */
	/*****************************************************************/

	$('body.scrollspy').scrollspy({
		offset: navbarAffixHeight + 1
	});

	
    /*****************************************************************/
	/* MAIN OWL CAROUSEL SETTINGS */
	/*****************************************************************/
    
    // fix for the autoplay carousel on mouseleave
    var owlCarousel = $('.owl-carousel');
    
    owlCarousel.mouseover(function(){
        owlCarousel.trigger('stop.owl.autoplay');
    });

    owlCarousel.mouseleave(function(){
        owlCarousel.trigger('play.owl.autoplay',[1000]);
    });
    
    
	/*****************************************************************/
	/* PAGE HEADER OWL CAROUSEL */
	/*****************************************************************/

	$(window).on("load", function() {
	
		if ( $( '.header-owl.owl-carousel' ).length ) { 
			
			$(".header-owl.owl-carousel").owlCarousel({
				items: 1,
				nav : true,
				navText : false,
				dots : false,
				loop : true,
				slideSpeed : 400,
				animateOut : 'fadeOut',
				animateIn : 'fadeIn',
				autoplay : true,
				autoplayTimeout : 5000,
				autoplayHoverPause : true,
				autoHeight : false,
				
			});
            			
		}
		
	});

	
	/*****************************************************************/
	/* FEATURED SLIDER OWL CAROUSEL */
	/*****************************************************************/

	$(window).on("load", function() {
	
		if ( $( '.featured-slider-owl.owl-carousel' ).length ) { 
			
			$(".featured-slider-owl.owl-carousel").owlCarousel({
				items: 1,
				nav : true,
				navText : false,
				dots : false,
				loop : true,
				slideSpeed : 400,
				animateOut : 'fadeOut',
				animateIn : 'fadeIn',
				autoplay : true,
				autoplayTimeout : 5000,
				autoplayHoverPause : true,
				autoHeight : true,
				
			});
			
		}
		
	});
	
	
	/*****************************************************************/
	/* WIDGET POST CAROUSEL */
	/*****************************************************************/

	$(window).on("load", function() {
		
		if ( $('.posts-carousel-widget.owl-carousel').length ) { 

			$(".posts-carousel-widget.owl-carousel").owlCarousel({
				items: 1,
				nav : false,
				navText : false,
				dots : true,
				loop : true,
				slideSpeed : 400,
				animateOut : 'slideOutRight',
				animateIn : 'slideInLeft',
				autoplay : true,
				autoplayTimeout : 5000,
				autoplayHoverPause : true,
				autoHeight : false
			});	

		}
		
	});
	

	/*****************************************************************/
	/* POST FORMAT GALLERY OWL CAROUSEL */
	/*****************************************************************/

	$(window).on("load", function() {
	
		if ( $( '.gallery-owl.owl-carousel' ).length ) { 
			
			$(".gallery-owl.owl-carousel").owlCarousel({
				items : 1,
				nav : true,
				navText : false,
				dots : false,
				loop : true,
				slideSpeed : 400,
				animateOut : 'slideOutRight',
				animateIn : 'slideInLeft',
				autoplay : true,
				autoHeight : true
			});
		}
		
	});
	
	
	/*****************************************************************/
	/* WOOCOMMERCE PRODUCT GALLERY */
	/*****************************************************************/

	$(window).on("load", function() {
		
		if ( $('.owl-products.owl-carousel').length ) { 

			$(".owl-products.owl-carousel").owlCarousel({
				items: 4,
				nav : true,
				navText : false,
				dots : false,
				loop : false,
				slideSpeed : 400,
				animateOut : 'slideOutRight',
				animateIn : 'slideInLeft',
				autoplay : false,
				autoHeight : false
			});	

		}
		
	});
	

	/*****************************************************************/
	/* LOGO OWL CAROUSEL */
	/*****************************************************************/

	$(window).on("load", function() {
		
		if ( $( '.logos-owl.owl-carousel' ).length ) {
			
			$(".logos-owl.owl-carousel").owlCarousel({
				items : 4,
				dots : true,
				autoHeight : false,
				responsiveClass : true,
				responsive : {
					0: {
						items: 1,
					},
					495: {
						items: 2,
					},
					768: {
						items: 3,
					},
					992: {
						items: 4,
					}
				}
			});
		}
		
	});


	/*****************************************************************/
	/* REVIEW OWL CAROUSEL */
	/*****************************************************************/

	$(window).on("load", function() {
		
		if ( $( '.review-owl.owl-carousel' ).length ) {
			
			$(".review-owl.owl-carousel").owlCarousel({
				items : 3,
				dots : true,
				autoHeight : false,
				responsiveClass : true,
				responsive : {
					0: {
						items: 1,
					},
					768: {
						items: 2,
					},
					992: {
						items: 3,
					}
				}
			});
		}
		
	});
	
	
	/*****************************************************************/
	/* FULL SIZE FOOTERBAR INSTAGRAM / PINTEREST OWL CAROUSEL */
	/*****************************************************************/
	
	if ( $('.footerbar .instagram-widget').length || $('.footerbar .pinterest-widget').length ) { 
	
		$('.footerbar .instagram-grid, .footerbar .pinterest-grid').addClass('owl-carousel');
		
		$(".footerbar .instagram-grid.owl-carousel, .footerbar .pinterest-grid.owl-carousel").owlCarousel({
			items: 12,
			nav : false,
			navText : false,
			dots : false,
			loop : false,
			slideSpeed : 400,
			autoplay : true,
			autoplayTimeout : 5000,
			autoplayHoverPause : true,
			autoHeight : false,
			responsiveClass : true,
			responsive : {
				0: {
					items: 1,
				},
				768: {
					items: 4,
				},
				992: {
					items: 7,
				},
				1100: {
					items: 8,
				},
				1300: {
					items: 9,
				},
				1500: {
					items: 12,
				},
				2000: {
					items: 14,
				}
			},
		});	
	
	}

    
    /*****************************************************************/
	/* ANIMATED NUMBERS */
	/*****************************************************************/
    
    if( $( '.number-animated' ).length ) {
        
        $('.number-animated .the-number').each(function () {
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });

    }
        
    
	/*****************************************************************/
	/* IFRAME LIGHTBOX */
	/*****************************************************************/

	if ( $( '.iframe-lightbox' ).length ) {
		
		$('.iframe-lightbox').magnificPopup({
			type : 'iframe',
			removalDelay : 300
		});
		
	}


	/*****************************************************************/
	/* WP GALLERY LIGHTBOX */
	/*****************************************************************/

	// find link with images
	$('.gallery a[href]').filter(
		function() {
    		return /(jpg|gif|png)$/.test( $(this).attr('href'))
		}
	).addClass('lightbox-image');
	
	// open image links with class "lightbox-image"
	if ( $( '.gallery' ).length ) {
		
		$('.gallery').each(function() {
			$(this).magnificPopup({
				delegate: 'a.lightbox-image',
				type: 'image',
				gallery: {
					enabled:true
				}
			});
		});
		
	}

	if ( $( '.owl-gallery' ).length ) {
		
		$('.owl-gallery').each(function() {
			$(this).magnificPopup({
				delegate: 'a',
				type: 'image',
				gallery: {
					enabled:true
				}
			});
		});
		
	}
	

	/*****************************************************************/
	/* MASONRY GRID */
	/*****************************************************************/

	if ( ! $( '.grid' ).hasClass('post-grid') ) { // only for masonry grid --> not for post-grid
	
		if ( $( '.grid' ).length ) {

			$(window).on("load", function(){
				
				// Masonry options
				var masonryOptions = {
				  	columnWidth: '.grid-sizer',
					gutter: '.gutter-sizer',
					itemSelector: '.grid-item',
					percentPosition: true,
					transitionDuration: '0.2s',
				};
				
				// Masonry class
				var $gridClass = $('.grid');
				
				// initialize Masonry
				var $grid = $gridClass.masonry( masonryOptions );
				
				// destroy and initialize Masonry after resizing
				$(window).resize(function() {
					$gridClass.masonry( 'destroy' );
					$gridClass.masonry( masonryOptions );                                                            
				});
				
				// destroy and initialize Masonry after mobile device orientation changing
				window.addEventListener('orientationchange', function(){
     				$gridClass.masonry( 'destroy' );
					$gridClass.masonry( masonryOptions );
				});
				
				
			});

		}
	
	}
    
    
    /*****************************************************************/
	/* POST GRID */
	/*****************************************************************/
    
    var gridInfoHeight;
    
    function checkSizeGridInfo() {
       if ( $('.grid.post-grid').length ) { 
           
            var mobile_768_less = $( '.mobile-check' ).css( 'display' ) === 'none';
            var mobile_768_more = $( '.mobile-check' ).css( 'display' ) === 'block';
            
            if ( mobile_768_less ) {
                gridInfoHeight = 0;
            } else if( mobile_768_more ) {
                gridInfoHeight = $(".grid-info").outerHeight() - 40;
            }

       }
    }
	

	/*****************************************************************/
	/* GRID --> SET SAME HEIGHT TO GRID ITEMS PER ROW */
	/*****************************************************************/
	
	$(window).on("load", function(){

		var $list = $( '.grid.post-grid ' ),
			$items = $list.find( '.grid-item' ),
			setHeights = function() {
			
				$items.css( 'height', 'auto' );

				var perRow = Math.round( $list.outerWidth() / $items.outerWidth() );
				if( perRow == null || perRow < 2 ) return true;

				for( var i = 0, j = $items.length; i < j; i += perRow ) {
				
					var maxHeight = 0,
						$row = $items.slice( i, i + perRow );

					$row.each( function() {
						var itemHeight = parseInt( $( this ).outerHeight() );
						if ( itemHeight > maxHeight ) maxHeight = itemHeight;
					});
					
					$row.css( 'height', maxHeight + gridInfoHeight );
				}
				
			};

		setHeights();
		$( window ).on( 'resize', setHeights );

	});
	
	
	/*****************************************************************/
	/* FULL PAGE HEADER FIT TO FULLSCREEN */
	/*****************************************************************/

	function checkSizeFitToFullscreen() {
		
		if ( $('.fit-to-fullscreen').length ) { 
			
			var mobile_768_less = $( '.mobile-check' ).css( 'display' ) === 'none';
			var mobile_768_more = $( '.mobile-check' ).css( 'display' ) === 'block';

			if( mobile_768_more ) {

				// set size for header fit to fullscreen
				function fullscreen(){
					$('.fit-to-fullscreen .header:not(.header-carousel)').css({
						width: $(window).width(),
						height: $(window).height() - $('#wpadminbar').outerHeight(),
						minHeight: $('.header-content').outerHeight(),
					});
                    $('.fit-to-fullscreen .header.header-carousel').css({
						width: $(window).width(),
						height: $(window).height() - $('#wpadminbar').outerHeight(),
						minHeight: $('.header-carousel-spacer').outerHeight(),
					});
				}

				fullscreen();

				$(window).resize(function() {
					fullscreen();         
				});

			} else {

				// remove fit to fullscreen for mobile view
				function fullscreen(){
					$('.fit-to-fullscreen .header:not(.header-carousel), .fit-to-fullscreen .header.header-carousel').css({
						width: '100%',
						height: 'auto',
						minHeight: 'auto',
					});
				}

				fullscreen();

				$(window).resize(function() {
					fullscreen();         
				});

			}      
            
			// set left position of the button label text
			var scrollDownLabel = $('.scrollDown-label').outerWidth();
			$('.scrollDown-label').css('margin-left', - scrollDownLabel / 2 );
		
			// fadeIn and fadeOut on scrolling down
			$(window).on('scroll', function() {
				var scrollTop = $(window).scrollTop(); 
				var headerFadePoint = $(window).height() / 2;
				
				if ( scrollTop >= headerFadePoint ) {
					$(".fit-to-fullscreen-scroll").stop().animate({
						opacity: 0
					}, 500);
				} else {
					$(".fit-to-fullscreen-scroll").stop().animate({
						opacity: 1
					}, 500);
				}
			});
			
		}
		
	}
	
	
	/*****************************************************************/
	/* PIN BUTTON */
	/*****************************************************************/

	$('.post-thumb').hover(
      	function(){
            // child pin button 
			$(this).find('.pin-button').fadeIn();
			$(this).find('.pin-button').toggleClass('animated slideInDown');
            // neighbor pin button
            $(this).next('.pin-button').fadeIn();
            $(this).next('.pin-button').toggleClass('animated slideInDown');
		},
      	function(){
            // child pin button
			$(this).find('.pin-button').fadeOut();
			$(this).find('.pin-button').toggleClass('animated slideInDown');
            // neighbor pin button
			$(this).next('.pin-button').fadeOut();
			$(this).next('.pin-button').toggleClass('animated slideInDown');
		}
	);
	
	
	/*****************************************************************/
	/* TOP LAYER SUBSCRIBE BUTTON */
	/*****************************************************************/
	
	/* set the button width to fix overlapping */
	$(".top-layer .mc4wp-form input[type=submit]").addClass("fa").val("\uf061");
	$(".top-layer .widget_wysija_cont .wysija-submit").addClass("fa").val("\uf061");
	$(".top-layer .tnp-subscription .tnp-field input[type=submit]").addClass("fa").val("\uf061");
	

	/*****************************************************************/
	/* SEARCH FORM */
	/*****************************************************************/

	if ( $('.search-form') ) {
		$(".search-form input[type=submit]").addClass("fa").val("\uf002");
	} 
    
    
    /*****************************************************************/
	/* SECTION EDGE END */
	/*****************************************************************/
    
	$("section.image-section").prev("section").addClass("section-before");  
	$("section.prices").prev("section").addClass("section-before");   
	$("section.banner").prev("section").addClass("section-before"); 
    $("section.sec").last().addClass("section-last");
        
    /*****************************************************************/
	/* CONTENT GRID SECTION IMAGES */
	/*****************************************************************/
    
    $(window).on("load", function(){

		var setImgHeights = function() {
			
            $('.content-grid-img').each(function() {
                var contentGridImgWidth = $(this).outerWidth();
                $(this).css( 'height', contentGridImgWidth );
            });
            
        };

		setImgHeights();
		$( window ).on( 'resize', setImgHeights );

	});


	/*****************************************************************/
	/* GALLERY CAROUSEL SHORTCODE */
	/*****************************************************************/

	if ( $('.gallery-carousel') ) {
		$(".gallery-carousel .gallery").addClass("owl-carousel");
	}
	
	/*****************************************************************/
	/* UNORDERED ICON LIST */
	/*****************************************************************/
	
	function setIconForChilds(ico, childs) {
		
		for(var i = 0; i < childs.length; i++) {			
				
			if(childs[i].localName != "li" && childs[i].children.length > 0) {
					setIconForChilds(ico, childs[i].children);
			} else if(childs[i].localName == "li") {
				var newdiv = document.createElement('i');
				newdiv.className = 'icon fa ' + ico;
				childs[i].insertBefore(newdiv, childs[i].firstChild);
				if(childs[i].children.length > 0)setIconForChilds(ico, childs[i].children);
			}
		}
	}
	
	var ulist = $('.ulist');
	
	for(var xl = 0; xl <  ulist.length; xl++ ) {
		
		var ulist_ico = ulist[xl].getAttribute('data-icon');
		var ulist_li = ulist[xl].children[0].children;
		
		for(var xx = 0; xx < ulist_li.length; xx++) {
			var newdiv = document.createElement('i');
			newdiv.className = 'icon fa ' + ulist_ico;
			ulist_li[xx].insertBefore(newdiv, ulist_li[xx].firstChild);
			setIconForChilds(ulist_ico, ulist_li[xx].children);
		}
		
	}
	
	
	/*****************************************************************/
	/* PINTEREST & INSTAGRAM WIDGET PINS */
	/*****************************************************************/
	
	$(document).ready(function() {	
        
        if ( $('.pinterest-widget, .instagram-widget').length ) { 

            // items without owl carousel
            
            function pinInstaItem() {
                
                $('.pinterest-grid:not(.owl-carousel), .instagram-grid:not(.owl-carousel)').each(function() {
                    
                    // Get value of widthest element
                    var maxPinInstaItemHeight = Math.max.apply(Math, $(this).find('.pinterest-item, .instagram-item').map (
                        function() {
                            return $(this).outerWidth();
                        }
                    ));
                    
                    // Set the widthest element width for all items as height
                    $(this).find('.pinterest-item, .instagram-item').each(function() {
                        $(this).css('height', maxPinInstaItemHeight);
                    });
                    
                    
                });
                
            } 		

            pinInstaItem();

            $(window).resize(function() {
                pinInstaItem();
            });

            // items with owl carousel
            
            function pinInstaOwlItem() {
                $('.pinterest-grid .owl-item, .instagram-grid .owl-item').each(function() {
                    var pinInstaOwlItemWidth = $(this).outerWidth();
                    $(this).css('height', pinInstaOwlItemWidth);
                });
            }

            pinInstaOwlItem();	

            $(".instagram-grid.owl-carousel, .pinterest-grid.owl-carousel").on('resize.owl.carousel resized.owl.carousel ',
                function() {
                    pinInstaOwlItem();
                }
            );
            
        }
        
    });
    
	
	/*****************************************************************/
	/* ADD CLASSES TO WP INLINE POST IMAGES */
	/*****************************************************************/
	
	$( '.wp-caption-text' ).wrapInner( '<span>' );
	
	
	/*****************************************************************/
	/* LIKE BUTTON */
	/*****************************************************************/

	var ajaxdata = window.like_ajax_data || null;

	$( function() {
    	$('.like-btn').on('click', function() {
      		var likeBtn = $(this);
      		var post_id = $(this).data('pid');
      		var like_action = $(this).data('get-like');
      		var current_like_count = $(this).data('like-count') ? $(this).data('like-count') : 0;
      		var new_like_count;
      		if(like_action == 'get_it') {
				likeBtn.children('i.fa-heart-o').attr('class', 'fa fa-heart');
        		likeBtn.removeClass('no-like').addClass('like-btn-has-voted');
        		new_like_count = current_like_count + 1;
        		likeBtn.data('like-count', new_like_count);
        		likeBtn.data('get-like', 'get_it_back');
        		likeBtn.find('.like-btn-count').text(new_like_count);
        		if(new_like_count > 0) {
					likeBtn.find('.like-btn-count').removeClass('hidden');
				}
        		likeBtn.find('.like-btn-label').text(likeBtn.data('liked-label'));
      		} else {
				likeBtn.children('i.fa-heart').attr('class', 'fa fa-heart-o');
        		likeBtn.addClass('no-like').removeClass('like-btn-liked');
        		new_like_count = current_like_count - 1;
        		likeBtn.data('like-count', new_like_count);
        		likeBtn.data('get-like', 'get_it');
        		likeBtn.find('.like-btn-count').text(new_like_count);
        		if(new_like_count === 0) {
					likeBtn.find('.like-btn-count').addClass('hidden');
				}
        		likeBtn.find('.like-btn-label').text(likeBtn.data('like-label'));
      		}
      		$.ajax( {
          		type: 'POST',
          		url: ajaxdata.wp_ajaxurl,
          		data: {
            		"action" : "like_btn_request",
            		"like_pid" : post_id,
            		"like_action" : like_action
          		},
				dataType: "json",
				success: function(data) {
					if(data.status == 200) {
						var count = data.message.count;
						var liked = data.message.liked;
						if(liked) {
		
						} else {
		
						}
					}
          		}
      		});
      	return false;
    	});
  	});


	/*****************************************************************/
	/* STAR RATING */
	/*****************************************************************/

	var globaldata = window.pr_ajax_data || null;
	
	$.fn.wpAjaxRating = function() {
		return this.each(function() {
			var el = this, post_id = parseInt(this.getAttribute('data-curr-pid'), 10);
			$(this).on('click', 'a', function(e) {
				var rating = parseInt(this.getAttribute('data-value'), 10),
					data = {
						"action": "post_rating",
						"rating": rating,
						"post_id": post_id
					},
					update_value = function(result, count) {
						$(el).addClass("is-voted").find('.post-rating-layer').css( {
							"width": (100 - result * 100 / 5) + '%'
						})
						.end().parent().parent().find('.post-rating-count').html(count).end().parent().parent().find('.post-rating-all').html(parseInt(result * 100) / 100);
					},
					show_message = function(message) {
						$('.post-rating').attr('data-tooltip', message);
					};
	
				if( globaldata === null ) {
					globaldata = window.pr_ajax_data || null;
				}

				e.preventDefault();
	
				$.post(globaldata.ajax_url, data, function(response) {
					switch(response.status) {
						case globaldata.codes.ALREADY_VOTED:
							show_message(globaldata.messages.already_voted);
							break;
						case globaldata.codes.ERROR:
							show_message(globaldata.messages.error);
							break;
						case globaldata.codes.SUCCESS:
							update_value(response.result, response.votes);
							show_message(globaldata.messages.success);
							break;
						default:
							show_message(globaldata.messages.unknown);
					}
	
				}, "json");
			});
		});
	};
	
	$('.post-rating-stars-wrapper').wpAjaxRating();
	
	
	/*****************************************************************/
	/* AJAX SEARCH */
	/*****************************************************************/
	
	var searchdata = window.search_ajax_data || null;
	
	$('.search-form, .woocommerce-product-search').append('<div class="ajax-search"><ul></ul>');
	
	$('.search-field').keypress(function(event) {
		
		if( searchdata === null ) {
			searchdata = window.search_ajax_data || null;
		}
 
		// prevent browser autocomplete
		$(this).attr('autocomplete','off');
		
		// get search term
		var searchTerm = $(this).val();
 
		// send request when the lenght is gt 2 letters
		if(searchTerm.length > 2){
			$.ajax({
				url : searchdata.search_ajaxurl,
				type : "POST",
				data : {
					'action' : 'ajax_search',
					'term' : searchTerm
				},
				success : function(result) {
					$('.ajax-search').fadeIn();
					$('.ajax-search ul').html(result);
					$(document).click(function(){
						$(".ajax-search").hide();
					});
				}
			});
		}
	});
	

	/*****************************************************************/
	/* TIMELINE PAGE */
	/*****************************************************************/
	
	$('.in-view:nth-child(odd)').addClass('wow slideInRight');
	$('.in-view:nth-child(even)').addClass('wow slideInLeft');
	
	
	/*****************************************************************/
	/* FASTER YOUTUBE EMBED - LOADING AFTER CLICKING */
	/*****************************************************************/
	
	$(".youtube-video").each(function() {
		
        // Based on the YouTube ID, we can easily find the thumbnail image
        $(this).css('background-image', 'url(http://i.ytimg.com/vi/' + this.id + '/sddefault.jpg)');
    
        $(document).delegate('#'+this.id, 'click', function() {
			
            // Create an iFrame with autoplay set to true
            var iframe_url = "https://www.youtube.com/embed/" + this.id + "?autoplay=1&rel=0&showinfo=0&autohide=1";
    
            // The height and width of the iFrame should be the same as parent
            var iframe = $('<iframe/>', {'frameborder': '0', 'src': iframe_url, 'allowfullscreen': '' });
    
            // Replace the YouTube thumbnail with YouTube HTML5 Player
            $(this).replaceWith(iframe);
			
        });
		
    });
	
	
	/*****************************************************************/
	/* FASTER VIMEO EMBED - LOADING AFTER CLICKING */
	/*****************************************************************/
	
	$(".vimeo-video").each(function() {
		
		// get Vimeo Thumbnail from JSON
		var vimeoVideoUrl = 'https://player.vimeo.com/video/' + this.id;
		var match = /vimeo.*\/(\d+)/i.exec(vimeoVideoUrl);

		if (match) {
			var vimeoVideoID = match[1];
			var vimeoThumbnail;
			$.getJSON('http://www.vimeo.com/api/v2/video/' + vimeoVideoID + '.json?callback=?', { format: "json" }, function (data) {

				vimeoThumbnail = data[0].thumbnail_large;

				// Based on the Vimeo ID, we can easily find the thumbnail image
				$(".vimeo-video").css( 'background-image', 'url(' + vimeoThumbnail + ')' );

			});	
		}
    
        $(document).delegate('#'+this.id, 'click', function() {
			
            // Create an iFrame with autoplay set to true
            var iframe_url = "https://player.vimeo.com/video/" + this.id;
    
            // The height and width of the iFrame should be the same as parent
            var iframe = $('<iframe/>', {'frameborder': '0', 'src': iframe_url, 'allowfullscreen': '' });
    
            // Replace the Vimeo thumbnail with Vimeo HTML5 Player
            $(this).replaceWith(iframe);
			
        });
		
		
	});
	
	
	/*****************************************************************/
	/* FASTER SOUNDCLOUD EMBED - LOADING AFTER CLICKING */
	/*****************************************************************/
	
	$(".soundcloud-audio").each(function() {
    
        $(document).delegate('#'+this.id, 'click', function() {
			
            // Create an iFrame with autoplay set to true
            var iframe_url = "https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/" + this.id + "&amp;auto_play=false&amp;hide_related=true&amp;show_comments=false&amp;show_user=false&amp;show_reposts=false&amp;visual=true";
    
            // The height and width of the iFrame should be the same as parent
            var iframe = $('<iframe/>', {'frameborder': '0', 'src': iframe_url, 'allowfullscreen': '' });
    
            // Replace the Soundcloud thumbnail with Soundcloud HTML5 Player
            $(this).replaceWith(iframe);
			
        });
		
    });
	
	
	/*****************************************************************/
	/* FASTER SPOTIFY EMBED - LOADING AFTER CLICKING */
	/*****************************************************************/
	
	$(".spotify-audio").each(function() {
        
        var id_get = this.id; // get the id [example = album:1DFixLWuPkv3KT3TnV35m3]
        var id_cleared = id_get.replace(/:/g, "\\:"); // add backslashes before the colon, because Javascript can't match ids with ":"
        
        $(document).delegate('#' + id_cleared, 'click', function() {
            
            // URL Example: uri=spotify:[ ... ]
            // [ ... ] = track:5JunxkcjfCYcY7xJ29tLai (Track)
            // [ ... ] = user:erebore:playlist:788MOXyTfcUb1tdw4oC7KJ (User Playlist)
            // [ ... ] = album:1DFixLWuPkv3KT3TnV35m3 (Album)          
            
            var id_get_start = id_cleared.replace(/\\:/g, ":"); // clear the string and remove all backslashes
            
            // Create an iFrame with autoplay set to true
            var iframe_url = "https://open.spotify.com/embed?uri=spotify:" + id_get_start;
    
            // The height and width of the iFrame should be the same as parent
            var iframe = $('<iframe/>', {'frameborder': '0', 'src': iframe_url, 'allowfullscreen': 'true', 'allow': 'encrypted-media' });
                        
            // Replace the Soundcloud thumbnail with Soundcloud HTML5 Player
            $(this).replaceWith(iframe);
			
        });
		
    });
	
	
	/*****************************************************************/
	/* WOOCOMMERCE */
	/*****************************************************************/
	
	/* layout */
	
	$(document).ready(function() {
		
		// wrap the WooCommerce product images for archive pages
		$( '.woocommerce li.product img' ).wrap( '<div class="product-img">' );
		
		// change WooCommerce tab classes
		$( '.woocommerce .tabs' ).addClass( 'nav nav-tabs' );
		$( '.woocommerce .tabs' ).removeClass( 'tabs' );
		
	});
	
	/* make the WooCommerce product gallery OWL carousel friendly */
	
	$(window).on("load", function() {
		
		// remove li container around the product gallery images
		$( '.woocommerce-product-gallery .flex-control-nav img' ).unwrap();
		
	});
	
	$(document).ready(function() {
		
		// create the OWL carousel parent container for all images
		$( '.woocommerce-product-gallery .flex-control-nav' ).wrapInner( '<li class="owl-products owl-carousel">' );
	
	});
	
	/* account cart */
	
	$(document).ready(function() {		
			
		var woo_account_cart = $( '.woocommerce-account-cart' );
		var woo_cart_overlay = $( '.cart-overlay' );
		
		// show account cart after login error
		
		if( $( ".woocommerce-account-cart .woocommerce-error" ).length ) {
			woo_account_cart.toggle();
			woo_account_cart.toggleClass('isVisible');
			
			woo_cart_overlay.stop().animate( {opacity:"0.6"}, 200 );
			woo_cart_overlay.show();
			woo_cart_overlay.toggleClass('isSlideOut');
		}
		
		// show account cart on click
		
		$('.account-button').on('click touchstart', function(e) {
			e.preventDefault();
			
			if ( woo_account_cart.hasClass('isSlideOut') || woo_cart_overlay.hasClass('isSlideOut') ) {
				woo_cart_overlay.stop().animate( {opacity:"0"}, 200 );
				woo_cart_overlay.hide();						    					
			} else {
				
				woo_cart_overlay.stop().animate( {opacity:"0.6"}, 200 );
				woo_cart_overlay.show();
			}
			
			woo_account_cart.toggle();
			woo_account_cart.toggleClass('isVisible');
			woo_cart_overlay.toggleClass('isSlideOut');
			
			e.stopPropagation();
		});
		
		// prevent hiding the account cart with clicking on itself
		
		$(document).on('click touchstart', '.woocommerce-account-cart', function(e) {
			e.stopPropagation();
		});
		
		// hide account cart by clicking outside from itself
		
		$(document).on('click touchstart', function() {
			if ( woo_account_cart.hasClass('isVisible') ) {
				woo_account_cart.toggle();
				woo_account_cart.toggleClass('isVisible');	    					
			}
			if ( woo_cart_overlay.hasClass('isSlideOut') ) {
				woo_cart_overlay.stop().animate( {opacity:"0"}, 200 );
				woo_cart_overlay.hide();
				woo_cart_overlay.toggleClass('isSlideOut');	    					
			}
		});
		
	});	
	
	/* shopping cart slide out woocommerce sidebar widget */
	
	$(document).ready(function() {		
			
		var woo_cart = $( '.woocommerce-shopping-cart' );
		var woo_cart_overlay = $( '.cart-overlay' );
		var wpadminbar = $( '#wpadminbar' ).outerHeight();
				
		woo_cart.css({ top: wpadminbar });
			
		// show sidebar shopping cart on click
		
		$('.cart-button').on('click touchstart', function(e) {
			e.preventDefault();
			
			if ( woo_cart.hasClass('isSlideOut') || woo_cart_overlay.hasClass('isSlideOut') ) {
				woo_cart.stop().animate( {right:"-300px"}, 200 );
				woo_cart_overlay.stop().animate( {opacity:"0"}, 200 );
				woo_cart_overlay.hide();						    					
			} else {
				woo_cart.stop().animate( {right:"0px"}, 200 );
				woo_cart_overlay.stop().animate( {opacity:"0.6"}, 200 );
				woo_cart_overlay.show();
			}
			
			woo_cart.toggleClass('isSlideOut');
			woo_cart_overlay.toggleClass('isSlideOut');
			
			e.stopPropagation();
		});
		
		// prevent hiding the sidebar shopping cart with clicking on itself
		
		$(document).on('click touchstart', '.woocommerce-shopping-cart', function(e) {
			e.stopPropagation();
		});

		// hide sidebar shopping cart by clicking outside from itself
		
		$(document).on('click touchstart', function() {
			if ( woo_cart.hasClass('isSlideOut') ) {
				woo_cart.stop().animate( {right:"-300px"}, 200 );
				woo_cart.toggleClass('isSlideOut');	    					
			}
			if ( woo_cart_overlay.hasClass('isSlideOut') ) {
				woo_cart_overlay.stop().animate( {opacity:"0"}, 200 );
				woo_cart_overlay.hide();
				woo_cart_overlay.toggleClass('isSlideOut');	    					
			}
		});
        
        // hide sidebar shopping cart by clicking close button
        
        $('.woocommerce-shopping-cart-close').on('click touchstart', function() {
			if ( woo_cart.hasClass('isSlideOut') ) {
				woo_cart.stop().animate( {right:"-300px"}, 200 );
				woo_cart.toggleClass('isSlideOut');	    					
			}
			if ( woo_cart_overlay.hasClass('isSlideOut') ) {
				woo_cart_overlay.stop().animate( {opacity:"0"}, 200 );
				woo_cart_overlay.hide();
				woo_cart_overlay.toggleClass('isSlideOut');	    					
			}
		});
		
	});	
	
	/* remove product from WooCommerce shopping cart */

	$(document).on('click', '.woocommerce-shopping-cart a.remove-product', function(e) {

		e.preventDefault();
		e.stopPropagation();

		var prod_id = $(this).attr('data-product-id'),
			variation_id = $(this).attr('data-variation-id'),
			prod_quantity = $(this).attr('data-product-qty'),
			empty_bag_txt = $('.woocommerce-shopping-cart').attr('data-empty-bag-txt'),
			data_shop_url = $('.woocommerce-shopping-cart .product_list_widget').attr('data-shop-url'),
			data_shop_button = $('.woocommerce-shopping-cart .product_list_widget').attr('data-shop-button'),
			data = {action: 'tdl_cart_product_remove', product_id: prod_id, variation_id: variation_id},
			ajaxURL = $(this).attr('data-ajaxurl');

			$.post(ajaxURL, data, function(response) {

				var cartTotal = response;
				var currProductCount = 0;

				// get the currently product count

				currProductCount = parseInt($('.cart-contents-count:first').text()) - prod_quantity;

				// replace shopping cart areas

				$('.cart-contents .amount').replaceWith(cartTotal);
				$('.total .amount').replaceWith(cartTotal);
				$('.cart-contents-count').text(currProductCount);

				$('.cart-contents-count').each(function() {
					$(this).text(currProductCount);
				});

				if ( variation_id > 0 ) {
					$('.product-var-id-'+variation_id).remove();
				} else {
					$('.product-id-'+prod_id).remove();	
				}

				if ( currProductCount <= 0 ) {

					// show this area if the product count is null (empty cart)

					$('.woocommerce-shopping-cart .widget_shopping_cart_content').append('<ul class="cart_list product_list_widget"><li class="empty"><h3>' + empty_bag_txt + '</h3><p class="return-to-shop"><a class="button" href="' + data_shop_url + '"><i class="fa fa-chevron-left"></i> <span>' + data_shop_button + '</span></a></p></li></ul>');

					// remove this shopping cart areas

					$('.woocommerce-shopping-cart .widget_shopping_cart_content .total').remove();
					$('.woocommerce-shopping-cart .widget_shopping_cart_content .buttons').remove();

					// update cart count

					$('.cart-contents-count').text(currProductCount);

				} else {

					// get currently product count if the cart is not empty

					if ( currProductCount == 1 ) {
						$('.cart-contents-count').text('1');
					} else {
						$('.cart-contents-count').text(currProductCount);
					}

				}
				
				// update mini card content
				
				updateCartContent(response);
				
			});

		return false;

	});
	
	/* WooCommerce add a product to the shopping cart */
	
	$(document).on('click', '.single_add_to_cart_button, .add_to_cart_button', function() {
		
		if( $(this).hasClass('product_type_variable') ) return true;
		
		var form = $(this).closest('form');
		
		// show loading icon after clicking the add to cart button
		
		$("button").addClass("loading");
		
		$.ajax( {
			type: "POST",
			url: form.attr( 'action' ),
			data: form.serialize(),
			success: function( response ) {
				
				$("button").removeClass("loading");

				// slide out mini cart sidebar
				
				$( '.woocommerce-shopping-cart' ).stop().animate( {right:"0px"}, 200 );
				$( '.woocommerce-shopping-cart' ).toggleClass('isSlideOut');
				
				$( '.cart-overlay' ).stop().animate( {opacity:"0.6"}, 200 );
				$( '.cart-overlay' ).show();
				$( '.cart-overlay' ).toggleClass('isSlideOut');

				// update mini card content
				
				updateCartContent(response);
				
			}
			
		} );
		
		return false;
	});
	
	/* WooCommerce update shopping card content */
	
	function updateCartContent(new_source) {
		
		// remove WooCommerce error and message boxes
		
		$(new_source).find('.woocommerce-error').remove();
		$(new_source).find('.woocommerce-message').remove();
		
		var $fragment_refresh = {
			url: woocommerce_params.ajax_url,
			type: 'POST',
			data: { action: 'woocommerce_get_refreshed_fragments' },
			success: function( data ) {
				if ( data && data.fragments ) {
					
					$.each( data.fragments, function( key, value ) {
						$(key).replaceWith(value);
					});

					$('body').trigger( 'wc_fragments_refreshed' );
				}
			}
		};

		$.ajax($fragment_refresh);
	}				
	
})(jQuery);
