<?php 
/*
*************************************** 
Displaying a static page
***************************************
*/ 
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
	<?php 
		$uc_title = ACF_GF('under_construction_title', 'option');
		$uc_text = ACF_GF('under_construction_text', 'option');
		$uc_countdown = ACF_GF('under_construction_countdown', 'option');
		$uc_date = ACF_GF('under_construction_date', 'option');
	
		$uc_section = ACF_GF('under_construction_additional_section', 'option');
	
		$uc_image = ACF_GF('under_construction_image', 'option');
		$bg_image = wp_get_attachment_image_src( $uc_image, 'large', false, '' );
	
		wp_head(); 
	?>
	
	<script type="text/javascript">
		( function($) {
  			'use strict';
			
			$(document).ready(function() {
				
				$("#clock").countdown("<?php echo esc_html( $uc_date ); ?>", function(event) {
					
					var $this = $(this).html(event.strftime(''
						+ '<div><span class="countdown-num">%-w</span> <span class="countdown-label"><?php echo esc_html__( 'week%!w', 'hannah-cd' ); ?></span></div>' // german: Woche%!D:n;
						+ '<div><span class="countdown-num">%-d</span> <span class="countdown-label"><?php echo esc_html__( 'day%!d', 'hannah-cd' ); ?></span></div>' // german: Tag%!D:e;
						+ '<div><span class="countdown-num">%H</span> <span class="countdown-label"><?php echo esc_html__( 'hours', 'hannah-cd' ); ?></span></div>'
						+ '<div><span class="countdown-num">%M</span> <span class="countdown-label"><?php echo esc_html__( 'minutes', 'hannah-cd' ); ?></span></div>'
						+ '<div><span class="countdown-num">%S</span> <span class="countdown-label"><?php echo esc_html__( 'seconds', 'hannah-cd' ); ?></span></div>')
					);
    				
  				});				
				
			});
			
		})(jQuery);
	</script>
	
</head>

<body <?php body_class(); ?>>

	<div class="under-construction" <?php if( $uc_image ) { ?>style="background-image:url(<?php echo esc_url( $bg_image[0] ); ?>)"<?php } ?>>
		<div class="under-construction-wrapper">
			<div class="container">
				<div class="row">

					<div class="under-construction-content">
					
						<h1 class="under-construction-title wow fadeInDown">
							<?php 
								if( $uc_title ) {
									echo esc_html( $uc_title );
								} else {
									echo get_bloginfo();
								} 
							?>
						</h1>

						<div class="under-construction-text">
							<?php 
								if( $uc_text ) {
									echo esc_html( $uc_text );
								} else {
									echo esc_html__( 'We are coming very soon.', 'hannah-cd' );
								} 
							?>
						</div>
						
						<?php if( $uc_countdown ) {?>
							<div class="countdown">
								<span id="clock"></span>
							</div>
						<?php } ?>
						
						<?php if( $uc_section == 'form' ) { ?>
							<div class="under-construction-form">
								<?php if( ACF_HR('newsletter_form_show', 'option') ) : 
									while ( ACF_HR('newsletter_form_show', 'option') ) { 
										
										/* include afc newsletter select */ 
										get_template_part( 'inc/acf', 'newsletter' );
										
									}
								endif; ?>
							</div>
						<?php } ?>
						
						<?php if( $uc_section == 'button' ) { ?>
							<?php if( ACF_HR('button_show', 'option') ) : ?>
								<div class="under-construction-buttons">
									<?php while ( ACF_HR('button_show', 'option') ) { 

										/* include afc button select */ 
										get_template_part( 'inc/acf', 'buttons' ); 

									} ?>
								</div>
							<?php endif; ?>
						<?php } ?>
						
					</div>

				</div>
			</div>
		</div>
	</div>
 
	<?php wp_footer(); ?>

</body>
</html>

 


