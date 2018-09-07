
<?php // POPUP MODAL WINDOW

if( ACF_HR('add_custom_popup', 'option') ): 
    while ( ACF_HR('add_custom_popup', 'option') ) { the_row(); 								

        $custom_popup_output = ACF_GSF('custom_popup_output', 'option');
        $custom_popup_id = ACF_GSF('custom_popup_id', 'option');
        $custom_popup_title = ACF_GSF('custom_popup_title', 'option');											
        $custom_popup_content = ACF_GSF('custom_popup_content', 'option');
        $custom_popup_form_id = ACF_GSF('custom_popup_form_id', 'option');

        hannah_cd_content_visibility( get_the_ID() );
                                                 
        global $hannah_cd_visibility, $hannah_cd_visibility_cases;       	
                         
        if( ! empty( $hannah_cd_visibility ) ) {
            foreach( $hannah_cd_visibility as $display ) :
                if( $hannah_cd_visibility_cases[ $display ] ) : ?>

                    <div id="<?php echo esc_attr( $custom_popup_id ); ?>" class="popup modal fade text-center" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <span class="close" data-dismiss="modal" aria-label="Close">&times;</span>
                                    <div class="h2-title"><?php echo esc_html( $custom_popup_title ); ?></div>
                                </div>
                                <div class="modal-body">

                                    <?php if( $custom_popup_content ) {
                                        echo ACF_GSF('custom_popup_content', 'option');
                                    } 

                                    if( $custom_popup_output == 'contact_form_7' ) { 

                                        if( empty( $custom_popup_form_id ) ) {
                                            echo esc_html__( 'Please insert you contact form id.', 'hannah-cd' );
                                        } else {
                                            echo do_shortcode( '[contact-form-7 id="' . esc_html( $custom_popup_form_id ) . '"]' );
                                        }

                                    } elseif( $custom_popup_output == 'newsletter' ) { 

                                        if( ACF_HR('newsletter_form_show', 'option') ) : 
                                            while ( ACF_HR('newsletter_form_show', 'option') ) { 

                                                /* include afc newsletter select */ 
                                                get_template_part( 'inc/acf', 'newsletter' );

                                            }
                                        endif;

                                    } ?>

                                </div>
                            </div>
                        </div>
                    </div>

                <?php endif; 
            endforeach;
        }
                                                    
    }
endif; ?>