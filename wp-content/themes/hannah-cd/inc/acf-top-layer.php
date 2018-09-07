
<?php // TOP LAYER 

if( ACF_HR('add_top_layer', 'option') ) : 
    while ( ACF_HR('add_top_layer', 'option') ) { the_row();
                                                 
        hannah_cd_content_visibility( get_the_ID() );
                                                 
        global $hannah_cd_visibility, $hannah_cd_visibility_cases; 
        
        if( ! empty( $hannah_cd_visibility ) ) {
            foreach( $hannah_cd_visibility as $display ) :
                if( $hannah_cd_visibility_cases[ $display ] ) :

                    $top_layer_icon = ACF_GSF('top_layer_icon', 'option');
                    $top_layer_action = ACF_GSF('top_layer_action', 'option');
                    $top_layer_color = ACF_GSF('top_layer_color', 'option'); ?>

                    <div class="top-layer"<?php if( $top_layer_color ) { ?> style="background-color:<?php echo esc_html( $top_layer_color ); ?>!important"<?php } ?>>
                        <div class="top-layer-wrapper <?php if( $top_layer_action == 'nothing' ) { ?>full<?php } ?>">
                            <div class="container">
                                <div class="top-layer-spacer">

                                    <div class="top-layer-text <?php if( $top_layer_icon ) { ?>with-icon<?php } ?>">
                                        <?php if( $top_layer_icon ) { ?>
                                            <i class="fa <?php echo esc_html( $top_layer_icon ); ?>"></i>
                                        <?php } 

                                        echo ACF_GSF('top_layer_content', 'option'); ?>
                                    </div>

                                <?php if( $top_layer_action == 'form' ) { ?>
                                    <div class="top-layer-action">
                                        <?php if( ACF_HR('newsletter_form_show', 'option') ) : 
                                            while ( ACF_HR('newsletter_form_show', 'option') ) { 

                                                /* include afc newsletter select */ 
                                                get_template_part( 'inc/acf', 'newsletter' );

                                            }
                                        endif; ?>
                                    </div>
                                <?php } elseif( $top_layer_action == 'button' ) { ?>
                                    <div class="top-layer-action">

                                        <?php if( ACF_HR('button_show', 'option') ) :
                                            while ( ACF_HR('button_show', 'option') ) {

                                                /* include afc button select */
                                                get_template_part( 'inc/acf', 'buttons' );

                                            }
                                        endif; ?>

                                    </div>
                                <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; 
            endforeach;
        }
                                                
    }
endif; ?>