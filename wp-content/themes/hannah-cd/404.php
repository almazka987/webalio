<?php
/*
*************************************** 
Displaying for 404 error page
***************************************
*/ 

get_header();

$error_headline = ACF_GF('error_headline', 'option');
$error_text = ACF_GF('error_text', 'option');

$error_action = ACF_GF('error_action', 'option');
$error_404_label = ACF_GF('error_404_label', 'option');
$error_home_button = ACF_GF('error_home_button', 'option');
$error_home_button_label = ACF_GF('error_home_button_label', 'option');
$error_align = ACF_GF('error_alignment', 'option');
			
if( $error_align == 'right' ) {
	$alignment = 'right';
} elseif( $error_align == 'center' ) {
	$alignment = 'center';
} else {
	$alignment = 'left';
}

$error_background = ACF_GF('error_background', 'option');
$bg_image = wp_get_attachment_image_src( $error_background, 'large', false, '' ); ?>       

	<div class="headers fit-to-fullscreen">
		<main class="header section-overlay"<?php if( $bg_image ){ ?> style="background-image:url(<?php echo esc_url( $bg_image[0] ); ?>)"<?php } ?>>			
			
			<div class="header-content header-<?php echo esc_html( $alignment ); ?>">
				<div class="container">                    

                    <div class="content-box">
                        
                        <?php if( ! $error_404_label ) { ?>
                            <div class="label-404">
                                <span>404</span>
                            </div>
                        <?php } ?>

                        <h1 class="wow fadeInDown">
                            <?php if( $error_headline ) {
                                echo esc_html( $error_headline );
                            } else {
                                esc_html_e( 'Oops! That page can&rsquo;t be found.', 'hannah-cd' );
                            } ?>
                        </h1>

                        <p>
                            <?php if( $error_text ) {
                                echo esc_html( $error_text );
                            } else {
                                esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'hannah-cd' );
                            } ?>
                        </p>

                        <div class="header-buttons">

                            <?php if( $error_action == 'form' ) {

                                if( ACF_HR('newsletter_form_show', 'option') ) : 
                                    while ( ACF_HR('newsletter_form_show', 'option') ) { 

                                        /* include afc newsletter select */ 
                                        get_template_part( 'inc/acf', 'newsletter' );

                                    }
                                endif;

                            } elseif( $error_action == 'button' ) {

                                if( ACF_HR('button_show', 'option') ) :
                                    while ( ACF_HR('button_show', 'option') ) { 

                                        /* include afc button select */ 
                                        get_template_part( 'inc/acf', 'buttons' ); 

                                    }
                                endif;

                            } else {

                                get_search_form();

                            } ?>

                        </div>

                    </div>
                    
				</div>
			</div>
		</main>
	</div>
		
	<?php // HOME BUTTON 

	if( ! $error_home_button ) { ?>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fit-to-fullscreen-scroll">
			<span class="scrollDown-button home animated infinite bounce"></span>
			<span class="scrollDown-label">
				<?php if( $error_home_button_label ) { 
					echo esc_html( $error_home_button_label ); 
				} else { 
					echo esc_html_e( 'Go to Home', 'hannah-cd' ); 
				} ?>
			</span>
		</a>

	<?php }

get_footer(); ?>
