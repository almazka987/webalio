<?php

define( 'HANNAH_CD_VER', '1.6' ); // update style.css theme version number manually
define( 'HANNAH_CD_THEME', 'Hannah by Creative-Dive' );
define( 'HANNAH_CD_THEME_ACTIVE', wp_get_theme() );
define( 'HANNAH_CD_THEME_WP', $wp_version );
define( 'HANNAH_CD_THEME_PHP', PHP_VERSION );
define( 'HANNAH_CD_THEME_DIR', get_stylesheet_directory() );
define( 'HANNAH_CD_THEME_DIR_URI', get_stylesheet_directory_uri() );
define( 'HANNAH_CD_TEMP_DIR', get_template_directory() );
define( 'HANNAH_CD_TEMP_DIR_URI', get_template_directory_uri() );
define( 'HANNAH_CD_MAIN_THEME', true );

/*****************************************************************/
/* SETUP THEME DEFAULTS */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_theme_setup' ) ) :

	function hannah_cd_theme_setup() {
		
		// make theme available for translation
		load_theme_textdomain( 'hannah-cd', get_template_directory() . '/languages' );
		
		// add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );
		
		// let WordPress manage the document title
		add_theme_support( 'title-tag' );
	
		// enable support for post thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 825, 510, true );
		add_image_size( 'hannah_cd_thumb_min', 100, 100, true );
		add_image_size( 'hannah_cd_thumb_wide', 360, 200, true );
		add_image_size( 'hannah_cd_visual_thumb', 510, 350, true );
		add_image_size( 'hannah_cd_grid', 450, 300, true );
	
		// switch default core markup for search form, comment form, and comments to output valid HTML5
		add_theme_support( 'html5', array(
			'search-form', 
			'comment-form', 
			'comment-list', 
			'gallery', 
			'caption'
		));
	
		// enable support for post formats
		add_theme_support( 'post-formats', array(
			'image', 
			'video', 
			'quote', 
			'link', 
			'gallery', 
			'audio'
		));
		
		// remove paragraphs from archive description
		remove_filter( 'term_description', 'wpautop' );
		
		// theme support for WooCommerce
		add_theme_support( 'woocommerce' );
		
		// product gallery support for WooCommerce
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

        // allow shortcodes in text / html widgets
        add_filter('widget_text', 'do_shortcode');
        
	}

endif; 

add_action( 'after_setup_theme', 'hannah_cd_theme_setup' );


/*****************************************************************/
/* THEME CONTENT WIDTH */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_content_width' ) ) :

	function hannah_cd_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'hannah_cd_content_width', 1200 );
	}

endif; 

add_action( 'after_setup_theme', 'hannah_cd_content_width', 0 );


/*****************************************************************/
/* ACTIVATION OF REQUIRED PLUGINS */
/*****************************************************************/

include_once( get_template_directory() . '/inc/acf.php' );
include_once( get_template_directory() . '/inc/plugins/activate-plugins.php' );
include_once( get_template_directory() . '/inc/plugins/update.php' );


/*****************************************************************/
/* INCLUDE WIDGETS */
/*****************************************************************/

include_once( get_template_directory() . '/inc/widgets/instagram.php' );
include_once( get_template_directory() . '/inc/widgets/pinterest.php' );
include_once( get_template_directory() . '/inc/widgets/pinterest-board.php' );
include_once( get_template_directory() . '/inc/widgets/facebook.php' );
include_once( get_template_directory() . '/inc/widgets/twitter.php' );
include_once( get_template_directory() . '/inc/widgets/google-plus.php' );
include_once( get_template_directory() . '/inc/widgets/social-counter.php' );
include_once( get_template_directory() . '/inc/widgets/author.php' );
include_once( get_template_directory() . '/inc/widgets/newsletter.php' );
include_once( get_template_directory() . '/inc/widgets/posts.php' );
include_once( get_template_directory() . '/inc/widgets/posts-alternative.php' );
include_once( get_template_directory() . '/inc/widgets/posts-trending.php' );
include_once( get_template_directory() . '/inc/widgets/posts-carousel.php' );
include_once( get_template_directory() . '/inc/widgets/pages.php' );
include_once( get_template_directory() . '/inc/widgets/social.php' );
include_once( get_template_directory() . '/inc/widgets/comments.php' );
include_once( get_template_directory() . '/inc/widgets/categories.php' );
include_once( get_template_directory() . '/inc/widgets/banner.php' );


/*****************************************************************/
/* INCLUDE FUNCTIONS */
/*****************************************************************/

include_once( get_template_directory() . '/inc/rating.php' );
include_once( get_template_directory() . '/inc/like-button.php' );
include_once( get_template_directory() . '/inc/shortcodes.php' );
include_once( get_template_directory() . '/inc/admin-settings.php' );


/*****************************************************************/
/* ADD BODY CLASSES */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_body_class' ) ) :

	function hannah_cd_body_class( $classes ) {

		global $hannah_cd_header_full, $hannah_cd_header_wide;

		// page is an attachment
		if( is_attachment() || is_singular() && has_post_format('image') ) { 
			$classes[] = 'attachment-page';
		}
		
		$masonry_global = ACF_GF('layout_show', 'option') == 'masonry';
		$grid_global = ACF_GF('layout_show', 'option') == 'grid';
		$metro_global = ACF_GF('layout_show', 'option') == 'metro';
		$masonry_filter = ACF_GF('filter_layout_show') == 'masonry';
		$grid_filter = ACF_GF('filter_layout_show') == 'grid';
		$metro_filter = ACF_GF('filter_layout_show') == 'metro';
		
		$other_layout = ACF_GF('filter_layout_show') == 'normal' || ACF_GF('filter_layout_show') == 'book_left' || ACF_GF('filter_layout_show') == 'book_right' || ACF_GF('filter_layout_show') == 'visual_left' || ACF_GF('filter_layout_show') == 'visual_right' || ACF_GF('filter_layout_show') == 'magazine';
		$special_layout = $masonry_filter || $grid_filter || $metro_filter || $masonry_global || $grid_global || $metro_global;
		
		// page has masonry layout
		if( is_page_template( 'page-filter.php' ) && $special_layout && ! $other_layout || is_archive() && $special_layout && ! $other_layout || is_front_page() && $special_layout && ! $other_layout || is_home() && $special_layout && ! $other_layout ) { 
			$classes[] = 'masonry';
		}
		
		// page is landingpage
		if( is_page_template( 'landingpage.php' ) ) { 
			$classes[] = 'scrollspy';
		}
		
		// page has full page header
		if( $hannah_cd_header_full || is_404() ) { 
			$classes[] = 'full-page';
		}
		
		// page has wide page header
		if( $hannah_cd_header_wide ) { 
			$classes[] = 'wide';
		}

		return $classes;

	}

endif;

add_filter( 'body_class', 'hannah_cd_body_class' );


/*****************************************************************/
/* ALLOW SPECIFIC TAGS IN FIELD OUTPUTS */
/*****************************************************************/

// custom html tag output
if ( ! function_exists( 'hannah_cd_strip_tags' ) ) : 

	function hannah_cd_strip_tags( $mystriptags ) {
	
		// output for custom text fields with allowed html tags
		return strip_tags( $mystriptags, '<p><a><strong><em><del><br><span>' );
	}

endif;

add_action( 'template_redirect', 'hannah_cd_strip_tags' );


// wp_kses
if ( ! function_exists( 'hannah_cd_kses' ) ) : 

	function hannah_cd_kses( $output ) {

		// output full feature allowed html tags
		return wp_kses( $output , wp_kses_allowed_html('post') );
		
	}

endif;

add_action( 'template_redirect', 'hannah_cd_kses' );


/*****************************************************************/
/* LOAD CUSTOM CSS / JS GENERATED BY ACF */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_generate_custom_css_js' ) ) :

	function hannah_cd_generate_custom_css_js() {
		
		global $wp_filesystem;
		WP_Filesystem(); // Initial WP file system

		ob_start();
		require_once( get_template_directory() . '/css/custom-styles.php' );
		$css = ob_get_clean();
		$wp_filesystem->put_contents( get_template_directory() . '/css/custom-styles.css', $css, 0644 );
		
		ob_start();
		require_once( get_template_directory() . '/js/custom-js.php' );
		$js = ob_get_clean();
		$wp_filesystem->put_contents( get_template_directory() . '/js/custom-js.js', $js, 0644 );
		
		ob_start();
		require_once( get_template_directory() . '/js/cookiebar.php' );
		$js = ob_get_clean();
		$wp_filesystem->put_contents( get_template_directory() . '/js/cookiebar.js', $js, 0644 );
		
		ob_start();
		require_once( get_template_directory() . '/js/google-maps.php' );
		$js = ob_get_clean();
		$wp_filesystem->put_contents( get_template_directory() . '/js/google-maps.js', $js, 0644 );
	}

endif;

add_action( 'acf/save_post', 'hannah_cd_generate_custom_css_js' );


/*****************************************************************/
/* INCLUDE CSS AND JS FILES */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_include_css_js' ) ) :

	function hannah_cd_include_css_js()	{
		
        global $hannah_cd_field_id, $hannah_cd_under_construction, $hannah_cd_visibility, $hannah_cd_visibility_cases;
        
		/* STYLES */
		/*****************************************************************/

		wp_enqueue_style( 'bootstrap', 						get_template_directory_uri() . '/css/bootstrap.min.css', 			array(), null, 'all' );
		wp_enqueue_style( 'fontawesome', 					get_template_directory_uri() . '/css/font-awesome.min.css', 		array(), null, 'all' );
		wp_enqueue_style( 'animate', 						get_template_directory_uri() . '/css/animate.css', 					array(), null, 'all' );
		wp_enqueue_style( 'magnific-popup', 				get_template_directory_uri() . '/css/magnific-popup.css', 			array(), null, 'all' );
		wp_enqueue_style( 'owl-carousel', 					get_template_directory_uri() . '/css/owl.carousel.min.css', 		array(), null, 'all' );
		wp_enqueue_style( 'style', 							get_template_directory_uri() . '/style.css', 						array(), null, 'all' );
        if( HANNAH_CD_MAIN_THEME == false ) :
            wp_enqueue_style( 'style-theme', 				get_template_directory_uri() . '/css/theme.css', 					array(), null, 'all' ); // Theme specific CSS
        endif;
		if( class_exists( 'WooCommerce' ) ) :
			wp_enqueue_style( 'hannah_cd_woocommerce',	 	get_template_directory_uri() . '/css/woocommerce.css', 				array(), null, 'all' ); // Custom WooCommerce CSS Styles by acf admin
		endif;
		wp_enqueue_style( 'hannah_cd_style-custom', 		get_template_directory_uri() . '/css/custom-styles.css', 			array(), null, 'all' ); // Custom CSS
		
		/* SCRIPTS */
		/*****************************************************************/
		
		wp_enqueue_script( 'bootstrap', 					get_template_directory_uri() . '/js/bootstrap.min.js', 				array( 'jquery' ), null, true );        
		wp_enqueue_script( 'wow', 							get_template_directory_uri() . '/js/wow.min.js', 					array( 'jquery' ), null, true );
		wp_enqueue_script( 'magnific-popup', 				get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', 	array( 'jquery' ), null, true );	
		wp_enqueue_script( 'owl-carousel', 					get_template_directory_uri() . '/js/owl.carousel.min.js', 			array( 'jquery' ), null, true );

		// ADOBE TYPEKIT [check if exist]
		if ( ACF_GF('adobe_typekit', 'option') && ACF_GF('adobe_typekit_token', 'option') ) {
			
			$adobe_typekit_token = ACF_GF('adobe_typekit_token', 'option');
			wp_enqueue_script( 'typekit', 					'//use.typekit.net/' . esc_html( $adobe_typekit_token ) . '.js', 	array( 'jquery' ), null, true );
			
		}

		// MASONRY GRID [check if exist]
		if( is_front_page() && ACF_GF('layout_show', 'option') == 'masonry' || is_home() && ACF_GF('layout_show', 'option') == 'masonry' || is_archive() && ACF_GF('layout_show', 'option') == 'masonry' || is_page() && ACF_GF('layout_show', 'option') == 'masonry' || ACF_GF('filter_layout_show') == 'masonry' || is_front_page() && ACF_GF('layout_show', 'option') == 'metro' || is_home() && ACF_GF('layout_show', 'option') == 'metro' || is_archive() && ACF_GF('layout_show', 'option') == 'metro' || is_page() && ACF_GF('layout_show', 'option') == 'metro' || ACF_GF('filter_layout_show') == 'metro' ) {
			
			wp_enqueue_script( 'masonry',					get_template_directory_uri() . '/js/masonry.pkgd.min.js', 			array( 'jquery' ), null, true );
			
		}

		// COOKIEBAR [check if exist]
		if( ACF_GF('cookiebar_activate', 'option') ) {
			
			wp_enqueue_script( 'cookiebar', 				get_template_directory_uri() . '/js/cookiebar.js', 					array( 'jquery' ), null, true );
			
		}
		
		// COUNTDOWN [check if exist]
		if( $hannah_cd_under_construction || shortcode_exists( 'countdown' ) ) {
		
			wp_enqueue_script( 'jquery-countdown',			get_template_directory_uri() . '/js/jquery.countdown.min.js', 		array( 'jquery' ), null, true );
			
		}
		
		// EXIT POPUP [check if exist]
        if( ACF_HR('add_exit_popup', 'option') ): 
            while( ACF_HR('add_exit_popup', 'option') ) { the_row(); 
                                                          
                hannah_cd_content_visibility( get_the_ID() );
                
                if( ! empty( $hannah_cd_visibility ) ) {
                    foreach( $hannah_cd_visibility as $display ) :
                        if( $hannah_cd_visibility_cases[ $display ] ) : 
                            if( ! $hannah_cd_under_construction ) {

                                wp_enqueue_script( 'exit', 					get_template_directory_uri() . '/js/bioep.min.js', 					array( 'jquery' ), null, true );
                                wp_enqueue_script( 'dialog-trigger',		get_template_directory_uri() . '/js/dialog-trigger.min.js', 		array( 'jquery' ), null, true );

                             }
                        endif;
                    endforeach;
                }
                                                          
            }
        endif;
		
		// PARTICLES CANVAS ANIMATION [check if exist]        
		if( ACF_HR('page_headers', $hannah_cd_field_id) ) :
			while ( ACF_HR('page_headers', $hannah_cd_field_id) ) { the_row();
                if( ACF_GF('header_type', $hannah_cd_field_id) == 'default' ) {
                    if( ACF_GSF('particles_show', $hannah_cd_field_id) ) {

                        if( ! $hannah_cd_under_construction ) {
                            wp_enqueue_script( 'particles', 	get_template_directory_uri() . '/js/particles.js', 					array( 'jquery' ), null, true ); 

                            $particles_style = ACF_GSF('particles_style', $hannah_cd_field_id);

                            if( $particles_style == 'style_8' ) {
                                $particles_json_file = get_template_directory_uri() . '/js/particles/cosmos.json';
                            } elseif( $particles_style == 'style_7' ) {
                                $particles_json_file = get_template_directory_uri() . '/js/particles/snow-storm.json';
                            } elseif( $particles_style == 'style_6' ) {
                                $particles_json_file = get_template_directory_uri() . '/js/particles/snow.json';
                            } elseif( $particles_style == 'style_5' ) {
                                $particles_json_file = get_template_directory_uri() . '/js/particles/particles-repulse.json';
                            } elseif( $particles_style == 'style_4' ) {
                                $particles_json_file = get_template_directory_uri() . '/js/particles/particles.json';
                            } elseif( $particles_style == 'style_3' ) {
                                $particles_json_file = get_template_directory_uri() . '/js/particles/bubble.json';
                            } elseif( $particles_style == 'style_2' ) {
                                $particles_json_file = get_template_directory_uri() . '/js/particles/repulse-minimal.json';
                            } else {
                                $particles_json_file = get_template_directory_uri() . '/js/particles/grab-minimal.json';
                            }

                            $inline_js = 'jQuery(function($){ particlesJS.load("particles-js", "' . esc_html( $particles_json_file ) . '", function() {}, "json"); });';		

                            wp_add_inline_script( 'particles', $inline_js );
                        }
                    }
                }
			}
		endif;
        
        // TYPEWRITER EFFECT [check if exist]
        if( ACF_HR('page_headers', $hannah_cd_field_id) ) :
            while ( ACF_HR('page_headers', $hannah_cd_field_id) ) { the_row();
                if( ACF_GSF('title_type_select', $hannah_cd_field_id) == 'typed' ) {
			
			         wp_enqueue_script( 'typed',            get_template_directory_uri() . '/js/typed.min.js', 					array( 'jquery' ), null, true );
            
                }
            }
        endif;

		// PIE CHARTS [check if exist]
		if( ACF_HR('content_rows') ) {
			while ( ACF_HR('content_rows') ) { the_row();
				if( get_row_layout() == 'pie_charts' ) {
					
					wp_enqueue_script( 'easypiechart', 		get_template_directory_uri() . '/js/jquery.easypiechart.min.js', 	array( 'jquery' ), null, true );
					
                    if( ACF_GF('main_color', 'option') ) { 
                        $pie_color = ACF_GF('main_color', 'option'); 
                    } else { 
                        $pie_color = '#222222';
                    }
                    
                    $inline_pie_js = 'jQuery(function($){ $(".chart").easyPieChart({ scaleColor: false, trackColor: "#ececec", barColor: "' . esc_html( $pie_color ) . '", lineWidth: 6, rotate: 160, size: 160, animate: false }); });';		

				    wp_add_inline_script( 'easypiechart', $inline_pie_js );
                    
				}
			}			
		}
		
		// MAIN JS
		wp_enqueue_script( 'hannah_cd_main', 				get_template_directory_uri() . '/js/main.js', 						array( 'jquery' ), null, true ); 
		
		// GOOGLE MAPS API [check if exist] 
        if( ACF_GF('map_show', 'option') && ACF_GF('map_api_key', 'option') ) {
            if( ACF_HR('maps', 'option') ): 
                while( ACF_HR('maps', 'option') ) { the_row();        
                    hannah_cd_content_visibility();     
                    if( ! empty( $hannah_cd_visibility ) ) {
                        foreach( $hannah_cd_visibility as $display ) :
                            if( $hannah_cd_visibility_cases[ $display ] ) :

                                wp_enqueue_script( 'gmap', '//maps.googleapis.com/maps/api/js?key=' . ACF_GF('map_api_key', 'option') . '', array( 'jquery' ), null, true); 
                                // get custom map js by acf admin
                                wp_enqueue_script( 'hannah_cd_custom-map', get_template_directory_uri() . '/js/google-maps.js', array( 'jquery' ), null, true );

                            endif;
                        endforeach;
                    }        
                }
            endif;
        }
        
		// CUSTOM JS
		wp_enqueue_script( 'hannah_cd_custom-js', 			get_template_directory_uri() . '/js/custom-js.js', 					array( 'jquery' ), null, true ); 
	
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { 
			wp_enqueue_script( 'comment-reply' ); 
		}
		
	}

endif;

add_action( 'wp_enqueue_scripts', 'hannah_cd_include_css_js', 30 );


/*****************************************************************/
/* REMOVE VERSION STRINGS FROM STATIC CSS / JS RESOURCES */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_remove_css_js_version' ) ) :

    if( ! is_admin() ) {
        function hannah_cd_remove_css_js_version( $src ){
            $parts = explode( '?ver', $src );
            return $parts[0];
        }

        add_filter( 'script_loader_src', 'hannah_cd_remove_css_js_version', 15, 1 );
        add_filter( 'style_loader_src', 'hannah_cd_remove_css_js_version', 15, 1 );
    }
        
endif;


/*****************************************************************/
/* CONTENT VISIBILITY CHECK [GET SUB FIELD] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_content_visibility' ) ) :

    function hannah_cd_content_visibility() {

        global $hannah_cd_visibility, $hannah_cd_visibility_cases; 

        $hannah_cd_visibility = ACF_GSF('content_visibility', 'option');
        $have_posts = ACF_GSF('content_visibility_posts', 'option');
        $have_products = ACF_GSF('content_visibility_products', 'option');
        $have_pages = ACF_GSF('content_visibility_pages', 'option');
        $have_categories = ACF_GSF('content_visibility_categories', 'option');
        $have_product_categories = ACF_GSF('content_visibility_product_categories', 'option');
        $have_tags = ACF_GSF('content_visibility_tags', 'option');
        $have_product_tags = ACF_GSF('content_visibility_product_tags', 'option');

        if( class_exists( 'WooCommerce' ) ) {
            $is_shop = is_shop();
            $is_shop_category = is_product_category();
            $is_shop_spec_category = is_product_category( $have_product_categories );
            $is_shop_tag = is_product_tag();
            $is_shop_spec_tag = is_product_tag( $have_product_tags );
        } else {
            $is_shop = false;
            $is_shop_category = false;
            $is_shop_spec_category = false;
            $is_shop_tag = false;
            $is_shop_spec_tag = false;
        }                                         

        $hannah_cd_visibility_cases = array(
            'all' => 1,
            'post' => is_single( $have_posts ),
            'product' => is_single( $have_products ),
            'shop' => $is_shop && ! is_search(),
            'page' => is_page( $have_pages ),
            'category' => is_category( $have_categories ),
            'product_category' => $is_shop_spec_category,
            'tag' => is_tag( $have_tags ),
            'product_tag' => $is_shop_spec_tag,
            'frontpage' => is_front_page(),
            'each_post' => is_singular( 'post' ),
            'each_product' => is_singular( 'product' ),
            'each_page' => is_singular( 'page' ),
            'each_category' => is_category(),
            'each_product_category' => $is_shop_category,
            'each_tag' => is_tag(),
            'each_product_tag' => $is_shop_tag,
        );
        
    }

endif;


/*****************************************************************/
/* LOADING GOOGLE WEB FONTS */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_webfonts_url' ) ) :

	function hannah_cd_webfonts_url( $font_style = '' ) {

		// default theme fonts
		$default_fonts = 'Lato:300,400,700,900|Montserrat:400,500,600,700';
		
		$total_rows = count( ACF_GF( 'custom_google_fonts_show', 'option' ) );

		if( ACF_HR('custom_google_fonts_show', 'option') ) {
			
			$selected_fonts = '';
			while ( ACF_HR('custom_google_fonts_show', 'option') ) { the_row();					
																	
				$custom_google_font_name = ACF_GSF('custom_google_font_name', 'option');
				$custom_google_font_weight = ACF_GSF('custom_google_font_weight', 'option');

				// get custom font name
				$selected_fonts .= $custom_google_font_name;
				
				// check if custom font weight exist
				if( ! empty($custom_google_font_weight) ) {													
					$selected_fonts .= ':' . $custom_google_font_weight ;
				}
																	
				if( get_row_index() == $total_rows ) {
					// get the last row
				} else {
					$selected_fonts .= $not_last = '|'; 
				}

			} 
			
			// check if custom font values exist
			if( empty($custom_google_font_name) ) {
				$get_fonts = $default_fonts;
			} else {
				$get_fonts = $selected_fonts;
			}
			
		} else {
			
			// get default theme fonts
			$get_fonts = $default_fonts;
			
		}

		$font_style = add_query_arg( 'family', esc_html( $get_fonts ), "//fonts.googleapis.com/css" );

		return $font_style;
	}

endif;


if ( ! function_exists( 'hannah_cd_webfonts_output' ) ) :
	
	function hannah_cd_webfonts_output() {

		wp_enqueue_style( 'hannah_cd_webfonts', hannah_cd_webfonts_url(), array(), null, 'all' );
		
	}
	
endif;

add_action( 'wp_enqueue_scripts', 'hannah_cd_webfonts_output', 30 );


/*****************************************************************/
/* CUSTOM PAGINATION */
/*****************************************************************/

if( ! function_exists('hannah_cd_pagination') ) :

	function hannah_cd_pagination( $numpages = '', $pagerange = '', $paged='' ) {
	
	  	if ( empty( $pagerange ) ) {
			$pagerange = 2;
	  	}

	  	global $paged;
	  	if ( empty( $paged ) ) {
			$paged = 1;
	  	}
	  	if ( $numpages == '' ) {
			global $wp_query;
			$numpages = $wp_query->max_num_pages;
			if( ! $numpages ) {
				$numpages = 1;
			}
	  	}
		
		$big = 999999999; // need an unlikely integer
		$search_for   = array( $big, '#038;' );
		$replace_with = array( '%#%', '&' );

	  	$pagination_args = array(
			'base'            => str_replace( $search_for, $replace_with, esc_url( get_pagenum_link( $big ) ) ),
			'format'          => 'page/%#%',
			'total'           => $numpages,
			'current'         => $paged,
			'show_all'        => False,
			'end_size'        => 1,
			'mid_size'        => $pagerange,
			'prev_next'       => True,
			'prev_text'       => '<i class="fa fa-angle-left"></i>',
			'next_text'       => '<i class="fa fa-angle-right"></i>',
			'type'            => 'plain',
			'add_args'        => false,
			'add_fragment'    => ''
	  	);
	
	  	$paginate_links = paginate_links( $pagination_args );
	
	  	if ( $paginate_links ) {
			echo '<nav class="custom-pagination">';
		  		echo '<span class="page-numbers page-num">' . esc_html__( 'Page', 'hannah-cd' ) . ' ' . esc_html( $paged ) . ' ' . esc_html__( ' of ', 'hannah-cd' ) . ' ' . esc_html( $numpages ) . '</span>';
		  		echo $paginate_links;
			echo '</nav>';
	  	}
	
	}

endif;


/*****************************************************************/
/* CHANGING EXCERPT MORE */
/*****************************************************************/

if( ! function_exists('hannah_cd_excerpt_more') ) :

   	function hannah_cd_excerpt_more( $more ) {
   		global $post;
   		return ' ... ';
   	}

endif;
   
add_filter('excerpt_more', 'hannah_cd_excerpt_more');


/*****************************************************************/
/* FILTER INDEX */
/*****************************************************************/

if( ! function_exists('hannah_cd_filter_index') ) :

	function hannah_cd_filter_index( $filter_query = false ) {

		if ( $filter_query->have_posts() ) { 
            $layout_special = ACF_GF('social_blogbar_show', 'option');?>

            <div class="default-layout<?php if( ! $layout_special ) { ?> special<?php } ?>">
                <?php while ( $filter_query->have_posts() ) : $filter_query->the_post();

                    include( get_template_directory() . '/content.php' );

                endwhile; ?>
            </div>

        <?php } 

		global $wp_query;

		wp_reset_postdata();

		$temp_query = $wp_query;
		$wp_query = $filter_query;
		hannah_cd_pagination();
		$wp_query = $temp_query;

	}
	
endif;


/*****************************************************************/
/* VISUAL INDEX */
/*****************************************************************/

if( ! function_exists('hannah_cd_visual_index') ) :
	
	function hannah_cd_visual_index( $visual_query = false ) {
		
		$layout_visual_right = ACF_GF('layout_show', 'option') == 'visual_right' || ACF_GF('filter_layout_show') == 'visual_right';
        $layout_special = ACF_GF('social_blogbar_show', 'option');
		
        if( is_page_template( 'page-filter.php' ) ) {
            $layout_alternate = ACF_GF('alt_orientation');
        } else {
            $layout_alternate = ACF_GF('alt_orientation', 'option');
        }   
        
		if ( $visual_query->have_posts() ) { ?>

			<div class="visual-layout visual<?php if( $layout_visual_right ) { ?> visual-right<?php } ?><?php if( ! $layout_special ) { ?> special<?php } ?><?php if( $layout_alternate ) { ?> alternate<?php } ?>">
				
				<?php while ( $visual_query->have_posts() ) : $visual_query->the_post();

					include( get_template_directory() . '/content-visual.php' );

				endwhile; ?>
				
			</div>

		<?php } 

		global $wp_query;

		wp_reset_postdata();
		
		$temp_query = $wp_query;
		$wp_query = $visual_query;
		hannah_cd_pagination();
		$wp_query = $temp_query;
	}
	
endif;


/*****************************************************************/
/* BOOK INDEX */
/*****************************************************************/

if( ! function_exists('hannah_cd_book_index') ) :
	
	function hannah_cd_book_index( $book_query = false ) {
		
		$layout_book_right = ACF_GF('layout_show', 'option') == 'book_right' || ACF_GF('filter_layout_show') == 'book_right';
        
        if( is_page_template( 'page-filter.php' ) ) {
            $layout_alternate = ACF_GF('alt_orientation');
        } else {
            $layout_alternate = ACF_GF('alt_orientation', 'option');
        }        
		
		if ( $book_query->have_posts() ) { ?>

			<div class="book-layout book<?php if( $layout_book_right ) { ?> book-right<?php } ?><?php if( $layout_alternate ) { ?> alternate<?php } ?>">
				
				<?php while ( $book_query->have_posts() ) : $book_query->the_post();

					include( get_template_directory() . '/content-book.php' );

				endwhile; ?>
				
			</div>

		<?php } 

		global $wp_query;

		wp_reset_postdata();
		
		$temp_query = $wp_query;
		$wp_query = $book_query;
		hannah_cd_pagination();
		$wp_query = $temp_query;
	}
	
endif;


/*****************************************************************/
/* MAGAZINE INDEX */
/*****************************************************************/

if( ! function_exists('hannah_cd_magazine_index') ) :
	
	function hannah_cd_magazine_index( $magazine_query = false ) {

		if ( $magazine_query->have_posts() ) { ?>
			
			<div class="magazine">
				<div class="magazin-collector dleft">
				
					<?php
			
					global $hannah_cd_sidebar_show, $hannah_cd_magazine_count;

					$hannah_cd_magazine_count = 1;
					$total = $magazine_query->post_count;
			
					while ( $magazine_query->have_posts() ) : $magazine_query->the_post(); 
					
						// get item count

						if( $hannah_cd_sidebar_show ) {
							$count_query_1 = $hannah_cd_magazine_count % 4 == 0 + 1;
							$count_query_2 = $hannah_cd_magazine_count % 4 == 0;
							$count_query_3 = $hannah_cd_magazine_count % 8 == 0;
						} else {
							$count_query_1 = $hannah_cd_magazine_count % 5 == 0 + 1;
							$count_query_2 = $hannah_cd_magazine_count % 5 == 0;
							$count_query_3 = $hannah_cd_magazine_count % 10 == 0;
						}
					
						?>

							<?php if( $count_query_1 ) { ?>
								<div class="magazine-item mgz-big <?php if( is_sticky() ) { ?>sticky<?php } ?>">
							<?php } else { ?>
								<div class="magazine-item <?php if( is_sticky() ) { ?>sticky<?php } ?>">
							<?php } ?>
								<?php if( is_sticky() ) { ?>
									<div class="ribbon"></div>
								<?php } ?>

								<?php include( get_template_directory() . '/content-magazine.php' ); ?>

							</div>

						<?php if( $count_query_2 ) { ?>
							
							<?php if( $hannah_cd_magazine_count < $total && $count_query_3 ) { ?>
								</div><div class="magazin-collector dleft">
							<?php } elseif( $hannah_cd_magazine_count < $total ) { ?>
								</div><div class="magazin-collector">
							<?php } else { 
								// nothing
							} ?>
							
						<?php } ?>

					<?php 
					$hannah_cd_magazine_count++;
					endwhile; 
				?>
				
				</div>
			</div>

		<?php }

		global $wp_query;

		wp_reset_postdata();	

		$temp_query = $wp_query;
		$wp_query = $magazine_query;
		hannah_cd_pagination();	
		$wp_query = $temp_query;
		
	}
	
endif;


/*****************************************************************/
/* GRID + METRO + MASONRY GRID INDEX */
/*****************************************************************/

if( ! function_exists('hannah_cd_masonry_index') ) :
	
	function hannah_cd_masonry_index( $masonry_query = false ) {

        $masonry_global = ACF_GF('layout_show', 'option') == 'masonry';
		$masonry_filter = ACF_GF('filter_layout_show') == 'masonry';
		$grid_global = ACF_GF('layout_show', 'option') == 'grid';
		$grid_filter = ACF_GF('filter_layout_show') == 'grid';
		$metro_global = ACF_GF('layout_show', 'option') == 'metro';
		$metro_filter = ACF_GF('filter_layout_show') == 'metro';
        
        $index_page = is_page_template( 'page-filter.php' ) && $grid_filter || is_page_template( 'page-filter.php' ) && $metro_filter || is_page_template( 'page-filter.php' ) && $masonry_filter;
        
        if( $index_page ) {					
            $mry_col_2 = ACF_GF('masonry_specific_custom_column') == 'masonry_spec_colnum_2';
            $mry_col_3 = ACF_GF('masonry_specific_custom_column') == 'masonry_spec_colnum_3';
            $mry_col_4 = ACF_GF('masonry_specific_custom_column') == 'masonry_spec_colnum_4';					
        } else {					
            $mry_col_2 = ACF_GF('masonry_custom_column', 'option') == 'masonry_colnum_2';
            $mry_col_3 = ACF_GF('masonry_custom_column', 'option') == 'masonry_colnum_3';
            $mry_col_4 = ACF_GF('masonry_custom_column', 'option') == 'masonry_colnum_4';						
        }				

        global $hannah_cd_mry_column, $hannah_cd_sidebar_show;
        
        if( $mry_col_4 && ! $hannah_cd_sidebar_show ) {
            $hannah_cd_mry_column = '4';
        } elseif( $mry_col_3 && ! $hannah_cd_sidebar_show ) {
            $hannah_cd_mry_column = '3';
        } else {
            $hannah_cd_mry_column = '2';
        }

		if ( $masonry_query->have_posts() ) {
            
            // GRID
			
            if( $grid_filter || ! $masonry_filter && ! $metro_filter && $grid_global ) { ?>
				<div class="grid post-grid column-<?php echo esc_html( $hannah_cd_mry_column ); ?>">

					<?php while( $masonry_query->have_posts() ) : $masonry_query->the_post(); ?>

						<div class="grid-item <?php if( is_sticky() ) { ?>sticky<?php } ?>">

							<?php if( is_sticky() ) { ?>
								<div class="ribbon"></div>
							<?php }
                                                                                        
                            get_template_part( 'content', 'grid' ); ?>
								
						</div>

					<?php endwhile; ?>

				</div>
				
			<?php // METRO
			
			} elseif( $metro_filter || ! $masonry_filter && ! $grid_filter && $metro_global ) { ?>
				
				<div class="grid metro-grid column-<?php echo esc_html( $hannah_cd_mry_column ); ?>">

					<div class="grid-sizer"></div>
					<div class="gutter-sizer"></div>

					<?php $metro_count = 1;
					while( $masonry_query->have_posts() ) : $masonry_query->the_post(); 
					
                        global $hannah_cd_item_repeat_1, $hannah_cd_item_repeat_2;

                        // repeat items
                        if( $mry_col_2 ) {
                            $hannah_cd_item_repeat_1 = $metro_count == 1 || $metro_count % 5 == 0;
                            $hannah_cd_item_repeat_2 = false;
                        } elseif( $mry_col_3 ) {
                            $hannah_cd_item_repeat_1 = $metro_count % 5 == 0;
                            $hannah_cd_item_repeat_2 = $metro_count == 1 || $metro_count % 7 == 0;
                        } else {
                            $hannah_cd_item_repeat_1 = $metro_count == 1 || $metro_count % 7 == 0;
                            $hannah_cd_item_repeat_2 = $metro_count % 3 == 0;
                        } 

                            if( $hannah_cd_item_repeat_1 ) { ?>
                                <div class="grid-item grid-item--width2 <?php if( is_sticky() ) { ?>sticky<?php } ?>">
                            <?php } elseif( $hannah_cd_item_repeat_2 ) { ?>
                                <div class="grid-item grid-item--height2 <?php if( is_sticky() ) { ?>sticky<?php } ?>">
                            <?php } else { ?>
                                <div class="grid-item <?php if( is_sticky() ) { ?>sticky<?php } ?>">
                            <?php }

                                if( is_sticky() ) { ?>
                                    <div class="ribbon"></div>
                                <?php }

                                get_template_part( 'content', 'metro' ); ?>

                            </div>

                        <?php $metro_count++;
					endwhile; ?>

				</div>
				
			<?php // MASONRY GRID
			
			} elseif( $masonry_filter || ! $metro_global && ! $grid_filter && $masonry_global ) { ?>
                                
				<div class="grid column-<?php echo esc_html( $hannah_cd_mry_column ); ?>">

					<div class="grid-sizer"></div>
					<div class="gutter-sizer"></div>

					<?php $grid_count = 1;
					while( $masonry_query->have_posts() ) : $masonry_query->the_post();
                                                                                                 
                        if( $grid_count == 1 ) { ?>
							<div class="grid-item grid-item--width2 <?php if( is_sticky() ) { ?>sticky<?php } ?>">
						<?php } else { ?>
							<div class="grid-item <?php if( is_sticky() ) { ?>sticky<?php } ?>">
						<?php }
                                                                                                 
                            if( is_sticky() ) { ?>
								<div class="ribbon"></div>
							<?php }
                                                                                                 
                            get_template_part( 'content', 'masonry' ); ?>
							
						</div>

					    <?php $grid_count++;
					endwhile; ?>

				</div>
				
			<?php }
        
        }

		global $wp_query;

		wp_reset_postdata();	

		$temp_query = $wp_query;
		$wp_query = $masonry_query;
		hannah_cd_pagination();	
		$wp_query = $temp_query;
		
	}
	
endif;


/*****************************************************************/
/* SINGLE NEXT POST NAV */
/*****************************************************************/

if( ! function_exists('hannah_cd_single_next_post') ) :

	function hannah_cd_single_next_post( $output, $format, $link, $post ) {		
        
		$nextPost = get_next_post();
		
		if( ! empty( $nextPost ) ) {
            $title = get_the_title( $nextPost->ID );
            $url = get_permalink( $nextPost->ID );
			$nextthumbnail = get_the_post_thumbnail( $nextPost->ID, array(100, 100) );
		}

		if( is_a( $nextPost, 'WP_Post') ) { ob_start(); ?>
			
			<a href="<?php echo esc_url( $url ); ?>" rel="next" class="next" title="<?php echo esc_html( $title ); ?>">
                <span class="post-nav-content">
                    <span class="post-nav-link">
                        <span class="post-nav-title-label"><?php echo esc_html__( 'Next Post', 'hannah-cd' ); ?></span>
                        <span class="post-nav-title"><?php echo esc_html( $title ); ?></span>
                    </span>
                    <i class="post-nav-icon fa fa-3x fa-angle-right"></i>                    
                    <?php if( ! $nextthumbnail ) { ?>
                        <div class="thumb"><div class="letter"><span><?php echo mb_strimwidth( $title, 0, 1 ); ?></span></div></div>
                    <?php } else {
                        echo $nextthumbnail;
                    } ?>
                </span>
			</a>
			
			<?php $content = ob_get_contents();
			ob_end_clean();
			return $content;

		}
		
	}

endif;

add_filter( 'next_post_link', 'hannah_cd_single_next_post', 10, 4 );


/*****************************************************************/
/* SINGLE PREC POST NAV */
/*****************************************************************/

if( ! function_exists('hannah_cd_single_prev_post') ) :

	function hannah_cd_single_prev_post( $output, $format, $link, $post ) {
        
		$prevPost = get_previous_post();
		
		if( ! empty( $prevPost ) ) {
            $title = get_the_title( $prevPost->ID );
            $url = get_permalink( $prevPost->ID );
			$prevthumbnail = get_the_post_thumbnail( $prevPost->ID, array(100, 100) );
		}

		if( ! empty( $prevPost ) ) { ob_start(); ?>
			
			<a href="<?php echo esc_url( $url ); ?>" rel="prev" class="prev" title="<?php echo esc_html( $title ); ?>">                
                <span class="post-nav-content">
                    <span class="post-nav-link">
                        <span class="post-nav-title-label"><?php echo esc_html__( 'Previous Post', 'hannah-cd' ); ?></span>
                        <span class="post-nav-title"><?php echo esc_html( $title ); ?></span>
                    </span>
                    <i class="post-nav-icon fa fa-3x fa-angle-left"></i>
                    <?php if( ! $prevthumbnail ) { ?>
                        <div class="thumb"><div class="letter"><span><?php echo mb_strimwidth( $title, 0, 1 ); ?></span></div></div>
                    <?php } else {
                        echo $prevthumbnail;
                    } ?>
                </span>
			</a>
			
			<?php $content = ob_get_contents();
			ob_end_clean();
			return $content;

		}
		
	}

endif;

add_filter( 'previous_post_link', 'hannah_cd_single_prev_post', 10, 4 );


/*****************************************************************/
/* START SESSION [Post View Counter] */
/*****************************************************************/

if( ! function_exists('hannah_cd_register_session') ) :

    function hannah_cd_register_session() {
        if( ! session_id() ) {
            session_start();
        }
    }

    add_action('init', 'hannah_cd_register_session');

endif;


/*****************************************************************/
/* COUNTER FOR POST VIEWS */
/*****************************************************************/

// get post views
if( ! function_exists('hannah_cd_getPostViews') ) :

	function hannah_cd_getPostViews( $postID ) {
		
		$count_key = 'post_views_count';
		$count = get_post_meta( $postID, $count_key, true );
		
		if( $count=='' ) {
			delete_post_meta( $postID, $count_key );
			add_post_meta( $postID, $count_key, '0' );
			return esc_html__( '0 Views', 'hannah-cd' );
		}
		
		if( $count=='1' ) {
			return $count . ' ' . esc_html__( 'View', 'hannah-cd' );
		} else {
			return $count . ' ' . esc_html__( 'Views', 'hannah-cd' );
		}
		
	}

endif;

// get post views only in count without label
if( ! function_exists('hannah_cd_getPostViews_Count') ) :

	function hannah_cd_getPostViews_Count( $postID ) {
		
		$count_key = 'post_views_count';
	  	$count = get_post_meta( $postID, $count_key, true );
		return $count;
	
	}

endif;

// set post views
if( ! function_exists('hannah_cd_setPostViews') ) :

	function hannah_cd_setPostViews( $postID ) {
		
		$count_key = 'post_views_count';
		$count = get_post_meta( $postID, $count_key, true );
		
		if( $count=='' ) {
			$count = 0;
			delete_post_meta( $postID, $count_key );
			add_post_meta( $postID, $count_key, '0' );
		} else {
			if( ! isset( $_SESSION['post_views_count-'. $postID] ) ) {
				$_SESSION['post_views_count-'. $postID]="si";
				$count++;
				update_post_meta( $postID, $count_key, $count );
			}
		} 
		
	}
	
endif;


/*****************************************************************/
/* SOCIAL SHARE BAR */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_social_share_bar' ) ) : 

	function hannah_cd_social_share_bar( $post_id ) {
		
		$post_permalink = get_permalink( $post_id );
		$post_title = str_replace( '&#038;', '', get_the_title( $post_id ) );
		$post_img = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
		$post_img_alt_text = get_post_meta( get_post_thumbnail_id( $post_id ), '_wp_attachment_image_alt', true );
		
		?>
		<a rel="nofollow" class="fa fa-facebook" target="_blank" href="http://www.facebook.com/share.php?u=<?php echo esc_html( $post_permalink ); ?>"></a>
		<a rel="nofollow" class="fa fa-pinterest-p" data-pin-custom="true" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_html( $post_permalink ); ?>&amp;media=<?php echo esc_html( $post_img ); ?>&amp;description=<?php echo esc_html( $post_img_alt_text ); ?>"></a>
		<a rel="nofollow" class="fa fa-twitter" target="_blank" href="https://twitter.com/home?status=<?php echo rawurlencode( $post_title . ' ' . $post_permalink ); ?>" ></a>
		<a rel="nofollow" class="fa fa-google-plus" target="_blank" href="https://plus.google.com/share?url=<?php echo esc_html( $post_permalink ); ?>" ></a>
		<a rel="nofollow" class="fa fa-whatsapp" target="_blank" href="whatsapp://send?text=<?php echo rawurlencode( $post_title . ' - ' ); ?><?php echo esc_html( $post_permalink ); ?>" ></a>
		<a rel="nofollow" class="fa fa-envelope-o" href="mailto:receiver@mail.com?subject=<?php echo rawurlencode( $post_title ); ?>&amp;body=<?php echo rawurlencode( $post_title . ' ' . $post_permalink ); ?>"></a>
		<?php

	}

endif;


/*****************************************************************/
/* ADD PIN BUTTON */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_pin_button' ) ) : 

	function hannah_cd_pin_button( $post_id ) {
		
		$post_permalink = get_permalink( $post_id );
		$post_img = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );
		$post_img_alt_text = get_post_meta( get_post_thumbnail_id( $post_id ), '_wp_attachment_image_alt', true ); ?>
                    
        <a rel="nofollow" class="pin-button" data-pin-custom="true" target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php echo esc_html( $post_permalink ); ?>&amp;media=<?php echo esc_html( $post_img ); ?>&amp;description=<?php echo esc_html( $post_img_alt_text ); ?>">
            <i class="fa fa-pinterest-p"></i><span><?php echo esc_html__( 'Pin it', 'hannah-cd' ); ?></span>
        </a>
                    
    <?php }

endif;


/*****************************************************************/
/* RELATED POSTS */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_related_posts' ) ) : 

	function hannah_cd_related_posts( $post_id ) {		
        
        global $post_id;
        
		$related_posts = ACF_GF('related_posts', 'option');
		$related_posts_column = ACF_GF('related_posts_column', 'option');
		$related_posts_items = ACF_GF('related_posts_items', 'option');
        
        // get the visible item count
        if( $related_posts_items ) {
            $rel_items = $related_posts_items;
        } else {
            $rel_items = '3';
        }
        
		// postformat exclude
		$get_postformat = ACF_GF('postformat_exclude', 'option');
		$postformat_exclude = array();
		if( is_array( $get_postformat ) || is_object( $get_postformat ) ) {
			foreach( $get_postformat as $postformat ) {
				array_push( $postformat_exclude, $postformat['value'] );
			}
		}

        // related posts settings
		$related_args = array( 
			'paged' => 1, 
			'posts_per_page' => esc_html( $rel_items ), 
			//'post_type' => 'custom_posttype', 
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1,
			'meta_query' => array(
				array( 
					'value' => 0,
					'type' => 'NUMERIC',
					'compare' => '>'
				),
			),
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
					'operator' => 'NOT IN',
				),
			),
		);

        // check the active related posts filter
        if( $related_posts == 'category' ) {
            $related_categories = wp_get_post_categories( get_the_ID(), array( 'fields' => 'all' ) );
        } elseif( $related_posts == 'tag' ) {
            $related_tags = wp_get_post_tags( get_the_ID() );
        }
        
        // check if post have categories or tags
        if( ! empty( $related_categories ) || ! empty( $related_tags ) ) {
        
            switch( $related_posts ) {

                // filter by categories
                case 'category':

                    if( $related_categories ) {
                        $categories = array();
                        foreach( $related_categories as $category ) {
                            $categories[] = $category->term_id;
                        }
                        $related_args['category__in'] = $categories;
                    }

                break;

                // filter by tags
                case 'tag':

                    if( $related_tags ) {
                        $tags = array();
                        foreach( $related_tags as $tag ) {
                            $tags[] = $tag->term_id;
                        }
                        $related_args['tag__in'] = $tags;
                    }
                    
                break;
                    
                default:
                    
                    $related_args['orderby'] = 'rand';

                break;
            }
        
        // get random posts if no categories or tags available
        } else {
            
            $related_args['orderby'] = 'rand';
            
        }
        
        // filter out the current post
		$related_args['post__not_in'] = array( get_the_ID() );
        
		$related_query = new WP_Query( $related_args ); ?>
                  
            <div class="related-posts">
                
                <div class="special-title">
                    <span><?php esc_html_e( 'Related Posts', 'hannah-cd' ); ?></span>
                </div>
                
                <div class="related-post-list">
                  <ul class="related-list row">

                        <?php $rel_row_counter = 1;
                        while( $related_query->have_posts() ) : $related_query->the_post(); 

                            // get the related post count
                            $post_count = $related_query->post_count;

                            // get the column count
                            if( $post_count == 1 || $related_posts_column == 'col_1' ) {
                                $rel_col = 'col-md-12';
                            } elseif( $post_count == 2 || $related_posts_column == 'col_2' ) {
                                $rel_col = 'col-md-6';
                            } elseif( $post_count == 4 || $related_posts_column == 'col_4' ) {
                                $rel_col = 'col-md-3';
                            } else {
                                $rel_col = 'col-md-4';
                            }

                            // get the item count
                            if( $post_count == 1 && $related_posts_items > $post_count || $related_posts_items == 1 && $post_count == 1 ) {
                                $item_count = '1';
                            } elseif( $post_count == 2 && $related_posts_items > $post_count || $related_posts_items == 2 && $post_count == 2 ) {
                                $item_count = '2';
                            } elseif( $post_count == 3 && $related_posts_items > $post_count || $related_posts_items == 3 && $post_count == 3 ) {
                                $item_count = '3';
                            } elseif( $post_count == 4 && $related_posts_items > $post_count || $related_posts_items == 4 && $post_count == 4 ) {
                                $item_count = '4';
                            } else {
                                $item_count = $related_posts_items;
                            }

                            // get the related post thumbnail
                            $thumb_id = get_post_thumbnail_id();

                            if( $related_posts_column == 'col_1' || $related_posts_column == 'col_2' ) {
                                $thumb_size = 'large';
                            } else {
                                $thumb_size = 'medium';
                            }

                            $thumb_url = wp_get_attachment_image_src( $thumb_id, $thumb_size, true );

                            if( has_post_thumbnail() ) { 
                                $bgimage = $thumb_url[0]; 
                            } 

                            // get the related post data
                            $title = get_the_title();
                            $date = get_the_date( $post_id ); ?>

                            <li class="<?php echo esc_html( $rel_col ); ?>">
                                <a href="<?php the_permalink(); ?>" title="<?php echo esc_html( $title ); ?>" class="related-posts-img hover-box"<?php if( get_the_post_thumbnail() ) { ?> style="background-image: url(<?php echo esc_url( $bgimage ); ?>)"<?php } ?>>
                                    <?php if( ! get_the_post_thumbnail() ) { ?>
                                        <div class="letter"><span><?php echo mb_strimwidth( esc_html( $title ), 0, 1 ); ?></span></div>
                                    <?php } ?>
                                    <div class="hover"></div>
                                </a>
                                <div class="related-content">
                                    <span class="related-category">
                                        <?php $categories = get_the_category(); 
                                        if( ! empty( $categories ) ) {
                                            echo esc_html( $categories[0]->name ); 
                                        } ?>
                                    </span>
                                    <div class="h4-title related-title">
                                        <a href="<?php the_permalink(); ?>"><?php echo esc_html( $title ); ?></a>
                                    </div>
                                    <div class="blog-list-date">
                                        <?php echo $date; ?>
                                    </div>
                                </div>
                            </li>

                        <?php // add row after every 2 items
                        if( $related_posts_column == 'col_2' ) {                                                   
                            if( $rel_row_counter % 2 == 0 && $item_count > 2 ) {
                                echo '</ul><ul class="related-list row">';
                            }

                        // add row after every 3 items    
                        } elseif( $related_posts_column == 'col_3' ) {                                                    
                            if( $rel_row_counter % 3 == 0 && $item_count > 3 ) {
                                echo '</ul><ul class="related-list row">';
                            }

                        // add row after every 4 items    
                        } elseif( $related_posts_column == 'col_4' ) {                                                    
                            if( $rel_row_counter % 4 == 0 && $item_count > 4 ) {
                                echo '</ul><ul class="related-list row">';
                            }

                        // add row after each item    
                        } else {
                            if( $rel_row_counter % 1 == 0 && $item_count > 1 ) {
                                echo '</ul><ul class="related-list row">';
                            }
                        } 

                        $rel_row_counter++; 

                    endwhile;

                    wp_reset_postdata(); ?>

                </ul>
                    
            </div>
        </div>

	<?php }

endif;


/*****************************************************************/
/* BREADCRUMB NAVIGATION */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_breadcrumb' ) ) : 

	function hannah_cd_breadcrumb() {

		$text['home']     = esc_html__( 'Home', 'hannah-cd' ); // text for the 'Home' link
		$text['category'] = esc_html__( 'Archive by Category "%s"', 'hannah-cd' ); // text for a category page
		$text['search']   = esc_html__( 'Search Results for "%s" Query', 'hannah-cd' ); // text for a search results page
		$text['tag']      = esc_html__( 'Posts Tagged "%s"', 'hannah-cd' ); // text for a tag page
		$text['author']   = esc_html__( 'Articles Posted by %s', 'hannah-cd' ); // text for an author page
		$text['404']      = esc_html__( 'Error 404', 'hannah-cd' ); // text for the 404 page
		$text['page']     = esc_html__( 'Page %s', 'hannah-cd' ); // text 'Page N'
		$text['cpage']    = esc_html__( 'Comment Page %s', 'hannah-cd' ); // text 'Comment Page N'
	
		$wrap_before    = '<ol class="breadcrumb">';
		$wrap_after     = '</ol>';
		$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
		$show_on_home   = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$show_current   = 1; // 1 - show current page title, 0 - don't show
		$before         = '<li class="current">'; // tag before the current crumb
		$after          = '</li>'; // tag after the current crumb
	
		global $post;
		$home_link      = home_url('/');
		$link_before    = '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb">';
		$link_after     = '</li>';
		$link_attr      = ' itemprop="url"';
		$link_in_before = '<span itemprop="title">';
		$link_in_after  = '</span>';
		$link           = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
		$frontpage_id   = get_option('page_on_front');
		if ( is_404() ) {
			$parent_id = false;
		} else {
			$parent_id = $post->post_parent;
		}
	
		// define WooCommerce functions
		
		if ( class_exists( 'WooCommerce' ) ) {
			$is_cart = is_cart();
			$is_checkout = is_checkout();
			$is_account_page = is_account_page();
			$is_woocommerce = is_woocommerce();
		} else {
			$is_cart = false;
			$is_checkout = false;
			$is_account_page = false;
			$is_woocommerce = false;
		}
		
		if ( is_home() || is_front_page() ) {
	
			if ( $show_on_home ) echo $wrap_before . $link_before . '<a href="' . $home_link . '">' . $text['home'] . '</a>' . $link_after . $wrap_after;
	
		} elseif( $is_woocommerce || $is_account_page || $is_checkout || $is_cart ) {

			woocommerce_breadcrumb();
		
		} else {
		
			// shorten the title
			function shortText($string, $lenght) {
				if(strlen($string) > $lenght) {
					$string = substr($string, 0, $lenght) . "...";
					$string_end = strrchr($string, " ");
					$string = str_replace($string_end, "...", $string);
				}
				return $string;
			}
			$curr_title = get_the_title();
	
			echo $wrap_before;
			if ( $show_home_link ) echo sprintf($link, $home_link, $text['home']);
	
			if ( is_category() ) {
				$cat = get_category(get_query_var('cat'), false);
				if ( $cat->parent != 0 ) {
					$cats = get_category_parents($cat->parent, TRUE, '');
					$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
					echo $cats;
				}
				if ( get_query_var('paged') ) {
					$cat = $cat->cat_ID;
					echo sprintf($link, get_category_link($cat), get_cat_name($cat)) . $before . sprintf($text['page'], get_query_var('paged')) . $after;
				} else {
					if ( $show_current ) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
				}
	
			} elseif ( is_search() ) {
				if ( have_posts() ) {
					if ( $show_current ) echo $before . sprintf($text['search'], get_search_query()) . $after;
				} else {
					echo $before . sprintf($text['search'], get_search_query()) . $after;
				}
	
			} elseif ( is_day() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'));
				echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F'));
				if ( $show_current ) echo $before . get_the_time('d') . $after;
	
			} elseif ( is_month() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'));
				if ( $show_current ) echo $before . get_the_time('F') . $after;
	
			} elseif ( is_year() ) {
				if ( $show_current ) echo $before . get_the_time('Y') . $after;
	
			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
					if ( $show_current ) echo $before . shortText($curr_title, 35) . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, '');
					$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
					echo $cats;
					if ( get_query_var('cpage') ) {
						echo sprintf($link, get_permalink(), get_the_title()) . $$before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
					} else {
						if ( $show_current ) echo $before . shortText($curr_title, 35) . $after;
					}
				}
	
			// custom post type
			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object(get_post_type());
				if ( get_query_var('paged') ) {
					echo sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
				} else {
					if ( $show_current ) echo $before . $post_type->label . $after;
				}
	
			} elseif ( is_attachment() && get_the_category() ) {
				$parent = get_post($parent_id);
				$cat = get_the_category($parent->ID); $cat = $cat[0];
				if ( $cat ) {
					$cats = get_category_parents($cat, TRUE, '');
					$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
					echo $cats;
				}
				printf($link, get_permalink($parent), $parent->post_title);
				if ( $show_current ) echo $before . shortText($curr_title, 35) . $after;
	
			} elseif ( is_page() && !$parent_id ) {
				if ( $show_current ) echo $before . shortText($curr_title, 35) . $after;
	
			} elseif ( is_page() && $parent_id ) {
				if ( $parent_id != $frontpage_id ) {
					$breadcrumbs = array();
					while ( $parent_id ) {
						$page = get_page($parent_id);
						if ( $parent_id != $frontpage_id ) {
							$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
						}
						$parent_id = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					for ( $i = 0; $i < count($breadcrumbs); $i++ ) {
						echo $breadcrumbs[$i];
					}
				}
				
				if ( $show_current ) echo $before . shortText($curr_title, 35) . $after;
				
			} elseif ( is_tag() ) {
				if ( get_query_var('paged') ) {
					$tag_id = get_queried_object_id();
					$tag = get_tag($tag_id);
					echo sprintf($link, get_tag_link($tag_id), $tag->name) . $before . sprintf($text['page'], get_query_var('paged')) . $after;
				} else {
					if ( $show_current ) echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
				}
	
			} elseif ( is_author() ) {
				global $author;
				$author = get_userdata($author);
				if ( get_query_var('paged') ) {
					echo sprintf($link, get_author_posts_url($author->ID), $author->display_name) . $before . sprintf($text['page'], get_query_var('paged')) . $after;
				} else {
					if ( $show_current ) echo $before . sprintf($text['author'], $author->display_name) . $after;
				}
	
			} elseif ( is_404() ) {
				if ( $show_current ) echo $before . $text['404'] . $after;
	
			} elseif ( has_post_format() && !is_singular() ) {
				echo get_post_format_string( get_post_format() );
			}
	
			echo $wrap_after;
	
		}

	}

endif;	


/*****************************************************************/
/* SCHEMA.ORG STRUCTURED DATA */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_html_tag_schema' ) ) : 

	function hannah_cd_html_tag_schema() {
		$schema = 'http://schema.org/';
		
		if( is_single() ) {
			// Is single post
			$type = "Article";
		} else if( is_page_template( 'page-contact.php' ) ) {
			// Contact form page ID
			$type = 'ContactPage';
		} elseif( is_author() ) {
			// Is author page
			$type = 'ProfilePage';
		} elseif( is_search() ) {
			// Is search results page
			$type = 'SearchResultsPage';
		} else {
			$type = 'WebPage';
		}
	
		echo 'itemscope="itemscope" itemtype="' . esc_html( $schema ) . esc_html( $type ) . '"';
	}

endif;


/*****************************************************************/
/* ADD AJAX SEARCH */
/*****************************************************************/

if ( ! function_exists( 'search_ajax' ) ) :
	function search_ajax() { wp_localize_script( 'hannah_cd_main', 'search_ajax_data', array( 'search_ajaxurl' => admin_url('admin-ajax.php') ) ); }
endif;

add_action( 'wp_head', 'search_ajax' );


if ( ! function_exists( 'hannah_cd_ajax_search' ) ) :

	function hannah_cd_ajax_search() {

		// creating a search query
		$args = array( 
			'post_type' => 'any',
			'post_status' => 'publish',
			'order' => 'DESC',
			'orderby' => 'date',
			's' => $_POST['term'],
			'posts_per_page' => -1,
		);

		$query = new WP_Query( $args );

		// display results
		if( $query->have_posts() ) {

			while ( $query->have_posts() ) { $query->the_post();
		
		?>
		
			<?php if( get_the_post_thumbnail() ) { ?>
				<li>
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('hannah_cd_thumb_min'); ?><span class="search-title"><?php the_title(); ?></span></a>
				</li>
			<?php } else { ?>
				<li>
					<a href="<?php the_permalink(); ?>">
						<div class="thumb"><div class="letter"><span><?php echo mb_strimwidth( get_the_title(), 0, 1 ); ?></span></div></div>
						<span class="search-title"><?php the_title(); ?></span>
					</a>
				</li>
			<?php } ?>
			
		<?php
			}
		} else {

		?>

			<li class="no-match">
				<?php echo esc_html__( 'No matches were found', 'hannah-cd' ) ?>.
			</li>

		<?php

		}
		exit;
	}
	
endif;

add_action('wp_ajax_nopriv_ajax_search','hannah_cd_ajax_search');
add_action('wp_ajax_ajax_search','hannah_cd_ajax_search');


/*****************************************************************/
/* HEADER EDGE SVG STYLE */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_header_end' ) ) : 

	function hannah_cd_header_end( $header_end = '' ) {
		
		$header_edge = ACF_GF('header_edge');
        
        // change the header edge bottom style
        
        $svg_triangle = 'M501.58,22.67v36.5H-5.58l4-1.25s219-15.12,256-17.94S501.58,22.67,501.58,22.67Z';
        $svg_rounded = 'M501.58,22.67v36.5H-5.58c83-3.25,174.57-5.87,273.75-13.5C352.64,39.16,430.82,32.62,501.58,22.67Z';
        
        if( $header_edge == 'shape_1' ) {       
            // Triangle descending
            $svg_path = $svg_triangle;
            $svg_transform = 'none';
        } elseif( $header_edge == 'shape_2' ) {    
            // Triangle ascending      
            $svg_path = $svg_triangle;
            $svg_transform = 'scaleX(-1)';
        } elseif( $header_edge == 'shape_3' ) {     
            // Rounded descending    
            $svg_path = $svg_rounded;
            $svg_transform = 'none';
        } elseif( $header_edge == 'shape_4' ) {    
            // Rounded ascending    
            $svg_path = $svg_rounded;
            $svg_transform = 'scaleX(-1)';
        } else {
            return false;
        }
        
        echo '<svg class="header-edge" style="transform:' . $svg_transform . '" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500.56 56.25" preserveAspectRatio="none"><path d="' . $svg_path . '" transform="translate(0.97 -2.39)" style="fill:#fff"/></svg>';        
            
		return $header_end;
	
	}

endif;

/*****************************************************************/
/* SECTION EDGE SVG STYLE (BOTTOM) */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_section_end' ) ) : 

	function hannah_cd_section_end( $section_end = '' ) {	
        
        $section_edge = ACF_GF('section_edge');
        
        // change the section edge bottom style of all section
        
        $svg_triangle = 'M501.58,22.67v36.5H-5.58l4-1.25s219-15.12,256-17.94S501.58,22.67,501.58,22.67Z';
        $svg_rounded = 'M501.58,22.67v36.5H-5.58c83-3.25,174.57-5.87,273.75-13.5C352.64,39.16,430.82,32.62,501.58,22.67Z';

        if( $section_edge == 'shape_1' ) {       
            // Triangle descending
            $svg_path = $svg_triangle;
            $svg_transform = 'none';
        } elseif( $section_edge == 'shape_2' ) {    
            // Triangle ascending      
            $svg_path = $svg_triangle;
            $svg_transform = 'scaleX(-1)';
        } elseif( $section_edge == 'shape_3' ) {     
            // Rounded descending    
            $svg_path = $svg_rounded;
            $svg_transform = 'none';
        } elseif( $section_edge == 'shape_4' ) {    
            // Rounded ascending    
            $svg_path = $svg_rounded;
            $svg_transform = 'scaleX(-1)';
        } else {
            return false;
        }
    
        echo '<svg class="section-edge" style="transform:' . $svg_transform . '"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500.56 56.25" preserveAspectRatio="none"><path d="' . $svg_path . '" transform="translate(0.97 -2.39)" /></svg>';

        return $section_end;
	
	}

endif;

/*****************************************************************/
/* SECTION EDGE SVG STYLE (TOP) */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_section_start' ) ) : 

	function hannah_cd_section_start( $section_start = '' ) {
        
        $section_edge = ACF_GF('section_edge');
        
        // change the section edge top style for sections with background color or image
        
        $svg_triangle = 'M498.92,5.92l-499,32.5V.39h499Z';
        $svg_rounded = 'M498.92,5.92s-96.54,15.23-251.5,24c-194.5,11-247.5,8.5-247.5,8.5V.39h499Z';
        
        if( $section_edge == 'shape_1' ) {       
            // Triangle descending
            $svg_path = $svg_triangle;
            $svg_transform = 'none';
        } elseif( $section_edge == 'shape_2' ) {    
            // Triangle ascending      
            $svg_path = $svg_triangle;
            $svg_transform = 'scaleX(-1)';
        } elseif( $section_edge == 'shape_3' ) {     
            // Rounded descending    
            $svg_path = $svg_rounded;
            $svg_transform = 'none';
        } elseif( $section_edge == 'shape_4' ) {    
            // Rounded ascending    
            $svg_path = $svg_rounded;
            $svg_transform = 'scaleX(-1)';
        } else {
            return false;
        }
        
        echo '<svg class="section-edge-top" style="transform:' . $svg_transform . '" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 499 38.27" preserveAspectRatio="none"><path d="' . $svg_path . '" transform="translate(0.08 -0.39)" /></svg>';

        return $section_start;
	
	}

endif;


/*****************************************************************/
/* HEAD ICONS */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_head_icons' ) ) : 

	function hannah_cd_head_icons() { ?>

		<?php // CUSTOM FAV ICON

		$fav_icon = ACF_GF('custom_favicon', 'option');

		if( $fav_icon ) { ?>
			<link rel="shortcut icon" href="<?php echo esc_url( $fav_icon ); ?>">
		<?php } else { ?>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri() . '/img/favicon.ico'; ?>">
		<?php } ?>

		<?php // APPLE TOUCH ICONS 

			$app_icon = ACF_GF('apple_touch_icon', 'option');
			$app_icon_76 = ACF_GF('apple_touch_icon_76', 'option');
			$app_icon_120 = ACF_GF('apple_touch_icon_120', 'option');
			$app_icon_152 = ACF_GF('apple_touch_icon_152', 'option');
			$app_icon_180 = ACF_GF('apple_touch_icon_180', 'option');

		if( ACF_GF('apple_touch_icon_select', 'option') == 'one' ) : ?>
			<?php if( $app_icon ) { ?>
				<link rel="apple-touch-icon" href="<?php echo esc_url( $app_icon ); ?>">
			<?php } ?>
		<?php elseif( ACF_GF('apple_touch_icon_select', 'option') == 'more' ) : ?>
			<?php if( $app_icon_76 ) { ?>
				<link rel="apple-touch-icon" sizes="76x76" href="<?php echo esc_url( $app_icon_76 ); ?>">
			<?php } ?>
			<?php if( $app_icon_120 ) { ?>
				<link rel="apple-touch-icon" sizes="120x120" href="<?php echo esc_url( $app_icon_120 ); ?>">
			<?php } ?>
			<?php if( $app_icon_152 ) { ?>
				<link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url( $app_icon_152 ); ?>">
			<?php } ?>
			<?php if( $app_icon_180 ) { ?>
				<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( $app_icon_180 ); ?>">
			<?php } ?>
		<?php endif; ?>

	<?php }

endif;

add_action('wp_head', 'hannah_cd_head_icons');


/*****************************************************************/
/* MASONRY COLUMN SWITCH */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_masonry_switch' ) ) : 

	function hannah_cd_masonry_switch() {

		wp_enqueue_style('masonry-style', get_template_directory_uri() . '/css/custom-styles.css');

		$mry_specific_2 = ACF_GF('masonry_specific_custom_column') == 'masonry_spec_colnum_2';
		$mry_specific_3 = ACF_GF('masonry_specific_custom_column') == 'masonry_spec_colnum_3';
		$mry_specific_4 = ACF_GF('masonry_specific_custom_column') == 'masonry_spec_colnum_4';

		global $hannah_cd_masonry_css;

		if( $mry_specific_2 ) :
			$hannah_cd_masonry_css = "
				@media (min-width: 768px) {
					/* masonry */
					#masonry-layout-filter .grid .grid-sizer, 
					#masonry-layout-filter .grid .grid-item {width:100%}
					#masonry-layout-filter .grid .gutter-sizer {width:0%}
					
					/* grid */
					#masonry-layout-filter .grid.post-grid .grid-sizer, 
					#masonry-layout-filter .grid.post-grid .grid-item {width:100%}
					#masonry-layout-filter .grid.post-grid .grid-item {border-right:0px}
				}
				@media (min-width: 992px) {
					/* masonry */
					#masonry-layout-filter .grid .grid-sizer, 
					#masonry-layout-filter .grid .grid-item {width:47.5%}
					#masonry-layout-filter .grid .gutter-sizer {width:5%}
					
					/* grid */
					#masonry-layout-filter .grid.post-grid .grid-sizer, 
					#masonry-layout-filter .grid.post-grid .grid-item {width:50%}
					#masonry-layout-filter .grid.post-grid .grid-item:nth-child(2n-1) {border-right:1px solid #eee}
					#masonry-layout-filter .grid.post-grid .grid-item:nth-last-of-type(1), 
					#masonry-layout-filter .grid.post-grid .grid-item:nth-last-of-type(2) {border-bottom:0px}
				}
			";
		elseif( $mry_specific_3 ) :
			$hannah_cd_masonry_css = "
				@media (min-width: 768px) {
					/* masonry */
					#masonry-layout-filter .grid .grid-sizer, 
					#masonry-layout-filter .grid .grid-item {width:100%}
					#masonry-layout-filter .grid .gutter-sizer {width:0%}
					
					/* grid */
					#masonry-layout-filter .grid.post-grid .grid-sizer, 
					#masonry-layout-filter .grid.post-grid .grid-item {width:100%}
					#masonry-layout-filter .grid.post-grid .grid-item {border-right:0px}
				}
				@media (min-width: 992px) {
					/* masonry */
					#masonry-layout-filter .grid .grid-sizer, 
					#masonry-layout-filter .grid .grid-item {width:30%}
					#masonry-layout-filter .grid .gutter-sizer {width:5%}
        
                    /* masonry -> allow only 2 columns with sidebar */
                    #masonry-layout-filter .has-sidebar .grid .grid-sizer, 
                    #masonry-layout-filter .has-sidebar .grid .grid-item {width:47.5%}
                    #masonry-layout-filter .has-sidebar .grid .gutter-sizer {width:5%}
        
					/* grid */
					#masonry-layout-filter .grid.post-grid .grid-sizer, 
					#masonry-layout-filter .grid.post-grid .grid-item {width:33.33333%}
					#masonry-layout-filter .grid.post-grid .grid-item:nth-child(3n-2), 
					#masonry-layout-filter .grid.post-grid .grid-item:nth-child(3n-1) {border-right:1px solid #eee}
					#masonry-layout-filter .grid.post-grid .grid-item:nth-last-of-type(1), 
					#masonry-layout-filter .grid.post-grid .grid-item:nth-last-of-type(2), 
					#masonry-layout-filter .grid.post-grid .grid-item:nth-last-of-type(3) {border-bottom:0px}
				}
			";
		elseif( $mry_specific_4 ) :
			$hannah_cd_masonry_css = "
				@media (min-width: 768px) {
					/* masonry */
					#masonry-layout-filter .grid .grid-sizer, 
					#masonry-layout-filter .grid .grid-item {width:100%}
					#masonry-layout-filter .grid .gutter-sizer {width:0%}
					
					/* grid */
					#masonry-layout-filter .grid.post-grid .grid-sizer, 
					#masonry-layout .grid.post-grid .grid-item {width:100%}
					#masonry-layout-filter .grid.post-grid .grid-item {border-right:0px}
				}
				@media (min-width: 992px) {
					/* masonry */
					#masonry-layout-filter .grid .grid-sizer, 
					#masonry-layout-filter .grid .grid-item {width:30%}
					#masonry-layout-filter .grid .gutter-sizer {width:5%}
        
                    /* masonry -> allow only 2 columns with sidebar */
                    #masonry-layout-filter .has-sidebar .grid .grid-sizer, 
                    #masonry-layout-filter .has-sidebar .grid .grid-item {width:47.5%}
                    #masonry-layout-filter .has-sidebar .grid .gutter-sizer {width:5%}
        
					/* grid */
					#masonry-layout-filter .grid.post-grid .grid-sizer, 
					#masonry-layout-filter .grid.post-grid .grid-item {width:33.33333%}
					#masonry-layout-filter .grid.post-grid .grid-item:nth-child(3n-2), 
					#masonry-layout-filter .grid.post-grid .grid-item:nth-child(3n-1) {border-right:1px solid #eee}
					#masonry-layout-filter .grid.post-grid .grid-item:nth-last-of-type(1), 
					#masonry-layout-filter .grid.post-grid .grid-item:nth-last-of-type(2), 
					#masonry-layout-filter .grid.post-grid .grid-item:nth-last-of-type(3) {border-bottom:0px}
				}
				@media (min-width: 1200px) {
					/* masonry */
					#masonry-layout-filter .grid .grid-sizer, 
					#masonry-layout-filter .grid .grid-item {width:23%}
					#masonry-layout-filter .grid .gutter-sizer {width:2.6666%}
		
					/* grid */
					#masonry-layout-filter .grid.post-grid .grid-sizer, 
					#masonry-layout-filter .grid.post-grid .grid-item {width:25%}
					#masonry-layout-filter .grid.post-grid .grid-item:nth-child(4n-1),
					#masonry-layout-filter .grid.post-grid .grid-item:nth-child(4n-2),
					#masonry-layout-filter .grid.post-grid .grid-item:nth-child(4n-3) {border-right:1px solid #eee}
					#masonry-layout-filter .grid.post-grid .grid-item:nth-child(4n) {border-right:0px}
					#masonry-layout-filter .grid.post-grid .grid-item:nth-last-of-type(1), 
					#masonry-layout-filter .grid.post-grid .grid-item:nth-last-of-type(2), 
					#masonry-layout-filter .grid.post-grid .grid-item:nth-last-of-type(3), 
					#masonry-layout-filter .grid.post-grid .grid-item:nth-last-of-type(4) {border-bottom:0px}
				}
			";
		endif;

		wp_add_inline_style( 'masonry-style', $hannah_cd_masonry_css );
		
		// show the first element in double width
		
		$mry_specific_double_width = ACF_GF('masonry_specific_double_width');

		global $hannah_cd_masonry_css2;
		
		if( $mry_specific_3 && $mry_specific_double_width ) :
			$hannah_cd_masonry_css2 = "
				@media (min-width: 992px) {
					#masonry-layout-filter .grid-item--width2 {width:65%!important}
				}
			";
		elseif( $mry_specific_4 && $mry_specific_double_width) :
			$hannah_cd_masonry_css2 = "
				@media (min-width: 992px) {
					#masonry-layout-filter .grid-item--width2 {width:65%!important}
				}
				@media (min-width: 1200px) {
					#masonry-layout-filter .grid-item--width2 {width:48%!important}
				}
			";
		endif;
		
		wp_add_inline_style( 'masonry-style', $hannah_cd_masonry_css2 );
		
	}

	add_action( 'wp_enqueue_scripts', 'hannah_cd_masonry_switch' );

 endif;
	 
 
/*****************************************************************/
/* TRACKING POST VIEWS FOR TRENDING POSTS */
/*****************************************************************/
 
// detect post views count and store it as a custom field for each post
function hannah_cd_trend_set_post_views( $postID ) {
	
    $days = get_post_meta( $postID, 'trend_post_views_count_days', true);
	$today = date('Ymd');
    
	// update today's counter
    $days[$today] = isset( $days[$today] ) ? (int)$days[$today] + 1 : 1;
	
	if( ! is_array($days) ) {
		$days = array();
	} 
	
    update_post_meta( $postID, 'trend_post_views_count_days', $days );
    update_post_meta( $postID, 'trend_post_views_count', array_sum( $days ) );
	
}

remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

function hannah_cd_trend_track_post_views ( $post_id ) {
	
    if ( ! is_singular( 'post' ) ) { 
		return;
	}
	
    if ( empty( $post_id ) ) {
        $post_id = $GLOBALS['post']->ID;
    	hannah_cd_trend_set_post_views( $post_id );
	}
	
}

add_action( 'wp_head', 'hannah_cd_trend_track_post_views' );
add_action( 'init', 'hannah_cd_trend_schedule_daily_cleanup' );

function hannah_cd_trend_schedule_daily_cleanup() {
	
    //check if event scheduled before
    if( ! wp_next_scheduled('trend_daily_cleanup_cronjob')) {
        //shedule event to run after every day
        wp_schedule_event( time(), 'daily', 'trend_daily_cleanup_cronjob' );
	}
	
}  

function hannah_cd_trend_daily_cleanup() {
	
	// get all published posts ids
	$posts = new WP_Query( array('posts_per_page' => -1, 'fields' => 'ids') );

	// date 30 days ago
	$clean_from_date = date('Ymd', strtotime('-' . $days . ' days'));

	// for every post delete old counters
	foreach ( $posts->posts as $postID ) {
		$days = get_post_meta( $postID, 'trend_post_views_count_days', true );
		if(!empty($days)) {
			foreach($days as $date => $views) {
				if($date < $clean_from_date) {
					unset($days[$date]);
					update_post_meta( $postID, 'trend_post_views_count_days', $days );
					update_post_meta( $postID, 'trend_post_views_count', array_sum( $days ) );
				}
			}
		}
	}

}

add_action( 'trend_daily_cleanup_cronjob', 'hannah_cd_trend_daily_cleanup' );


/*****************************************************************/
/* CUSTOM POST PROTECT FORM */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_password_form' ) ) :

	function hannah_cd_password_form() {
		
		global $post;
		
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		
		$passform = '<form class="post-password-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">';
			$passform .= '<p>' . esc_html__( 'This content is password protected. To view it please enter your password below.', 'hannah-cd') . '</p>';
			$passform .= '<label class="pass-label" for="' . esc_html( $label ) . '">' . esc_html__( 'Password', 'hannah-cd' ) . ':</label>';
			$passform .= '<div><input name="post_password" id="' . esc_html( $label ) . '" type="password" size="20" /></div>';
			$passform .= '<div><input type="submit" name="Submit" class="button" value="' . esc_attr__( 'Enter', 'hannah-cd' ) . '" /></div>';
		$passform .= '</form>';
		
		return $passform;
		
	}

endif; 

add_filter( 'the_password_form', 'hannah_cd_password_form' );


/*****************************************************************/
/* ADD TAG TO WP CATEGORY WIDGET */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_category_widget' ) ) :

	// set post count into a span
	function hannah_cd_category_widget( $tag ) {
		
	  	$tag = str_replace('</a> (', '</a> <span>', $tag);
	  	$tag = str_replace(')', '</span>', $tag);
	  	
		return $tag;
		
	}

endif; 

add_filter('wp_list_categories', 'hannah_cd_category_widget');


/*****************************************************************/
/* ADD TAG TO WP ARCHIVE WIDGET */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_archive_widget' ) ) :

	// set post count into a span
	function hannah_cd_archive_widget( $tag ) {
		
	  	$tag = str_replace('</a>&nbsp;(', '</a> <span>', $tag);
	  	$tag = str_replace(')', '</span>', $tag);
	  	
		return $tag;
		
	}

endif; 

add_filter('get_archives_link', 'hannah_cd_archive_widget');


/*****************************************************************/
/* GET THE CATEGORIES */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_get_categories' ) ) :

	function hannah_cd_get_categories( $post_id ) {
		
	  	if( get_post_type() == 'product' ) {
            $categories = get_the_terms( $post_id, 'product_cat' );
        } elseif( get_post_type() == 'post' ) {
            $categories = get_the_category();
        } else {
            // nothing
        }
        
        $cat_item_count = 0;
        
        if( ! empty( $categories ) ) { ?>
            <div class="blog-list-cat">
                <?php foreach( $categories as $cat ) {                    
                    if( get_post_type() == 'product' ) {
                        $category_link = $cat->slug;
                        $category_name = $cat->name;
                    } elseif( get_post_type() == 'post' ) {
                        $category_link = get_category_link( $cat->term_id );
                        $category_name = $cat->name;
                    } else {
                        // nothing
                    }
            
                    echo '<a href="' . esc_url( $category_link ) . '">' . esc_html( $category_name ) . '</a>';
            
                    $cat_item_count+=1;            
                    if( $cat_item_count == 3 ) break; // limit categories to 3 items
                } ?>
            </div>
        <?php } 
		
	}

endif;


/*****************************************************************/
/* GET THE TAGS */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_get_tags' ) ) :

	function hannah_cd_get_tags( $post_id ) {
		
	  	if( get_post_type() == 'product' ) {
            $tags = get_the_terms( $post_id, 'product_tag' );
        } elseif( get_post_type() == 'post' ) {
            $tags = get_the_tags();
        } else {
            // nothing
        }
        
        $tag_item_count = 0;

        if( ! empty( $tags ) ) { ?>
            <div class="blog-list-tag">
                <?php foreach( $tags as $tag ) {                        
                    if( get_post_type() == 'product' ) {
                        $tag_link = $tag->slug;
                        $tag_name = $tag->name;
                    } elseif( get_post_type() == 'post' ) {
                        $tag_link = get_tag_link( $tag->term_id );
                        $tag_name = $tag->name;
                    } else {
                        // nothing
                    }

                    echo '<a href="' . esc_url( $tag_link ) . '">' . esc_html( $tag_name ) . '</a>';
            
                    $tag_item_count+=1;            
                    if( $tag_item_count == 3 ) break; // limit tags to 3 items
                } ?>
            </div>
        <?php } 
		
	}

endif;


/*****************************************************************/
/* SHOW WP-SITE AS UNDER CONSTRUCTION */
/*****************************************************************/ 

if ( ! function_exists( 'hannah_cd_under_construction' ) ) :

	$hannah_cd_under_construction = ACF_GF('under_construction_show', 'option') || isset( $_GET['coming-soon'] );

	if( $hannah_cd_under_construction ) {

		function hannah_cd_under_construction() {

			$front = is_front_page() || is_home();

			if( ! current_user_can('edit_themes') || ! is_user_logged_in() ) {
				
				global $hannah_cd_under_construction;
				
				if( $hannah_cd_under_construction == true || $front == true ) {
					
					// show the under construction template

					function under_construction() {

						return get_template_directory() . '/page-under-construction.php';

					}

					add_filter( 'template_include', 'under_construction' );

				} else {

					// redirect all pages to front page

					function not_front_page_redirect() {

						wp_safe_redirect( home_url() );
						exit();

					}

					add_action( 'template_redirect', 'not_front_page_redirect' );

				}

			}

		}

		add_action('wp', 'hannah_cd_under_construction');

	}
		
endif; 


/*****************************************************************/
/* FORMATING COUNTS */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_format_count' ) ) :

	function hannah_cd_format_count( $n ) {
			
			if ( is_numeric($n) ) {
				// strip any formatting
				$n = ( 0 + str_replace( ",", "", $n ) );

				// check it's a number?
				if ( ! is_numeric( $n ) ) return false;

				// filter the number
				if ( $n > 1000000000 ) return round( ( $n / 1000000000 ), 2 ).' B';
				elseif ( $n > 1000000 ) return round( ( $n / 1000000 ), 2 ).' M';
				elseif ( $n > 1000 ) return round( ( $n / 1000 ), 2 ).' K';

				return number_format( $n );
			} else {
				return 'n/a';
			}
			
		}

endif;


/*****************************************************************/
/* ADD CUSTOM CODE TO WP HEAD */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_add_code_to_wphead' ) ) :

    function hannah_cd_add_code_to_wphead() {
        echo ACF_GF('header_code', 'option');
    }

    add_action( 'wp_head', 'hannah_cd_add_code_to_wphead' );

endif;


/*****************************************************************/
/* ADD CUSTOM CODE TO WP FOOTER */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_add_code_to_wpfooter' ) ) :

    function hannah_cd_add_code_to_wpfooter() {
        echo ACF_GF('footer_code', 'option');
    }

    add_action( 'wp_footer', 'hannah_cd_add_code_to_wpfooter', 999 );

endif;


/*****************************************************************/
/* THEME SUPPORT INFO */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_theme_support' ) ) :

    function hannah_cd_theme_support() {
        
        if( ACF_GF('mode_custom_fields_json', 'option') ) { 
            $theme_mode = 'Developer'; 
        } else { 
            $theme_mode = 'User'; 
        } 
        
        echo 'Theme support: ' . HANNAH_CD_THEME . ' | Version: ' . HANNAH_CD_VER . ' | Installed: ' . HANNAH_CD_THEME_ACTIVE . ' | Mode: ' . $theme_mode . ' | WP: ' . HANNAH_CD_THEME_WP . ' (' . HANNAH_CD_THEME_PHP . ')';
    }

endif;


/*****************************************************************/
/* WOOCOMMERCE */
/*****************************************************************/

if ( class_exists( 'WooCommerce' ) ) :

	/*****************************************************************/
	/* WOOCOMMERCE REMOVE DEFAULT BREADCRUMB */
	/*****************************************************************/
	
	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
	
	
	/*****************************************************************/
	/* WOOCOMMERCE CUSTOMIZE BREADCRUMB */
	/*****************************************************************/
	
	if ( ! function_exists( 'hannah_cd_woo_breadcrumb' ) ) :
	
		function hannah_cd_woo_breadcrumb() {
			return array(
				'delimiter'   => '',
				'wrap_before' => '<div class="container crumb"><ol class="breadcrumb">',
				'wrap_after'  => '</ol></div>',
				'before'      => '<li itemtype="http://data-vocabulary.org/Breadcrumb">',
				'after'       => '</li>',
				'home'        => _x( 'Home', 'breadcrumb', 'hannah-cd' ),
			);
		}

		add_filter( 'woocommerce_breadcrumb_defaults', 'hannah_cd_woo_breadcrumb' );
	
	endif;
	

	/*****************************************************************/
	/* WOOCOMMERCE OUTPUT SHOPPING CART ICON WITH COUNT + SUBTOTAL */
	/*****************************************************************/

	if ( ! function_exists( 'hannah_cd_woo_cart_icon' ) ) :

		function hannah_cd_woo_cart_icon() {

			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
				?>

				<a class="cart-contents" href="<?php echo esc_url(WC()->cart->get_cart_url()); ?>">
					<?php /*<span class="cart-contents-total"><?php echo WC()->cart->get_cart_total(); ?></span>*/ ?>
                    <i class="fa fa-shopping-bag"></i>
					<span class="cart-contents-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
				</a>

			<?php }

		}

	endif; 

	add_action( 'wc_shopping_cart_icon', 'hannah_cd_woo_cart_icon' );


	/*****************************************************************/
	/* WOOCOMMERCE REFRESH MINI-CART ITEMS */
	/*****************************************************************/

	if( ! function_exists( 'hannah_cd_woo_update_cart_data' ) ) :

		function hannah_cd_woo_update_cart_data( $array ) {

			ob_start();
			hannah_cd_woo_update_cart_count();
			$count = ob_get_clean();

			ob_start();
			hannah_cd_woo_update_cart_subtotal();
			$subtotal = ob_get_clean();

			$array['.cart-contents .cart-contents-count'] = $count;
			$array['.cart-contents .cart-contents-total'] = $subtotal;

			return $array;

		}

		add_filter('woocommerce_add_to_cart_fragments', 'hannah_cd_woo_update_cart_data', 30);

	endif;

	// update cart items count from global cart icon

	if( ! function_exists( 'hannah_cd_woo_update_cart_count' ) ) :

		function hannah_cd_woo_update_cart_count() {
			?>
				<span class="cart-contents-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
			<?php
		}

	endif;

	// update cart items aubtotal from global cart icon

	if( ! function_exists( 'hannah_cd_woo_update_cart_subtotal' ) ) :

		function hannah_cd_woo_update_cart_subtotal() {
			?>
				<span class="cart-contents-total"><?php echo WC()->cart->get_cart_total(); ?></span>
			<?php
		}

	endif;


	/*****************************************************************/
	/* WOOCOMMERCE SHOW MINI-CART ON EACH SITE */
	/*****************************************************************/

	if ( ! function_exists( 'hannah_cd_woo_show_mini_cart_always' ) ) :

		function hannah_cd_woo_show_mini_cart_always() { 
			return false; 
		}

		add_filter( 'woocommerce_widget_cart_is_hidden', 'hannah_cd_woo_show_mini_cart_always', 10, 1 );

	endif;


	/*****************************************************************/
	/* WOOCOMMERCE AJAX ADD TO CART */
	/*****************************************************************/

	if( ! function_exists( 'hannah_cd_woo_add_to_cart_single_product_ajax' ) ) :

		function hannah_cd_woo_add_to_cart_single_product_ajax() {

			//global $woocommerce;
			//wp_localize_script('hannah_cd_main', 'woo_cart_ajax_data', array('cart_url' => $woocommerce->cart->get_cart_url())); // woo ajax script
            wp_localize_script('hannah_cd_main', 'woo_cart_ajax_data', array('cart_url' => wc_get_cart_url())); // woo ajax script

		}

		add_action( 'wp_head', 'hannah_cd_woo_add_to_cart_single_product_ajax' );

	endif; 


	/*****************************************************************/
	/* WOOCOMMERCE REMOVE PRODUCT FROM CART */
	/*****************************************************************/

	if ( ! function_exists('hannah_cd_woo_mini_cart_product_remove')) :

		function hannah_cd_woo_mini_cart_product_remove() {

			global $wpdb, $woocommerce;

			$id = 0; 
			$variation_id = 0;

			if ( ! empty( $_REQUEST['product_id'] ) ) {
				$id = $_REQUEST['product_id'];
			}

			if ( ! empty( $_REQUEST['variation_id'] ) ) {
				$variation_id = $_REQUEST['variation_id'];
			}

			$cart = $woocommerce->cart;

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

				if ( ($cart_item['product_id'] == $id && $variation_id <= 0) || ($cart_item['variation_id'] == $variation_id && $variation_id > 0 ) ) {
					$cart->set_quantity($cart_item_key,0);	
				}           

			}

			if ( $woocommerce->tax_display_cart == 'excl' ) {
				$totalamount = wc_price($woocommerce->cart->get_total());
			} else {
				$totalamount = wc_price($woocommerce->cart->cart_contents_total + $woocommerce->cart->tax_total);
			} 	

			echo $totalamount;

			die();
		}

		add_action( 'wp_ajax_tdl_cart_product_remove', 'hannah_cd_woo_mini_cart_product_remove' );
		add_action( 'wp_ajax_nopriv_tdl_cart_product_remove', 'hannah_cd_woo_mini_cart_product_remove' );

	endif; 


	/*****************************************************************/
	/* WOOCOMMERCE PRODUCT COLUMNS */
	/*****************************************************************/

	if ( ! function_exists('hannah_cd_woo_product_columns')) :

		function hannah_cd_woo_product_columns() {

			$woo_column_count = ACF_GF('woocommerce_product_page_column', 'option');
			
			if( $woo_column_count == 'col_2' ) {
				return 2; // 2 columns
			} elseif( $woo_column_count == 'col_4' ) {
				return 4; // 4 columns
			} else {
				return 3; // default are 3 columns
			}

		}

		add_filter('loop_shop_columns', 'hannah_cd_woo_product_columns', 999);

	endif; 


	/*****************************************************************/
	/* WOOCOMMERCE CUSTOMIZE PRODUCTS PER PAGE */
	/*****************************************************************/

	if ( ! function_exists('hannah_cd_woo_products_per_page')) :

		$hannah_cd_woo_product_count = ACF_GF('woocommerce_products_per_page', 'option');

		function hannah_cd_woo_products_per_page( $cols ){

			global $hannah_cd_woo_product_count;
			
			if( $hannah_cd_woo_product_count ) {
				// customized products per page
				return $hannah_cd_woo_product_count;
			} else {
				// default products per page
				return 9;
			}

		}

		add_filter( 'loop_shop_per_page', 'hannah_cd_woo_products_per_page', 20 );

	endif; 


	/*****************************************************************/
	/* WOOCOMMERCE DISABLE DEFAULT SORTING DROPDOWN */
	/*****************************************************************/

	if( ACF_GF('disable_woocommerce_sorting', 'option') ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );	
	}

	
	/*****************************************************************/
	/* WOOCOMMERCE REMOVE SHOP PAGE TITLE FROM MAIN PAGE AND CATEGORYS PAGE */
	/*****************************************************************/

	if ( ! function_exists('hannah_cd_woo_remove_page_title_all')) :

		// the title will displayed at woocommerce.php instead
		
		function hannah_cd_woo_remove_page_title_all() {
			return false;
		}

		add_filter( 'woocommerce_show_page_title' , 'hannah_cd_woo_remove_page_title_all' );
		
	endif;


	/*****************************************************************/
	/* WOOCOMMERCE CHANGE CATEGORY PRODUCT TITLE FROM H2 TO H3 */
	/*****************************************************************/
	
	if ( ! function_exists( 'hannah_cd_woo_product_loop_title' ) ) :
		
		if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {
			function woocommerce_template_loop_product_title() {
				$tag = apply_filters( 'woocommerce_template_loop_product_title_tag', 'h3' );
				echo '<' . tag_escape( $tag ) . ' class="woocommerce-loop-product__title">' . get_the_title() . '</' . tag_escape( $tag ) . '>';
			}
		}
		
		function hannah_cd_woo_product_loop_title( $tag ) {
			if ( is_product_taxonomy() || is_shop() ) {
				$tag = 'h3';
			}
			return $tag;
		}
		
		add_filter( 'woocommerce_template_loop_product_title_tag', 'hannah_cd_woo_product_loop_title' );
		
	endif;	


	/*****************************************************************/
	/* WOOCOMMERCE RELATED PRODUCTS */
	/*****************************************************************/

	if ( ! function_exists('hannah_cd_woo_related_products')) :

		function hannah_cd_woo_related_products( $args ) {

			$related_products_count = ACF_GF('woocommerce_related_products_count', 'option');
			$related_products_column = ACF_GF('woocommerce_related_products_column', 'option');
			
			if( $related_products_count ) {
				$p_count = $related_products_count; // customized
			} else {
				$p_count = '3'; // default
			}
			
			if( $related_products_column == 'col_2' ) {
				$p_column = '2'; // 2 columns
			} elseif( $related_products_column == 'col_4' ) {
				$p_column = '4'; // 4 columns
			} else {
				$p_column = '3'; // default are 3 columns
			}
			
			$args['posts_per_page'] = $p_count; // count of related products per page
			$args['columns'] = $p_column; // count of columns
			return $args;

		}

		add_filter( 'woocommerce_output_related_products_args', 'hannah_cd_woo_related_products' );

	endif; 


	/*****************************************************************/
	/* WOOCOMMERCE REMOVE RELATED PRODUCTS */
	/*****************************************************************/

	if( ACF_GF('remove_woocommerce_related_products', 'option') ) {
		
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

	}


	/*****************************************************************/
	/* WOOCOMMERCE CATEGORY WIDGET SHOW ONLY THE COUNT WITHOUT ANYTHING */
	/*****************************************************************/

	if ( ! function_exists('hannah_cd_woo_cat_count') ) :

		function hannah_cd_woo_cat_count( $cat_count ) {
			$cat_count = str_replace('(', '', $cat_count);
			$cat_count = str_replace(')', '', $cat_count);
			return $cat_count;
		}

		add_filter('wp_list_categories', 'hannah_cd_woo_cat_count');

	endif;


	/*****************************************************************/
	/* WOOCOMMERCE CUSTOMIZE PAGINATION */
	/*****************************************************************/

	if ( ! function_exists('hannah_cd_woo_pagination') ) :

		function hannah_cd_woo_pagination() {
			return hannah_cd_pagination();
		}

		// Remove default WooCoomerce pagination
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

		// Add new pagination
		add_action( 'woocommerce_after_shop_loop', 'hannah_cd_woo_pagination', 10 );

	endif;

endif;

 
