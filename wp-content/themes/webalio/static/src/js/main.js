jQuery(document).ready(function($){

    // Equal Height
    function setEqualHeight(columns) {
        var tallestcolumn = 0;
        columns.each(
            function() {
                currentHeight = $(this).height();
                if(currentHeight > tallestcolumn) {
                    tallestcolumn = currentHeight;
                }
            }
        );
        columns.height(tallestcolumn);
    }

    setEqualHeight($(".three-columns .item"));

    // prettyPhoto
    if($("a[rel^='prettyPhoto']").length > 0){
        $("a[rel^='prettyPhoto']").prettyPhoto({
        animation_speed: 'fast',
        autoplay_slideshow: true,
        slideshow: 3000,
        opacity: 0.60,
        show_title: true,
        default_width: 500,
        autoplay_slideshow: false,
        default_height: 500,
        counter_separator_label: ' из ',
        theme: 'facebook',
        modal: false,
        social_tools: false
    });
    }

    // filter image block
    if ( $('#isotope-list').size() > 0 ) {
        var $container = $('#isotope-list');
        setTimeout( function() {
            $container.isotope({
                itemSelector : '.item',
                layoutMode : 'masonry'
            });
        }, 500 );

        var $optionSets = $('#filters'),
        $optionLinks = $optionSets.find('a');

        $optionLinks.click(function(){
        var $this = $(this);
        // don't proceed if already selected
        if ( $this.hasClass('selected') ) {
          return false;
        }
        var $optionSet = $this.parents('#filters');
        $optionSets.find('.selected').removeClass('selected');
        $this.addClass('selected');

        //When an item is clicked, sort the items.
         var selector = $(this).attr('data-filter');
        $container.isotope({ filter: selector });

        return false;
        });
    }

    // anchor scrolling
    $('a[href*="#lnk_"]').bind("click", function(e) {
        e.preventDefault();
        let anchor = $(this);
        let id = anchor.attr('href').split('#');
        id = '#' + id[id.length - 1];
        $('html, body').stop().animate({
            scrollTop: $(id).offset().top - 120
         }, 1000);
    });

    jQuery(window).bind("load", function() {
        let hash =  jQuery(location).attr('hash');
        if(hash != '') {
            jQuery('html, body').stop().animate({
                scrollTop: jQuery(hash).offset().top - 120
            }, 1000);
        }
    });

    // Menu
    $('.hmbrgr').hmbrgr({
        width     : 30,
        height    : 20,
        barHeight : 4
    });

    $('.hmbrgr').click(function(event) {
        $('#primary-navbar-collapse').stop().slideToggle().toggleClass('animated slideInTop');
    });

    // Nav hover
    $('.alio-navbar .dropdown').hover(function() {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(250).fadeIn();
    }, function() {
        $(this).find('.dropdown-menu').first().stop(true, true).delay(100).fadeOut();
    });

    $('.alio-navbar .dropdown > a').click(function(){
        location.href = this.href;
    });

    // Sticky menu
    var barSpace = 0;
    if ( $( 'body' ).hasClass( 'mobile' ) ) {
        if ( $( 'body' ).hasClass( 'admin-bar' ) && document.documentElement.offsetWidth > 600 ) {
            barSpace = $( '#wpadminbar' ).height() - 1;
        }
    } else {
        if ( $( 'body' ).hasClass( 'admin-bar' ) && document.documentElement.offsetWidth > 600 ) {
            barSpace = $( '#wpadminbar' ).height() - 1;
        }
    }

    if ( $( '.navbar' ).size() > 0 ) {
        scrollIntervalID = setInterval( function() {
            var orgElementTop = $( 'header .top' ).height();

            if ( $( window ).scrollTop() >= ( orgElementTop ) ) {
                orgElement = $('.navbar');
                coordsOrgElement = orgElement.offset();
                leftOrgElement = coordsOrgElement.left;
                //widthOrgElement = orgElement.css('width');
                $( '.navbar' ).addClass('sticky').css('margin-top',barSpace).css('left',leftOrgElement+'px').css('top',0);//.css('width',widthOrgElement);
            } else {
                $('.navbar').removeClass('sticky').css('margin-top','');
            }
        }, 10 );
    }

    // Scroll to Top Button
    var scroll_timer;
    var displayed = false;
    var top = jQuery( document.body ).children(0).position().top;
    jQuery( window ).scroll(function () {
        window.clearTimeout( scroll_timer );
        scroll_timer = window.setTimeout( function () {
            if( jQuery( window ).scrollTop() <= top ) {
                displayed = false;
                jQuery( '#alio_to_top a' ).fadeOut(500);
            }
            else if(displayed == false) {
                displayed = true;
                jQuery( '#alio_to_top a' ).stop( true, true ).show().click( function () { jQuery( '#alio_to_top a' ).fadeOut( 500 ); } );
            }
        }, 100);
    });
    jQuery('#alio_to_top a').click(function(){
        jQuery('html, body').animate({scrollTop:0}, 'slow');
    });
}); /* document ready end */
