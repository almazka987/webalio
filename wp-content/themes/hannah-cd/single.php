<?php 
/*
*************************************** 
Displaying for post format types
***************************************
* @ schema.org
* -> itemprop = keywords
* -> itemprop = datePublished
* -> itemprop = dateModified
*/

global $post_id;

// IMAGE POSTFORMAT

if( has_post_format('image') ) {

	get_template_part( 'postformat/postformat', 'image' );

// ALL OTHER POSTFORMATS

} else { 

get_header();
	
	// POST HEADER
	
	include( locate_template('inc/acf-header.php') ); ?>

	<div class="content" id="content-scroll">
		<section <?php post_class(); ?>>
			<div class="container">

				<?php if( $hannah_cd_sidebar_show ) { ?>
					<div class="has-sidebar col-md-9<?php if( $hannah_cd_sidebar_pos ) { ?> has-sidebar-right<?php } ?>">
				<?php } ?>

						<article id="post-<?php the_ID(); ?>" class="post-main-content">

							<?php // SOCIAL SHARE BAR

							if( ! ACF_GF('social_slidebar_show', 'option') ) { ?>
								<div class="social-share-bar<?php if( ! ACF_GF('social_slidebar_color', 'option') ) { ?> colored<?php } ?>">
									<div class="social-share-bar-content">
										<?php hannah_cd_social_share_bar( get_the_ID() ); ?>
									</div>
								</div>
							<?php }

                            // FEATURED SLIDER
                            
				            include( locate_template('inc/acf-featured-slider.php') );
    
							// SPONSORED POST

							$sponsored_post = ACF_GF('sponsored_post');
							if( $sponsored_post ) { 
								echo '<span class="sponsored-post"><i class="fa fa-paperclip"></i>' . esc_html__( 'Sponsored Post', 'hannah-cd' ) . '</span>'; 
							}
    
                            // DATE                           
            
                            if( ! ACF_GF('the_post_date', 'option') ) { ?>            
                                <div class="blog-list-date">        
                                    <?php echo get_the_date( $post_id ); ?>    
                                </div>            
                            <?php }

                            // TAXONOMIES

                            if( ! ACF_GF('the_post_taxonomy', 'option') ) {                
                                // TAGS                
                                if( ACF_GF('the_post_taxonomy_select', 'option') == 'tag' ) {
                                    hannah_cd_get_tags( $post_id );

                                // CATEGORIES                    
                                } else {
                                    hannah_cd_get_categories( $post_id );
                                }                
                            } 

							// TITLE ?>

							<header class="page-header">
								<?php if( $hannah_cd_header && $hannah_cd_header_default ) { ?>
									<h2 itemprop="headline"><?php the_title(); ?></h2>
								<?php } else { ?>
									<h1 itemprop="headline"><?php the_title(); ?></h1>
								<?php } ?>
							</header>

							<?php // POST META

							if( ! ACF_GF('post_meta_single_show', 'option') ) {
								get_template_part( 'post-meta' );
							}

							while ( have_posts() ) : the_post();

								// GALLERY POSTFORMAT
								if ( has_post_format( 'gallery' )) {
									get_template_part( 'postformat/postformat', 'gallery' );

								// VIDEO POSTFORMAT
								} elseif (has_post_format('video')) {
									get_template_part( 'postformat/postformat', 'video' );

								// AUDIO POSTFORMAT
								} elseif (has_post_format('audio')) {
									get_template_part( 'postformat/postformat', 'audio' );

								// LINK POSTFORMAT
								} elseif (has_post_format('link')) {
									get_template_part( 'postformat/postformat', 'link' );

								// QUOTE POSTFORMAT
								} elseif (has_post_format('quote')) {
									get_template_part( 'postformat/postformat', 'quote' );

								// STANDARD POSTFORMAT
								} else {
									get_template_part( 'postformat/postformat', 'standard' );
								}

							endwhile;

							// LIKE BUTTON

							if( ! ACF_GF('like_button_show', 'option') ) {
								hannah_cd_like_btn( $post->ID );
							} ?>

							<div class="post-content">

								<?php // CONTENT

								the_content(); ?>

							</div>

							<?php // CONTENT BELOW 

							if( ACF_GF('content_below') ) { ?>

								<div class="wpcontent showbottom">
									<?php echo ACF_GF('content_below');	?>
								</div>

							<?php }
                        
                            // CONTENT GRID

                            if( ACF_GF('content_grid_rows') ) { ?>

                                <div class="content-grid">
                                    <div class="container">
                                        <div class="row">
                                            <?php include( locate_template( 'inc/acf-area-content-grid.php' ) ); ?>
                                        </div>
                                    </div>
                                </div>

                            <?php } 

							// ADDITIONAL INFO

							$additional_info = ACF_GF('additional_info');
							if( $additional_info ) { 
								echo '<div class="additional-info">' . ACF_GF('additional_info') . '</div>'; 
							} 

							// POST PAGINATION

							$args = array (
								'before' => '<div class="custom-pagination post-navigation"><span class="page-numbers page-num">' . esc_html__( 'Pages', 'hannah-cd' ) . '</span>',
								'after' => '</div>',
								'link_before' => '<span class="page-numbers">',
								'link_after' => '</span>',
								'next_or_number' => 'number'
							);

							wp_link_pages( $args );

							// POST RATING

							if( ! ACF_GF('post_rating_show', 'option') ) {
								post_rating();
							}           

							// SOCIAL & TAGS POSTBAR

							if( ! ACF_GF('social_postbar_show', 'option') || ! ACF_GF('tags_postbar_show', 'option') ) { ?>
								<div class="postbar">
									<?php if( ! ACF_GF('social_postbar_show', 'option') ) { ?>
										<div class="social-postbar">
											<div class="social-postbar-label"><?php esc_html_e( 'Share', 'hannah-cd' ); ?>:</div> 
											<?php hannah_cd_social_share_bar( get_the_ID() ); ?>
										</div>
									<?php } ?>

									<?php if( ! ACF_GF('tags_postbar_show', 'option') ) {                                
                                        $tags = get_the_tags();
                                        $tags_count = 0;
                                        if( $tags ) { ?>
                                        <div class="tags-postbar">
                                            <div class="tags-postbar-label"><?php esc_html_e( 'Tags', 'hannah-cd' ); ?>:</div> 
                                            <?php foreach( $tags as $tag ) {
                                                echo '<span itemprop="keywords"><a href="' . get_tag_link( $tag->term_id ) . '">' . $tag->name . '</a></span>';
                                                $tags_count++;
                                                if( $tags_count == 5 ) break; // limit tags item count to 5
                                            } ?>
                                        </div>
                                        <?php }
									} ?>
								</div>
							<?php } 

							// AUTHOR BIO

							get_template_part( 'author-bio' );  
                                
                            // RELATED POSTS

							if( ! ACF_GF('related_posts_show', 'option') ) {								
								hannah_cd_related_posts( get_the_ID() );
							}            

                            // PREV / NEXT NAVIGATION
    
                            if( ! ACF_GF('post_prev_next_show', 'option') ) { ?>
                            
                                <div class="single-post-section">
                                    <div class="special-title">
                                        <span><?php echo esc_html__( 'Read more', 'hannah-cd' ); ?></span>
                                    </div>
                                    <div class="single-post-navigation">
                                        <?php previous_post_link();
                                        next_post_link(); ?>
                                    </div>
                                </div>
                            
							<?php }
    
                            // COMMENTS

							if ( comments_open() || get_comments_number() ) {
								comments_template();
							} ?>

						</article>

						<meta itemprop="datePublished" content="<?php the_time( 'c' ); ?>">
						<meta itemprop="dateModified" content="<?php the_modified_time( 'c' ) ?>">

				<?php if( $hannah_cd_sidebar_show ) { ?>
					</div>

					<div class="sidebar col-md-3<?php if( $hannah_cd_sidebar_pos ) { ?> sidebar-right<?php } ?>">
						<?php get_sidebar(); ?>
					</div>
				<?php } ?>

			</div>
		</section>

	<?php get_footer();

} ?>