
<?php // LOGO

// FULL PAGE HEADER LOGO 
					
if( $hannah_cd_header_full || is_404() ) { 

    if( ! empty( $image_white ) ) :

        echo '<img class="logo-white" src="' . esc_url( $image_white['url'] ) . '" alt="' . esc_attr( $image_white['alt'] ) . '" width="' . esc_attr( $logo_white_width ) . '" />';

    else :	

        echo '<div class="logo-white logo-title">' . get_bloginfo() . '</div>';

    endif; 				

    if( ! empty( $image_normal ) ) :

        echo '<img class="logo-img" src="' . esc_url( $image_normal['url'] ) . '" alt="' . esc_attr( $image_normal['alt'] ) . '" width="' . esc_attr( $logo_normal_width ) . '" />';

    else :	

        echo '<div class="logo-img logo-title">' . get_bloginfo() . '</div>';

    endif; 

    if( $logo_teaser_text ) { ?>
        <div class="logo-teaser-text"><span><?php echo( esc_html( $logo_teaser_text ) ) ?></span></div>
    <?php } 

// DEFAULT LOGO 

} else { 

    if( ! empty( $image_normal ) ) : 

        echo '<img src="' . esc_url( $image_normal['url'] ) . '" alt="' . esc_attr( $image_normal['alt'] ) . '" width="' . esc_attr( $logo_normal_width ) . '" />';

    elseif ( empty( $image_normal ) ) : 

        echo '<div class="logo-title">' . get_bloginfo() . '</div>';

    endif; 

    if( $logo_teaser_text ) { ?>
        <div class="logo-teaser-text"><span><?php echo( esc_html( $logo_teaser_text ) ) ?></span></div>
    <?php } 

} ?>