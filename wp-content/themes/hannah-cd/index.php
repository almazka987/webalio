<?php 
/*
*************************************** 
Displaying for all posts by no specific matches a query or used if default post site is choosen by wp admin settings
***************************************
*/ 

get_header();

$layout_normal = ACF_GF('layout_show', 'option') == 'normal';
$layout_magazine = ACF_GF('layout_show', 'option') == 'magazine';
$layout_book_left = ACF_GF('layout_show', 'option') == 'book_left';
$layout_book_right = ACF_GF('layout_show', 'option') == 'book_right';
$layout_metro = ACF_GF('layout_show', 'option') == 'metro';
$layout_grid = ACF_GF('layout_show', 'option') == 'grid';
$layout_masonry = ACF_GF('layout_show', 'option') == 'masonry';
$layout_visual_left = ACF_GF('layout_show', 'option') == 'visual_left';
$layout_visual_right = ACF_GF('layout_show', 'option') == 'visual_right';

$custom_layout = $layout_normal || $layout_magazine || $layout_book_left || $layout_book_right || $layout_metro || $layout_grid || $layout_masonry || $layout_visual_left || $layout_visual_right;

	// POST LIST SETTINGS

	if( get_query_var( 'page' ) ) {
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
	} else {
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	}

	if( ! empty( ACF_GF('masonry_posts_per_page', 'option') ) ) {
		$posts_per_page = ACF_GF('masonry_posts_per_page', 'option');
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
		
	$post_query = new WP_Query( $args );

	// PAGE TITLE + CONTENT VISIBILITY

	$page_title = ACF_GF('page_title_global', 'option');
	$page_content = ACF_GF('main_content_global', 'option');
	$latest_posts_title = ACF_GF('latest_posts_title', 'option');
	$latest_posts_content = ACF_GF('latest_posts_content', 'option');

	// SHOW THE CONTENT ABOVE WITHOUT SIDEBAR
    if( ! $hannah_cd_sidebar_show ) :

		if( ! $page_title && ! empty( $latest_posts_title ) || ! $page_content && ! empty( $latest_posts_content ) ) { ?>

		<div class="archive-header">
			<div class="container">
				
				<?php // ARCHIVE TITLE 
				
				if( ! $page_title && ! empty( $latest_posts_title ) ) { ?>
					<?php if( $hannah_cd_header && $hannah_cd_header_default ) { ?>
						<h2><?php echo esc_html( $latest_posts_title ); ?></h2>
					<?php } else { ?>
						<h1><?php echo esc_html( $latest_posts_title ); ?></h1>
					<?php } ?>
				<?php } 
																											  
				// CONTENT  

				if( ! $page_content && ! empty( $latest_posts_content ) ) { ?>
					<p><?php echo ACF_GF('latest_posts_content', 'option'); ?></p>
				<?php }  ?>
				
			</div>
		</div>

	<?php }

	endif;

	// POST LIST

	if( $custom_layout || $custom_layout === false ) : ?>

		<div class="content" id="content-scroll">

			<section <?php post_class(); ?> id="scroll-to">
				<div class="container"<?php if( $layout_masonry || $layout_grid || $layout_metro ) { ?> id="masonry-layout"<?php } ?>>

					<?php if( $hannah_cd_sidebar_show ) { ?>
						<div class="has-sidebar col-md-9<?php if( $hannah_cd_sidebar_pos ) { ?> has-sidebar-right<?php } ?>">
					<?php } ?>

						<article id="page-<?php the_ID(); ?>">
					   
							<?php // SHOW THE CONTENT NEXT TO THE ACTIVE SIDEBAR
                            if( $hannah_cd_sidebar_show ) :

								// ARCHIVE TITLE 

								if( ! $page_title && ! empty( $latest_posts_title ) ) { ?>
									<header class="page-header">
										<?php if( $hannah_cd_header && $hannah_cd_header_default ) { ?>
											<h2><?php echo esc_html( $latest_posts_title ); ?></h2>
										<?php } else { ?>
											<h1><?php echo esc_html( $latest_posts_title ); ?></h1>
										<?php } ?>
									</header>
								<?php }

								// CONTENT  

								if( ! $page_content && ! empty( $latest_posts_content ) ) { ?>

									<div class="wpcontent showtop">
										<?php echo ACF_GF('latest_posts_content', 'option'); ?>
									</div>

								<?php }

							endif; ?>

							<?php 

							// NORMAL LAYOUT
							// ****************************************************************************************

							if( $layout_normal || $custom_layout === false ) :

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

							// MASONRY, GRID, METRO LAYOUT
							// ****************************************************************************************

							elseif( $layout_masonry || $layout_grid || $layout_metro ) :

								echo hannah_cd_masonry_index( $post_query );

							endif; ?>
							
						</article>

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

<?php get_footer(); ?>
