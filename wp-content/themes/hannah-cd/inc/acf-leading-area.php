
<?php // LEADING AREA 

global $hannah_cd_field_id; 
$field_id = $hannah_cd_field_id;

$area_html = ACF_GSF('area_content', 'option') == 'html';
$area_banner = ACF_GSF('area_content', 'option') == 'banner';
$area_grid = ACF_GSF('area_content', 'option') == 'content_grid';
$area_promo = ACF_GSF('area_content', 'option') == 'promobox';

$area_post_carosuel = ACF_GSF('area_carousel_type', 'option') == 'carousel_post';
$area_product_carosuel = ACF_GSF('area_carousel_type', 'option') == 'carousel_product';
$area_tax_carosuel = ACF_GSF('area_carousel_type', 'option') == 'cat_tag_teaser';

hannah_cd_content_visibility( get_the_ID() );

global $hannah_cd_visibility, $hannah_cd_visibility_cases; 

if( ! empty( $hannah_cd_visibility ) ) {
    foreach( $hannah_cd_visibility as $display ) :
        if( $hannah_cd_visibility_cases[ $display ] ) : ?>

            <div class="leading-area<?php if( $area_grid ) { ?> content-grid<?php } ?>">                
                <div class="container">
                    <div class="row">
                                
                        <?php // CUSTOM HTML

                        if( $area_html ) { 

                            echo ACF_GSF('area_custom_html', 'option');

                        // RANDOM AD BANNER

                        } elseif( $area_banner ) { ?> 

                            <div class="ad-banner">
                                <div class="ad-banner-content">

                                    <?php get_template_part( 'inc/acf', 'area-random-ad-banner' ); ?>

                                </div>
                            </div>

                        <?php // CONTENT GRID 

                        } elseif( $area_grid ) {

                            include( locate_template( 'inc/acf-area-content-grid.php' ) );

                        // PROMOBOX

                        } elseif( $area_promo ) { 

                            if( ACF_GSF('promo_box_show', 'option') ) :

                                get_template_part( 'inc/acf', 'area-promo-box' );

                            endif;

                        // POST TYPE CAROUSEL (POSTS, PRODUCTS)  

                        } elseif( $area_post_carosuel || $area_product_carosuel ) { ?>

                            <div class="area-carousel">
                                <div class="leading-area-owl owl-carousel <?php if( $area_product_carosuel ) { ?> product<?php } ?>">

                                    <?php include( locate_template('inc/acf-area-post-type-carousel.php') ); ?>

                                </div>
                            </div>

                        <?php // TAXONOMY CAROUSEL (CATEGORIES, TAGS) 

                        } elseif( $area_tax_carosuel ) { ?>

                            <div class="area-carousel">
                                <div class="leading-area-owl owl-carousel">

                                    <?php include( locate_template('inc/acf-area-taxonomy-carousel.php') ); ?>

                                </div>
                            </div>

                        <?php }

                        // OWL CAROUSEL 

                        if( ACF_GSF('area_content', 'option') == 'carousel' ) { 

                            $carousel_in_use = $area_post_carosuel || $area_product_carosuel || $area_tax_carosuel;

                            if( $carousel_in_use ) { ?>

                                <script>
                                    ( function($) { 'use strict';

                                        $(document).ready(function($) {

                                            if ( $('.leading-area-owl.owl-carousel').length ) { 

                                                $(".leading-area-owl.owl-carousel").owlCarousel({
                                                    items: <?php echo esc_html( $item_count ); ?>,
                                                    nav : false,
                                                    navText : false,
                                                    dots : false,
                                                    <?php if( $get_carousel ) { ?>
                                                        loop : true,
                                                    <?php } ?>
                                                    slideSpeed : 400,
                                                    autoplay : true,
                                                    autoplayTimeout : 5000,
                                                    autoplayHoverPause : true,
                                                    autoHeight : false,
                                                    responsiveClass : true,
                                                    <?php if( ! $get_carousel ) { ?>
                                                        mouseDrag : false,
                                                    <?php } ?>
                                                    responsiveClass : true,
                                                    <?php if( $teaser_column == 'col_1' ) { ?>
                                                        responsive : {
                                                            0: {
                                                                items: 1,
                                                            }
                                                        },
                                                    <?php } elseif( $teaser_column == 'col_2' ) { ?>
                                                        responsive : {
                                                            0: {
                                                                items: 1,
                                                            },
                                                            768: {
                                                                items: 2,
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
                                                                items: 3,
                                                            }
                                                        },
                                                    <?php } ?>
                                                });	

                                            }	

                                        });

                                    })(jQuery);
                                </script>

                            <?php }

                        } ?>

                    </div>
                </div>
            </div>

        <?php endif; 
    endforeach; 
} ?>

	