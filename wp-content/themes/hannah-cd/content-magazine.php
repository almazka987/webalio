<?php 
/*
*************************************** 
Displaying for all posts / if layout is magazine
***************************************
*/ 

global $post_id, $hannah_cd_sidebar_show, $hannah_cd_magazine_count;

// get item count	
if( $hannah_cd_sidebar_show ) {
	$big_item = $hannah_cd_magazine_count % 4 == 0 + 1;
} else {
	$big_item = $hannah_cd_magazine_count % 5 == 0 + 1;
}

$images = ACF_GF('gallery_images_show');
$video = ACF_HR('embed_videos_show');
$audio = ACF_HR('embed_audio_show'); ?>            
	
	<div class="post-thumb">
	
		<?php // IMAGE POSTFORMAT
        
        if ( has_post_format('image') ) :
        
            if( get_the_post_thumbnail() ) : ?>
        
				<div class="post-thumbnail">
					<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'hannah_cd_visual_thumb' ); ?></a>
				</div>
        
			<?php endif;
        
        // GALLERY POSTFORMAT
        
        elseif( has_post_format( 'gallery' )) :
        
            if( $images && $big_item ) : ?>
        
				<div class="post-gallery-placeholder">
					<div class="owl-gallery">
						<div class="gallery-owl owl-carousel">
							<?php foreach( $images as $image ) : ?>
								<div class="gallery-owl-item" style="background-image:url(<?php echo esc_url( $image['sizes']['large'] ); ?>)"></div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
                
            <?php else : ?>

                <div class="post-thumb-placeholder">
                    <div class="post-thumb-placeholder-content">
                        <i class="fa fa-picture-o"></i>
                    </div>
                </div>
        
			<?php endif;
        
        // VIDEO POSTFORMAT
        
        elseif( has_post_format('video') ) :
        
            if( ACF_HR('embed_videos_show') && $big_item ) : ?>
        
				<div class="post-thumbnail">
					<div class="owl-gallery">
						<div class="gallery-owl owl-carousel">

							<?php get_template_part( 'inc/embed', 'video' ); ?>

						</div>
					</div>
				</div>
        
            <?php else : ?>
        
                <div class="post-thumb-placeholder">
                    <div class="post-thumb-placeholder-content">
                        <i class="fa fa-youtube-play"></i>
                    </div>
                </div>
        
			<?php endif;
        
        // AUDIO POSTFORMAT
        
        elseif( has_post_format('audio') ) :
        
            if( ACF_HR('embed_audio_show') && $big_item ) : ?>
        
				<div class="post-thumbnail">
					<div class="owl-gallery">
						<div class="gallery-owl owl-carousel">

							<?php get_template_part( 'inc/embed', 'audio' ); ?>

						</div>
					</div>
				</div>
        
            <?php else : ?>
        
                <div class="post-thumb-placeholder">
                    <div class="post-thumb-placeholder-content">
                        <i class="fa fa-volume-up"></i>
                    </div>
                </div>
        
			<?php endif;
        
        // LINK POSTFORMAT
        
        elseif( has_post_format('link') ) : ?>

			<div class="post-thumb-placeholder">
                <div class="post-thumb-placeholder-content">
                    <i class="fa fa-link"></i>
                </div>
            </div>

		<?php // QUOTE POSTFORMAT
        
        elseif( has_post_format('quote') ) : ?>

			<div class="post-thumb-placeholder">
                <div class="post-thumb-placeholder-content">
                    <i class="fa fa-quote-right"></i>
                </div>
            </div>

		<?php // STANDARD POSTFORMAT
        
        else :
        
            // THUMBNAIL
        
            if( get_the_post_thumbnail() ) { ?>
        
				<a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" class="post-thumbnail">
					<?php the_post_thumbnail( 'hannah_cd_visual_thumb' ); ?>
				</a>
				<?php if( ! ACF_GF('pin_button_show', 'option') ) {
                    hannah_cd_pin_button( get_the_ID() );
                }
                                            
            } else { ?>
                
                <div class="post-thumb-placeholder">
                    <div class="post-thumb-placeholder-content">
                        <i class="fa fa-align-justify"></i>
                    </div>
                </div>
        
			<?php }
        
        endif; ?>
		
	</div>
   
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
        
        echo '<p>';
        
            // EXCERPT

            if( $big_item ) {
                $excerpt = '40'; 
            } else {            
                $excerpt = '20'; 
            }

            echo wp_trim_words( get_the_excerpt(), esc_html( $excerpt ) );
        
            // READ MORE 
        
            if( ! $big_item ) {
                if( ! ACF_GF('post_read_more', 'option') ) { ?>
                    <a class="read-more inline" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                        <span><?php echo esc_html__( 'Read More', 'hannah-cd' ) ?></span>
                    </a>           
                <?php }                
            }

        echo '</p>';
        
        // READ MORE 
        
        if( $big_item ) {
            if( ! ACF_GF('post_read_more', 'option') ) { ?>
                <a class="read-more" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                    <span><?php echo esc_html__( 'Read More', 'hannah-cd' ) ?></span>
                </a>           
            <?php }                
        }
        
        // POST META 
        
        if( ! ACF_GF('post_meta_show_archive', 'option') && $big_item ) { ?>
            <div class="blog-list-meta">
                <?php get_template_part( 'post-meta-lite' ); ?>
            </div>
        <?php } ?>
        
    </div>
