<?php 
/*
*************************************** 
Displaying featured slider post carousel
***************************************
*/ 

global $post_id;

$fs_column = ACF_GF('featured_slider_custom_post_teaser_column', $field_id); 	
$fs_amount = ACF_GF('featured_slider_custom_post_teaser_amount', $field_id);
$box_style = ACF_GF('fs_post_type_content_style', 'option');
$fs_type = ACF_GF('featured_slider_type', $field_id);
$fs_hidden_items = ACF_GF('fs_hidden_items', 'option');

// postformat exclude
$get_postformat = ACF_GF('fs_post_type_postformat_exclude', 'option'); 
$postformat_exclude = array();
if ( is_array( $get_postformat ) || is_object( $get_postformat ) ) {
    foreach( $get_postformat as $postformat ) {
        array_push( $postformat_exclude, $postformat['value'] );
    }
}

// get the post type
if( $fs_type == 'product' ) {

    // product carousel
    $fs_post_type = 'product';
    $taxonomy = array(
        'taxonomy' 	=> 'product_cat',
        'field' 	=> 'slug',
        'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
        'operator' 	=> 'NOT IN'
    );

} elseif( $fs_type == 'page' ) {

    // page carousel
    $fs_post_type = 'page';
    $taxonomy = false;

} else {

    // post carousel
    $fs_post_type = 'post';
    $taxonomy = array(
        'taxonomy' 	=> 'post_format',
        'field' 	=> 'slug',
        'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
        'operator' 	=> 'NOT IN'
    );

} ?>

<div class="featured-slider-item header header-carousel">
	<div class="container">
			
        <?php $fs_type_post = ACF_GF('featured_slider_post_teaser_types', $field_id); 
        $fs_type_page = ACF_GF('featured_slider_page_teaser_types', $field_id);  
        $fs_type_product = ACF_GF('featured_slider_product_teaser_types', $field_id); 

        $fs_selected_posts = ACF_GF('featured_slider_post_teaser_selected', $field_id);
        $fs_selected_pages = ACF_GF('featured_slider_page_teaser_selected', $field_id);
        $fs_selected_products = ACF_GF('featured_slider_product_teaser_selected', $field_id);	

        $is_fs_post = $fs_type == 'post' && ACF_GF('featured_slider_post_teaser_types', $field_id);
        $is_fs_page = $fs_type == 'page' && ACF_GF('featured_slider_page_teaser_types', $field_id);
        $is_fs_product = $fs_type == 'product' && ACF_GF('featured_slider_product_teaser_types', $field_id);  

        // post type filter cases                
        $fs_post_popular = $is_fs_post && $fs_type_post == 'post_popular';
        $fs_page_popular = $is_fs_page && $fs_type_page == 'page_popular';
        $fs_product_popular = $is_fs_product && $fs_type_product == 'product_popular';                        
        $fs_post_liked = $is_fs_post && $fs_type_post == 'post_liked';                
        $fs_post_rated = $is_fs_post && $fs_type_post == 'post_rated';
        $fs_product_rated = $is_fs_product && $fs_type_product == 'product_rated';                
        $fs_post_commented = $is_fs_post && $fs_type_post == 'post_commented';
        $fs_page_commented = $is_fs_page && $fs_type_page == 'page_commented';
        $fs_post_recent = $is_fs_post && $fs_type_post == 'post_recent';
        $fs_page_recent = $is_fs_page && $fs_type_page == 'page_recent';
        $fs_product_recent = $is_fs_product && $fs_type_product == 'product_recent';                
        $fs_post_selected = $is_fs_post && $fs_type_post == 'post_selected';
        $fs_page_selected = $is_fs_page && $fs_type_page == 'page_selected';
        $fs_product_selected = $is_fs_product && $fs_type_product == 'product_selected';                
        $fs_product_sales = $is_fs_product && $fs_type_product == 'product_sales';
        $fs_product_reduced = $is_fs_product && $fs_type_product == 'product_reduced';

        // check if amount of posts exists
        if( $is_fs_post && $fs_selected_posts && $fs_post_selected ) {
            $fs_items_count = count( $fs_selected_posts );
        } elseif( $is_fs_page && $fs_selected_pages && $fs_page_selected ) {
            $fs_items_count = count( $fs_selected_pages );
        } elseif( $is_fs_product && $fs_selected_products && $fs_product_selected ) {
            $fs_items_count = count( $fs_selected_products );
        } elseif( ! empty( $fs_amount ) ) {
            $fs_items_count = $fs_amount;
        } else {
            $fs_items_count = '1';
        }

        // POPULAR POSTS / PAGES / PRODUCTS
        if( $fs_post_popular || $fs_page_popular || $fs_product_popular ) {

            $args = array(
                'post_type' => $fs_post_type,
                'meta_key' => 'post_views_count', // by views count
                'posts_per_page' => $fs_items_count,
                'orderby' => 'meta_value_num', // order by views
                'order' => 'DESC',
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // LIKED POSTS
        } elseif( $fs_post_liked ) {

            $args = array(
                'post_type' => $fs_post_type,
                'meta_key' => '_like_btn', // by likes count
                'posts_per_page' => $fs_items_count,
                'orderby' => 'meta_value_num', // order by likes count
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // RATED POSTS / PRODUCTS
        } elseif( $fs_post_rated || $fs_product_rated ) {

            // get the meta_keys
            if( ACF_GF('header_type', $field_id) == 'product' ) {
                $meta_key = '_wc_average_rating';
            } else {
                $meta_key = 'post_rating';
            }

            $args = array(
                'post_type' => $fs_post_type,
                'meta_key' => $meta_key, // by post rating (rating / votes count = post rating)
                'posts_per_page' => $fs_items_count,
                'orderby' => 'meta_value_num', // order by likes count
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // COMMENTED POSTS / PAGES
        } elseif( $fs_post_commented || $fs_page_commented ) {

            $args = array(
                'post_type' => $fs_post_type,
                'posts_per_page' => $fs_items_count,
                'orderby' => 'comment_count', // order by comment count
                'order' => 'DESC',
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // RECENT POSTS / PAGES / PRODUCTS
        } elseif( $fs_post_recent || $fs_page_recent || $fs_product_recent ) {

            $args = array(
                'post_type' => $fs_post_type,
                'posts_per_page' => $fs_items_count,
                'orderby' => 'date', 
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // SELECTED POSTS / PAGES / PRODUCTS
        } elseif( $fs_post_selected || $fs_page_selected || $fs_product_selected ) {

            // get the selected items
            if( $fs_type == 'product' ) {
                $fs_selected_items = $fs_selected_products;
            } elseif( $fs_type == 'page' ) {
                $fs_selected_items = $fs_selected_pages;
            } else {
                $fs_selected_items = $fs_selected_posts;
            }

            $args = array(
                'post_type' => $fs_post_type,
                'post__in' => $fs_selected_items, // post id, like (1,22,50)
                'posts_per_page' => $fs_items_count,
                'orderby' => 'post__in', // order by user
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // MOST PRODUCT SALES
        } elseif( $fs_product_sales ) {

            $args = array(
                'post_type' => $fs_post_type,
                'meta_key' => 'total_sales', // by most saled products
                'posts_per_page' => $fs_items_count,
                'orderby' => 'meta_value_num', // order by likes count
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // REDUCED PRODUCTS
        } elseif( $fs_product_reduced ) {

            $args = array(
                'post_type' => $fs_post_type,
                'meta_key' => '_sale_price', // by products in sale
                'posts_per_page' => $fs_items_count,
                'orderby' => 'meta_value_num', // order by likes count
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        }

        $get_carousel = false;

        // get the count of teaser
        $fs_teaser_count = $fs_items_count;

        // column 1

        if( $fs_column == 'col_1' ) {

            $teaser_column = 'col-md-12';
            $teaser_column_count = 1;
            $item_amount = 1;
            $only_one_item = false;

            if( $fs_teaser_count > $teaser_column_count ) {
                $get_carousel = true;
            } 

        // columns 2

        } elseif( $fs_column == 'col_2' ) { 

            $teaser_column = 'col-md-6';
            $teaser_column_count = 2;
            $item_amount = 2;
            $only_one_item = false;

            if( $fs_teaser_count > $teaser_column_count ) {
                $get_carousel = true;
            }

        // columns 3

        } elseif( $fs_column == 'col_3' ) { 

            $teaser_column = 'col-md-4';
            $teaser_column_count = 3;
            $item_amount = 3;
            $only_one_item = true;

            if( $fs_teaser_count > $teaser_column_count ) {
                $get_carousel = true;
            }

        // columns 4

        } elseif( $fs_column == 'col_4' ) { 

            $teaser_column = 'col-md-3';
            $teaser_column_count = 4;
            $item_amount = 4;
            $only_one_item = true;

            if( $fs_teaser_count > $teaser_column_count ) {
                $get_carousel = true;
            }

        } ?>

        <div class="featured-slider-owl owl-carousel <?php if( $only_one_item == true && $get_carousel ) { ?>only-one<?php } ?>">		

            <?php // if showing the product carousel and WooCommerce is deactivate
            if( ! class_exists( 'WooCommerce' ) && $is_fs_product ) { ?>

                <div class="header-carousel-item <?php echo esc_html( $teaser_column ); ?>">
                    <div class="header-content">
                        <div class="header-carousel-spacer">
                            <div class="content-box">
                                <?php echo '<div class="alert alert-warning">' . esc_html__( 'You have to activate the WooCommerce plugin to show products here', 'hannah-cd' ) . '.</div>'; ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } else {

                $my_posts_query = new WP_Query( $args );

                if ( $my_posts_query->have_posts() ) :

                    while ( $my_posts_query->have_posts() ) : $my_posts_query->the_post(); 

                        $post_title = get_the_title();

                        // get post thumbnail
                        $thumb_id = get_post_thumbnail_id();
                        $thumb_url = wp_get_attachment_image_src( $thumb_id, 'large', true );

                        if( has_post_thumbnail() ) { 
                            $bgimage = $thumb_url[0]; 
                        } 

                        // get product items

                        if( $is_fs_product ) {

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

                        <div class="header-carousel-item <?php echo esc_html( $teaser_column ); ?>">
                            <div class="header-content header-center<?php if( $box_style == 'box' ) { ?> header-box<?php } ?>" <?php if( has_post_thumbnail() ) { ?>style="background-image: url(<?php echo esc_url( $bgimage ); ?>)"<?php } ?>>
                                <div class="header-carousel-spacer">
                                    <div class="content-box">

                                        <?php // SALE (WOOCOMMERCE)
                
                                        if( $product_in_sale ) { 
                                            echo '<span class="onsale">' . esc_html__( 'Sale', 'hannah-cd' ) . '!</span>'; 
                                        } 
                
                                        if( ! ACF_GF('fs_date', 'option') || ! ACF_GF('fs_taxonomy', 'option') ) {
                                            echo '<div class="header-meta">';
                                        }
                
                                            // DATE 

                                            if( ! ACF_GF('fs_date', 'option') ) { ?>            
                                                <div class="blog-list-date">        
                                                    <?php echo get_the_date( $post_id ); ?>    
                                                </div>            
                                            <?php }

                                            // TAXONOMIES

                                            if( $fs_type != 'page' && ! ACF_GF('fs_taxonomy', 'option') ) {                
                                                // TAGS                
                                                if( ACF_GF('fs_taxonomy_select', 'option') == 'tag' ) {
                                                    hannah_cd_get_tags( $post_id );

                                                // CATEGORIES                    
                                                } else {
                                                    hannah_cd_get_categories( $post_id );
                                                }                
                                            }
                
                                        if( ! ACF_GF('fs_date', 'option') || ! ACF_GF('fs_taxonomy', 'option') ) {
                                            echo '</div>';
                                        }
                
                                        // TITLE

                                        echo '<a href="' . get_the_permalink() . '"><h3>' . get_the_title() . '</h3></a>';

                                        // EXCERPT
                
                                        if( ! ACF_GF('fs_excerpt', 'option') ) {
                                            $excerpt = get_the_excerpt();
                                            echo '<p class="description">' . mb_strimwidth( $excerpt, 0, 100, '...' ) . '</p>';
                                        } 

                                        // PRICE (WOOCOMMERCE)
                
                                        if( $is_fs_product && $price_html ) { 
                                            echo '<span class="woo-price">' . $price_html . '</span>'; 
                                        }

                                        // READ MORE
                
                                        if( ! ACF_GF('fs_read_more', 'option') ) { ?>
                                            <div class="header-buttons">
                                                <a class="btn" href="<?php the_permalink(); ?>">
                                                    <?php if( $is_fs_product ) {
                                                        esc_html_e( 'Shop now', 'hannah-cd' );
                                                    } else {
                                                        esc_html_e( 'Read more', 'hannah-cd' );
                                                    } ?>
                                                </a>
                                            </div>                                        
                                        <?php } ?>

                                    </div>
                                </div>
                                <?php if( ! has_post_thumbnail() ) {
                                    echo '<div class="post-letter"><div class="letter"><span>' . mb_strimwidth( esc_html( $post_title ) , 0, 1 ) . '</span></div></div>';
                                } ?>
                            </div>
                        </div>

                    <?php endwhile; 

                else : 

                    echo '<div class="alert alert-warning">' . esc_html__( 'No content selected', 'hannah-cd' ) . '.</div>';

                endif;

                wp_reset_postdata();

            } ?>
			
		</div>
	</div>
</div>

<script>
	jQuery(document).ready(function($) {

        if ( $('.featured-slider-owl.owl-carousel').length ) { 

            <?php if( $fs_column == 'col_3' && $get_carousel || $fs_column == 'col_4' && $get_carousel ) { ?>

                // set active-item class to to middle active item

                $(".featured-slider-owl.owl-carousel").on('initialize.owl.carousel initialized.owl.carousel ' + 'initialize.owl.carousel initialize.owl.carousel ' + 'translate.owl.carousel translated.owl.carousel ' + 'resize.owl.carousel resized.owl.carousel ',
                    function(e) {
                        var idx = e.item.index;
                        $('.owl-item.active').removeClass('active-item');
                        $('.owl-item').eq(idx+1).addClass('active-item');
                        $('.owl-item').eq(idx-1).removeClass('active-item');
                    }
                );

            <?php } ?>

            $(".featured-slider-owl.owl-carousel").owlCarousel({
                <?php if( $fs_hidden_items ) { ?>
                    stagePadding : 100,
                <?php } ?>
                items: <?php echo esc_html( $item_amount ); ?>,
                nav : true,
                navText : false,
                dots : false,
                <?php if( $get_carousel ) { ?>
                    loop : true,
                <?php } ?>
                <?php if( ! $get_carousel ) { ?>
                    mouseDrag : false,
                <?php } ?>
                slideSpeed : 400,
                autoplay : true,
                autoplayTimeout : 5000,
                autoplayHoverPause : true,
                autoHeight : false,
                margin : 20,
                responsiveClass : true,
                <?php if( $fs_column == 'col_1' ) { ?>
                    responsive : {
                        0: {
                            items: 1,
                        }
                    },
                <?php } elseif( $fs_column == 'col_4' ) { ?>
                    responsive : {
                        0: {
                            items: 1,
                        },
                        768: {
                            items: 2,
                        },
                        992: {
                            items: 3,
                        },
                        1200: {
                            items: <?php echo esc_html( $item_amount ); ?>,
                        }
                    },
                <?php } else { ?>
                    responsive : {
                        0: {
                            items: 1,
                        },
                        768: {
                            items: 2,
                        },
                        992: {
                            items: <?php echo esc_html( $item_amount ); ?>,
                        }
                    },
                <?php } ?>
            });	

        }	

        // find the heighest height of owl items

        function setTheHeight() {

            // Get value of highest element
            var maxHeight = Math.max.apply(Math, $('.featured-slider-owl .header-carousel-spacer').map (
                function() {
                    return $(this).outerHeight();
                }
            ));				

            $( '.featured-slider-owl .header-carousel-item' ).height(
                maxHeight
            );

        }

        $(window).on("load", function() {
            setTheHeight();
        });

        // set height after window resizing

        $(window).resize(function() {
            setTheHeight();
        });

        // set height after owl carousel resizing

        $(".featured-slider-owl.owl-carousel").on('resize.owl.carousel resized.owl.carousel ',
            function(e) {
                setTheHeight();
            }
        );

    });
</script>


