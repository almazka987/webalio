<?php // POST TYPE CAROUSEL

// get the post type
if( ACF_GSF('area_carousel_type', $field_id) == 'carousel_product' ) {

    // product carousel
    $post_type = 'product';

} else {

    // post carousel
    $post_type = 'post';

}

$la_type = ACF_GSF('area_types', $field_id);  
$la_type_product = ACF_GSF('area_product_types', $field_id);  
$la_item_amount = ACF_GSF('area_post_amount', $field_id);	
$la_selected_post = ACF_GSF('area_post_selected', $field_id);	
$la_selected_product = ACF_GSF('area_product_selected', $field_id);
$teaser_column = ACF_GSF('area_item_column', $field_id) ; 

$owl_have_posts = ACF_GSF('area_carousel_type', $field_id) == 'carousel_post' && ACF_GSF('area_types', $field_id);
$owl_have_products = ACF_GSF('area_carousel_type', $field_id) == 'carousel_product' && ACF_GSF('area_product_types', $field_id); 

// check if amount of posts exists
if ( $la_type == 'selected' ) {
    $la_item_amount = count( ACF_GSF('area_post_selected', $field_id) );
} elseif ( $la_type_product == 'selected' ) {
    $la_item_amount = count( ACF_GSF('area_product_selected', $field_id) );
} elseif ( $la_item_amount ) {
    $la_item_amount = ACF_GSF('area_post_amount', $field_id);
} else {
    $la_item_amount = '1';
}

// get the count of teaser
if( $la_type == 'selected' ) {
    $teaser_count = count( $la_selected_post );
} elseif( $la_type_product == 'selected' ) {
    $teaser_count = count( $la_selected_product );
} else {
    $teaser_count = $la_item_amount;
}

$get_carousel = false;

// get column
if( $teaser_column == 'col_1' ) {

    $column_count = 'col-md-12';
    $teaser_column_count = 1;
    $item_count = '1';

} elseif( $teaser_column == 'col_2' ) { 

    $column_count = 'col-md-6';
    $teaser_column_count = 2;
    $item_count = '2';

} else { 

    $column_count = 'col-md-4';
    $teaser_column_count = 3;
    $item_count = '3';

}

if( $teaser_count > $teaser_column_count ) {
    $get_carousel = true;
} 

// popular posts or products
if( $owl_have_posts && $la_type == 'popular' || $owl_have_products && $la_type_product == 'product_popular' ) {
    $args = array(
        'post_type' => $post_type,
        'meta_key' => 'post_views_count', // by views count
        'posts_per_page' => $la_item_amount,
        'orderby' => 'meta_value_num', // order by views
        'order' => 'DESC',
        'ignore_sticky_posts' => 1
    );

// liked posts
} elseif( $owl_have_posts && $la_type == 'liked' ) {
    $args = array(
        'post_type' => $post_type,
        'meta_key' => '_like_btn', // by likes count
        'posts_per_page' => $la_item_amount,
        'orderby' => 'meta_value_num', // order by likes count
        'ignore_sticky_posts' => 1
    );

// rated posts or products
} elseif( $owl_have_posts && $la_type == 'rated' || $owl_have_products && $la_type_product == 'product_rated' ) {

    // get the meta_keys
    if( ACF_GSF('area_carousel_type', $field_id) == 'carousel_product' ) {
        $meta_key = '_wc_average_rating';
    } else {
        $meta_key = 'post_rating';
    }

    $args = array(
        'post_type' => $post_type,
        'meta_key' => $meta_key, // by post rating (rating / votes count = post rating)
        'posts_per_page' => $la_item_amount,
        'orderby' => 'meta_value_num', // order by likes count
        'ignore_sticky_posts' => 1
    );

// commented posts
} elseif( $owl_have_posts && $la_type == 'commented' ) {
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $la_item_amount,
        'orderby' => 'comment_count', // order by comment count
        'order' => 'DESC',
        'ignore_sticky_posts' => 1
    );

// recent posts or products
} elseif( $owl_have_posts && $la_type == 'recent' || $owl_have_products && $la_type_product == 'product_recent' ) {
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $la_item_amount,
        'orderby' => 'date', 
        'ignore_sticky_posts' => 1
    );

// selected posts or products
} elseif( $owl_have_posts && $la_type == 'selected' || $owl_have_products && $la_type_product == 'product_selected' ) {

    // get the selected items
    if( ACF_GSF('area_carousel_type', $field_id) == 'carousel_product' ) {
        $selected_items = $la_selected_product;
    } else {
        $selected_items = $la_selected_post;
    }

    $args = array(
        'post_type' => $post_type,
        'post__in' => $selected_items, // post id, like (1,22,50)
        'posts_per_page' => $la_item_amount,
        'orderby' => 'post__in', // order by user
        'ignore_sticky_posts' => 1
    );

// most product sales
} elseif( $owl_have_products && $la_type_product == 'product_sales' ) {
    $args = array(
        'post_type' => $post_type,
        'meta_key' => 'total_sales', // by most saled products
        'posts_per_page' => $la_item_amount,
        'orderby' => 'meta_value_num', // order by likes count
        'ignore_sticky_posts' => 1
    );

// reduced products
} elseif( $owl_have_products && $la_type_product == 'product_reduced' ) {
    $args = array(
        'post_type' => $post_type,
        'meta_key' => '_sale_price', // by products in sale
        'posts_per_page' => $la_item_amount,
        'orderby' => 'meta_value_num', // order by likes count
        'ignore_sticky_posts' => 1
    );
}				

// if showing the product carousel and WooCommerce is deactivate
if( ! class_exists( 'WooCommerce' ) && $owl_have_products ) {

    echo '<div class="alert alert-warning">' . esc_html__( 'You have to activate the WooCommerce plugin to show products here.', 'hannah-cd' ) . '.</div>';

} else {

    $my_posts_query = new WP_Query( $args );

    if( $my_posts_query->have_posts() ) :
        while( $my_posts_query->have_posts() ) : $my_posts_query->the_post(); 

            // get post thumbnail
            $thumb_id = get_post_thumbnail_id();
            $thumb_url = wp_get_attachment_image_src( $thumb_id, 'large', true );
            $post_title = get_the_title();

            if( has_post_thumbnail() ) { 
                $bgimage = $thumb_url[0]; 
            }

            // get product items
            if( $owl_have_products ) {

                global $product;
                $product = new WC_Product( get_the_ID() ); 

                // get product price
                $price_html = $product->get_price_html();

                // get product sale status
                if ( $product->is_on_sale() ) {
                    $product_in_sale = true;
                } else {
                    $product_in_sale = false;
                }

            } else {
                $product_in_sale = false;
            } ?>

            <div class="area-carousel-box <?php echo esc_html( $column_count ); ?>">
                <a href="<?php the_permalink(); ?>" class="area-carousel-content" <?php if( has_post_thumbnail() ) { ?>style="background-image: url(<?php echo esc_url( $bgimage ); ?>)"<?php } ?>>
                    <?php if( ! has_post_thumbnail() ) { ?>
                        <div class="letter"><span><?php echo mb_strimwidth( esc_html( $post_title ) , 0, 1 ) ?></span></div>
                    <?php } ?>
                    <div class="hover"></div>
                    <?php if( $product_in_sale ) { 
                        echo '<span class="onsale">' . esc_html__( 'Sale', 'hannah-cd' ) . '!</span>'; 
                    } ?>
                </a>

                <a href="<?php the_permalink(); ?>"><h4><?php echo esc_html( $post_title ); ?></h4></a>                

                <?php if( $owl_have_products ) { 
                    echo '<span class="woo-price">' . $price_html . '</span>'; 
                } ?>
            </div>

        <?php endwhile;
    endif;

    wp_reset_postdata();

} ?>

        