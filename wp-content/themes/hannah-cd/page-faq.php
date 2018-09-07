<?php
/*
* Template Name: FAQ Page
* 
*************************************** 
Displaying for a FAQ content
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

						<div class="faq-page">

							<?php // FAQ CONTENT

                            $togg_id_count = 1; 
                            $togg_count = 1; 
                            $row_counter = 0;
                            $faq_columns = get_post_meta( get_the_ID(), 'faq_columns', true ); // ACF_GF('faq_columns');

                            // get column
                            if( $faq_columns == 'col_1' ) {
                                $column = 'col-1';
                            } elseif( $faq_columns == 'col_2' ) { 
                                $column = 'col-2';
                            } elseif( $faq_columns == 'col_3' ) { 
                                $column = 'col-3';
                            } ?>

							<div class="panel-group toggle-menu" id="toggle<?php echo esc_html( $togg_id_count ); ?>">

								<?php $rows = get_post_meta( get_the_ID(), 'faq_content_show', true ); 
                                if( $rows ) : // if( ACF_HR('faq_content_show') ) : ?>
                                
									<div class="faq-column <?php echo esc_html( $column ); ?>">

										<?php for( $count = 0; $count < $rows; $count++ ) { // while ( ACF_HR('faq_content_show') ) { the_row();

											$end_result = get_post_meta( get_the_ID(), 'faq_content_show', true ); // count( ACF_GF('faq_content_show') ); // get end result of the rows
											$faq_collapse_all = get_post_meta( get_the_ID(), 'faq_content_show_' . $count . '_faq_collapse_all', true ); // ACF_GF('faq_collapse_all');	
                                            $faq_collapse = get_post_meta( get_the_ID(), 'faq_content_show_' . $count . '_faq_collapse', true ); // ACF_GSF('faq_collapse'); 	
											$faq_title = get_post_meta( get_the_ID(), 'faq_content_show_' . $count . '_faq_content_title', true ); // ACF_GSF('faq_content_title'); 

											// define collapsing								
											if ( $faq_collapse_all == 'collapse' ) {

												$collapse_class = '';
												$toggle_class = 'collapsed';

											} elseif( $faq_collapse_all == 'uncollapse' ) {

												$collapse_class = 'in';
												$toggle_class = '';

											} elseif( $faq_collapse ) {

												$collapse_class = 'in';
												$toggle_class = '';

											} else {

												$collapse_class = '';
												$toggle_class = 'collapsed';

											}
																					
											if( $faq_title ) : ?>
												<div class="panel panel-default">
													<div class="panel-heading">
														<div class="panel-title">
															<a class="<?php echo esc_html( $toggle_class ); ?>" data-toggle="collapse" href="#collapse-toggle<?php echo esc_html( $togg_count ); ?>">
																<i class="fa fa-plus"></i>
																<i class="fa fa-minus"></i>
																<?php echo esc_html( $faq_title ); ?>
															</a>
														</div>
													</div>

													<div id="collapse-toggle<?php echo esc_html( $togg_count ); ?>" class="panel-collapse collapse <?php echo esc_html( $collapse_class ); ?>">
														<div class="panel-body">
															<?php echo apply_filters( 'the_content', get_post_meta( get_the_ID(), 'faq_content_show_' . $count . '_faq_content', true ) ); // ACF_GSF('faq_content'); ?>
														</div>
													</div>
												</div>
											<?php endif;																	

											// end counter 									
											$togg_id_count++; 
											$togg_count++;
											$row_counter++;												

											if( $faq_columns == 'col_2' ) {
												$result = $end_result / 2; 
												if( $row_counter == round( $result ) ) {
													echo '</div><div class="faq-column ' . esc_html( $column ) . '">';
												} 
											} elseif( $faq_columns == 'col_3' ) { 
												$result = $end_result / 3; 
												if( $row_counter % round( $result ) == 0 ) {
													echo '</div><div class="faq-column ' . esc_html( $column ) . '">';
												} 
											} 
																				   
										} ?>

									</div>

								<?php endif; ?>

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
