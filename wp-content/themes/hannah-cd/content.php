<?php 
/*
*************************************** 
Displaying for all posts
***************************************
*/

global $post_id; ?>
               
<div class="post-listing <?php if( is_sticky() ) { ?>sticky<?php } ?>" id="post-<?php the_ID(); ?>">

	<?php // STICKY
    
    if( is_sticky() ) { ?>
		<div class="ribbon"></div>
	<?php }
    
    // DATE 
            
    if( ! ACF_GF('post_date', 'option') ) { ?>            
        <div class="blog-list-date">        
            <?php echo get_the_date( $post_id ); ?>    
        </div>            
    <?php }
    
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
    
    // TITLE

    echo '<a href="' . get_the_permalink() . '"><h2>' . get_the_title() . '</h2></a>';    

    // POST META
    
    if( ! ACF_GF('post_meta_show_archive', 'option') ) {
        get_template_part( 'post-meta' );
    } 
    
    // IMAGE POSTFORMAT 
    
    if( has_post_format('image') ) :
    
        if( get_the_post_thumbnail() ) : ?>
        	<div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
        	</div>
        <?php endif;
    
    // GALLERY POSTFORMAT
    
    elseif( has_post_format( 'gallery' )) :
    
        $images = ACF_GF('gallery_images_show');    
        if( $images ) : ?>
        	<div class="post-thumbnail">
				<div class="owl-gallery">
					<div class="gallery-owl owl-carousel">
						<?php foreach( $images as $image ): ?>

							<a href="<?php echo esc_url( $image['url'] ); ?>">
								<img src="<?php echo esc_url( $image['sizes']['large'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
								<?php if( $image['caption'] ) { ?><p><?php echo esc_html( $image['caption'] ); ?></p><?php } ?>
							</a>

						<?php endforeach; ?>
					</div>
				</div>
			</div>
		<?php endif;
    
    // VIDEO POSTFORMAT
    
    elseif( has_post_format('video') ) :
    
        if( ACF_HR('embed_videos_show') ) : ?>
    		<div class="post-thumbnail">
				<div class="owl-gallery">
					<div class="gallery-owl owl-carousel">

						<?php get_template_part( 'inc/embed', 'video' ); ?>

					</div>
				</div>
			</div>
        <?php endif;
    
    // AUDIO POSTFORMAT
    
    elseif( has_post_format('audio') ) :
    
        if( ACF_HR('embed_audio_show') ) : ?>
			<div class="post-thumbnail">
				<div class="owl-gallery">
					<div class="gallery-owl owl-carousel">

						<?php get_template_part( 'inc/embed', 'audio' ); ?>

					</div>
				</div>
			</div>
        <?php endif;
    
    // LINK POSTFORMAT
    
    elseif( has_post_format('link') ) :
    
        $link_text = ACF_GF('link_text'); 
        $link_url = ACF_GF('link_url');    
        if( $link_url || $link_text ) : ?>
    
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
    
        <?php endif;
    
    // QUOTE POSTFORMAT
    
    elseif( has_post_format('quote') ) :
    
        $quote = ACF_GF('quote_text'); 
        $quote_author = ACF_GF('quote_author');    
        if( $quote || $quote_author ) : ?>

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

		<?php endif;
    
    // STANDARD POSTFORMAT
    
    else :
    
        // THUMBNAIL
    
        if( get_the_post_thumbnail() ) { ?>
			<div class="post-thumb">
				<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" class="post-thumbnail">
					<?php the_post_thumbnail( 'large' ); ?>
				</a>
				<?php if( ! ACF_GF('pin_button_show', 'option') ) {
                    hannah_cd_pin_button( $post_id );
                } ?>
			</div>
		<?php }
    
    endif; ?>

    <div class="post-content">
       
        <?php // EXCERPT
        
        the_excerpt();
        
        // READ MORE 
            
        if( ! ACF_GF('post_read_more', 'option') ) { ?>    
            <a class="read-more" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                <span><?php echo esc_html__( 'Read More', 'hannah-cd' ) ?></span>
            </a>        
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

</div>
    
				
