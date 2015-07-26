<?php

// require files
//require_once(get_stylesheet_directory() . '/templates/wp_bootstrap_navwalker.php'); // Bootstrap navwalker

function pr($val) {
	echo '<pre>';
	print_r($val);
	echo '</pre>';
}

/* Register scripts and styles */
add_action( 'wp_enqueue_scripts', 'add_scripts' );

function add_scripts() {

	/* include styles */
	wp_register_style( 'maincss', get_template_directory_uri() . '/style.css' );
	wp_register_style( 'bootstraptheme', get_template_directory_uri() . '/css/bootstrap-theme.css' );
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css' );
	wp_register_style( 'bootstrapmap', get_template_directory_uri() . '/css/bootstrap.css.map' );
	wp_register_style( 'prettyphoto', get_template_directory_uri() . '/css/prettyPhoto.css' );

	/* include scripts */
	wp_register_script( 'mainscripts', get_template_directory_uri() . '/js/scripts.js', array('jquery') );
	wp_register_script( 'bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js' );
	wp_register_script( 'mixitupjs', get_template_directory_uri() . '/js/jquery.mixitup.min.js' );
	wp_register_script( 'prettyPhotojs', get_template_directory_uri() . '/js/jquery.prettyPhoto.js' );

	wp_enqueue_style( 'maincss' );
	wp_enqueue_style( 'bootstraptheme' );
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'bootstrapmap' );
	wp_enqueue_style( 'prettyphoto' );

	wp_enqueue_script( 'mainscripts' );
	wp_enqueue_script( 'bootstrapjs' );
	wp_enqueue_script( 'mixitupjs' );
	wp_enqueue_script( 'prettyPhotojs' );
}

// register sidebars
function register_wpm_sidebars() {

	 register_sidebar(
		  array(
			   'id' => 'coloumn_side', // уникальный id
			   'name' => 'Right coloumn', // название сайдбара
			   'description' => 'Drag widgets to add them in the sidebar', // описание
			   'before_widget' => '<li id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
			   'after_widget' => '</li>',
			   'before_title' => '<h2 class="widgettitle">', // по умолчанию заголовки виджетов в <h2>
			   'after_title' => '</h2>'
		  )
	 );

	 register_sidebar(
		  array(
			   'id' => 'custom_side',
			   'name' => 'Custom Place Sidebar',
			   'description' => 'Drag widgets to add them in the sidebar',
			   'before_widget' => '<div id="%1$s" class="foot widget %2$s">',
			   'after_widget' => '</div>',
			   'before_title' => '<h3 class="widget-title">',
			   'after_title' => '</h3>'
		  )
	 );
}

add_action( 'widgets_init', 'register_wpm_sidebars' );

/* add favicon */
/*function favicon_link() {
	 echo '<link rel="shortcut icon" type="image/x-icon" href="' . get_stylesheet_directory_uri() . '/favicon.ico" />' . "\n";
}
add_action('wp_head', 'favicon_link');*/

/* add images thumbnails */
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


