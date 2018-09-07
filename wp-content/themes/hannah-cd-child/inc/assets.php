<?php
// Styles & Scripts for frontend
function alio_init_assets() {

	// Register assets
	wp_register_style( 'main-styles', get_stylesheet_directory_uri() . '/css/main.css' );

	wp_enqueue_style( 'main-styles' );

	wp_register_script( 'main-scripts', get_stylesheet_directory_uri() . '/js/main.js', array( 'jquery' ) );

	wp_enqueue_script( 'main-scripts' );
	wp_enqueue_script( 'jquery' );

	$ajax = array(
		'url' => admin_url( 'admin-ajax.php' )
	);
	wp_localize_script( 'jquery', 'alio_ajax', $ajax );

}
add_action( 'wp_enqueue_scripts', 'alio_init_assets', 20 );

// Styles & Scripts for admin
function alio_add_scripts_admin() {
	// Register assets
	wp_register_style( 'admin-styles', get_stylesheet_directory_uri() . '/css/admin.css' );

	wp_enqueue_style( 'admin-styles' );
}

add_action( 'admin_init', 'alio_add_scripts_admin' );