<?php 
/*
*************************************** 
Displaying for all posts
***************************************
*/ 

global $post_id;

$link_text = ACF_GF('link_text'); 
$link_url = ACF_GF('link_url');
$quote = ACF_GF('quote_text'); 
$quote_author = ACF_GF('quote_author'); 
$images = ACF_GF('gallery_images_show');

$bg_image_book = get_the_post_thumbnail_url( $post_id, 'large' ); ?>
   
<div class="book-post" id="post-<?php the_ID(); ?>">

    <div class="book-post-image"<?php if( get_the_post_thumbnail() ) { ?> style="background-image:url(<?php echo esc_url( $bg_image_book ); ?>)"<?php } ?>>
        <div class="post-thumb">
            
            <a href="<?php echo the_permalink(); ?>" title="<?php echo the_title(); ?>">

                <?php if( ! get_the_post_thumbnail() ) {                
                
                    // GALLERY POSTFORMAT

                    if( has_post_format( 'gallery' ) ) :

                        if( $images ) : ?>
                
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

                    elseif( has_post_format('video') ) : ?>
                
                        <div class="post-thumb-placeholder">
                            <div class="post-thumb-placeholder-content">
                                <i class="fa fa-youtube-play"></i>
                            </div>
                        </div>

                    <?php // AUDIO POSTFORMAT

                    elseif( has_post_format('audio') ) : ?>
                
                        <div class="post-thumb-placeholder">
                            <div class="post-thumb-placeholder-content">
                                <i class="fa fa-volume-up"></i>
                            </div>
                        </div>

                    <?php // LINK POSTFORMAT

                    elseif( has_post_format('link') ) :

                        if( $link_url || $link_text ) : ?>

                            <div class="post-thumb-placeholder">
                                <div class="post-thumb-placeholder-content">
                                    <i class="fa fa-link"></i>
                                    <div>
                                        <?php if( $link_text ) {
                                            echo esc_html( $link_text );
                                        }

                                        if( $link_url ) { ?>
                                            <span>&ndash; <?php echo esc_html( $link_url ); ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                
                        <?php else : ?>
                
                            <div class="post-thumb-placeholder">
                                <div class="post-thumb-placeholder-content">
                                    <i class="fa fa-link"></i>
                                </div>
                            </div>

                        <?php endif;

                    // QUOTE POSTFORMAT

                    elseif( has_post_format('quote') ) :

                        if( $quote || $quote_author ) : ?>

                            <div class="post-thumb-placeholder">
                                <div class="post-thumb-placeholder-content">
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
                            </div>
                
                        <?php else : ?>
                
                            <div class="post-thumb-placeholder">
                                <div class="post-thumb-placeholder-content">
                                    <i class="fa fa-quote-right"></i>
                                </div>
                            </div>

                        <?php endif;

                    // STANDARD POSTFORMAT
    
                    else : ?>

                        <div class="letter">
                            <span>
                                <?php $the_title = get_the_title();
                                echo mb_strimwidth( $the_title, 0, 1 ) ?>
                            </span>
                        </div>

                    <?php endif; 

                    } ?>

                <div class="hover"></div>
            </a>

            <?php // PIN BUTTON    

            if( get_the_post_thumbnail() ) {
                if( ! ACF_GF('pin_button_show', 'option') ) {
                    hannah_cd_pin_button( get_the_ID() );
                }
            } ?>
            
        </div>
    </div>

    <div class="book-post-content<?php if( is_sticky() ) { ?> sticky<?php } ?>">

        <div class="book-post-content-border"></div>

        <div class="post-content">
            
            <?php // RIBBON

            if( is_sticky() ) { ?><div class="ribbon"></div><?php } ?>

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

            $excerpt = get_the_excerpt();
            echo '<p>' . mb_strimwidth( $excerpt, 0, 235, '...' ) . '</p>';

            // READ MORE 

            if( ! ACF_GF('post_read_more', 'option') ) { ?>  
                <a class="read-more" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                    <span><?php echo esc_html__( 'Read More', 'hannah-cd' ) ?></span>
                </a>        
            <?php }


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
        
    </div>    

</div>


