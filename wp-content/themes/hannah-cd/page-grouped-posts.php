<?php
/*
* Template Name: Grouped Posts Page
* 
*************************************** 
Displaying for a specific grouped posts
***************************************
*/ 

get_header(); 

global $post_id;

$show_content = ACF_GF('wp_content_show');
$content_top = ACF_GF('wp_content_show_order') == 'top';
$content_bottom = ACF_GF('wp_content_show_order') == 'bottom';

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
                        
                        // GROUPED POSTS CONTENT

						if( ACF_HR('post_group_show') ) : 
							while ( ACF_HR('post_group_show') ) { the_row(); 

								$post_group_headline = ACF_GSF('post_group_headline');
								$post_group_type = ACF_GSF('post_group_type');
								$grouped_by_selected_posts = ACF_GSF('grouped_by_selected_posts');
								$grouped_by_selected_category = ACF_GSF('grouped_by_selected_category');
								$grouped_by_selected_tag = ACF_GSF('grouped_by_selected_tag');
								$post_group_amount = ACF_GSF('post_group_amount');
								$get_postformat = ACF_GSF('postformat_exclude');

								// COLUMNS OF POST GROUP

								if( ACF_GSF('post_group_column') == 'col_1' ) {
									$post_group_column = 'col-md-12';
								} elseif( ACF_GSF('post_group_column') == 'col_2' ) {
									$post_group_column = 'col-md-6';
								} elseif( ACF_GSF('post_group_column') == 'col_3' ) {
									$post_group_column = 'col-md-4';
								} elseif( ACF_GSF('post_group_column') == 'col_4' ) {
									$post_group_column = 'col-md-3';
								}

								// POST FORMAT EXCLUDE

								$postformat_exclude = array();
								if (is_array($get_postformat) || is_object($get_postformat)) {
									foreach($get_postformat as $postformat) {
										array_push($postformat_exclude, $postformat['value']);
									}
								}

								// POST GROUP OUTPUT								   

								//--> recent posts
								if( $post_group_type == 'group_recent_post' ) {
									$args = array(
										'post_type' => 'post',
										'posts_per_page' => $post_group_amount,
										'orderby' => 'date', 
										'ignore_sticky_posts' => 1,
										'tax_query' => array(
											array(
												'taxonomy' 	=> 'post_format',
												'field' 	=> 'slug',
												'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
												'operator' 	=> 'NOT IN'
											)
										),
									);

								//--> recent posts by category
								} elseif( $post_group_type == 'group_recent_category' ) {
									$args = array(
										'post_type' => 'post',
										'category__in' => $grouped_by_selected_category, // term id, like (1,22,50)
										'posts_per_page' => $post_group_amount,
										'orderby' => 'date', 
										'ignore_sticky_posts' => 1,
										'tax_query' => array(
											array(
												'taxonomy' 	=> 'post_format',
												'field' 	=> 'slug',
												'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
												'operator' 	=> 'NOT IN'
											)
										),
									);

								//--> recent posts by tag
								} elseif( $post_group_type == 'group_recent_tag' ) {
									$args = array(
										'post_type' => 'post',
										'tag__in' => $grouped_by_selected_tag, // term id, like (1,22,50)
										'posts_per_page' => $post_group_amount,
										'orderby' => 'date', 
										'ignore_sticky_posts' => 1,
										'tax_query' => array(
											array(
												'taxonomy' 	=> 'post_format',
												'field' 	=> 'slug',
												'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
												'operator' 	=> 'NOT IN'
											)
										),
									);

								//--> selected posts
								} elseif( $post_group_type == 'group_selected' ) {
									$args = array(
										'post_type' => 'post',
										'post__in' => $grouped_by_selected_posts, // post id, like (1,22,50)
										'posts_per_page' => $post_group_amount,
										'orderby' => 'post__in', // order by user select
										'ignore_sticky_posts' => 1,
										'tax_query' => array(
											array(
												'taxonomy' 	=> 'post_format',
												'field' 	=> 'slug',
												'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
												'operator' 	=> 'NOT IN'
											)
										),
									);

								//--> selected posts from categories
								} elseif( $post_group_type == 'group_tag' ) {
									$args = array(
										'post_type' => 'post',
										'category__in' => $grouped_by_selected_category, // term id, like (1,22,50)
										'posts_per_page' => $post_group_amount,
										'orderby' => 'post__in', // order by user select
										'ignore_sticky_posts' => 1,
										'tax_query' => array(
											array(
												'taxonomy' 	=> 'post_format',
												'field' 	=> 'slug',
												'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
												'operator' 	=> 'NOT IN'
											)
										),
									);

								//--> selected posts from tags
								} elseif( $post_group_type == 'group_category' ) {
									$args = array(
										'post_type' => 'post',
										'tag__in' => $grouped_by_selected_tag, // term id, like (1,22,50)
										'posts_per_page' => $post_group_amount,
										'orderby' => 'post__in', // order by user select
										'ignore_sticky_posts' => 1,
										'tax_query' => array(
											array(
												'taxonomy' 	=> 'post_format',
												'field' 	=> 'slug',
												'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
												'operator' 	=> 'NOT IN'
											)
										),
									);
								}

							?>
								<div class="grouped-posts">

									<?php // GROUP HEADLINE

                                    if( $post_group_headline ) { 
                                        echo '<h2 class="grouped-headline">' . esc_html( $post_group_headline ) . '</h2>';
                                    }  ?>

									<div class="grouped-post-box">
										<div class="row">
											<?php $post_group_query = new WP_Query( $args );

                                            if ( $post_group_query->have_posts() ) :

                                                $row_counter = '1'; // start counter												

                                                while ( $post_group_query->have_posts() ) : $post_group_query->the_post(); 

                                                    // get post thumbnail
                                                    $thumb_id = get_post_thumbnail_id();
                                                    $thumb_url = wp_get_attachment_image_src( $thumb_id, 'large', true );

                                                    if( has_post_thumbnail() ) { 
                                                        $bgimage = $thumb_url[0]; 
                                                    } ?>

													<div class="grouped-post-box-item <?php echo esc_html( $post_group_column ); ?>">

														<?php $the_title = get_the_title();		   
														if( has_post_thumbnail() ) { ?>
															<a href="<?php the_permalink(); ?>" class="grouped-post-box-item-img hover-box" <?php if( has_post_thumbnail() ) { ?>style="background-image: url(<?php echo esc_url( $bgimage ); ?>)"<?php } ?>>
																<div class="hover"></div>
															</a>
														<?php } else { ?>
															<a href="<?php the_permalink(); ?>" class="grouped-post-box-item-img hover-box">
																<div class="letter"><span><?php echo mb_strimwidth( $the_title, 0, 1 ) ?></span></div>
																<div class="hover"></div>
															</a>
														<?php } ?>

														<div class="grouped-post-box-item-content">                                                            
                                                           
                                                            <div class="blog-list-date">        
                                                                <?php echo get_the_date( $post_id ); ?>    
                                                            </div>
                                                            
															<a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>

															<?php echo '<p>';

                                                                $excerpt = get_the_excerpt();

                                                                if( ACF_GSF('post_group_column') == 'col_1' ) {
                                                                    echo mb_strimwidth( $excerpt, 0, 250, '...' ); 
                                                                } elseif( ACF_GSF('post_group_column') == 'col_2' ) {
                                                                    echo mb_strimwidth( $excerpt, 0, 110, '...' ); 
                                                                } elseif( ACF_GSF('post_group_column') == 'col_3' ) {
                                                                    echo mb_strimwidth( $excerpt, 0, 100, '...' ); 
                                                                } elseif( ACF_GSF('post_group_column') == 'col_4' ) {
                                                                    echo mb_strimwidth( $excerpt, 0, 50, '...' ); 
                                                                } 

                                                                // READ MORE (CASE 1)

                                                                if( ACF_GSF('post_group_column') != 'col_1' ) { ?>
                                                                    <a class="read-more inline" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                                                                        <span><?php echo esc_html__( 'Read More', 'hannah-cd' ) ?></span>
                                                                    </a>        
                                                                <?php } ?>
                                                            
                                                            <?php echo '</p>'; 

                                                            // READ MORE (CASE 2)

                                                            if( ACF_GSF('post_group_column') == 'col_1' ) { ?>
                                                                <a class="read-more" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>">
                                                                    <span><?php echo esc_html__( 'Read More', 'hannah-cd' ) ?></span>
                                                                </a>        
                                                            <?php } ?>

														</div>
													</div>

													<?php  if( ACF_GSF('post_group_column') == 'col_2' ) {
                                                        // add row after every 2 items
                                                        if ($row_counter % 2 == 0) {
                                                            echo '</div><div class="row">';
                                                        }
                                                    } elseif( ACF_GSF('post_group_column') == 'col_3' ) {
                                                        // add row after every 3 items
                                                        if ($row_counter % 3 == 0) {
                                                            echo '</div><div class="row">';
                                                        }
                                                    } elseif( ACF_GSF('post_group_column') == 'col_4' ) {
                                                        // add row after every 4 items
                                                        if ( $row_counter % 4 == 0 ) {
                                                            echo '</div><div class="row">';
                                                        } 
                                                    }		

                                                    $row_counter ++; // end counter

                                                endwhile; 

                                            endif;

                                            wp_reset_postdata(); ?>
										</div>
									</div>

								</div>

							<?php } 
						endif; ?>
					
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
