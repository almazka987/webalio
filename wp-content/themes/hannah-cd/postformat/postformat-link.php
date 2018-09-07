<?php 
/*
*************************************** 
Displaying for post format: link
***************************************
*/ 
    
    // LINK

	$link_text = ACF_GF('link_text'); 
	$link_url = ACF_GF('link_url');

	if( $link_url || $link_text ): ?>

		<div class="post-thumbnail post-format-link">
			<a href="<?php echo esc_url( $link_url ); ?>" target="_blank">
                <i class="fa fa-link"></i>
				<div>
					
					<?php if( $link_text ) {
						echo esc_html( $link_text );
					}
					
					if( $link_url ) { ?>
                    	<span>&ndash; <?php echo esc_html( $link_url ); ?></span>
                    <?php } ?>
					
				</div>
			</a>
		</div>

   	<?php endif; ?>

    
