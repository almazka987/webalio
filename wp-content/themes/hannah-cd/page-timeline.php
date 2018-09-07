<?php
/*
* Template Name: Timeline Page
* 
*************************************** 
Displaying for a Timeline
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

                        // TIMELINE CONTENT
						
						if( ACF_HR('timeline_show') ) : ?>
                            
                            <div class="timeline">
                                <ul class="timeline-ul">

                                    <?php while ( ACF_HR('timeline_show') ) { the_row();

                                        $timeline_year = ACF_GSF('timeline_year'); 
                                        $timeline_title = ACF_GSF('timeline_title');
                                        $timeline_content = ACF_GSF('timeline_content');

                                        if( $timeline_title || $timeline_content ) { ?>

                                            <li class="timeline-li in-view">
                                                <?php if( $timeline_year ) { ?>
                                                    <time><?php echo esc_html( $timeline_year ); ?></time> 
                                                <?php } ?>
                                                <div class="timeline-content">
                                                    <h3><?php echo esc_html( $timeline_title ); ?></h3>
                                                    <?php echo do_shortcode( ACF_GSF('timeline_content')); ?>
                                                </div>
                                            </li>

                                        <?php }

                                    } ?>

                                </ul>
                            </div>
                        
						<?php endif;
                        
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

