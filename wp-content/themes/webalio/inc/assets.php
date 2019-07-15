<?php

// Register scripts and styles
function add_scripts_admin() {
    wp_enqueue_script( 'js_admin', get_template_directory_uri() . '/js/admin.js', array( 'jquery' ) );
}
add_action( 'admin_init', 'add_scripts_admin' );

function add_scripts() {

    /* include styles */
    wp_register_style( 'animateStyle', get_template_directory_uri() . '/css/animate.css' );
    wp_register_style( 'hmbrgrStyle', get_template_directory_uri() . '/css/hmbrgr.min.css' );
    wp_register_style( 'maincss', get_template_directory_uri() . '/css/main.min.css' );
    wp_register_style( 'bootstraptheme', get_template_directory_uri() . '/css/bootstrap-theme.css' );
    wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css' );
    wp_register_style( 'bootstrapmap', get_template_directory_uri() . '/css/bootstrap.css.map' );
    wp_register_style( 'prettyphoto', get_template_directory_uri() . '/css/prettyPhoto.css' );

    /* include scripts */
    wp_register_script( 'hamburgerButton', get_template_directory_uri() . '/js/jquery.hmbrgr.min.js', array('jquery') );
    wp_register_script( 'mainscripts', get_template_directory_uri() . '/js/main.min.js', array('jquery') );
    wp_register_script( 'bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery') );
    wp_register_script( 'isotopeJS', get_template_directory_uri() . '/js/isotope.js', array('jquery') );
    wp_register_script( 'prettyPhotojs', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery') );

    wp_enqueue_style( 'hmbrgrStyle' );
    wp_enqueue_style( 'animateStyle' );
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
add_action( 'wp_enqueue_scripts', 'add_scripts' );

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
