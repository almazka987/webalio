<?php 
/*
*************************************** 
Displaying for all posts / if layout is masonry
***************************************
*/ 
    
    global $post_id, $hannah_cd_mry_column; 

    // IMAGE POSTFORMAT

    if( has_post_format('image') ) :

        if( get_the_post_thumbnail() ) : ?>

            <div class="post-thumb">
                <div class="post-thumbnail">
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
                </div>
                <?php if( ! ACF_GF('pin_button_show', 'option') ) {
                    hannah_cd_pin_button( get_the_ID() );
                } ?>
            </div>

    	<?php endif;

    // GALLERY POSTFORMAT

    elseif( has_post_format( 'gallery' ) ) :

        $images = ACF_GF('gallery_images_show');
        if( $images ) : ?>
			<div class="owl-gallery">
				<div class="gallery-owl owl-carousel">
					<?php foreach( $images as $image ) : ?>

						<a href="<?php echo esc_url( $image['url'] ); ?>">
							<img src="<?php echo esc_url( $image['sizes']['large'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
							<?php if( $image['caption'] ) { ?><p><?php echo esc_html( $image['caption'] ); ?></p><?php } ?>
						</a>

					<?php endforeach; ?>
				</div>
			</div>
		<?php endif;

    // VIDEO POSTFORMAT

    elseif( has_post_format('video') ) :

        if( ACF_HR('embed_videos_show') ) : ?>

            <div class="owl-gallery">
                <div class="gallery-owl owl-carousel">

                    <?php get_template_part( 'inc/embed', 'video' ); ?>

                </div>
            </div>

        <?php endif;

    // AUDIO POSTFORMAT

    elseif( has_post_format('audio') ) :

        if( ACF_HR('embed_audio_show') ) : ?>
    
            <div class="owl-gallery">
                <div class="gallery-owl owl-carousel">
        
                    <?php get_template_part( 'inc/embed', 'audio' ); ?>
        
                </div>
            </div>
    
        <?php endif;

    // LINK POSTFORMAT

    elseif( has_post_format('link') ) : ?>

		<a href="<?php the_permalink(); ?>" class="post-thumbnail link">
		
			<?php $link_text = ACF_GF('link_text'); 
            $link_url = ACF_GF('link_url');
            
            if( $link_text ) {
                echo '<h2>' . esc_html( $link_text ) . '</h2>';
            }
            
            if( $link_url ) { ?>
				<span>&ndash; <?php echo esc_html( $link_url ); ?></span>
			<?php } ?>

			<i class="fa fa-link"></i>

		</a>

	<?php // QUOTE POSTFORMAT

    elseif( has_post_format('quote') ) : ?>

		<a href="<?php the_permalink(); ?>" class="post-thumbnail quote">
		
			<?php $quote = ACF_GF('quote_text'); 
            $quote_author = ACF_GF('quote_author'); 
			
            if( $quote ) {
                echo '<h2>' . esc_html( $quote ) . '</h2>';
            }
            
            if( $quote_author ) { ?>
				<span>&ndash; <?php echo esc_html( $quote_author ); ?></span>
			<?php } ?>

			<i class="fa fa-quote-right"></i>

        </a>

	<?php // STANDARD POSTFORMAT

    else :

        if( get_the_post_thumbnail() ) { ?>

            <div class="post-thumb">
                <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" class="post-thumbnail">
                    <div class="hover-box">
                        <?php the_post_thumbnail( 'large' ); ?>
                        <div class="hover"></div>
                    </div>
                </a>

                <?php if( ! ACF_GF('pin_button_show', 'option') ) {
                    hannah_cd_pin_button( get_the_ID() );
                } ?>
            </div> 

    	 <?php }

    endif; ?>
       
    <?php if( has_post_format('quote') || has_post_format('link') ) {
    
        // NOTHING

    } else { ?>

        <div class="post-content">
            
            <?php // DATE 
            
            if( ! ACF_GF('post_date', 'option') ) { ?>            
                <div class="blog-list-date">        
                    <?php echo get_the_date( $post_id ); ?>    
                </div>            
            <?php }
    
            // TITLE
    
			echo '<a href="' . get_the_permalink() . '"><h2>' . get_the_title() . '</h2></a>';    
            
            // TAXONOMIES
            
            if( ! ACF_GF('post_taxonomy', 'option') ) {                
                // TAGS                
                if( ACF_GF('post_taxonomy_select', 'option') == 'tag' ) {
                    hannah_cd_get_tags( $post_id );
                
                // CATEGORIES                    
                } else {
                    hannah_cd_get_categories( $post_id );
                }                
            }
            
            // EXCERPT
    
            if( $hannah_cd_mry_column == 4 ) { 
                $excerpt_wcount = 14;
            } elseif( $hannah_cd_mry_column == 3 ) { 
                $excerpt_wcount = 22;
            } else {
                $excerpt_wcount = 34;
            }    
    
            echo '<p>' . wp_trim_words( get_the_excerpt(), $excerpt_wcount );

            // READ MORE 

            if( ! ACF_GF('post_read_more', 'option') ) { ?>
                <a class="read-more inline" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                    <span><?php echo esc_html__( 'Read More', 'hannah-cd' ) ?></span>
                </a>    
            <?php }

            echo '</p>';
    
            // POST META 
        
            if( ! ACF_GF('post_meta_show_archive', 'option') ) { ?>
                <div class="blog-list-meta">
                    <?php get_template_part( 'post-meta-lite' ); ?>
                </div>
            <?php }
            
            // SOCIAL SHARING 
    
            if( ! ACF_GF('social_blogbar_show', 'option') ) { ?>
                <div class="blog-list">
                    <div class="social-postbar">
                        <div class="social-postbar-in">
                            <?php hannah_cd_social_share_bar( $post_id ); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
                
        </div>

    <?php } ?>


