<?php
/*
* Template Name: Download Page
* 
*************************************** 
Displaying for download files
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
                        
                        // DOWNLOAD AREA
                        
                        if( ACF_HR('downloads_show') ) : ?>
                            <ul class="download-list">
                                <?php while( ACF_HR('downloads_show') ) { the_row();
                                                                          
                                    $download_name = ACF_GSF('download_name'); 
                                    $download_name_sep = ACF_GSF('download_name_sep'); 
                                    $download_link = ACF_GSF('download_link'); 
                                    $files = ACF_GSF('download_file'); 

                                    $attachment_id = ACF_GSF('download_file');
                                    $url = wp_get_attachment_url( $attachment_id );
                                    //$title = get_the_title( $attachment_id );
                                    $filesize = filesize( get_attached_file( $attachment_id ) );
                                    $filesize = size_format($filesize, 2);
                                    $path_info = pathinfo( get_attached_file( $attachment_id ) );
                                                                          
                                    if( ACF_GSF('kind_of_download') == 'link' ) {
                                        
                                        if( $download_link ){ ?>
                                            <li>
                                                <i class="fa fa-external-link"></i>
                                                <a href="<?php echo esc_url( $download_link ); ?>" target="_blank">
                                                    <?php echo esc_html( $download_name ); ?>
                                                </a>
                                            </li>
                                        <?php }
                                    
                                    } elseif( ACF_GSF('kind_of_download') == 'file' ) {
                                        
                                        if( !empty( $files ) ) { ?>
                                            <li>
                                                <i class="fa fa-download"></i>
                                                <a href="<?php echo esc_URL( $url ); ?>" target="_blank">
                                                    <?php echo esc_html( $download_name ); ?>
                                                </a>
                                                <?php if ( !empty($url) ) { ?>
                                                    <span class="file-info"><?php echo esc_html( $filesize ); ?> | <?php echo esc_html( $path_info['extension'] ); ?></span>
                                                <?php } else { ?>
                                                    <span class="file-info"><?php echo esc_html_e( 'not found', 'hannah-cd' ) ?></span>
                                                <?php } ?>
                                            </li>
                                        <?php }
                                    
                                    } elseif( ACF_GSF('kind_of_download') == 'separator' ) {
                                        
                                        if( $download_name_sep ) { ?>
                                            <li class="list-separator">
                                                <?php echo esc_html( $download_name_sep ); ?>
                                            </li>
                                        <?php }
                                    
                                    }
                                                                         
                                } ?>
                            </ul>
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

