<?php // PROMO BOX

$promo_box_column = ACF_GSF('promo_box_column', 'option'); 

if( ACF_HR('promo_box_show', 'option') ) :
    while ( ACF_HR('promo_box_show', 'option') ) : the_row(); 

        $promo_box_title = ACF_GSF('promo_box_title', 'option');
        $promo_box_link = ACF_GSF('promo_box_link', 'option');

        // get image
        $image = ACF_GSF('promo_box_img', 'option');
        if( ! is_array( $image ) ) { 
            $image = acf_get_attachment( $image ); 
        }

        // get link											
        if( $promo_box_link == 'intern' ) {
            $url = ACF_GSF('promo_box_link_to', 'option');
        } elseif( $promo_box_link == 'extern' ) {
            $url = ACF_GSF('promo_box_link_url', 'option');
        } else {
            $url = false;
        }  

        // get column
        if( $promo_box_column == 'col_1' ) {
            $column_count = 'col-md-12';
        } elseif( $promo_box_column == 'col_2' ) { 
            $column_count = 'col-md-6';
        } elseif( $promo_box_column == 'col_3' ) { 
            $column_count = 'col-md-4';
        } ?>

        <div class="promo-box-col <?php echo esc_html( $column_count ); ?>">
            <div class="promo-box">
                <?php if( $url ) { echo '<a href="' . esc_url( $url ) . '">'; } ?>
                    <div class="promo-box-content" <?php if( $image['url'] ) { ?>style="background-image: url(<?php echo esc_url( $image['url'] ); ?>)"<?php } ?>>
                        <div class="promo-box-title"><span><?php echo esc_html( $promo_box_title ); ?></span></div>
                        <div class="hover"></div>
                    </div>
                <?php if( $url ) { echo '</a>'; } ?>
            </div>
        </div>

    <?php endwhile;
endif; ?>