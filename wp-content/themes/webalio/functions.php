<?php

// require files
require_once( get_stylesheet_directory() . '/inc/assets.php');
require_once( get_stylesheet_directory() . '/inc/register-post-type.php');
require_once( get_stylesheet_directory() . '/inc/shortcodes.php');
require_once( get_stylesheet_directory() . '/lib/Mobile_Detect.php' );
require_once( get_stylesheet_directory() . '/lib/wp_bootstrap_navwalker.php' );

if ( ! function_exists( 'pr' ) ) {
	function pr($val) {
		echo '<pre>';
		print_r($val);
		echo '</pre>';
	}
}

// translate custom
add_action( 'after_setup_theme', 'add_translations' );
function add_translations() {
    load_theme_textdomain( 'webalio', get_stylesheet_directory() . '/languages' );
}

// add images thumbnails
add_theme_support( 'post-thumbnails' );
add_image_size( 'sizeThumb', 300, 320, array( 'top', 'left' ) );

// register menu
function theme_register_nav_menu() {
	register_nav_menu( 'primary', 'Primary Menu' );
}
add_action( 'after_setup_theme', 'theme_register_nav_menu' );

// register sidebars
function register_alio_sidebars() {

	register_sidebar(
		array(
			'id' => 'footer3_sidebar',
			'name' => 'Footer 3  column',
			'description' => 'Drag widgets to add them in the sidebar',
			'before_widget' => '<div id="%1$s" class="foot widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
}
add_action( 'widgets_init', 'register_alio_sidebars' );