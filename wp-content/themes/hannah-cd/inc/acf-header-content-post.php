<?php 
/*
*************************************** 
Displaying post header content
***************************************
*/

global $post_id;

$header_compact = ACF_GF('header_padding', $field_id);
$header_alignment = ACF_GF('header_alignment', $field_id);
$box_style = ACF_GF('header_post_type_content_style', 'option');
$header_type = ACF_GF('header_type', $field_id);
$columns = ACF_GF('custom_post_teaser_column', $field_id);
$amount = ACF_GF('custom_post_teaser_amount', $field_id);	 	
$spacing_header = ACF_GF('spacing_header_wide', 'option');
$hidden_items = ACF_GF('header_hidden_items', 'option');
        
if( $hannah_cd_header_wide && $spacing_header || ! $hannah_cd_header_full && ! $hannah_cd_header_wide && ! $hannah_cd_header_fullscreen ) {
    $spacing = true;
} else {
    $spacing = false;
}
            
if( $header_alignment == 'left' ) {
    $header_align = 'left';
} elseif( $header_alignment == 'right' ) {
    $header_align = 'right';
} else {
    $header_align = 'center';
}

// postformat exclude
$get_postformat = ACF_GF('post_type_postformat_exclude', 'option'); 
$postformat_exclude = array();
if ( is_array( $get_postformat ) || is_object( $get_postformat ) ) {
    foreach( $get_postformat as $postformat ) {
        array_push( $postformat_exclude, $postformat['value'] );
    }
}

// get the post type
if( $header_type == 'product' ) {

    // product carousel
    $post_type = 'product';
    $taxonomy = array(
        'taxonomy' 	=> 'product_cat',
        'field' 	=> 'slug',
        'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
        'operator' 	=> 'NOT IN'
    );

} elseif( $header_type == 'page' ) {

    // page carousel
    $post_type = 'page';
    $taxonomy = false;

} else {

    // post carousel
    $post_type = 'post';
    $taxonomy = array(
        'taxonomy' 	=> 'post_format',
        'field' 	=> 'slug',
        'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
        'operator' 	=> 'NOT IN'
    );

} ?>

<main class="header header-carousel<?php if( $spacing_header ) { ?> header-spacing<?php } ?>">
    <div class="container">
			
        <?php $type_post = ACF_GF('custom_post_teaser_types', $field_id);  
        $type_page = ACF_GF('custom_page_teaser_types', $field_id);  
        $type_product = ACF_GF('custom_product_teaser_types', $field_id); 

        $selected_posts = ACF_GF('custom_post_teaser_selected', $field_id);
        $selected_pages = ACF_GF('custom_page_teaser_selected', $field_id);
        $selected_products = ACF_GF('custom_product_teaser_selected', $field_id);	

        $is_post = $header_type == 'post' && $type_post;
        $is_page = $header_type == 'page' && $type_page;
        $is_product =	$header_type == 'product' && $type_product;  

        // post type filter cases                
        $post_popular = $is_post && $type_post == 'custom_post_teaser_show_popular';
        $page_popular = $is_page && $type_page == 'custom_page_teaser_show_popular';
        $product_popular = $is_product && $type_product == 'custom_product_teaser_show_popular';                        
        $post_liked = $is_post && $type_post == 'custom_post_teaser_show_liked';                
        $post_rated = $is_post && $type_post == 'custom_post_teaser_show_rated';
        $product_rated = $is_product && $type_product == 'custom_product_teaser_show_rated';                
        $post_commented = $is_post && $type_post == 'custom_post_teaser_show_commented';
        $page_commented = $is_page && $type_page == 'custom_page_teaser_show_commented';
        $post_recent = $is_post && $type_post == 'custom_post_teaser_show_recent';
        $page_recent = $is_page && $type_page == 'custom_page_teaser_show_recent';
        $product_recent = $is_product && $type_product == 'custom_product_teaser_show_recent';                
        $post_selected = $is_post && $type_post == 'custom_post_teaser_show_selected';
        $page_selected = $is_page && $type_page == 'custom_page_teaser_show_selected';
        $product_selected = $is_product && $type_product == 'custom_product_teaser_show_selected';                
        $product_sales = $is_product && $type_product == 'custom_product_teaser_show_sales';
        $product_reduced = $is_product && $type_product == 'custom_product_teaser_show_reduced';

        // check if amount of posts exists
        if( $is_post && $selected_posts && $post_selected ) {
            $items_count = count( $selected_posts );
        } elseif( $is_page && $selected_pages && $page_selected ) {
            $items_count = count( $selected_pages );
        } elseif( $is_product && $selected_products && $product_selected ) {
            $items_count = count( $selected_products );
        } elseif( ! empty( $amount ) ) {
            $items_count = $amount;
        } else {
            $items_count = '1';
        }

        // POPULAR POSTS / PAGES / PRODUCTS
        if( $post_popular || $page_popular || $product_popular ) {

            $args = array(
                'post_type' => $post_type,
                'meta_key' => 'post_views_count', // by views count
                'posts_per_page' => $items_count,
                'orderby' => 'meta_value_num', // order by views
                'order' => 'DESC',
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // LIKED POSTS
        } elseif( $post_liked ) {

            $args = array(
                'post_type' => $post_type,
                'meta_key' => '_like_btn', // by likes count
                'posts_per_page' => $items_count,
                'orderby' => 'meta_value_num', // order by likes count
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // RATED POSTS / PRODUCTS
        } elseif( $post_rated || $product_rated ) {

            // get the meta_keys
            if( $header_type == 'product' ) {
                $meta_key = '_wc_average_rating';
            } else {
                $meta_key = 'post_rating';
            }

            $args = array(
                'post_type' => $post_type,
                'meta_key' => $meta_key, // by post rating (rating / votes count = post rating)
                'posts_per_page' => $items_count,
                'orderby' => 'meta_value_num', // order by likes count
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // COMMENTED POSTS / PAGES
        } elseif( $post_commented || $page_commented ) {

            $args = array(
                'post_type' => $post_type,
                'posts_per_page' => $items_count,
                'orderby' => 'comment_count', // order by comment count
                'order' => 'DESC',
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // RECENT POSTS / PAGES / PRODUCTS
        } elseif( $post_recent || $page_recent || $product_recent ) {

            $args = array(
                'post_type' => $post_type,
                'posts_per_page' => $items_count,
                'orderby' => 'date', 
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // SELECTED POSTS / PAGES / PRODUCTS
        } elseif( $post_selected || $page_selected || $product_selected ) {

            // get the selected items
            if( $header_type == 'product' ) {
                $selected_items = $selected_products;
            } elseif( $header_type == 'page' ) {
                $selected_items = $selected_pages;
            } else {
                $selected_items = $selected_posts;
            }

            $args = array(
                'post_type' => $post_type,
                'post__in' => $selected_items, // post id, like (1,22,50)
                'posts_per_page' => $items_count,
                'orderby' => 'post__in', // order by user
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // MOST PRODUCT SALES
        } elseif( $product_sales ) {

            $args = array(
                'post_type' => $post_type,
                'meta_key' => 'total_sales', // by most saled products
                'posts_per_page' => $items_count,
                'orderby' => 'meta_value_num', // order by likes count
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        // REDUCED PRODUCTS
        } elseif( $product_reduced ) {

            $args = array(
                'post_type' => $post_type,
                'meta_key' => '_sale_price', // by products in sale
                'posts_per_page' => $items_count,
                'orderby' => 'meta_value_num', // order by likes count
                'ignore_sticky_posts' => 1,
                'tax_query' => array( $taxonomy ),
            );

        }

        $get_carousel = false;

        // get the count of teaser
        $teaser_count = $items_count;

        // column 1
        if( $columns == 'col_1' ) {

            $teaser_column = 'col-md-12';
            $teaser_column_count = 1;
            $item_amount = 1;
            $only_one_item = false;

            if( $teaser_count > $teaser_column_count ) {
                $get_carousel = true;
            } 

        // columns 2
        } elseif( $columns == 'col_2' ) { 

            $teaser_column = 'col-md-6';
            $teaser_column_count = 2;
            $item_amount = 2;
            $only_one_item = false;

            if( $teaser_count > $teaser_column_count ) {
                $get_carousel = true;
            }

        // columns 3
        } elseif( $columns == 'col_3' ) { 

            $teaser_column = 'col-md-4';
            $teaser_column_count = 3;
            $item_amount = 3;
            $only_one_item = true;

            if( $teaser_count > $teaser_column_count ) {
                $get_carousel = true;
            }

        // columns 4
        } elseif( $columns == 'col_4' ) { 

            $teaser_column = 'col-md-3';
            $teaser_column_count = 4;
            $item_amount = 4;
            $only_one_item = true;

            if( $teaser_count > $teaser_column_count ) {
                $get_carousel = true;
            }

        } ?>

        <div class="header-carousel-owl owl-carousel <?php if( $only_one_item == true && $get_carousel ) { ?>only-one<?php } ?>">		

            <?php // if showing the product carousel and WooCommerce is deactivate
            if( ! class_exists( 'WooCommerce' ) && $is_product ) { ?>

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

                        if( $is_product ) {

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
                            <div class="header-content<?php if( $header_compact == 'compact' ) { ?> header-compact<?php } ?> header-<?php echo esc_html( $header_align ); ?><?php if( $box_style == 'box' ) { ?> header-box<?php } ?>"<?php if( has_post_thumbnail() ) { ?> style="background-image: url(<?php echo esc_url( $bgimage ); ?>)"<?php } ?>>  
                                <div class="header-carousel-spacer">
                                    <div class="content-box">

                                        <?php // SALE (WOOCOMMERCE)
                
                                        if( $product_in_sale ) { 
                                            echo '<span class="onsale">' . esc_html__( 'Sale', 'hannah-cd' ) . '!</span>'; 
                                        }
                
                                        if( ! ACF_GF('header_date', 'option') || ! ACF_GF('header_taxonomy', 'option') ) {
                                            echo '<div class="header-meta">';
                                        }
                
                                            // DATE 

                                            if( ! ACF_GF('header_date', 'option') ) { ?>            
                                                <div class="blog-list-date">        
                                                    <?php echo get_the_date( $post_id ); ?>    
                                                </div>            
                                            <?php }

                                            // TAXONOMIES

                                            if( $header_type != 'page' && ! ACF_GF('header_taxonomy', 'option') ) {                
                                                // TAGS                
                                                if( ACF_GF('header_taxonomy_select', 'option') == 'tag' ) {
                                                    hannah_cd_get_tags( $post_id );

                                                // CATEGORIES                    
                                                } else {
                                                    hannah_cd_get_categories( $post_id );
                                                }                
                                            }
                
                                        if( ! ACF_GF('header_date', 'option') || ! ACF_GF('header_taxonomy', 'option') ) {
                                            echo '</div>';
                                        }
                
                                        // TITLE

                                        echo '<a href="' . get_the_permalink() . '"><h3>' . get_the_title() . '</h3></a>';
                
                                        // EXCERPT
                
                                        if( ! ACF_GF('header_excerpt', 'option') ) {
                                            $excerpt = get_the_excerpt();
                                            echo '<p class="description">' . mb_strimwidth( $excerpt, 0, 100, '...' ) . '</p>';
                                        } 

                                        // PRICE (WOOCOMMERCE)
                
                                        if( $is_product && $price_html ) { 
                                            echo '<span class="woo-price">' . $price_html . '</span>'; 
                                        } 
                                        
                                        // READ MORE
                
                                        if( ! ACF_GF('header_read_more', 'option') ) { ?>
                                            <div class="header-buttons">
                                                <a class="btn" href="<?php the_permalink(); ?>">
                                                    <?php if( $is_product ) {
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
    
    <?php hannah_cd_header_end(); ?>
    
</main>

<script>
	jQuery(document).ready(function($) {

        if ( $('.header-carousel-owl.owl-carousel').length ) { 

            <?php if( $columns == 'col_3' && $get_carousel || $columns == 'col_4' && $get_carousel ) { ?>

                // set active-item class to to middle active item

                $(".header-carousel-owl.owl-carousel").on('initialize.owl.carousel initialized.owl.carousel ' + 'initialize.owl.carousel initialize.owl.carousel ' + 'translate.owl.carousel translated.owl.carousel ' + 'resize.owl.carousel resized.owl.carousel ',
                    function(e) {
                        var idx = e.item.index;
                        $('.owl-item.active').removeClass('active-item');
                        $('.owl-item').eq(idx+1).addClass('active-item');
                        $('.owl-item').eq(idx-1).removeClass('active-item');
                    }
                );

            <?php } ?>

            $(".header-carousel-owl.owl-carousel").owlCarousel({
                <?php if( $hidden_items ) { ?>
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
                <?php if( $spacing ) { ?>
                    margin : 20,
                <?php } ?>
                responsiveClass : true,
                <?php if( $columns == 'col_1' ) { ?>
                    responsive : {
                        0: {
                            items: 1,
                        }
                    },
                <?php } elseif( $columns == 'col_4' ) { ?>
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


        // check the header height for mobile and desktop view

        $(window).on("load", function() {
            checkHeaderHeight();
        });
        checkHeaderHeight();

        $(window).resize(checkHeaderHeight);            

        var navBarHeight;

        function checkHeaderHeight() {
            // mobile-desktop switch        
            var mobile_768_less = $( '.mobile-check' ).css( 'display' ) === 'none';
            var mobile_768_more = $( '.mobile-check' ).css( 'display' ) === 'block';                

            if( mobile_768_less ) {
                navBarHeight = $('.navbar-header').outerHeight();
            } else if( mobile_768_more ) {
                navBarHeight = $('.navbar').outerHeight();
            }

        }

        // find the heighest height of owl items

        function setTheHeight() {

            // Get value of highest element
            var maxHeight = Math.max.apply(Math, $('.header-carousel-owl .header-carousel-spacer').map (
                function() {
                    return $(this).outerHeight();
                }
            ));

            var wpAdminBarHeight;
            var topLayerHeight;
            var topBarHeight;
            var logoHeight;
            var topSumHeight;

            if ( $( '.full-page' ).length ) { 

                wpAdminBarHeight = $('#wpadminbar').outerHeight();
                topLayerHeight = $('.top-layer').outerHeight();
                topBarHeight = $('.topbar').outerHeight();
                logoHeight = $('.main-logo').outerHeight();    
                topSumHeight = wpAdminBarHeight + topLayerHeight + topBarHeight + logoHeight + navBarHeight;

                var topSumMargin = parseInt( $( '.full-page .content-box' ).css('margin-top') );

                $( '.full-page .header-carousel-owl .header-carousel-item' ).height( maxHeight + topSumHeight - topSumMargin );

            } else {

                $( '.header-carousel-owl .header-carousel-item' ).height( maxHeight );

            }

        }
        
        $(window).on("load", function() {
            setTheHeight();
        });
        
        // set height after window resizing

        $(window).resize(function() {
            setTheHeight();
        });

        // set height after owl carousel resizing

        $(".header-carousel-owl.owl-carousel").on('resize.owl.carousel resized.owl.carousel ',
            function(e) {
                setTheHeight();
            }
        );

    });
</script>


