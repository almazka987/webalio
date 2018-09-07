<?php 
/*
*************************************** 
Displaying for post format: video
***************************************
*/ 

	// VIDEO

	if( ACF_HR('embed_videos_show') ): ?>

		<div class="post-thumbnail">
			<div class="owl-gallery">
				<div class="gallery-owl owl-carousel">

					<?php get_template_part( 'inc/embed', 'video' ); ?>
                    
				</div>
			</div>
		</div>

   	<?php endif; ?>

    
