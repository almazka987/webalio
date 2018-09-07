<?php 
/*
*************************************** 
Displaying page header content
***************************************
*/ 

	$header_compact = ACF_GF('header_padding', $field_id);
    $header_alignment = ACF_GF('header_alignment', $field_id);

    if( $header_alignment == 'left' ) {
        $header_align = 'left';
    } elseif( $header_alignment == 'right' ) {
        $header_align = 'right';
    } else {
        $header_align = 'center';
    }

	$home_header_title = ACF_GSF('home_header_title', $field_id);
	$home_header_text = ACF_GSF('home_header_text', $field_id);
    $title_type_select = ACF_GSF('title_type_select', $field_id);
	$particles = ACF_GSF('particles_show', $field_id); 
    $box_style = ACF_GF('header_content_style', 'option');
    
    $header_object_image = ACF_GSF('object_image', $field_id);
    $header_object_width = ACF_GSF('object_width', $field_id);
    $header_object_width_col_1 = 100 - $header_object_width;
    $header_object_overflow = ACF_GSF('object_overflow', $field_id);
    $header_object_bottom = ACF_GSF('object_bottom', $field_id);

    // get the image object
    if( $header_object_image ) {
        if( ! is_array( $header_object_image ) ) { $header_object_image = acf_get_attachment( $header_object_image ); }
        $thumb_object_size = 'large';
        $thumb_object = $header_object_image['sizes'][ $thumb_object_size ];
    }
        
    if( is_category() || is_tag() || is_tax() ) {
        $the_title = get_the_archive_title();
    } else {
        $the_title = get_the_title();
    }

	/* <main> include afc header background select */
    include( locate_template('inc/acf-header-background.php') ); ?>

    <div class="container">
	    <div class="header-content<?php if( $header_compact == 'compact' ) { ?> header-compact<?php } ?> header-<?php echo esc_html( $header_align ); ?><?php if( $box_style == 'box' ) { ?> header-box<?php } ?>">		
            <div class="content-box"<?php if( $header_object_image ) { ?> style="width:<?php echo esc_html( $header_object_width_col_1 ); ?>%"<?php } ?>>

                <?php if( $title_type_select == 'typed' ) {

                    // TYPEWRITER TITLE

                    if( ACF_HR('home_header_title_typed', $field_id) ) :
                        while( ACF_HR('home_header_title_typed', $field_id) ) { the_row();
                            if ( $hannah_cd_header_count == 1 ) { ?> 
                                <h1 class="typewriter"><span id="typewriter"></span></h1>
                            <?php } else { // set headline to h2, if there are more than one header ?>
                                <h2 class="typewriter"><span id="typewriter"></span></h2>
                            <?php } 
                        }
                    endif; ?>  

                    <script>
                        jQuery(document).ready(function() {
                            var typewriter = new Typed('#typewriter', {                                
                                strings: [
                                    <?php if( ACF_HR('home_header_title_typed', $field_id) ) :
                                        while( ACF_HR('home_header_title_typed', $field_id) ) { the_row();
                                            echo '"' . ACF_GSF('title_typed', $field_id) . '",';
                                        }
                                    endif; ?>
                                ],
                                typeSpeed: 60,
                                backSpeed: 0,
                                backDelay: 1500,
                                startDelay: 1000,
                                fadeOut: true,
                                loop: true
                            });                                
                        });
                    </script>

                <?php } elseif( $title_type_select == 'page_title' ) {

                    // PAGE TITLE

                    if ( $hannah_cd_header_count == 1 ) { ?> 
                        <h1><?php echo esc_html( $the_title ); ?></h1>
                    <?php } else { // set headline to h2, if there are more than one header ?>
                        <h2><?php echo esc_html( $the_title ); ?></h2>
                    <?php } 

                } else {

                    // DEFAULT TITLE

                    if( $home_header_title ) { ?>
                        <?php if ( $hannah_cd_header_count == 1 ) { ?> 
                            <h1><?php echo ACF_GSF('home_header_title', $field_id); ?></h1>
                        <?php } else { // set headline to h2, if there are more than one header ?>
                            <h2><?php echo ACF_GSF('home_header_title', $field_id); ?></h2>
                        <?php } 
                    } 

                }

                if( $home_header_text ) {
                    echo ACF_GSF('home_header_text', $field_id);
                }

                if( ACF_HR('button_show', $field_id) ) : ?>
                    <div class="header-buttons">
                        <?php while ( ACF_HR('button_show', $field_id) ) {
                            include( locate_template('inc/acf-buttons.php') );
                        } ?>
                    </div>
                <?php endif; ?>                    

            </div>

            <?php // HEADER OBJECT

            if( $header_object_image ) : 
                $myeffect = ACF_GSF('animated_image_effect'); 
                $myeffectduration = ACF_GSF('animated_image_effect_duration'); ?>

                <div class="object-header" style="width:<?php echo esc_html( $header_object_width ); ?>%">
                    <div class="object-content">                            
                        <div class="object-content-in"<?php if( $header_object_bottom ) { ?> style="bottom:-<?php echo esc_html( $header_object_bottom ); ?>px"<?php } ?>>
                            <img src="<?php echo esc_url( $thumb_object ); ?>" alt="<?php echo esc_attr( $header_object_image['alt'] ); ?>" class="<?php if( $myeffect ) { ?> wow <?php echo esc_attr( $myeffect ); ?><?php } ?>" data-wow-duration="<?php if( $myeffectduration ) { ?><?php echo esc_attr( $myeffectduration ); ?><?php } ?>s" />
                        </div>
                    </div>
                </div>

            <?php endif; ?>

        </div>
		
	</div>
		
    <?php if( $particles ) { ?>
        <div id="particles-js"></div>
    <?php } 

    hannah_cd_header_end(); ?>

</main>

<?php $hannah_cd_header_count ++; // end counter ?>