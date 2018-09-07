<?php 
/*
*************************************** 
Displaying featured slider content
***************************************
*/ 

$featured_title = ACF_GSF('featured_slider_title', $field_id);
$featured_text = ACF_GSF('featured_slider_text', $field_id);
$box_style = ACF_GF('fs_content_style', 'option');

/* <div class="featured-slider-item"> include afc featured slider background select */
include( locate_template('inc/acf-featured-slider-background.php') ); ?>

    <div class="container">
        <div class="header-content header-center <?php if( $box_style == 'box' ) { ?> header-box<?php } ?>">
            <div class="content-box">

                <?php if( $featured_title ) { ?>
                    <h2><?php echo ACF_GSF('featured_slider_title', $field_id); ?></h2>
                <?php }

                if( $featured_text ) {
                    echo ACF_GSF('featured_slider_text', $field_id);
                }

                if( ACF_HR('button_show', $field_id) ) : ?>
                    <div class="header-buttons">
                        <?php while ( ACF_HR('button_show', $field_id) ) {
                            include( locate_template('inc/acf-buttons.php') );
                        } ?>
                    </div>
                <?php endif; ?>

            </div>
			
		</div>
		
	</div>
	
</div>