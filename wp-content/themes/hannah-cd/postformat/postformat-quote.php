<?php 
/*
*************************************** 
Displaying for post format: quote
***************************************
*/ 

	// QUOTE 

	$quote = ACF_GF('quote_text'); 
	$quote_author = ACF_GF('quote_author');

	if( $quote || $quote_author ): ?>

		<div class="post-thumbnail post-format-quote">
            <i class="fa fa-quote-right"></i>
            <div>
				
                <?php if( $quote ) {
					echo esc_html( $quote );
				}
				
				if( $quote_author ) { ?>
                	<span>&ndash; <?php echo esc_html( $quote_author ); ?></span>
                <?php } ?>
				
            </div>
		</div>

   	<?php endif; ?>
    
