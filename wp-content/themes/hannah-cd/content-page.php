<?php 
/*
*************************************** 
Displaying for default pages 
***************************************
*/

	// PAGE HEADER

	include( locate_template('inc/acf-header.php') );

	// PAGE CONTENT ?>

	<div class="content" id="content-scroll">					
		<section <?php post_class(); ?>>
			<div class="container">

				<?php if( $hannah_cd_sidebar_show ) { ?>
					<div class="has-sidebar col-md-9<?php if( $hannah_cd_sidebar_pos ) { ?> has-sidebar-right<?php } ?>">
				<?php } ?>

					<article id="page-<?php the_ID(); ?>">

						<?php // FEATURED SLIDER
                            
				        include( locate_template('inc/acf-featured-slider.php') ); 
                        
                        // TITLE 
						
						if( ! ACF_GF('page_title') ) { ?>
							<header class="page-header">
								<?php if( $hannah_cd_header && $hannah_cd_header_default ) { ?>
									<h2><?php the_title(); ?></h2>
								<?php } else { ?>
									<h1><?php the_title(); ?></h1>
								<?php } ?>
							</header>
						<?php }
                        
                        // THUMBNAIL
						
						if( get_the_post_thumbnail() ) { 
							if( ! ACF_GF('hide_page_thumbnail') ) { ?>

							<div class="post-thumb">
								<div class="post-thumbnail" itemscope itemtype="http://schema.org/ImageObject" itemprop="image">

									<?php the_post_thumbnail( 'large' );
															  
                                    // output structured data
                                    $image_data = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "large" );
                                    $image_width = $image_data[1]; 
                                    $image_height = $image_data[2]; ?>
									
									<meta itemprop="url" content="<?php echo esc_url( $image_data[0] ); ?>">
									<meta itemprop="width" content="<?php echo esc_attr( $image_width ); ?>">
									<meta itemprop="height" content="<?php echo esc_attr( $image_height ); ?>">

									<?php // PIN BUTTON
									
									if( ! ACF_GF('pin_button_show', 'option') ) {
										hannah_cd_pin_button( get_the_ID() );
									} ?>
									
								</div>
							</div>

						<?php }
						} 
                        
                        // CONTENT  
						
						if( ! ACF_GF('main_content') && ! empty( get_the_content() ) ) { ?>

							<div class="wpcontent showtop">
								<?php the_content(); ?>
							</div>
						
						<?php } 
						
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
        
