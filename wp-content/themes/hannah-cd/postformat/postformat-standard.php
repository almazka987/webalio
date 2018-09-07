<?php 
/*
*************************************** 
Displaying for post format: standard
***************************************
* @ schema.org
* -> itemtype = Article (controlling of type in functions.php)
* --> itemprop = headline
* --> itemprop = articleBody
* --> itemtype = ImageObject
* ---> itemprop = image
* ---> itemprop = url
* ---> itemprop = width
* ---> itemprop = height
*/ 

?>

	<meta itemscope itemprop="mainEntityOfPage"  itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>" content="" />
    
    <?php // THUMBNAIL

	if( get_the_post_thumbnail() ) { 
		if( ! ACF_GF('hide_post_thumbnail') ) { ?>
       
			<div class="post-thumb">
				<div class="post-thumbnail" itemscope itemtype="http://schema.org/ImageObject" itemprop="image">

					<?php the_post_thumbnail( 'large' );
											   
                    // output structured data
                    $image_data = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "large" );
                    $image_width = $image_data[1]; 
                    $image_height = $image_data[2]; ?>
					
					<meta itemprop="url" content="<?php echo esc_url( $image_data[0] ); ?>">
					<meta itemprop="width" content="<?php echo esc_attr( $image_width ); ?>">
					<meta itemprop="height" content="<?php echo esc_attr( $image_height ); ?>">

					<?php // PIN BUTTON
											   
					if( ! ACF_GF('pin_button_show', 'option') ) {
						hannah_cd_pin_button( get_the_ID() );
					} 
                    
                    // THUMBNAIL CAPTION
                                               
                    $thumbnail_caption = get_post( get_post_thumbnail_id() )->post_excerpt;                                              
                    if( ACF_GF('thumbnail_caption_show') && $thumbnail_caption ) {
                        echo '<p class="caption">' . esc_html( $thumbnail_caption ) . '</p>';
                    } ?>                    
					
				</div>
			</div>
   
   		<?php }
	} ?>


    
