<?php

// Register admin scripts and styles
function add_scripts_admin() {
    wp_enqueue_script( 'js_admin', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ) );
    wp_enqueue_style('alio_admin_style', get_template_directory_uri() . '/css/admin.css');
}
add_action( 'admin_init', 'add_scripts_admin' );

// Register scripts and styles
function add_scripts() {

    /* include scripts */
    wp_register_script( 'mainscripts', get_template_directory_uri() . '/js/main.min.js', array('jquery'), false, true );
    wp_register_script( 'bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), false, true );
    wp_register_script( 'isotopeJS', get_template_directory_uri() . '/js/isotope.js', array('jquery'), false, true );
    wp_register_script( 'prettyPhotojs', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'), false, true );

    /* include styles */
    wp_register_style( 'maincss', get_template_directory_uri() . '/css/main.min.css' );

    wp_enqueue_script( 'isotopeJS' );
    wp_enqueue_script( 'prettyPhotojs' );
    wp_enqueue_script( 'bootstrapjs' );
    wp_enqueue_script( 'mainscripts' );

    wp_enqueue_style( 'maincss' );
}
add_action( 'wp_enqueue_scripts', 'add_scripts' );

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
