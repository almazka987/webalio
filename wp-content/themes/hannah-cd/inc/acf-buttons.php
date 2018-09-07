<?php 
/*
*************************************** 
Displaying button types for content sections 
***************************************
*/ 

    the_row();

    $button_name = ACF_GSF('button_name');
    $button_custom_link = ACF_GSF('button_custom_link');
    $button_youtube = ACF_GSF('button_youtube');
    $button_map = ACF_GSF('button_map');
    $button_ankerlink = ACF_GSF('button_ankerlink');
    $button_form = ACF_GSF('button_form');
    $button_page = ACF_GSF('button_page');
    $button_post = ACF_GSF('button_post'); 
    $button_product = ACF_GSF('button_product');
    $button_category = ACF_GSF('button_category');
    $button_tag = ACF_GSF('button_tag');

    if( $button_name ) {
        
        // PAGES LINK
        
        if( ACF_GSF('button_types') == 'linktype1' ) {
            
            if( $button_page ) { ?>
                <a href="<?php echo esc_url( $button_page ); ?>" class="btn">
                    <?php echo esc_html( $button_name ); ?>
                </a>
            <?php }
            
        // POSTS LINK
        
        } elseif( ACF_GSF('button_types') == 'linktype2' ) {
            
            if( $button_post ) { ?>
                <a href="<?php echo esc_url( $button_post ) ; ?>" class="btn">
                    <?php echo esc_html( $button_name ); ?>
                </a>
            <?php }
        
        // CUSTOM / EXTERN LINK    
            
        } elseif ( ACF_GSF('button_types') == 'linktype3' ) {
            
            if( $button_custom_link ) { ?>
                <a href="<?php echo esc_url( $button_custom_link ); ?>" class="btn">
                    <?php echo esc_html( $button_name ); ?>
                </a>
            <?php }
        
        // VIDEO IFRAME OVERLAY LINK
            
        } elseif ( ACF_GSF('button_types') == 'linktype4' ) {
            
            if( $button_youtube ) { ?>
                <a href="<?php echo esc_url( $button_youtube ); ?>" class="btn-ico iframe-lightbox">
                    <i class="fa fa-3x fa-play-circle"></i>
                    <?php echo esc_html( $button_name ); ?>
                </a>
            <?php }
        
        // MAPS IFRAME OVERLAY LINK    
            
        } elseif ( ACF_GSF('button_types') == 'linktype5' ) {
            
            if( $button_map ) { ?>
                <a href="<?php echo esc_url( $button_map ); ?>" class="btn-ico iframe-lightbox">
                    <i class="fa fa-3x fa-map-marker"></i>
                    <?php echo esc_html( $button_name ); ?>
                </a>
            <?php }
        
        // MODAL POPUP LINK    
            
        } elseif ( ACF_GSF('button_types') == 'linktype6' ) {
            
            if( $button_form ) { ?>
                <a href="#<?php echo esc_html( $button_form ); ?>" class="btn" data-toggle="modal">
                    <?php echo esc_html( $button_name ); ?>
                </a>
            <?php }
        
        // ANCHOR LINK    
            
        } elseif ( ACF_GSF('button_types') == 'linktype7' ) {
            
            if( $button_ankerlink ) { ?>
                <a href="#<?php echo esc_html( $button_ankerlink ); ?>" class="section-scroll btn">
                    <?php echo esc_html( $button_name ); ?>
                </a>
            <?php }
        
        // PRODUCTS LINK    
            
        } elseif( ACF_GSF('button_types') == 'linktype8' ) {
            
            if( $button_product ) { ?>
                <a href="<?php echo esc_url( $button_product ) ; ?>" class="btn">
                    <?php echo esc_html( $button_name ); ?>
                </a>
            <?php }
        
        // CATEGORIES LINK    
            
        } elseif( ACF_GSF('button_types') == 'linktype9' ) {
            
            if( $button_category ) { ?>
                <a href="<?php echo get_term_link( $button_category ); ?>" class="btn">
                    <?php echo esc_html( $button_name ); ?>
                </a>
            <?php }
        
        // TAGS LINK    
            
        } elseif( ACF_GSF('button_types') == 'linktype10' ) {
            
            if( $button_tag ) { ?>
                <a href="<?php echo get_term_link( $button_tag ) ; ?>" class="btn">
                    <?php echo esc_html( $button_name ); ?>
                </a>
            <?php }
        
        }
    
    } ?>