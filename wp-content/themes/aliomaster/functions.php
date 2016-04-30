<?php

// require files
//require_once(get_stylesheet_directory() . '/templates/wp_bootstrap_navwalker.php'); // Bootstrap navwalker

if ( ! function_exists( 'pr' ) ) {
	function pr($val) {
		echo '<pre>';
		print_r($val);
		echo '</pre>';
	}
}

/* Register scripts and styles */
add_action( 'wp_enqueue_scripts', 'add_scripts' );

function add_scripts() {

	/* include styles */
	wp_register_style( 'faStyle', get_template_directory_uri() . '/css/font-awesome.min.css' );
	wp_register_style( 'animateStyle', get_template_directory_uri() . '/css/animate.css' );
	wp_register_style( 'hmbrgrStyle', get_template_directory_uri() . '/css/hmbrgr.min.css' );
	wp_register_style( 'robotoFont', 'https://fonts.googleapis.com/css?family=Roboto:400,700,300&subset=latin,cyrillic' );
	wp_register_style( 'montcerratFont', 'https://fonts.googleapis.com/css?family=Montserrat:400,700' );
	wp_register_style( 'maincss', get_template_directory_uri() . '/css/responsive.css' );
	wp_register_style( 'bootstraptheme', get_template_directory_uri() . '/css/bootstrap-theme.css' );
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css' );
	wp_register_style( 'bootstrapmap', get_template_directory_uri() . '/css/bootstrap.css.map' );
	wp_register_style( 'prettyphoto', get_template_directory_uri() . '/css/prettyPhoto.css' );

	/* include scripts */
	wp_register_script( 'hamburgerButton', get_template_directory_uri() . '/js/jquery.hmbrgr.min.js', array('jquery') );
	wp_register_script( 'mainscripts', get_template_directory_uri() . '/js/main.js', array('jquery') );
	wp_register_script( 'bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery') );
	wp_register_script( 'mixitupjs', get_template_directory_uri() . '/js/jquery.mixitup.min.js', array('jquery') );
	wp_register_script( 'prettyPhotojs', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery') );

	wp_enqueue_style( 'faStyle' );
	wp_enqueue_style( 'hmbrgrStyle' );
	wp_enqueue_style( 'animateStyle' );
	wp_enqueue_style( 'robotoFont' );
	wp_enqueue_style( 'montcerratFont' );
	wp_enqueue_style( 'bootstraptheme' );
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'bootstrapmap' );
	wp_enqueue_style( 'prettyphoto' );
	wp_enqueue_style( 'maincss' );

	wp_enqueue_script( 'hamburgerButton' );
	wp_enqueue_script( 'mixitupjs' );
	wp_enqueue_script( 'prettyPhotojs' );
	wp_enqueue_script( 'bootstrapjs' );
	wp_enqueue_script( 'mainscripts' );
}

// add images thumbnails
add_theme_support( 'post-thumbnails' );
add_image_size( 'sizeThumb', 300, 200, true );

// register menu
function theme_register_nav_menu() {
	 register_nav_menu( 'primary', 'Primary Menu' );
}
add_action( 'after_setup_theme', 'theme_register_nav_menu' );

if (function_exists('register_sidebar')) {
	register_sidebar(array("name" => "header-sidebar"));
	register_sidebar(array("name" => "footer-sidebar"));
}


