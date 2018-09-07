<?php

/*****************************************************************/
/* ADD MENU POSITIONS */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_theme_menu_locations' ) ) :

	function hannah_cd_theme_menu_locations() {
	
		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary_menu' 	=> esc_html__( 'Primary Menu', 'hannah-cd' ),
			'top_menu' 		=> esc_html__( 'Top Menu', 'hannah-cd' ),
			'footer_menu'	=> esc_html__( 'Footer Menu', 'hannah-cd' ),
		) );
	
	}

endif; 

add_action( 'init', 'hannah_cd_theme_menu_locations' );


/*****************************************************************/
/* REGISTER ACF ADMIN MENU */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_admin_setup' ) ) :

	function hannah_cd_admin_setup() {

		if( function_exists('acf_add_options_sub_page') ) {
		
			acf_add_options_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ),
				'menu_slug'   	=> 'theme-general-settings',
				'capability'	=> 'edit_theme_options',
				'post_id'		=> 'options',
				'redirect' 		=> true,
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'General', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'General', 'hannah-cd' ),
				'menu_slug'     => 'theme-general',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Design & Colors', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Design & Colors', 'hannah-cd' ),
				'menu_slug'     => 'theme-colors',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Blog List', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Blog List', 'hannah-cd' ),
				'menu_slug'     => 'theme-blog-list',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Posts', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Posts', 'hannah-cd' ),
				'menu_slug'     => 'theme-posts',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Sidebars', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Sidebars', 'hannah-cd' ),
				'menu_slug'     => 'theme-sidebars',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Social', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Social', 'hannah-cd' ),
				'menu_slug'     => 'theme-social',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Web Fonts', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Web Fonts', 'hannah-cd' ),
				'menu_slug'     => 'web-fonts',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Top Layer', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Top Layer', 'hannah-cd' ),
				'menu_slug'     => 'theme-top-layer',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Topbar', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Topbar', 'hannah-cd' ),
				'menu_slug'     => 'theme-topbar',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Leading Area', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Leading Area', 'hannah-cd' ),
				'menu_slug'     => 'theme-leading-area',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Header', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Header', 'hannah-cd' ),
				'menu_slug'     => 'theme-header',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Featured Slider', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Featured Slider', 'hannah-cd' ),
				'menu_slug'     => 'theme-featured-slider',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Ending Area', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Ending Area', 'hannah-cd' ),
				'menu_slug'     => 'theme-ending-area',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Footer', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Footer', 'hannah-cd' ),
				'menu_slug'     => 'theme-footer',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'PopUp Layer', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'PopUp Layer', 'hannah-cd' ),
				'menu_slug'     => 'theme-popup',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Exit PopUp', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Exit PopUp', 'hannah-cd' ),
				'menu_slug'     => 'theme-exit-popup',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'EU Cookiebar', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'EU Cookiebar', 'hannah-cd' ),
				'menu_slug'     => 'theme-cookiebar',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Google Maps', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Google Maps', 'hannah-cd' ),
				'menu_slug'     => 'theme-google-maps',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'Coming Soon Page', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( 'Coming Soon', 'hannah-cd' ),
				'menu_slug'     => 'theme-coming-soon',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			acf_add_options_sub_page(array(
				'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( '404 Page', 'hannah-cd' ),
				'menu_title'  	=> esc_html__( '404 Page', 'hannah-cd' ),
				'menu_slug'     => 'theme-404',
				'parent_slug' 	=> 'theme-general-settings',
				'capability'  	=> 'edit_theme_options',
				'post_id'		=> 'options',
			));
		
			if ( class_exists( 'WooCommerce' ) ) :
				acf_add_options_sub_page(array(
					'page_title'  	=> esc_html__( 'Theme Settings', 'hannah-cd' ) . ' - ' . esc_html__( 'WooCommerce', 'hannah-cd' ),
					'menu_title'  	=> esc_html__( 'WooCommerce', 'hannah-cd' ),
					'menu_slug'     => 'theme-woocommerce',
					'parent_slug' 	=> 'theme-general-settings',
					'capability'  	=> 'edit_theme_options',
					'post_id'		=> 'options',
				));
			endif;
		
		}

    }

endif;

add_action( 'admin_menu', 'hannah_cd_admin_setup', 98 );
	

/*****************************************************************/
/* REGISTER WIDGET AREA */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_widgets_include' ) ) :

	function hannah_cd_widgets_include() {
	
		// sidebar widgets

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'hannah-cd' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your left or right content sidebar.', 'hannah-cd' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget-title">',
			'after_title'   => '</div>',
		));  
	
		// full width footerbar top widgets

		register_sidebar( array(
			'name'          => esc_html__( 'Footerbar', 'hannah-cd' ) . ' - ' . esc_html__( 'Full-Size', 'hannah-cd' ) . ' (' . esc_html__( 'top', 'hannah-cd' ) . ')',
			'id'            => 'instagram-bar-top',
			'description'   => esc_html__( 'Add widgets here to appear in your full-size footerbar. E.g. It is useful for a full size instagram or pinterest widget.', 'hannah-cd' ),
			'before_widget' => '<aside id="%1$s" class="widget-footer %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget-title">',
			'after_title'   => '</div>',
		));
        
        if( ACF_GF('footer_sidebar_column', 'option') == 'col_1' ) {
            $footer_widget_area_1 = true;
            $footer_widget_area_2 = false; 
            $footer_widget_area_3 = false; 
            $footer_widget_area_4 = false;
        } elseif( ACF_GF('footer_sidebar_column', 'option') == 'col_2' ) {
            $footer_widget_area_1 = true;
            $footer_widget_area_2 = true; 
            $footer_widget_area_3 = false; 
            $footer_widget_area_4 = false;
        } elseif( ACF_GF('footer_sidebar_column', 'option') == 'col_4' ) {
            $footer_widget_area_1 = true;
            $footer_widget_area_2 = true; 
            $footer_widget_area_3 = true; 
            $footer_widget_area_4 = true;
        } else {
            $footer_widget_area_1 = true;
            $footer_widget_area_2 = true; 
            $footer_widget_area_3 = true; 
            $footer_widget_area_4 = false;
        }    
        
        // footer sidebar 1 widgets
        
        if( $footer_widget_area_1 ) {

            register_sidebar( array(
                'name'          => esc_html__( 'Footer Sidebar', 'hannah-cd' ) . ' - ' . esc_html__( 'Column', 'hannah-cd' ) . ' 1',
                'id'            => 'sidebar-left',
                'description'   => esc_html__( 'Add widgets here to appear in the footer sidebar.', 'hannah-cd' ),
                'before_widget' => '<aside id="%1$s" class="widget-footer %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<div class="widget-title">',
                'after_title'   => '</div>',
            ));
            
        }
	
		// footer sidebar 2 widgets
        
        if( $footer_widget_area_1 && $footer_widget_area_2 ) {

            register_sidebar( array(
                'name'          => esc_html__( 'Footer Sidebar', 'hannah-cd' ) . ' - ' . esc_html__( 'Column', 'hannah-cd' ) . ' 2',
                'id'            => 'sidebar-middle',
                'description'   => esc_html__( 'Add widgets here to appear in the footer sidebar.', 'hannah-cd' ),
                'before_widget' => '<aside id="%1$s" class="widget-footer %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<div class="widget-title">',
                'after_title'   => '</div>',
            ));
            
        }
	
		// footer sidebar 3 widgets
        
        if( $footer_widget_area_1 && $footer_widget_area_2 && $footer_widget_area_3 ) {

            register_sidebar( array(
                'name'          => esc_html__( 'Footer Sidebar', 'hannah-cd' ) . ' - ' . esc_html__( 'Column', 'hannah-cd' ) . ' 3',
                'id'            => 'sidebar-right',
                'description'   => esc_html__( 'Add widgets here to appear in the footer sidebar.', 'hannah-cd' ),
                'before_widget' => '<aside id="%1$s" class="widget-footer %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<div class="widget-title">',
                'after_title'   => '</div>',
            ));
            
        }
	
		// footer sidebar 4 widgets
        
        if( $footer_widget_area_1 && $footer_widget_area_2 && $footer_widget_area_3 && $footer_widget_area_4 ) {

            register_sidebar( array(
                'name'          => esc_html__( 'Footer Sidebar', 'hannah-cd' ) . ' - ' . esc_html__( 'Column', 'hannah-cd' ) . ' 4',
                'id'            => 'sidebar-last',
                'description'   => esc_html__( 'Add widgets here to appear in the footer sidebar.', 'hannah-cd' ),
                'before_widget' => '<aside id="%1$s" class="widget-footer %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<div class="widget-title">',
                'after_title'   => '</div>',
            ));
            
        }
	
		// full width footerbar bottom widgets

		register_sidebar( array(
			'name'          => esc_html__( 'Footerbar', 'hannah-cd' ) . ' - ' . esc_html__( 'Full-Size', 'hannah-cd' ) . ' (' . esc_html__( 'bottom', 'hannah-cd' ) . ')',
			'id'            => 'instagram-bar',
			'description'   => esc_html__( 'Add widgets here to appear in your full-size footerbar. E.g. It is useful for a full size instagram or pinterest widget.', 'hannah-cd' ),
			'before_widget' => '<aside id="%1$s" class="widget-footer %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<div class="widget-title">',
			'after_title'   => '</div>',
		));
	
		// woocommerce sidebar widgets
		
		if ( class_exists( 'WooCommerce' ) ) :
			register_sidebar( array(
				'name'          => esc_html__( 'Woocommerce - Shop Sidebar', 'hannah-cd' ),
				'id'            => 'sidebar-shop',
				'description'   => esc_html__( 'Add your WooCommerce shop widgets here.', 'hannah-cd' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<div class="widget-title">',
				'after_title'   => '</div>',
			));
		endif;
		
	}

endif;

add_action( 'widgets_init', 'hannah_cd_widgets_include' );


/*****************************************************************/
/* REGISTER CUSTOM SIDEBARS */
/*****************************************************************/

if( ACF_GF('sidebars_show', 'option') ) :

	if ( ! function_exists( 'hannah_cd_custom_sidebars' ) ) :

		function hannah_cd_custom_sidebars() {

			if( ACF_HR('add_sidebars', 'option') ) { 
				$id_count = 1;
				while ( ACF_HR('add_sidebars', 'option') ) { the_row();
					
					$sidebars_label = ACF_GSF('sidebars_label', 'option');
					$sidebars_description = ACF_GSF('sidebars_description', 'option');										
															
					register_sidebar( array(
						'name'          => $sidebars_label,
						'id'            => 'custom-sb-' . $id_count,
						'description'   => $sidebars_description,
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<div class="widget-title">',
						'after_title'   => '</div>',
					));
					$id_count++;
				}
			}
		}

	endif;

	add_action( 'widgets_init', 'hannah_cd_custom_sidebars' );

endif;


/*****************************************************************/
/* ADD FAVICON TO WP ADMIN */
/*****************************************************************/

global $acf_favicon;

$acf_favicon = ACF_GF('custom_favicon', 'option');

if ( ! function_exists( 'hannah_cd_favicon' ) ) :

	function hannah_cd_favicon() {
		global $acf_favicon;
		
		if($acf_favicon) {
			echo '<link rel="shortcut icon" href="' . esc_url( $acf_favicon ) . '" />',"\n";
		} else {
			echo '<link rel="shortcut icon" href="' . get_template_directory_uri() . '/img/favicon.ico" />',"\n";
		}
	}

endif; 

add_action('admin_head', 'hannah_cd_favicon');


/*****************************************************************/
/* CUSTOM STYLE FOR ADMIN PAGE */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_custom_admin_style' ) ) :

	function hannah_cd_custom_admin_style() {
	  	echo '<style>
			.update-nag {
		  		display:block!important;
			}
			#post_views {
		  		width:63px;
			} 
			.acf-repeater .acf-row td {
				border-top: 2px solid #DFDFDF
			}
			.acf-repeater .acf-row:first-hild td {
				border-top: 0px
			}
			.acf-repeater .acf-row-handle.order {
				font-size: 30px
			}
            .acf-field-message .acf-label, .acf-field-message p {
				margin-bottom: 0px
			}
	  	</style>';
	}

endif; 

add_action('admin_head', 'hannah_cd_custom_admin_style');


/*****************************************************************/
/* ADD POSTVIEW COL TO WP ADMIN POSTS AND PAGES */
/*****************************************************************/

if( ! function_exists('hannah_cd_posts_column_views') ) :

	function hannah_cd_posts_column_views($defaults) {
		$defaults['post_views'] = esc_html__('Views', 'hannah-cd');
		return $defaults;
	}

endif;

add_filter('manage_posts_columns', 'hannah_cd_posts_column_views');
add_filter('manage_pages_columns', 'hannah_cd_posts_column_views');


if( ! function_exists('hannah_cd_posts_custom_column_views') ) :

	function hannah_cd_posts_custom_column_views($column_name, $id) {
		if($column_name === 'post_views'){
			echo hannah_cd_getPostViews(get_the_ID());
		}
	}

endif;

add_action('manage_posts_custom_column', 'hannah_cd_posts_custom_column_views', 5, 2);
add_action('manage_pages_custom_column', 'hannah_cd_posts_custom_column_views', 5, 2);


/*****************************************************************/
/* POPULAR POSTS DASHBOARD WIDGET */
/*****************************************************************/

// POPULAR POSTS DASHBOARD WIDGET --> AJAX JAVASCRIPT

if( ! function_exists('hannah_cd_top10_posts_ajax') ) :

    function hannah_cd_top10_posts_ajax() { ?>

        <script type="text/javascript">
            jQuery(document).ready(function($) {

                // post views
                data = {
                    'action': 'hannah_cd_top10_posts',
                    'meta_key': 'post_views_count',
                };

                $("#popular_types").change(function(){

                    $(this).find("option:selected").each(function(){
                        // post likes
                        if($(this).attr("value") == "likes"){
                            data = {
                                'action': 'hannah_cd_top10_posts',
                                'case': 'likes',
                            };
                        // post views
                        } else if($(this).attr("value") == "views"){
                            data = {
                                'action': 'hannah_cd_top10_posts',
                                'case': 'views',
                            };
                        // post ratings
                        } else if($(this).attr("value") == "rated"){
                            data = {
                                'action': 'hannah_cd_top10_posts',
                                'case': 'ratings',
                            };
                        // post comments
                        } else if($(this).attr("value") == "commented"){
                            data = {
                                'action': 'hannah_cd_top10_posts',
                                'case': 'comments'
                            };
                        }

                    });

                    jQuery.post(ajaxurl, data, function( data ) {
                        $( '.get-top10-results' ).html( data ); // get dynamic html by selected value
                    });

                }).change();

            });
        </script> 

    <?php }

endif;

add_action( 'admin_footer', 'hannah_cd_top10_posts_ajax' );


// POPULAR POSTS DASHBOARD WIDGET --> DYNAMIC AJAX CONTENT

if( ! function_exists('hannah_cd_top10_posts') ) :

    function hannah_cd_top10_posts() {

        $case = $_POST['case'];

        // get query meta key
        if( $case == 'views' ) {
            $meta_key = 'post_views_count';
        } elseif( $case == 'likes' ) {
            $meta_key = '_like_btn';
        } elseif( $case == 'ratings' ) {
            $meta_key = 'post_rating';
        } else {
            $meta_key = '';
        }

        // get query order by
        if( $case == 'views' ) {
            $order_by = 'meta_value_num';
        } elseif( $case == 'likes' ) {
            $order_by = 'meta_value_num';
        } elseif( $case == 'ratings' ) {
            $order_by = 'meta_value_num';
        } else {
            $order_by = 'comment_count';
        }

        $args = array(
            'post_type' => 'post',
            'meta_key' => $meta_key,
            'posts_per_page' => 10,
            'orderby' => $order_by,
        );                                      

        $wp_query_top = new WP_Query( $args );

        if ( $wp_query_top->have_posts() ) : ?>

            <div class="table listing">
                <table>
                    <tr>
                        <th colspan="2" style="text-align: left">
                            <?php esc_html_e( 'Post', 'hannah-cd' ); ?>
                        </th>
                        <th style="text-align:right">
                            <?php if( $case == 'views' ) {
                                esc_html_e( 'Views', 'hannah-cd' ); 
                            } elseif( $case == 'likes' ) {
                                esc_html_e( 'Likes', 'hannah-cd' ); 
                            } elseif( $case == 'ratings' ) {
                                esc_html_e( 'Score', 'hannah-cd' ); 
                            } else {
                                esc_html_e( 'Comments', 'hannah-cd' ); 
                            } ?>
                        </th>
                    </tr>

                    <?php while ( $wp_query_top->have_posts() ) : $wp_query_top->the_post(); 
                        $post_title = get_the_title(); ?>
                        <tr>
                            <td class="listing-img">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php echo the_post_thumbnail( 'hannah_cd_thumb_min' ); ?>
                                <?php else : ?>
                                    <div class="no-thumb"><div class="letter"><span><?php echo mb_strimwidth( esc_html( $post_title ), 0, 1 ); ?></span></div></div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="post-title" href="<?php the_permalink(); ?>" target="_blank">
                                    <?php echo mb_strimwidth( esc_html( $post_title ), 0, 100 ) ?>
                                </a>
                            </td>
                            <td style="text-align:right">
                                <?php if( $case == 'views' ) {
                                    echo hannah_cd_getPostViews_Count( get_the_ID() ); 
                                } elseif( $case == 'likes' ) {
                                    echo hannah_cd_like_count( get_the_ID() );
                                } elseif( $case == 'ratings' ) {
                                    echo hannah_cd_get_ratings( get_the_ID() ); 
                                } else {
                                    echo comments_number( '0', '1', '%' ); 
                                } ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                </table>
            </div>

        <?php endif;

    wp_reset_postdata();    

    wp_die();
}

endif;

add_action( 'wp_ajax_hannah_cd_top10_posts', 'hannah_cd_top10_posts' );

// POPULAR POSTS DASHBOARD WIDGET --> CALLABLE WIDGET CONTENT

if( ! function_exists('hannah_cd_popular_posts_dashboard_widget_content') ) :

    function hannah_cd_popular_posts_dashboard_widget_content() { ?>

        <style>
            .top-10-posts select {width:100%;margin-bottom:10px}
            .top-10-posts table {width:100%;border:1px solid #eee;border-collapse: collapse}
            .top-10-posts tr:nth-child(even) {background:#fafafa}
            .top-10-posts th, .top-10-posts td {padding:8px 16px;border-bottom:1px solid #eee}
            .top-10-posts td:nth-child(1) {border-right:1px solid #eee}
            .top-10-posts td:nth-child(3) {font-size:16px;font-weight:500;white-space:nowrap;color:#8e8e8e;border-left:1px solid #eee}
            .top-10-posts td.listing-img {padding:0px;width:60px}
            .top-10-posts td img, .top-10-posts .no-thumb {vertical-align:bottom;width:60px;height:60px}
            .top-10-posts .letter {display:table;width:100%;height:100%}
            .top-10-posts .letter span {display:table-cell;vertical-align:middle;font-size:20px;text-align:center;color:#8e8e8e}
        </style>

        <div class="top-10-posts">
            <form method="POST">
                <select name="popular_types" id="popular_types">

                    <option name="views" value="views">
                        <?php esc_html_e( 'Ordered by views', 'hannah-cd' ); ?>
                    </option>

                    <option name="likes" value="likes">
                        <?php esc_html_e( 'Ordered by likes', 'hannah-cd' ); ?>
                    </option>

                    <option name="rated" value="rated">
                        <?php esc_html_e( 'Ordered by rated', 'hannah-cd' ); ?>
                    </option>

                    <option name="commented" value="commented">
                        <?php esc_html_e( 'Ordered by commented', 'hannah-cd' ); ?>
                    </option>

                </select>
            </form>

            <div class="get-top10-results"></div>																 
        </div>

        <?php

    }

endif;

// POPULAR POSTS DASHBOARD WIDGET --> ADD DASHBOARD WIDGET

if( ! function_exists('hannah_cd_popular_posts_dashboard_widget') ) :

	function hannah_cd_popular_posts_dashboard_widget() {

		global $wp_meta_boxes;
		wp_add_dashboard_widget('popular_posts_db_widget', esc_html__( 'TOP 10: Popular Posts', 'hannah-cd' ), 'hannah_cd_popular_posts_dashboard_widget_content');

	}

endif;

add_action('wp_dashboard_setup', 'hannah_cd_popular_posts_dashboard_widget');


