<?php 
/*
*************************************** 
Displaying for post format: audio
***************************************
*/ 

	// AUDIO CONTENT

	if( ACF_HR('embed_audio_show') ) : ?>

		<div class="post-thumbnail">
			<div class="owl-gallery">
				<div class="gallery-owl owl-carousel">

					<?php get_template_part( 'inc/embed', 'audio' ); ?>

				</div>
			</div>
		</div>

   	<?php endif; ?>

    
