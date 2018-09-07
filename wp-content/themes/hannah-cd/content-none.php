<?php 
/*
*************************************** 
Displaying for nothing found page 
***************************************
*/ 

$error_background = ACF_GF('error_background', 'option');
$bg_image = wp_get_attachment_image_src( $error_background, 'large', false, '' );

?>       

<main class="header section-overlay" <?php if( $bg_image ){ ?>style="background-image:url(<?php echo esc_url( $bg_image[0] ); ?>)"<?php } ?>>
	<div class="header-content">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">

					<h1 class="wow fadeInDown"><?php esc_html_e( 'Nothing Found', 'hannah-cd' ); ?></h1>

					<p>
						<?php if ( is_search() ) : ?>
							<?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hannah-cd' ); ?>
						<?php else : ?>
							<?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'hannah-cd' ); ?>  
						<?php endif; ?>
					</p>
					
					<div class="header-buttons">
						<?php get_search_form(); ?>
					</div>

				</div>
			</div>
		</div>
	</div>
</main>
