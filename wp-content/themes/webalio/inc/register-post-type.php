<?php

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
        'menu_icon' => '', // get_stylesheet_directory_uri() . '/img/career.png',
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'taxonomies' => array('workscategory')
        );
    register_post_type( 'works', $args );
}

add_action( 'init', 'work_init' );

// register taxonomy Category for Listing
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
add_action( 'init', 'prowp_define_works_workscategory_taxonomy' );
