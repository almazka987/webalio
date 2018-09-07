<?php
/*
* Template Name: Categories Page
* 
*************************************** 
Displaying for a specific categories
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
                            
				        include( locate_template('inc/acf-featured-slider.php') ); ?>

						<div class="categories">
							<div class="cat-teaser-wrapper">
								
								<?php // CATEGORY CONTENT

									$category_exclude = ACF_GF('category_exclude');
									$category_layout = ACF_GF('category_layout');
									$show_post_count = ACF_GF('show_post_count');
									$show_category_title = ACF_GF('show_category_title');
									$show_category_desc = ACF_GF('show_category_desc');
									$hide_empty_category = ACF_GF('hide_empty_category');

									if( ! $hide_empty_category ) { $hide_empty = 1; } else { $hide_empty = 0; }

									if( $category_layout == 'col1' ) {
										$column = 'col-md-12';
									} elseif( $category_layout == 'col2' ) {
										$column = 'col-md-6';
									} elseif( $category_layout == 'col3' ) {
										$column = 'col-md-4';
									}

									// ALL CATEGORIES
								
									if( ACF_GF('categories_show') == 'all_cat' ) :

										$categories = get_categories( 
											array(
												'orderby' => 'name',
												'order' => 'ASC',
												'hide_empty' => $hide_empty,
												'exclude' => $category_exclude,
											)
										); 
								
										$row_counter = 1; ?>

										<div class="row">
												
										<?php foreach( $categories as $category ) {
											
											// get term fields
											$taxonomy_image = ACF_GF('taxonomy_image', "category_{$category->cat_ID}");
											$bg_image = wp_get_attachment_image_src( $taxonomy_image, 'large', false, '' );
	
											echo '<div class="cat-teaser-box ' . esc_html( $column ) . '">'; 
												echo '<a class="cat-teaser-img hover-box" href="' . esc_url( get_category_link( $category->term_id ) ) . '"'; 
													if ( $bg_image ) {
														echo ' style="background-image:url(' . esc_url( $bg_image[0] ) . ')"';
													} 
												echo '>';
													if ( ! $bg_image ) {
														 echo '<div class="letter"><span>' . mb_strimwidth( $category->name, 0, 1 ) . '</span></div>';
													}
													echo '<div class="hover"></div>';
												echo '</a>';
												echo '<div class="cat-teaser-content">'; 
													if( ! $show_category_title ) {
														if( ! $show_post_count ) {
															echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '"><h3>' . esc_html( $category->name ) . ' (' . $category->category_count . ')</h3></a>';
														} else {
															echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '"><h3>' . esc_html( $category->name ) . '</h3></a>';
														}
													}
													if( ! $show_category_desc ) {
														echo category_description( $category->term_id );
													}
												echo '</div>';
											echo '</div>';
											
											if( $category_layout == 'col2' ) {
												// add row after every 2 items
												if ($row_counter % 2 == 0) {
													echo '</div><div class="row">';
												}
											} elseif( $category_layout == 'col3' ) {
												// add row after every 3 items
												if ($row_counter % 3 == 0) {
													echo '</div><div class="row">';
												}
											} else {
												// add row after each item
												if ( $row_counter % 1 == 0 ) {
													echo '</div><div class="row">';
												} 
											}
											
											$row_counter++;
											
										}

									// SPECIFIC CATEGORIES
											
									elseif( ACF_GF('categories_show') == 'spec_cat' ) :

										// get selected term ids from array

										$cat_output = '';
										$category_include = ACF_GF('select_category');

										foreach( $category_include as $value ) {
											$cat_output .= $value . ",";
										}

										$args = array(
											'hierarchical' => 1,
											'orderby' => 'id',
											'order' => 'ASC',
											'hide_empty' => $hide_empty,
											'include' => $cat_output,
										); 

										$categories = get_categories( $args );
								
										$row_counter = 1; ?>

										<div class="row">
												
										<?php foreach ( $categories as $category ) {

											// get term fields
											$taxonomy_image = ACF_GF('taxonomy_image', "category_{$category->cat_ID}");
											$bg_image = wp_get_attachment_image_src( $taxonomy_image, 'large', false, '' );

											echo '<div class="cat-teaser-box ' . esc_html( $column ) . '">'; 
												echo '<a class="cat-teaser-img hover-box" href="' . esc_url( get_category_link( $category->term_id ) ) . '"'; 
													if ( $bg_image ) {
														echo ' style="background-image:url(' . esc_url( $bg_image[0] ) . ')"';
													} 
												echo '>';
													if ( ! $bg_image ) {
														 echo '<div class="letter"><span>' . mb_strimwidth( $category->name, 0, 1 ) . '</span></div>';
													}
													echo '<div class="hover"></div>';
												echo '</a>';
												echo '<div class="cat-teaser-content">'; 
													if( ! $show_category_title ) {
														if( ! $show_post_count ) {
															echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '"><h3>' . esc_html( $category->name ) . ' (' . $category->category_count . ')</h3></a>';
														} else {
															echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '"><h3>' . esc_html( $category->name ) . '</h3></a>';
														}
													}
													if( ! $show_category_desc ) {
														echo category_description( $category->term_id );
													}
												echo '</div>';
											echo '</div>';
											
											if( $category_layout == 'col2' ) {
												// add row after every 2 items
												if ($row_counter % 2 == 0) {
													echo '</div><div class="row">';
												}
											} elseif( $category_layout == 'col3' ) {
												// add row after every 3 items
												if ($row_counter % 3 == 0) {
													echo '</div><div class="row">';
												}
											} else {
												// add row after each item
												if ( $row_counter % 1 == 0 ) {
													echo '</div><div class="row">';
												} 
											}
											
											$row_counter++;
										}
											
									endif;

								?>
								
							</div>
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
