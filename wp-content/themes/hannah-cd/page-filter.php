<?php
/*
* Template Name: Post Index Page
* 
*************************************** 
Displaying for posts by individual selection
***************************************
*/ 

get_header(); 

$mry_specific_2 = ACF_GF('masonry_specific_custom_column') == 'masonry_spec_colnum_2';
$mry_specific_3 = ACF_GF('masonry_specific_custom_column') == 'masonry_spec_colnum_3';
$mry_specific_4 = ACF_GF('masonry_specific_custom_column') == 'masonry_spec_colnum_4';

$layout_normal = ACF_GF('filter_layout_show') == 'normal';
$layout_magazine = ACF_GF('filter_layout_show') == 'magazine';
$layout_book_left = ACF_GF('filter_layout_show') == 'book_left';
$layout_book_right = ACF_GF('filter_layout_show') == 'book_right';
$layout_metro = ACF_GF('filter_layout_show') == 'metro';
$layout_grid = ACF_GF('filter_layout_show') == 'grid';
$layout_masonry = ACF_GF('filter_layout_show') == 'masonry';
$layout_visual_left = ACF_GF('filter_layout_show') == 'visual_left';
$layout_visual_right = ACF_GF('filter_layout_show') == 'visual_right';

$custom_layout = $layout_normal || $layout_magazine || $layout_book_left || $layout_book_right || $layout_metro || $layout_grid || $layout_masonry || $layout_visual_left || $layout_visual_right;

while ( have_posts() ) : the_post();

	// POST LIST SETTINGS

	if( get_query_var( 'page' ) ) {
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	} else {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	}

	if( ! empty( ACF_GF('posts_per_page') ) ) {
		$posts_per_page = ACF_GF('posts_per_page');
	} else {
		$posts_per_page = get_option( 'posts_per_page' );
	}

	$args = array(
		'orderby' => 'position',
		'order' => 'DESC',
		'posts_per_page' => $posts_per_page,
		'paged' => $paged,
		'tax_query' => array()
	);

	if( ACF_GF('show_posts_from_selected_categories') ) 
	$args['category__in'] = ACF_GF('show_posts_from_selected_categories');

	if( ACF_GF('show_posts_from_selected_tags') ) 
	$args['tag__in'] = ACF_GF('show_posts_from_selected_tags');

	if( ACF_GF('show_only_specific_posts') ) 
	$args['post__in'] = ACF_GF('show_only_specific_posts');

	$post_query = new WP_Query( $args );

	// PAGE HEADER

	include( locate_template('inc/acf-header.php') );

	// POST LIST

	if( $custom_layout ) : ?>

		<div class="content" id="content-scroll">
			
			<?php // SHOW THE CONTENT ABOVE WITHOUT SIDEBAR
            if( ! $hannah_cd_sidebar_show ) : 
                if( ! ACF_GF('page_title') || ! ACF_GF('main_content') ) { ?>
                    <div class="archive-header">
                        <div class="container">

                            <?php // TITLE 

                            if( ! ACF_GF('page_title') ) {
                                if( $hannah_cd_header && $hannah_cd_header_default ) { ?>
                                    <h2><?php the_title(); ?></h2>
                                <?php } else { ?>
                                    <h1><?php the_title(); ?></h1>
                                <?php }
                            }

                            // CONTENT  

                            if( ! ACF_GF('main_content') && ! empty( get_the_content() ) ) {
                                the_content();
                            } ?>

                        </div>
                    </div>
			    <?php }
            endif; ?>
			
			<section <?php post_class(); ?>>
				<div class="container" id="<?php if( $mry_specific_2 || $mry_specific_3 || $mry_specific_4 ) { ?>masonry-layout-filter<?php } else { ?>masonry-layout<?php } ?>">

					<?php if( $hannah_cd_sidebar_show ) { ?>
						<div class="has-sidebar col-md-9<?php if( $hannah_cd_sidebar_pos ) { ?> has-sidebar-right<?php } ?>">
					<?php } ?>

						<article id="page-<?php the_ID(); ?>">

							<?php // SHOW THE CONTENT NEXT TO THE ACTIVE SIDEBAR
                            if( $hannah_cd_sidebar_show ) :
							
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

								// CONTENT  

								if( ! ACF_GF('main_content') && ! empty( get_the_content() ) ) { ?>

									<div class="wpcontent showtop">
										<?php the_content(); ?>
									</div>

								<?php }
							
							endif;
							
							// FEATURED SLIDER
                            
							include( locate_template('inc/acf-featured-slider.php') );

							// NORMAL LAYOUT
							// ****************************************************************************************
							
							if( $layout_normal ) :							
								
								echo hannah_cd_filter_index( $post_query );
							
							// MAGAZINE LAYOUT 
							// ****************************************************************************************
							
							elseif( $layout_magazine ) : 							
								
								echo hannah_cd_magazine_index( $post_query );

							// BOOK LAYOUT 
							// ****************************************************************************************

							elseif( $layout_book_left || $layout_book_right ) : 							

								echo hannah_cd_book_index( $post_query );
							
							// VISUAL LAYOUT
							// ****************************************************************************************
							
							elseif( $layout_visual_left || $layout_visual_right ) : 
							
								echo hannah_cd_visual_index( $post_query );								
							
							// MASONRY, GRID OR METRO LAYOUT  
							// ****************************************************************************************	
							
							elseif( $layout_masonry || $layout_grid || $layout_metro ) :
															
								echo hannah_cd_masonry_index( $post_query );
							
							endif;
                            
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

	<?php else : ?>

		<div class="content">
			<div class="container">

				<?php get_template_part( 'content', 'none' ); ?>

			</div>

	<?php endif; ?>

<?php endwhile; 
				
get_footer(); ?>
