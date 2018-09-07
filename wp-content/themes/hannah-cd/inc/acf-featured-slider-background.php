<?php 
/*
*************************************** 
Displaying featured slider backgrounds 
***************************************
*/ 

    $background_color = ACF_GSF('background_color');
    $background_gradient_start = ACF_GSF('background_gradient_start_color');
    $background_gradient_end = ACF_GSF('background_gradient_end_color');
    $background_image = ACF_GSF('background_image');
    $bg_image = wp_get_attachment_image_src( $background_image, 'large', false, '' );

    $background_video = ACF_GSF('background_video'); 
    $background_video_alternate = ACF_GSF('background_video_alternate'); 
    $background_video_external = ACF_GSF('background_video_external'); 
    $background_video_external_alternate = ACF_GSF('background_video_external_alternate'); 
    $background_video_poster = ACF_GSF('background_video_poster'); 
    $remove_overlay = ACF_GSF('remove_overlay'); 

    // BACKGROUND IMAGE

    if( ACF_GSF('image_or_video') == 'bgimage' && $bg_image ) { ?>
        
            <div class="header featured-slider-item<?php if( $remove_overlay ) { ?> no-overlay<?php } ?>" style="background-image:url(<?php echo esc_url( $bg_image[0] ); ?>)">
        
    <?php // BACKGROUND VIDEO
                                                              
    } elseif( ACF_GSF('image_or_video') == 'bgvideo' && $background_video || $background_video_alternate ) {
        
        if( $background_video || $background_video_alternate ) { ?>
            <div class="header featured-slider-item header-video<?php if( $remove_overlay ) { ?> no-overlay<?php } ?>">
                <video autoplay loop muted<?php if( $background_video_poster ) { ?> poster="<?php echo esc_attr( $background_video_poster ); ?>"<?php } ?>>
                    <source src="<?php echo esc_url( $background_video ); ?>" type="video/mp4">
                    <?php if( $background_video_alternate ) { ?>
                        <source src="<?php echo esc_url( $background_video_alternate ); ?>" type="video/webm">
                    <?php } ?>
                </video>
        <?php }
    
    // BACKGROUND VIDEO EXTERN    
        
    } elseif ( ACF_GSF('image_or_video') == 'bgvideoextern' && $background_video_external || $background_video_external_alternate) {
        
        if( $background_video_external || $background_video_external_alternate ) { ?>
            <div class="header featured-slider-item header-video<?php if( $remove_overlay ) { ?> no-overlay<?php } ?>">
                <video autoplay loop muted<?php if( $background_video_poster ) { ?> poster="<?php echo esc_attr( $background_video_poster ); ?>"<?php } ?>>
                    <source src="<?php echo esc_url( $background_video_external ); ?>" type="video/mp4">
                    <?php if( $background_video_external_alternate ) { ?>
                        <source src="<?php echo esc_url( $background_video_external_alternate ); ?>" type="video/webm">
                    <?php } ?>
                </video>
        <?php }
                                                                                                                                    
    // BACKGROUND COLOR
                                                              
    } elseif( ACF_GSF('image_or_video') == 'bgcolor' ) { ?>
        
            <div class="header featured-slider-item<?php if( $remove_overlay ) { ?> no-overlay<?php } ?>" style="background-color:<?php echo esc_html( $background_color ); ?>">
    
    <?php // BACKGROUND GRADIENT
                                                        
    } elseif( ACF_GSF('image_or_video') == 'bggradient' ) { ?>
        
            <div class="header featured-slider-item<?php if( $remove_overlay ) { ?> no-overlay<?php } ?>" style="background: radial-gradient(ellipse at center, <?php echo esc_html( $background_gradient_start ); ?> 0%, <?php echo esc_html( $background_gradient_end ); ?> 100%);">
    
    <?php } else { ?>

            <div class="header featured-slider-item<?php if( $remove_overlay ) { ?> no-overlay<?php } ?>">

    <?php } ?>