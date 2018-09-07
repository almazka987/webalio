<?php 
/*
*************************************** 
Displaying for image attachment pages 
***************************************
*/ 

get_header(); ?>

	<?php          
		$attachments = array_values( get_children( array( 
			'post_parent' 		=> $post->post_parent, 
			'post_status' 		=> 'inherit', 
			'post_type' 		=> 'attachment', 
			'post_mime_type'	=> 'image', 
			'order' 			=> 'ASC', 
			'orderby'			=> 'menu_order ID' 
		) ) );

		foreach ( $attachments as $i => $attachment ) {
			if ( $attachment->ID == $post->ID ) break;
		}

		$i++;

		// if there is more than 1 attachment in a gallery
		if ( count( $attachments ) > 1 ) {
			if ( isset( $attachments[ $i ] ) ) {
				// get the URL of the next image attachment
				$next_prev_attachment_url = get_attachment_link( $attachments[ $i ]->ID );
				$linktext = esc_html__( 'Next Image', 'hannah-cd' );
				$linkicon = 'fa-arrow-right';
			} else {
				// or get the URL of the first image attachment
				$next_prev_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
				$linktext = esc_html__( 'Previous Image', 'hannah-cd' );
				$linkicon = 'fa-arrow-left';
			}
		}
	?>

	<?php while ( have_posts() ) : the_post(); ?>

        <div class="attach-image attach-<?php the_ID(); ?>">
            <div class="attachment-image">

                <?php // SOCIAL SHAREBAR ?>

                <?php if( ! ACF_GF('social_postbar_show', 'option') ) { ?>
                    <div class="postbar">
						<div class="social-postbar">
							<div class="social-postbar-label"><?php esc_html_e( 'Share', 'hannah-cd' ); ?>:</div> 
							<?php hannah_cd_social_share_bar( get_the_ID() ); ?>
						</div>
                    </div>
                <?php } ?>

                <?php // ATTACHMENT IMAGE ?>
 
                <?php
                    $attachment_size = apply_filters( 'shape_attachment_size', array( 1200, 1200 ) );
                    echo wp_get_attachment_image( $post->ID, $attachment_size );
                ?>

                <?php // IMAGE TITLE ?>
 
                <h1>
                	<?php 
						if ( has_excerpt() ) { 
							get_the_excerpt(); 
						} else { 
							get_the_title(); 
						} 
					?>
                </h1>

                <?php // IMAGE META DATA ?>
 
				<p>
					<?php
                        $metadata = wp_get_attachment_metadata();
                        printf( 
							hannah_cd_kses( 
								__( 'Published <time class="entry-date" datetime="%1$s">%2$s</time> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a>', 'hannah-cd' )
							),
                            esc_attr( get_the_date('c') ),
                            esc_html( get_the_date() ),
                            wp_get_attachment_url(),
                            $metadata['width'],
                            $metadata['height'],
                            get_permalink( $post->post_parent ),
                            get_the_title( $post->post_parent )
                        );
                    ?>
				</p>

				<div>
                    <?php if ( comments_open() && pings_open() ) : // Comments and trackbacks open ?>
                        <?php 
							printf( 
								hannah_cd_kses( 
									__( '<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'hannah-cd' )
								), 
								get_trackback_url()
							); 
						?>
                    <?php elseif ( ! comments_open() && pings_open() ) : // Only trackbacks open ?>
                        <?php 
							printf( 
								hannah_cd_kses( 
									__( 'Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'hannah-cd' )
								),  
								get_trackback_url() 
							); 
						?>
                    <?php elseif ( comments_open() && ! pings_open() ) : // Only comments open ?>
                        <?php 
							printf( 
								hannah_cd_kses( 
									__( 'Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'hannah-cd' )
								)
							); 
						?>
                    <?php elseif ( ! comments_open() && ! pings_open() ) : // Comments and trackbacks closed ?>
                        <?php esc_html_e( 'Both comments and trackbacks are currently closed.', 'hannah-cd' ); ?>
                    <?php endif; ?>
                </div>

                <div class="attach-bottom">
					
                    <?php // FOOTER MENU ?>
        
                    <?php wp_nav_menu( array( 'theme_location' => 'footer_menu' ) ); ?>

                    <?php // COPYRIGHT ?>

                    <?php if( ! ACF_GF('copyright_show', 'option') ) { ?>
            
                        <?php $copyright_year = ACF_GF('copyright_year', 'option'); ?>
                        <?php $copyright_name = ACF_GF('copyright_name', 'option'); ?>
            
                        <div class="copyright">
							&copy; 
							<?php if( $copyright_year ) { ?>
								<?php echo esc_html( $copyright_year ); ?> - <?php echo esc_html( date("Y") ); ?>
							<?php } else { ?>
								2016 - <?php echo esc_html( date("Y") ); ?>
							<?php } ?> 
							- 
							<?php if( $copyright_name ) { ?>
								<?php echo esc_html( $copyright_name ); ?>
							<?php } else { ?>
								Creative-Dive
							<?php } ?>
						</div>
                    <?php } ?>

                </div>

            </div>

		</div>

        <div class="attach-right">

            <?php // PREV / NEXT NAV ?>

            <?php if ( count( $attachments ) > 1 ) { ?>
				<div class="attach-nav">
                    <a href="<?php echo esc_url( $next_prev_attachment_url ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment">
                        <i class="fa <?php echo esc_attr( $linkicon ); ?>"></i> <?php echo esc_html( $linktext ); ?>
                    </a>
				</div>
            <?php } ?>

            <?php // COMMENTS ?>

            <?php comments_template(); ?>

        </div>

	<?php endwhile; ?>

<?php get_footer(); ?>
