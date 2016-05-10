<?php

// require files
require_once( get_stylesheet_directory() . '/lib/wp_bootstrap_navwalker.php' );
require_once( get_stylesheet_directory() . '/inc/shortcodes.php');

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
	wp_register_script( 'isotopeJS', get_template_directory_uri() . '/js/isotope.js', array('jquery') );
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
	wp_enqueue_script( 'isotopeJS' );
	wp_enqueue_script( 'prettyPhotojs' );
	wp_enqueue_script( 'bootstrapjs' );
	wp_enqueue_script( 'mainscripts' );
}

// add images thumbnails
add_theme_support( 'post-thumbnails' );
add_image_size( 'sizeThumb', 300, 320, array( 'top', 'left' ) );

// register menu
function theme_register_nav_menu() {
	register_nav_menu( 'primary', 'Primary Menu' );
}
add_action( 'after_setup_theme', 'theme_register_nav_menu' );

// register Works custom type
function work_init() {
	$labels = array(
		'name' => __( 'Works', 'wordpress' ),
		'singular_name' => __( 'Work', 'wordpress' ),
		'add_new' => __( 'Add New', 'wordpress' ),
		'add_new_item' => __( 'Add New Work', 'wordpress' ),
		'edit_item' => __( 'Edit Work', 'wordpress' ),
		'new_item' => __( 'New Work', 'wordpress' ),
		'all_items' => __( 'All Works', 'wordpress' ),
		'view_item' => __( 'View Work', 'wordpress' ),
		'search_items' => __( 'Search Works', 'wordpress' ),
		'not_found' => __( 'No works found', 'wordpress' ),
		'not_found_in_trash' => __( 'No works found in Trash', 'wordpress' ),
		'menu_name' => __( 'Works', 'wordpress' )
		);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'menu_icon' => get_stylesheet_directory_uri() . '/img/career.png',
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'taxonomies' => array('workscategory')
		);
	register_post_type( 'works', $args );
}

add_action( 'init', 'work_init' );

/* register taxonomy Category for Listing */
add_action( 'init', 'prowp_define_works_workscategory_taxonomy' );

function prowp_define_works_workscategory_taxonomy() {
	register_taxonomy( 'workscategory', 'works', array(
		'hierarchical' => true,
		'label' => 'Category',
		'query_var' => true,
		'rewrite' => true,
		'show_admin_column' => true,
		)
	);
}