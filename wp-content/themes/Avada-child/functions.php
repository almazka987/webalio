<?php

// require files
require_once( get_stylesheet_directory() . '/lib/Mobile_Detect.php' );

if ( ! function_exists( 'pr' ) ) {
    function pr($val) {
        echo '<pre>';
        print_r($val);
        echo '</pre>';
    }
}

// Register scripts and styles
function add_scripts_admin() {
    wp_enqueue_script( 'js_admin', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ) );
}
add_action( 'admin_init', 'add_scripts_admin' );

function add_scripts() {

    /* include styles */
    wp_register_style( 'maincss', get_template_directory_uri() . '/css/responsive.css' );

    /* include scripts */
    wp_register_script( 'mainscripts', get_template_directory_uri() . '/js/main.js', array('jquery') );

    wp_enqueue_style( 'maincss' );
    wp_enqueue_script( 'mainscripts' );
}
add_action( 'wp_enqueue_scripts', 'add_scripts' );
