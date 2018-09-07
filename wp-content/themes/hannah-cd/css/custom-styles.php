<?php

	// SITE BACKGROUND
	// ************************************************************************

	$site_background = ACF_GF('site_background', 'option');
	$site_background_size = ACF_GF('site_background_size', 'option');
	$site_background_repeat = ACF_GF('site_background_repeat', 'option');
	$site_background_pos_x = ACF_GF('site_background_pos_x', 'option');
	$site_background_pos_y = ACF_GF('site_background_pos_y', 'option');

	if( $site_background_size == 'normal' ) {
		$bg_size = false;
	} else { 
		$bg_size = $site_background_size;
	}

	if( $site_background_repeat ) {
		$bg_repeat = $site_background_repeat;
	} else { 
		$bg_repeat = 'no-repeat';
	}

	if( $site_background ) { 
		
		echo 'body { ';
		
			echo 'background-image: url(' . esc_url( $site_background ) . '); ';

			if( $bg_size ) { 
				echo 'background-size: ' . esc_html( $bg_size ) . '; ';
			}

			echo 'background-repeat: ' . esc_html( $bg_repeat ) . '; ';

			echo 'background-position: ' . esc_html( $site_background_pos_x ) . ' ' . esc_html( $site_background_pos_y ) . '; ';
		
		echo '} ';
		
		// background-attachment: fixed 
	}

	// MAIN FONT
	// ************************************************************************ 

	$main_font = ACF_GF('main_google_font_name', 'option'); 
	$font_weight = ACF_GF('main_google_font_weight', 'option'); 

	// if no font selected by acf settings
	if ( ! $main_font && ! $font_weight ) {
		echo 'body {font-family:"Lato", sans-serif; }';
	// if selected
	} else {
		if( $main_font && ! $font_weight ) :
		
			echo 'body {font-family:"' . str_replace( '+', ' ', esc_html( $main_font ) ) . '", sans-serif}';
		
		elseif( ! $main_font && $font_weight ) :
		
			echo 'body {font-weight:' . esc_html( $font_weight ) . '}';
		
		elseif( $main_font && $font_weight ) :
		
			echo 'body {font-family:"' . str_replace( '+', ' ', esc_html( $main_font ) ) . '", sans-serif; font-weight:' . esc_html( $font_weight ) . '}';
		
		endif;
	}

	// MENU FONT 
	// ************************************************************************

	$menu_font = ACF_GF('menu_google_font_name', 'option'); 
	$menu_font_weight = ACF_GF('menu_google_font_weight', 'option'); 

	if( $menu_font && ! $menu_font_weight ) :
		
		echo '.navbar {font-family:"' . str_replace( '+', ' ', esc_html( $menu_font ) ) . '", sans-serif}';

	elseif( ! $menu_font && $menu_font_weight ) :

		echo '.navbar {font-weight:' . esc_html( $menu_font_weight ) . '}';

	elseif( $menu_font && $menu_font_weight ) :

		echo '.navbar {font-family:"' . str_replace( '+', ' ', esc_html( $menu_font ) ) . '", sans-serif; font-weight:' . esc_html( $menu_font_weight ) . '}';

	endif;
	
	// H1 FONT 
	// ************************************************************************

	$main_h1_font = ACF_GF('main_google_font_h1_name', 'option');
	$main_h1_weight = ACF_GF('main_google_font_h1_weight', 'option');

	if( $main_h1_font && ! $main_h1_weight ) :

		echo 'h1 {font-family:"' . str_replace( '+', ' ', esc_html( $main_h1_font ) ) . '", sans-serif}';

	elseif( ! $main_h1_font && $main_h1_weight ) :

		echo 'h1 {font-weight:' . esc_html( $main_h1_font ) . '}';

	elseif( $main_h1_font && $main_h1_weight ) :

		echo 'h1 {font-family:"' . str_replace( '+', ' ', esc_html( $main_h1_font ) ) . '", sans-serif; font-weight:' . esc_html( $main_h1_weight ) . '}';

	endif;

	// H2 FONT 
	// ************************************************************************

	$main_h2_font = ACF_GF('main_google_font_h2_name', 'option');
	$main_h2_weight = ACF_GF('main_google_font_h2_weight', 'option');

	if( $main_h2_font && ! $main_h2_weight ) :

		echo 'h2 {font-family:"' . str_replace( '+', ' ', esc_html( $main_h2_font ) ) . '", sans-serif}';

	elseif( ! $main_h2_font && $main_h2_weight ) :

		echo 'h2 {font-weight:' . esc_html( $main_h2_font ) . '}';

	elseif( $main_h2_font && $main_h2_weight ) :

		echo 'h2 {font-family:"' . str_replace( '+', ' ', esc_html( $main_h2_font ) ) . '", sans-serif; font-weight:' . esc_html( $main_h2_weight ) . '}';

	endif;

	// H3 FONT 
	// ************************************************************************

	$main_h3_font = ACF_GF('main_google_font_h3_name', 'option');
	$main_h3_weight = ACF_GF('main_google_font_h3_weight', 'option');

	if( $main_h3_font && ! $main_h3_weight ) :

		echo 'h3 {font-family:"' . str_replace( '+', ' ', esc_html( $main_h3_font ) ) . '", sans-serif}';

	elseif( ! $main_h3_font && $main_h3_weight ) :

		echo 'h3 {font-weight:' . esc_html( $main_h3_font ) . '}';

	elseif( $main_h3_font && $main_h3_weight ) :

		echo 'h3 {font-family:"' . str_replace( '+', ' ', esc_html( $main_h3_font ) ) . '", sans-serif; font-weight:' . esc_html( $main_h3_weight ) . '}';

	endif;

	// H4 FONT 
	// ************************************************************************

	$main_h4_font = ACF_GF('main_google_font_h4_name', 'option');
	$main_h4_weight = ACF_GF('main_google_font_h4_weight', 'option');

	if( $main_h4_font && ! $main_h4_weight ) :

		echo 'h4 {font-family:"' . str_replace( '+', ' ', esc_html( $main_h4_font ) ) . '", sans-serif}';

	elseif( ! $main_h4_font && $main_h4_weight ) :

		echo 'h4 {font-weight:' . esc_html( $main_h4_font ) . '}';

	elseif( $main_h4_font && $main_h4_weight ) :

		echo 'h4 {font-family:"' . str_replace( '+', ' ', esc_html( $main_h4_font ) ) . '", sans-serif; font-weight:' . esc_html( $main_h4_weight ) . '}';

	endif;

	// MAIN COLOR 
	// ************************************************************************

	$main_color = ACF_GF('main_color', 'option');
	
	if($main_color) { ?>

		.fa, 
		.btn:hover, 
		.btn:focus, 
		.btn:active, 
		input[type=submit]:hover, 
		input[type=submit]:focus, 
		input[type=submit]:active,
		.content .page h2, 
		.content .post h2, 
		.archive-header h1,
		.socialbar a:hover, 
		.video-lightbox:hover .fa, 
		.author-title,
		.post-format-link a:hover .fa,
		.single-post-navigation .fa,
		.seminar-user .instructor,
		.archive-header h1,
		.archive-header h2,
		blockquote,
		.logo-title,
		.content .post h1, .content .page h1,
		.content .post .page-header h2, .content .page .page-header h2 { color:<?php echo esc_html( $main_color ); ?> }

		.custom-pagination a:hover, 
		.custom-pagination span.current,
		ul.glossary-index li a:hover,
		ul.sitemap-index li a:hover,
		.social-postbar a:hover,
		.comment-reply-link:hover,
		.read-more a:hover, 
		.custom-post-teaser-box-bg, 
		.post-list-teaser-box-bg,
		.top-search-form input[type=submit]:hover,
        .owl-dot.active span, .owl-dot:hover span { background-color:<?php echo esc_html( $main_color ); ?> }

		a.button, 
		.btn, 
		input[type=submit],
		.owl-controls .owl-page.active span, 
		.owl-controls .owl-page:hover span, 
		.logo-overlay, 
		.content section.banner, 
		ul.download-list .list-separator, 
		.features-3 .fa-stack,
		.post-format-link .fa,
		.post-format-quote .fa,
		.toggle-menu a .fa,
		.top-layer,
        .social-profile-sidebar .social-profile-sidebar-icon,
        .social-widget a,
        ul.download-list li.list-separator,
        .timeline ul.timeline-ul li.timeline-li.in-view::after,
        .pin-button,
        .metro-grid .grid-item:not(.grid-item--width2):not(.grid-item--height2) .has-image .post-content,
        .metro-grid .grid-item.grid-item--height2 .has-image .post-content { background:<?php echo esc_html( $main_color ); ?> }

		a.button, .btn, input[type=submit], 
		.mc4wp-form input[type=email], 
		.search-form input[type=search], 
		input[type=submit]:hover, 
		input[type=submit]:focus, 
		input[type=submit]:active, 
		.navbar-nav li li:after,
		.nav-white.affix .navbar-nav li:after,
		.comment-reply-link:hover,
		abbr, acronym,
		.bypostauthor { border-color:<?php echo esc_html( $main_color ); ?> }

		@media (min-width: 1460px) {

		.single-post-navigation a { background:<?php echo esc_html( $main_color ); ?> }

		}

<?php } 

	// MAIN COLOR SECOND
	// ************************************************************************

	$main_color_second = ACF_GF('main_color_second', 'option');
	
	if($main_color_second) { ?>

		.blockquote, q, h3,
		.contact-user .person { color:<?php echo esc_html( $main_color_second ); ?> }

		.letter, 
		.single-post-navigation .thumb,
		.header,
		.leading-area-content,
		.posts-carousel-widget a.posts-carousel-link,        
		.price-content.leading .the-price,
        .cart-contents-count,
        .woocommerce.widget_shopping_cart .cart_list li a.remove { background-color:<?php echo esc_html( $main_color_second ); ?> }

		mark,
		.read-more a,
		.dropcap { background:<?php echo esc_html( $main_color_second ); ?> }

		.dl dt:before,
		.ribbon:after,
		.divider.solid,
		.divider.solid.with-content,
		.divider.dotted,
		.divider.dotted.with-content,
		.divider.dashed,
		.divider.dashed.with-content,
		.divider.double,
		.divider.double.with-content,
		.navbar-nav li:after,
		.navbar-nav li li:after,
        .full-page .affix-top .navbar-nav li li:after { border-color:<?php echo esc_html( $main_color_second ); ?> }

<?php }

	// LINK COLOR 
	// ************************************************************************

	$link_color = ACF_GF('link_color', 'option'); 

	if($link_color) { ?>

		a, 
		a:hover, 
		a:focus, 
		.recent-comments-widget a,
		.posts-alternative-widget a,
		.category-widget a,
		.posts-widget a,
		.blog-post-meta a { color:<?php echo esc_html( $link_color ); ?> }
  
<?php } 

	// H1 COLOR
	// ************************************************************************ 
	
	$h1_color = ACF_GF('h1_color', 'option'); 
	
	if($h1_color) { ?>

		section h1, a h1 { color:<?php echo esc_html( $h1_color ); ?>!important }
  
<?php } 

	// H2 COLOR
	// ************************************************************************ 
	
	$h2_color = ACF_GF('h2_color', 'option'); 
	
	if($h2_color) { ?>

		section h2, a h2, .archive-header h1, .archive-header h2 { color:<?php echo esc_html( $h2_color ); ?>!important }
  
<?php } 

	// LIKE BUTTON COLOR 
	// ************************************************************************

	$like_button_color = ACF_GF('like_button_color', 'option'); 
	
	if($like_button_color) { ?>

		.like-btn .fa { color:<?php echo esc_html( $like_button_color ); ?> }
  
<?php } 

	// RATING STARS COLOR 
	// ************************************************************************

	$rating_stars_color = ACF_GF('rating_stars_color', 'option'); 
	
	if($rating_stars_color) { ?>

		.post-rating-stars.has-votes .fa,
		.post-rating-stars-wrapper a:hover .fa,
		.post-rating-stars-wrapper:hover .fa, 
		.post-rating-stars-wrapper.is-voted .fa { color:<?php echo esc_html( $rating_stars_color ); ?> }
  
<?php } 

	// PRICE / SALE COLOR 
	// ************************************************************************

	$sale_color = ACF_GF('sale_color', 'option'); 
	
	if($sale_color) { ?>

        .woocommerce ul.products li.product .onsale, 
        .woocommerce span.onsale, span.onsale,
        .woocommerce div.product form.cart .button,
        .woocommerce.widget_shopping_cart .buttons a.checkout,
        .woocommerce-cart .cart-collaterals .cart_totals .button,
        #payment #place_order { background:<?php echo esc_html( $sale_color ); ?> }

		.woocommerce ul.products li.product .price, 
        .woo-price,
        .woocommerce div.product p.price, 
        .woocommerce div.product span.price { color:<?php echo esc_html( $sale_color ); ?> }

<?php } 

	// CUSTOM MASONRY COLUMNS 
	// ************************************************************************

	$mry_custom_2 = ACF_GF('masonry_custom_column', 'option') == 'masonry_colnum_2';
	$mry_custom_4 = ACF_GF('masonry_custom_column', 'option') == 'masonry_colnum_4';
	$masonry_double_width = ACF_GF('masonry_double_width', 'option');
	
	$grid_global = ACF_GF('layout_show', 'option') == 'grid';

?>

@media (min-width: 768px) {

	<?php if( $mry_custom_2 ) : ?>
		/* masonry */
		#masonry-layout .grid .grid-sizer, 
        #masonry-layout .grid .grid-item {width:100%}
		#masonry-layout .grid .gutter-sizer {width:0%}
		
		/* grid */
		#masonry-layout .grid.post-grid .grid-sizer, 
        #masonry-layout .grid.post-grid .grid-item {width:100%}
		#masonry-layout .grid.post-grid .grid-item {border-right:0px}
	<?php elseif( $mry_custom_4 ) : ?>
		/* masonry */
		#masonry-layout .grid .grid-sizer, 
        #masonry-layout .grid .grid-item {width:100%}
		#masonry-layout .grid .gutter-sizer {width:0%}
		
		/* grid */
		#masonry-layout .grid.post-grid .grid-sizer, 
        #masonry-layout .grid.post-grid .grid-item {width:100%}
		#masonry-layout .grid.post-grid .grid-item {border-right:0px}
	<?php else : // default value is 3 columns 'masonry_colnum_3' ?>
		/* masonry */
		#masonry-layout .grid .grid-sizer, 
        #masonry-layout .grid .grid-item {width:100%}
		#masonry-layout .grid .gutter-sizer {width:0%}
		
		/* grid */
		#masonry-layout .grid.post-grid .grid-sizer, 
        #masonry-layout .grid.post-grid .grid-item {width:100%}
		#masonry-layout .grid.post-grid .grid-item {border-right:0px}
	<?php endif; ?>

}

@media (min-width: 992px){

	<?php if( $mry_custom_2 ) : ?>
		/* masonry */
		#masonry-layout .grid .grid-sizer, 
        #masonry-layout .grid .grid-item {width:47.5%}
		#masonry-layout .grid .gutter-sizer {width:5%}
		
		/* grid */
		#masonry-layout .grid.post-grid .grid-sizer, 
        #masonry-layout .grid.post-grid .grid-item {width:50%}
		#masonry-layout .grid.post-grid .grid-item:nth-child(2n-1) {border-right:1px solid #eee}
		#masonry-layout .grid.post-grid .grid-item:nth-last-of-type(1), 
		#masonry-layout .grid.post-grid .grid-item:nth-last-of-type(2) {border-bottom:0px}
	<?php elseif( $mry_custom_4 ) : ?>
		/* masonry */
		#masonry-layout .grid .grid-sizer, 
        #masonry-layout .grid .grid-item {width:30%}
		#masonry-layout .grid .gutter-sizer {width:5%}
		
		<?php if( $masonry_double_width && ! $grid_global ) : ?>
            #masonry-layout .grid-item--width2 {width:65%!important}
            #masonry-layout .has-sidebar .grid-item--width2 {width:47.5%!important}
        <?php endif; ?>
		
        /* masonry -> allow only 2 columns with sidebar */
        #masonry-layout .has-sidebar .grid .grid-sizer, 
        #masonry-layout .has-sidebar .grid .grid-item {width:47.5%}
        #masonry-layout .has-sidebar .grid .gutter-sizer {width:5%}

		/* grid */
		#masonry-layout .grid.post-grid .grid-sizer, 
        #masonry-layout .grid.post-grid .grid-item {width:33.33333%}
		#masonry-layout .grid.post-grid .grid-item:nth-child(3n-2), 
		#masonry-layout .grid.post-grid .grid-item:nth-child(3n-1) {border-right:1px solid #eee}
		#masonry-layout .grid.post-grid .grid-item:nth-last-of-type(1), 
		#masonry-layout .grid.post-grid .grid-item:nth-last-of-type(2), 
		#masonry-layout .grid.post-grid .grid-item:nth-last-of-type(3) {border-bottom:0px}
	<?php else : // default value is 3 columns 'masonry_colnum_3' ?>
		/* masonry */
		#masonry-layout .grid .grid-sizer, 
        #masonry-layout .grid .grid-item {width:30%}
		#masonry-layout .grid .gutter-sizer {width:5%}
		
        /* masonry -> allow only 2 columns with sidebar */
        #masonry-layout .has-sidebar .grid .grid-sizer, 
        #masonry-layout .has-sidebar .grid .grid-item {width:47.5%}
        #masonry-layout .has-sidebar .grid .gutter-sizer {width:5%}

		<?php if( $masonry_double_width && ! $grid_global ) : ?>
            #masonry-layout .grid-item--width2 {width:65%!important}
            #masonry-layout .has-sidebar .grid-item--width2 {width:47.5%!important}
        <?php endif; ?>
		
		/* grid */
		#masonry-layout .grid.post-grid .grid-sizer, 
        #masonry-layout .grid.post-grid .grid-item {width:33.33333%}
		#masonry-layout .grid.post-grid .grid-item:nth-child(3n-2), 
		#masonry-layout .grid.post-grid .grid-item:nth-child(3n-1) {border-right:1px solid #eee}
		#masonry-layout .grid.post-grid .grid-item:nth-last-of-type(1), 
		#masonry-layout .grid.post-grid .grid-item:nth-last-of-type(2), 
		#masonry-layout .grid.post-grid .grid-item:nth-last-of-type(3) {border-bottom:0px}
	<?php endif; ?>

}

@media (min-width: 1200px){

	<?php if( $mry_custom_4 ) : ?>
		/* masonry */
		#masonry-layout .grid .grid-sizer, 
        #masonry-layout .grid .grid-item {width:23%}
		#masonry-layout .grid .gutter-sizer {width:2.6666%}
		
		<?php if( $masonry_double_width && ! $grid_global ) : ?>
            #masonry-layout .grid-item--width2 {width:48%!important}
            #masonry-layout .has-sidebar .grid-item--width2 {width:48%!important}
        <?php endif; ?>
		
		/* grid */
		#masonry-layout .grid.post-grid .grid-sizer, 
        #masonry-layout .grid.post-grid .grid-item {width:25%}
		#masonry-layout .grid.post-grid .grid-item:nth-child(4n-1),
		#masonry-layout .grid.post-grid .grid-item:nth-child(4n-2),
		#masonry-layout .grid.post-grid .grid-item:nth-child(4n-3) {border-right:1px solid #eee}
		#masonry-layout .grid.post-grid .grid-item:nth-child(4n) {border-right:0px}
		#masonry-layout .grid.post-grid .grid-item:nth-last-of-type(1), 
		#masonry-layout .grid.post-grid .grid-item:nth-last-of-type(2), 
		#masonry-layout .grid.post-grid .grid-item:nth-last-of-type(3), 
		#masonry-layout .grid.post-grid .grid-item:nth-last-of-type(4) {border-bottom:0px}
	<?php endif; ?>

}
		
<?php 

	// STRETCHING FOR THUMBNAIL LOWER WIDTH
	// ************************************************************************

	$thumb_stretching = ACF_GF('thumb_stretching', 'option'); 

	if( $thumb_stretching ) { ?>

		.post-thumbnail img { width: 100%; height: auto }
  
<?php } ?>

<?php 

	// DISABLE STICKY MENU
	// ************************************************************************

	$sticky_menu = ACF_GF('sticky_menu', 'option'); 

	if( $sticky_menu ) { ?>

		.navbar.affix { position: static!important }
  
<?php } ?>
