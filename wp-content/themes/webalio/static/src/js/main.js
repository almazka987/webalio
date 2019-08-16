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
            var windowWidth = $(window).width(),
                $pp_pic_holder = $('.pp_pic_holder');
            if (imgPreloader.width > windowWidth) {
                $pp_pic_holder.find('.pp_expand').hide();
            }
        },
    });

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

    // Sticky menu and anchor scroll
    var $nav = $('.navbar'),
        barSpace = ($('body').hasClass('admin-bar') && document.documentElement.offsetWidth > 600) ? $('#wpadminbar').outerHeight() - 1 : 0,
        $navbarFluid = $('.navbar-fluid'),
        navStaticHeight = $nav.outerHeight();

    function stickyNav(){
        if ($(window).scrollTop() >= $('.header-top').outerHeight() + navStaticHeight + 150) {
            $nav.addClass('sticky');
            $navbarFluid.height(navStaticHeight + 20);
        } else {
            $nav.removeClass('sticky');
            $navbarFluid.height(0);
        }
    }

    stickyNav();

    // run it again every time you scroll
    $(window).scroll(function() {
        stickyNav();
    });

    // Scrolling to anchor
    jQuery(window).bind("load", function() {
        var hash =  jQuery(location).attr('hash');

        // Get the sticky navbar height, to do so, I need to clone it since it's invisible
        var $stickyFake = $nav.clone().addClass('sticky fake').appendTo($('body')).css({
            'position':'absolute',
            'top':-10000
        });

        $nav.data('hSticky', $stickyFake.outerHeight());
        $stickyFake.remove();

        if(hash != '') {
            jQuery('html, body').stop().animate({
                scrollTop: jQuery(hash).offset().top - $nav.data('hSticky') - 20 - barSpace
            }, 1000);
        }
    });

    $('a[href*="#lnk_"]').bind("click", function(e) {
        var anchor = $(this);
        var id = anchor.attr('href').split('#');
        id = '#' + id[id.length - 1];

        // if opened mobile menu
        var parentUl = $(this).parents('ul.alio-navbar'),
            parentNavbar = $(this).parents('.navbar'),
            scrollPlace;
        if (parentUl && parentNavbar && !$(parentNavbar[0]).is('.sticky') && document.documentElement.offsetWidth < 767) {
            scrollPlace = $(id).offset().top - $(parentNavbar[0]).outerHeight() - 20 - barSpace;
        } else {
            scrollPlace = $(id).offset().top - $nav.data('hSticky') - 20 - barSpace;
        }

        $('html, body').stop().animate({
            scrollTop: scrollPlace
         }, 1000);
        e.preventDefault();
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
        if ($(this).scrollTop() > 300) {
            $('#alio_to_top a').css('display', 'block').addClass('active');
        } else {
            $('#alio_to_top a').fadeOut("slow", function() {
                $(this).removeClass("active");
            });
        }
    });

    $('#alio_to_top a').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
}); /* document ready end */
