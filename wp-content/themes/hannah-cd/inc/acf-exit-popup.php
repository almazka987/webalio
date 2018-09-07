
<?php // EXIT POPUP

if( ACF_HR('add_exit_popup', 'option') ): 
    while ( ACF_HR('add_exit_popup', 'option') ) { the_row();     								

        $exit_popup_title = ACF_GSF('exit_popup_title', 'option'); 
        $exit_popup_content = ACF_GSF('exit_popup_content', 'option');
        $exit_popup_action = ACF_GSF('exit_popup_action', 'option');

        $exit_popup_image = ACF_GSF('exit_popup_image', 'option');
        $bg_image = wp_get_attachment_image_src( $exit_popup_image, 'large', false, '' );	

        $exit_popup_style = ACF_GSF('exit_popup_style', 'option'); 

        if( $exit_popup_style == 'right' ) {
            $style_class = 'right';
        } elseif( $exit_popup_style == 'left' ) {
            $style_class = 'left';
        } else {
            $style_class = 'full';
        }

        hannah_cd_content_visibility( get_the_ID() );
                                                 
        global $hannah_cd_visibility, $hannah_cd_visibility_cases;  
                                                  
        if( ! empty( $hannah_cd_visibility ) ) {
            foreach( $hannah_cd_visibility as $display ) :
                if( $hannah_cd_visibility_cases[ $display ] ) :	 ?>

                    <div id="bio_ep" class="exit-popup animated fadeIn <?php echo esc_html( $style_class ); ?>">

                        <div id="bio_ep_close" class="exit-popup-close">&times;</div>

                        <div class="exit-popup-content" <?php if( $exit_popup_image ) { ?>style="background-image:url(<?php echo esc_url( $bg_image[0] ); ?>)"<?php } ?>>

                        <?php if( $exit_popup_style != 'full' ) { ?>
                            <div class="exit-popup-content-align">
                        <?php } ?>

                                <div class="exit-popup-header">
                                    <div class="h2-title"><?php echo esc_html( $exit_popup_title ); ?></div>
                                </div>

                                <div class="exit-popup-body">

                                    <?php echo hannah_cd_kses( $exit_popup_content ); ?>

                                    <?php if( $exit_popup_action == 'form' ) { ?>
                                        <div class="exit-popup-buttons">
                                            <?php if( ACF_HR('newsletter_form_show', 'option') ) : 
                                                while ( ACF_HR('newsletter_form_show', 'option') ) { 

                                                    /* include afc newsletter select */ 
                                                    get_template_part( 'inc/acf', 'newsletter' );

                                                }
                                            endif; ?>
                                        </div>
                                    <?php } elseif( $exit_popup_action == 'button' ) { ?>
                                        <?php if( ACF_HR('button_show', 'option') ): ?>
                                            <div class="exit-popup-buttons">
                                                <?php while ( ACF_HR('button_show', 'option') ) { ?>

                                                    <?php /* include afc button select */ ?>
                                                    <?php get_template_part( 'inc/acf', 'buttons' ); ?>

                                                <?php } ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php } ?>

                                </div>

                        <?php if( $exit_popup_style != 'full' ) { ?>
                            </div>
                        <?php } ?>

                        </div>

                    </div>

                <?php endif; 
            endforeach;
        }
            
    }
endif; ?>