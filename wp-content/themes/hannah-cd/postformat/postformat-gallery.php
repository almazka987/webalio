<?php 
/*
*************************************** 
Displaying for post format: gallery
***************************************
*/ 

	// GALLERY

	$images = ACF_GF('gallery_images_show');

	if( $images ) : ?>

    	<div class="post-thumbnail">
			<div class="owl-gallery owl-gallery-img">
				<div class="gallery-owl owl-carousel">
					<?php foreach( $images as $image ) : ?>

						<a href="<?php echo esc_url( $image['url'] ); ?>">
							<img src="<?php echo esc_url( $image['sizes']['large'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
							<?php if( $image['caption'] ) { ?><p><?php echo esc_html( $image['caption'] ); ?></p><?php } ?>
						</a>

					<?php endforeach; ?>
				</div>
			</div>
		</div>

	<?php endif; ?>

    
