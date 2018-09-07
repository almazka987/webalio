<?php 

/**********************/ 
/* FEATURED SLIDER */ 
/**********************/ 

$field_id = $hannah_cd_field_id;

$fs_count = count( ACF_GF('featured_slider_static_content', $field_id) );

if( $hannah_cd_featured_slider ) { ?>

    <div class="featured-slider">

        <?php // POST OR PRODUCT SLIDER

        if( ACF_GF('featured_slider_type', $field_id) == 'post' || ACF_GF('featured_slider_type', $field_id) == 'page' || ACF_GF('featured_slider_type', $field_id) == 'product' ) {

            include( locate_template('inc/acf-featured-slider-content-post.php') );

        // STATIC SLIDER

        } else { 

            if( ACF_HR('featured_slider_static_content', $field_id) ) :

                if( $fs_count > 1 ) {  // if featured slider has more than one row = Show OWL Slideshow ?>
                    <div class="featured-slider-owl owl-carousel">
                <?php } 						

                        while ( ACF_HR('featured_slider_static_content', $field_id) ) { the_row();

                            include( locate_template('inc/acf-featured-slider-content.php') );

                        }

                if( $fs_count > 1 ) { // if featured slider has more than one row = Show OWL Slideshow ?>
                    </div>
                <?php } ?>

            <?php else : ?>

                <div class="featured-slider-item section-overlay">
                    <div class="container">
                        <div class="header-content header-center">
                            <div class="content-box">
                                <?php echo '<div class="alert alert-warning">' . esc_html__( 'No content selected', 'hannah-cd' ) . '.</div>'; ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif;

        } ?>
        
    </div>

<?php } ?>