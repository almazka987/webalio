function getScrollBarWidth(){var a=jQuery("<div>").css({visibility:"hidden",width:100,overflow:"scroll"}).appendTo("body"),b=jQuery("<div>").css({width:"100%"}).appendTo(a).outerWidth();return a.remove(),100-b}jQuery(window).load(function(){var a=parseFloat(getScrollBarWidth());jQuery(".fusion-modal").each(function(){jQuery("body").append(jQuery(this))}),jQuery(".fusion-modal").bind("hidden.bs.modal",function(){jQuery("html").css("overflow",""),0!==a&&(jQuery("body").hasClass("layout-boxed-mode")&&jQuery('#sliders-container .main-flex[data-parallax="1"]').css("margin-left",function(b,c){return parseFloat(c)+a/2+"px"}),jQuery('body, .fusion-is-sticky .fusion-header, .fusion-is-sticky .fusion-secondary-main-menu, #sliders-container .main-flex[data-parallax="1"], #wpadminbar, .fusion-footer.fusion-footer-parallax').css("padding-right",""))}),jQuery(".fusion-modal").bind("show.bs.modal",function(){var b,c='body, .fusion-is-sticky .fusion-header, .fusion-is-sticky .fusion-secondary-main-menu, #sliders-container .main-flex[data-parallax="1"], #wpadminbar, .fusion-footer.fusion-footer-parallax';jQuery("html").css("overflow","visible"),0!==a&&(jQuery("body").hasClass("layout-boxed-mode")&&(c="body, #wpadminbar",jQuery('#sliders-container .main-flex[data-parallax="1"]').css("margin-left",function(b,c){return parseFloat(c)-a/2+"px"})),jQuery(c).css("padding-right",function(b,c){return parseFloat(c)+a+"px"})),b=jQuery(this),setTimeout(function(){b.find(".fusion-youtube").find("iframe").each(function(a){var b;1!==jQuery(this).parents(".fusion-video").data("autoplay")&&"true"!==jQuery(this).parents(".fusion-video").data("autoplay")||(jQuery(this).parents(".fusion-video").data("autoplay","false"),b="playVideo",this.contentWindow.postMessage('{"event":"command","func":"'+b+'","args":""}',"*"))}),b.find(".fusion-vimeo").find("iframe").each(function(a){1!==jQuery(this).parents(".fusion-video").data("autoplay")&&"true"!==jQuery(this).parents(".fusion-video").data("autoplay")||(jQuery(this).parents(".fusion-video").data("autoplay","false"),$f(jQuery(this)[0]).api("play"))}),b.find(".flexslider, .rev_slider_wrapper, .ls-container").length&&jQuery(window).trigger("resize"),"function"==typeof fusionCalcFlipBoxesHeight&&b.find(".flip-box-inner-wrapper").each(function(){jQuery(this).fusionCalcFlipBoxesHeight()}),b.find(".fusion-carousel").length&&"function"==typeof generateCarousel&&generateCarousel(),b.find(".fusion-blog-shortcode").each(function(){var a,b=2;for(i=1;i<7;i++)jQuery(this).find(".fusion-blog-layout-grid").hasClass("fusion-blog-layout-grid-"+i)&&(b=i);a=Math.floor(100/b*100)/100+"%",jQuery(this).find(".fusion-blog-layout-grid").find(".fusion-post-grid").css("width",a),jQuery(this).find(".fusion-blog-layout-grid").isotope(),"function"==typeof calcSelectArrowDimensions&&calcSelectArrowDimensions()}),"function"==typeof reinitializeGoogleMap&&b.find(".shortcode-map").each(function(){jQuery(this).reinitializeGoogleMap()}),b.find(".fusion-portfolio").each(function(){jQuery(this).find(".fusion-portfolio-wrapper").isotope()}),b.find(".fusion-testimonials .reviews").each(function(){jQuery(this).css("height",jQuery(this).children(".active-testimonial").height())}),"function"==typeof calcSelectArrowDimensions&&calcSelectArrowDimensions()},350)}),1==jQuery("#sliders-container .tfs-slider").data("parallax")&&jQuery(".fusion-modal").css("top",jQuery(".header-wrapper").height()),jQuery(".fusion-modal").each(function(){jQuery(this).on("hide.bs.modal",function(){jQuery(this).find("iframe").each(function(a){this.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}',"*")}),jQuery(this).find(".fusion-vimeo iframe").each(function(a){$f(this).api("pause")})})}),jQuery("[data-toggle=modal]").on("click",function(a){a.preventDefault()}),jQuery(".fusion-modal-text-link").click(function(a){a.preventDefault()})});