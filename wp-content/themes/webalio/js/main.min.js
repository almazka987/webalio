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

    if (window.screen.availWidth > 757) {
        setEqualHeight($(".three-columns .item"));
    }

    // prettyPhoto
    if($("a[rel^='prettyPhoto']").length > 0) {
        $("a[rel^='prettyPhoto']").prettyPhoto({
            animation_speed: 'fast',
            slideshow: 3000,
            opacity: 0.60,
            show_title: true,
            default_width: 500,
            autoplay_slideshow: false,
            default_height: 500,
            allow_resize: true,
            counter_separator_label: ' из ',
            theme: 'facebook',
            modal: false,
            social_tools: false,
            changepicturecallback: function () {
                let windowWidth = $(window).width(),
                    $pp_pic_holder = $('.pp_pic_holder');
                if (imgPreloader.width > windowWidth) {
                    $pp_pic_holder.find('.pp_expand').hide();
                }
            },
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

    // Sticky menu
    let barSpace = 0;
    if ($('body').hasClass('mobile')) {
        if ($('body').hasClass('admin-bar') && document.documentElement.offsetWidth > 600) {
            barSpace = $('#wpadminbar').height() - 1;
        }
    } else {
        if ($('body').hasClass('admin-bar') && document.documentElement.offsetWidth > 600) {
            barSpace = $('#wpadminbar').height() - 1;
        }
    }

    if ( $( '.navbar' ).size() > 0 ) {
        scrollIntervalID = setInterval( function() {
            let navbar = $('.navbar');
            let navHeight = navbar.height();
            let navbarFluid = $('.navbar-fluid');
            let orgElementTop = $( 'header .header-top' ).height() + navHeight + 100;
            let coordsOrgElement = navbar.offset();
            let leftOrgElement = coordsOrgElement.left;

            if ($(window).scrollTop() >= (orgElementTop)) {
                $('.navbar').addClass('sticky').css('margin-top', barSpace).css('left',leftOrgElement+'px').css('top', 0);
                navbarFluid.height(navHeight);
            } else {
                $('.navbar').removeClass('sticky').css('margin-top', '');
                navbarFluid.height(0);
            }
        }, 10 );
    }

    // Scrolling to anchor
    $('a[href*="#lnk_"]').bind("click", function(e) {
        let anchor = $(this);
        let id = anchor.attr('href').split('#');
        id = '#' + id[id.length - 1];
        let navHeight = $('.navbar').height() + 20;
        $('html, body').stop().animate({
            scrollTop: $(id).offset().top - navHeight - barSpace
         }, 1000);
        e.preventDefault();
    });

    jQuery(window).bind("load", function() {
        let hash =  jQuery(location).attr('hash');
        let navHeight = $('.navbar').height() + 20;
        if(hash != '') {
            jQuery('html, body').stop().animate({
                scrollTop: jQuery(hash).offset().top - navHeight - barSpace
            }, 1000);
        }
    });

    // Mobile Menu
    $('.hamburger').click(function() {
        $('#primary-navbar-collapse').stop().slideToggle().toggleClass('animated slideInTop');
        $(this).stop().toggleClass('is-active');
    });

    // Close mobile menu
    $(document).on("click", '.mobile .navbar #menu-primary li a', function() {
        $('.hamburger').click();
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

    // Scroll to Top Button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 0) {
            $('#alio_to_top a').fadeIn();
        } else {
            $('#alio_to_top a').fadeOut();
        }
    });
    $('#alio_to_top a').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
}); /* document ready end */
