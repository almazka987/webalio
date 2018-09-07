<?php 
/*
*************************************** 
Displaying page header backgrounds
***************************************
*/ 

    $background_color = ACF_GSF('background_color');
    $background_gradient_start = ACF_GSF('background_gradient_start_color');
    $background_gradient_end = ACF_GSF('background_gradient_end_color');
    $background_image = ACF_GSF('background_image');
    $bg_image = wp_get_attachment_image_src( $background_image, 'large', false, '' );
    $bg_image_featured = get_the_post_thumbnail_url( get_the_ID(), 'large' );

    $background_video = ACF_GSF('background_video'); 
    $background_video_alternate = ACF_GSF('background_video_alternate'); 
    $background_video_external = ACF_GSF('background_video_external'); 
    $background_video_external_alternate = ACF_GSF('background_video_external_alternate'); 
    $background_video_poster = ACF_GSF('background_video_poster'); 
    $remove_overlay = ACF_GSF('remove_overlay');

    if( $hannah_cd_header_full || $hannah_cd_header_fullscreen || $hannah_cd_header_wide ) {        
        $fixed_background_image = ACF_GF('header_fixed_bg', 'option');
    } else {
        $fixed_background_image = false;
    }

    // BACKGROUND IMAGE

    if( ACF_GSF('image_or_video') == 'bgimage' && $bg_image ) { ?>
        
        <main class="header<?php if( $remove_overlay ) { ?> no-overlay<?php } ?><?php if( $header_object_image ) { ?> header-object<?php } ?><?php if( $header_object_overflow ) { ?> header-overflow<?php } ?><?php if( $fixed_background_image ) { ?> header-fixed<?php } ?>" style="background-image:url(<?php echo esc_url( $bg_image[0] ); ?>)">
    
    <?php // BACKGROUND FEATURED IMAGE
                                                              
    } elseif( ACF_GSF('image_or_video') == 'bgfeaturedimage' ) { ?>
            
        <main class="header<?php if( $remove_overlay ) { ?> no-overlay<?php } ?><?php if( $header_object_image ) { ?> header-object<?php } ?><?php if( $header_object_overflow ) { ?> header-overflow<?php } ?><?php if( $fixed_background_image ) { ?> header-fixed<?php } ?>" style="background-image:url(<?php echo esc_url( $bg_image_featured ); ?>)">
                
    <?php // BACKGROUND VIDEO
                                                              
    } elseif( ACF_GSF('image_or_video') == 'bgvideo' && $background_video || $background_video_alternate ) {
        
        if( $background_video || $background_video_alternate ) { ?>
            <main class="header header-video<?php if( $remove_overlay ) { ?> no-overlay<?php } ?><?php if( $header_object_image ) { ?> header-object<?php } ?><?php if( $header_object_overflow ) { ?> header-overflow<?php } ?>">
                <video class="video-bg" autoplay loop muted<?php if( $background_video_poster ) { ?> poster="<?php echo esc_attr( $background_video_poster ); ?>"<?php } ?>>
                    <source src="<?php echo esc_url( $background_video ); ?>" type="video/mp4">
                    <?php if( $background_video_alternate ) { ?>
                        <source src="<?php echo esc_url( $background_video_alternate ); ?>" type="video/webm">
                    <?php } ?>
                </video>
        <?php }
                                                                                                            
    // BACKGROUND VIDEO EXTERN
                                                              
    } elseif ( ACF_GSF('image_or_video') == 'bgvideoextern' && $background_video_external || $background_video_external_alternate) {
        
        if( $background_video_external || $background_video_external_alternate ) { ?>
            <main class="header header-video<?php if( $remove_overlay ) { ?> no-overlay<?php } ?><?php if( $header_object_image ) { ?> header-object<?php } ?><?php if( $header_object_overflow ) { ?> header-overflow<?php } ?>">
                <video class="video-bg" autoplay loop muted<?php if( $background_video_poster ) { ?> poster="<?php echo esc_attr( $background_video_poster ); ?>"<?php } ?>>
                    <source src="<?php echo esc_url( $background_video_external ); ?>" type="video/mp4">
                    <?php if( $background_video_external_alternate ) { ?>
                        <source src="<?php echo esc_url( $background_video_external_alternate ); ?>" type="video/webm">
                    <?php } ?>
                </video>
        <?php }
                                                                                                                                    
    // BACKGROUND COLOR
                                                              
    } elseif( ACF_GSF('image_or_video') == 'bgcolor' ) { ?>
        
            <main class="header<?php if( $remove_overlay ) { ?> no-overlay<?php } ?><?php if( $header_object_image ) { ?> header-object<?php } ?><?php if( $header_object_overflow ) { ?> header-overflow<?php } ?>" style="background-color:<?php echo esc_html( $background_color ); ?>">
    
    <?php // BACKGROUND GRADIENT
                                                        
    } elseif( ACF_GSF('image_or_video') == 'bggradient' ) { ?>
        
            <main class="header<?php if( $remove_overlay ) { ?> no-overlay<?php } ?><?php if( $header_object_image ) { ?> header-object<?php } ?><?php if( $header_object_overflow ) { ?> header-overflow<?php } ?>" style="background: radial-gradient(ellipse at center, <?php echo esc_html( $background_gradient_start ); ?> 0%, <?php echo esc_html( $background_gradient_end ); ?> 100%);">
                
    <?php } else { ?>

            <main class="header<?php if( $remove_overlay ) { ?> no-overlay<?php } ?><?php if( $header_object_image ) { ?> header-object<?php } ?><?php if( $header_object_overflow ) { ?> header-overflow<?php } ?>">

    <?php } ?>