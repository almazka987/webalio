<?php
/*
* Template Name: Glossary Page
* 
*************************************** 
Displaying for a glossary page by selected categories, posts or tags
***************************************
*/ 

get_header();

while ( have_posts() ) : the_post();

	// POST HEADER

	include( locate_template('inc/acf-header.php') );

	// PAGE CONTENT ?>

	<div class="content" id="content-scroll">
		<section <?php post_class(); ?>>
            <div class="container">

				<?php if( $hannah_cd_sidebar_show ) { ?>
					<div class="has-sidebar col-md-9<?php if( $hannah_cd_sidebar_pos ) { ?> has-sidebar-right<?php } ?>">
				<?php } ?>

					<article id="page-<?php the_ID(); ?>">

						<?php // TITLE 
						
						if( ! ACF_GF('page_title') ) { ?>
							<header class="page-header">
								<?php if( $hannah_cd_header && $hannah_cd_header_default ) { ?>
									<h2><?php the_title(); ?></h2>
								<?php } else { ?>
									<h1><?php the_title(); ?></h1>
								<?php } ?>
							</header>
						<?php } 
                        
                        // CONTENT  
						
						if( ! ACF_GF('main_content') && ! empty( get_the_content() ) ) { ?>

							<div class="wpcontent showtop">
								<?php the_content(); ?>
							</div>
						
						<?php } 
                        
                        // FEATURED SLIDER
                            
				        include( locate_template('inc/acf-featured-slider.php') );
                        
                        // GLOSSARY CONTENT
						
						$post_exclude = ACF_GF('post_exclude');
						$get_postformat = ACF_GF('postformat_exclude');

						// postformat exclude
						$postformat_exclude = array();
						if (is_array($get_postformat) || is_object($get_postformat)) {
							foreach($get_postformat as $postformat) {
								array_push($postformat_exclude, $postformat['value']);
							}
						}

						$args = array(
							'orderby' => 'title',
							'order' => 'ASC',
							'posts_per_page' => '-1',
							'post__not_in' => $post_exclude, // exclude post id, like (1, 33, 12)
							'ignore_sticky_posts' => 1,
							'tax_query' => array(
								array(
									'taxonomy' => 'post_format',
									'field' => 'slug',
									'terms' => $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
									'operator' => 'NOT IN'
								)
							),
						);

						if( ACF_GF('show_posts_from_selected_categories') ) 
						$args['category__in'] = ACF_GF('show_posts_from_selected_categories');

						if( ACF_GF('show_posts_from_selected_tags') ) 
						$args['tag__in'] = ACF_GF('show_posts_from_selected_tags');

						if( ACF_GF('show_only_specific_posts') ) 
						$args['post__in'] = ACF_GF('show_only_specific_posts');

						$glossay_query = new WP_Query( $args );
						
						// GLOSSARY INDEX 
				
						function glossay_index( $glossay_query = false ) {

							global $post_id;

							if( $glossay_query->have_posts() ) {

								$glossary_letter = '';

								while( $glossay_query->have_posts() ) {
									$glossay_query->the_post();
									$term_letter = mb_strimwidth( $glossay_query->post->post_title, 0, 1 );
									if ( $glossary_letter != $term_letter ) {
										$glossary_letter = $term_letter;
										$active_letters[] = $term_letter;
									}

								}

								$lt_index = '<ul class="glossary-index">';

									if ( get_locale() == 'de_DE' || get_locale() == 'sv_SE' || get_locale() == 'fi' || get_locale() == 'hu_HU' ) {
										$glossary_letters = array( 'A', 'Ä', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'Ö', 'P', 'Q', 'R', 'S', 'T', 'U', 'Ü', 'V', 'W', 'X', 'Y', 'Z' );
									} else {
										$glossary_letters = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
									}

									foreach ( $glossary_letters as $letter ) {
										if (in_array( $letter, $active_letters )) {
											$lt_index .= '<li><a class="section-scroll" href="#' . $letter . '">' . $letter . '</a></li>';
										} else {
											$lt_index .= '<li class="no-item">' . $letter . '</li>';
										}
									}

								$lt_index .= '</ul>';

								echo '<div class="glossary">' . hannah_cd_kses( $lt_index ) . '</div>';

							}		
						}
						
						echo glossay_index( $glossay_query );
						
						// GLOSSARY CONTENT 

    					function glossay_content( $glossay_query = false ) {
				
							global $post_id;
				
							if( $glossay_query->have_posts() ) {
				
								$lt_content = '';	
								$glossary_letter = '';
								$glossary_thumbnail = ACF_GF('glossary_thumbnail');
								$glossary_excerpt = ACF_GF('glossary_excerpt');
								
								while( $glossay_query->have_posts() ) {
									$glossay_query->the_post();
									$term_letter = mb_strimwidth( $glossay_query->post->post_title, 0, 1 );
									if ( $glossary_letter != $term_letter ) {
										$lt_content .= '<li class="glossary-heading" id="' . $term_letter . '"><span>' . $term_letter;
										$glossary_letter = $term_letter;
									}
	
									if( ! $glossary_thumbnail && get_the_post_thumbnail() ) {
										$lt_content .= '<li class="glossary-image">';
									} elseif( ! $glossary_thumbnail && ! get_the_post_thumbnail() ) {
										$lt_content .= '<li class="glossary-image">';
									} else {
										$lt_content .= '<li>';
									}

									if( ! $glossary_thumbnail && get_the_post_thumbnail() ) {
                                    	$lt_content .= get_the_post_thumbnail( $post_id, 'hannah_cd_thumb_min' );
									} else {
										$lt_content .= '<div class="no-thumb"><div class="letter"><span>' . mb_strimwidth( $glossay_query->post->post_title, 0, 1 ) . '</span></div></div>';
									}
									
									$lt_content .= '<a href="' . get_the_permalink() . '">' . $glossay_query->post->post_title . '</a>';

									if( ! $glossary_excerpt ) { 
										if( get_the_excerpt() ) { 
											$lt_content .= '<div class="glossary-excerpt">';
											$lt_content .= wp_trim_words( get_the_excerpt(), 30 );
											$lt_content .= '</div>';
										}
									}

									$lt_content .= '</span></li>';
								}
								
								echo '<div class="glossary"><ul class="glossary-content">' . hannah_cd_kses( $lt_content ) . '</ul></div>';

							} else {
								load_template_part( 'content', 'none' ); 
							}

							global $wp_query;
							$temp_query = $wp_query;
							$wp_query = $glossay_query;
							$wp_query = $temp_query;
							wp_reset_postdata();		
						}
						
						echo glossay_content( $glossay_query );

						// CONTENT BELOW 

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
                        
                        <?php } ?>			

					</article>

					<?php // COMMENTS

					if ( comments_open() || get_comments_number() ) {
						comments_template();
					} ?>

				<?php if( $hannah_cd_sidebar_show ) { ?>
					</div>

                    <div class="sidebar col-md-3<?php if( $hannah_cd_sidebar_pos ) { ?> sidebar-right<?php } ?>">
                        <?php get_sidebar(); ?>
                    </div>
                <?php } ?>

            </div>
		</section>

<?php endwhile; 
				
get_footer(); ?>
