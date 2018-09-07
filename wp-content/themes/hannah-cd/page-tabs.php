<?php
/*
* Template Name: Tabs Page
* 
*************************************** 
Displaying for a tabbed content
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

						<div class="tab-page <?php if( ACF_GF('tab_content_direction') == 'right' ) { ?>right<?php } ?>">

							<?php // TABS CONTENT

							if( ACF_HR('tab_content_show') ) : 
							
								$count = '0';
								$tab_counter = '1'; ?>

								<ul class="nav nav-tabs" data-tabs="tabs">

									<?php while ( ACF_HR('tab_content_show') ) { the_row();
																				
										// add class to the first li
										$count = $count +1;
										if ($count == 1) {
											$li_class = 'active'; 
										} else {
											$li_class = ''; 
										}

										$tab_icon = ACF_GSF('tab_icon'); 
										$tab_title = ACF_GSF('tab_content_title'); ?>

										<li class="<?php echo $li_class ?>">
											<a data-target="#tab-<?php echo esc_html( $tab_counter ); ?>" data-toggle="tab" href="#tab-<?php echo esc_html( $tab_counter ); ?>">
												<?php if( $tab_icon ) { ?>
													<i class="fa <?php echo esc_html( $tab_icon ); ?>"></i>
												<?php } else { ?>
													<span class="tab-letter">
														<?php echo mb_strimwidth( esc_html( $tab_title ), 0, 1 ); ?>
													</span>
												<?php } ?>
												<span class="tab-title"><?php echo esc_html( $tab_title ); ?></span>
											</a>
										</li>

										<?php $tab_counter ++; // end counter
																			   
									} ?>

								</ul>

							<?php endif;
							
							if( ACF_HR('tab_content_show') ) :
							
								$count = '0'; 
								$tab_counter = '1'; ?>

								<div class="tab-content">

									<?php while ( ACF_HR('tab_content_show') ) { the_row();
																				
										// add class to the first li
										$count = $count +1;
										if ($count == 1) {
											$active_class = 'in active'; 
										} else {
											$active_class = ''; 
										} ?>

										<div id="tab-<?php echo esc_html( $tab_counter ); ?>" class="tab-pane fade <?php echo esc_html( $active_class ); ?>">
											<?php echo ACF_GSF('tab_content'); ?>
										</div>

										<?php $tab_counter ++; // end counter
																			   
									} ?>

								</div>

							<?php endif; ?>

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
