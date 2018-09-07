
<?php // PAGE HEADERS 

$field_id = $hannah_cd_field_id;

$count = count( ACF_GF('page_headers', $field_id) );
$fit_to_fullscreen = ACF_GF('header_style', $field_id) == 'fullscreen';
$scroll_down_button_label = ACF_GF('full_page_scrolldown_button_label', $field_id);	

if( $hannah_cd_header ) { ?>

    <div class="headers container<?php if ( $fit_to_fullscreen ) { ?> fit-to-fullscreen<?php } ?>" id="section_top">

        <?php // POST OR PRODUCT HEADER

        if( ACF_GF('header_type', $field_id) == 'post' || ACF_GF('header_type', $field_id) == 'page' || ACF_GF('header_type', $field_id) == 'product' ) { 

            include( locate_template('inc/acf-header-content-post.php') );

        // STATIC HEADER

        } else {

            // STATIC HEADER ITEMS
            
            if( ACF_HR('page_headers', $field_id) ) {
                
                if( $count > 1 ) { echo '<div class="header-owl owl-carousel">'; } // with more than one row, add OWL carousel

                    $hannah_cd_header_count = 1;
                    while ( ACF_HR('page_headers', $field_id) ) { the_row();
                        include( locate_template('inc/acf-header-content.php') );
                    }

                if( $count > 1 ) {  echo '</div>'; } // with more than one row, add OWL carousel

            // STATIC HEADER ERROR MESSAGE
                
            } else { ?>

                <main class="header">
                    <div class="container">
                        <div class="header-content header-center">
                            <div class="content-box">
                                <?php echo '<div class="alert alert-warning">' . esc_html__( 'No content selected', 'hannah-cd' ) . '.</div>'; ?>
                            </div>
                        </div>
                    </div>
                </main>

            <?php }

        } 
        
        // SCROLL DOWN BUTTON FOR FIT TO FULL SCREEN HEADER 

        if ( $fit_to_fullscreen && $scroll_down_button_label ) { ?>
            <a href="#content-scroll" class="fit-to-fullscreen-scroll section-scroll">
                <span class="scrollDown-button animated infinite bounce"></span>
                <span class="scrollDown-label"><?php echo esc_html( $scroll_down_button_label ); ?></span>
            </a>
        <?php } ?>
        
    </div>

<?php }

// MAP SECTION

if( ACF_GF('map_show', 'option') && ACF_GF('map_api_key', 'option') ) {
    if( ACF_HR('maps', 'option') ) : 
        while ( ACF_HR('maps', 'option') ) { the_row(); 	
            if( ACF_GSF('map_position', 'option') == 'top' ) {
                include( locate_template('inc/acf-map.php') );
            }
        }
    endif; 
}

// LEADING AREA BELOW 

if( ACF_GF('leading_area_show', 'option') ) { 
    if( ACF_HR('add_leading_area', 'option') ) : 
        while ( ACF_HR('add_leading_area', 'option') ) { the_row();

            if( ACF_GSF('leading_area_position', 'option') == 'below_header' ) {
                include( locate_template('inc/acf-leading-area.php') );
            }

        } 
    endif;
} ?>