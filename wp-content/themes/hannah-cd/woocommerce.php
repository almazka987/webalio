<?php 
/*
*************************************** 
Displaying for all default WooCommerce pages
***************************************
*/ 

get_header(); 

$field_id = $hannah_cd_field_id;

/* manage the sidebar view */

if( is_shop() && ACF_GF('sidebar_disable_shop', 'option') ) {
    // disable sidebar for shop base page only
    $sidebar_show = false;
} else {
    $sidebar_show = ACF_GF('sidebar_shop_show', 'option') == 'show';	
}

$sidebar_right = ACF_GF('sidebar_shop_position', 'option') == 'right';

/* customize the count of product columns */

$woo_column_count = ACF_GF('woocommerce_product_page_column', 'option');

if( $woo_column_count == 'col_2' ) {
    $woo_column_count = '2'; // 2 columns
} elseif( $woo_column_count == 'col_4' ) {
    $woo_column_count = '4'; // 4 columns
} else {
    $woo_column_count = '3'; // default are 3 columns
}

/* customize the count of related product columns */

$woo_rel_column_count = ACF_GF('woocommerce_related_products_column', 'option');

if( $woo_rel_column_count == 'col_2' ) {
    $woo_rel_column_count = '2'; // 2 columns
} elseif( $woo_rel_column_count == 'col_4' ) {
    $woo_rel_column_count = '4'; // 4 columns
} else {
    $woo_rel_column_count = '3'; // default are 3 columns
}

// PAGE HEADER

include( locate_template('inc/acf-header.php') ); ?>

<div class="content woo-col-<?php echo esc_html( $woo_column_count ); ?> woo-rel-col-<?php echo esc_html( $woo_rel_column_count ); ?>" id="content-scroll">		
    <section <?php post_class(); ?>>
        <div class="container">

            <?php if( $sidebar_show ) { ?>
                <div class="has-sidebar col-md-9<?php if( $sidebar_right ) { ?> has-sidebar-right<?php } ?>">
            <?php } ?>

                <article id="product-<?php the_ID(); ?>">

                    <div class="product-content">							

                        <?php // WOOCOMMERCE CONTENT
                        // use custom output instead of the woocommerce_content(); function

                        if( is_singular( 'product' ) ) {

                            // SINGLE PRODUCT

                            while( have_posts() ) : the_post();
                                wc_get_template_part( 'content', 'single-product' );
                            endwhile;

                        } else { 

                            // SHOP TITLE

                            if( ! ACF_GF('page_title', $field_id) ) { ?>

                                <header class="page-header">
                                    <?php if( $hannah_cd_header && $hannah_cd_header_default ) { ?>
                                        <h2><?php woocommerce_page_title(); ?></h2>
                                    <?php } else { ?>
                                        <h1><?php woocommerce_page_title(); ?></h1>
                                    <?php } ?>
                                </header>

                            <?php }

                            // SHOP CONTENT 

                            if( ! ACF_GF('main_content', $field_id) ) { ?>

                                <div class="wpcontent showtop">
                                    <?php do_action( 'woocommerce_archive_description' ); ?>
                                </div>

                            <?php }

                            // FEATURED SLIDER
                            
				            include( locate_template('inc/acf-featured-slider.php') );
                            
                            // SHOP PRODUCTS

                            if( have_posts() ) :

                                do_action( 'woocommerce_before_shop_loop' );

                                    woocommerce_product_loop_start();

                                        woocommerce_product_subcategories();

                                        while( have_posts() ) : the_post();
                                            wc_get_template_part( 'content', 'product' );
                                        endwhile;

                                    woocommerce_product_loop_end();

                                do_action( 'woocommerce_after_shop_loop' );

                            elseif( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) :

                                do_action( 'woocommerce_no_products_found' );

                            endif;

                        }

                        // CONTENT BELOW 

                        if( ACF_GF('content_below', $field_id) ) { ?>

                            <div class="wpcontent showbottom">
                                <?php echo ACF_GF('content_below', $field_id);	?>
                            </div>

                        <?php } 
                        
                        // CONTENT GRID

                        if( ACF_GF('content_grid_rows', $field_id) ) { ?>

                            <div class="content-grid">
                                <div class="container">
                                    <div class="row">
                                        <?php include( locate_template( 'inc/acf-area-content-grid.php' ) ); ?>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>		

                    </div>

                </article>

            <?php if( $sidebar_show ) { ?>
                </div>

                <div class="sidebar col-md-3<?php if( $sidebar_right ) { ?> sidebar-right<?php } ?>">
                    <?php get_sidebar(); ?>
                </div>
            <?php } ?>

        </div>
    </section>

<?php get_footer(); ?>
