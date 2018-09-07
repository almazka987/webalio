<?php 
/*
*************************************** 
Displaying for archive, tag, author pages 
***************************************
*/ 

get_header(); 

global $hannah_cd_field_id; 
$field_id = $hannah_cd_field_id;

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

	if( is_category() ) {
		$args = array(
			'orderby' => 'position',
			'order' => 'DESC',
			'cat' => get_query_var('cat'),
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'tax_query' => array()
		);
	} elseif( is_tag() ) {
		$args = array(
			'orderby' => 'position',
			'order' => 'DESC',
			'tag' => get_query_var('tag'),
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'tax_query' => array()
		);
	} elseif( is_author() ) {
		$args = array(
			'orderby' => 'position',
			'order' => 'DESC',
			'author' => get_query_var('author'),
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'tax_query' => array()
		);
	} elseif( is_day() || is_month() ) {
		$args = array(
			'orderby' => 'position',
			'order' => 'DESC',
			'post_type' => 'post',
			'date_query' => array(
				array(
					'year' => get_the_date('Y'),
					'month' => get_the_date('m')
				),
			),
			'ignore_sticky_posts' => 1,
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
		);
	} elseif( is_year() ) {
		$args = array(
			'orderby' 		=> 'position',
			'order' 		=> 'DESC',
			'year' 			=> get_query_var('year'),
			'posts_per_page' => $posts_per_page,
			'paged' 		=> $paged,
			'tax_query' 	=> array()
		);
	} elseif( is_archive() && has_post_format( array( 'quote' ) ) ) {
		$args = array(
			'orderby' 		=> 'position',
			'order' 		=> 'DESC',
			'posts_per_page' => $posts_per_page,
			'paged' 		=> $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => 'post-format-quote'
				),
			),
		);
	} elseif( is_archive() && has_post_format( array( 'link' ) ) ) {
		$args = array(
			'orderby' => 'position',
			'order' => 'DESC',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => 'post-format-link'
				),
			),
		);
	} elseif( is_archive() && has_post_format( array( 'video' ) ) ) {
		$args = array(
			'orderby' => 'position',
			'order' => 'DESC',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => 'post-format-video'
				),
			),
		);
	} elseif( is_archive() && has_post_format( array( 'audio' ) ) ) {
		$args = array(
			'orderby' => 'position',
			'order' => 'DESC',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => 'post-format-audio'
				),
			),
		);
	} elseif( is_archive() && has_post_format( array( 'gallery' ) ) ) {
		$args = array(
			'orderby' => 'position',
			'order' => 'DESC',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => 'post-format-gallery'
				),
			),
		);
	} elseif( is_archive() && has_post_format( array( 'image' ) ) ) {
		$args = array(
			'orderby' => 'position',
			'order' => 'DESC',
			'posts_per_page' => $posts_per_page,
			'paged' => $paged,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => 'post-format-image'
				),
			),
		);
	}

	$post_query = new WP_Query( $args );

	// PAGE TITLE + CONTENT VISIBILITY

	if( is_category() || is_tag() || is_tax() ) {
		$page_title = ACF_GF('page_title', $field_id);
		$page_content = ACF_GF('main_content', $field_id);
	} else {
		$page_title = ACF_GF('page_title_global', 'option');
		$page_content = ACF_GF('main_content_global', 'option');
	}

    // TAXONOMY TITLE

	if( ACF_GF('remove_term_label', 'option') ) {
        if( is_category() ) {
            $tax_title = single_cat_title('', false);
        } elseif( is_tag() ) {
            $tax_title = single_tag_title('', false);
        } elseif( is_author() ) {
            $tax_title = get_the_author();
        } else {
            $tax_title = single_term_title('', false);
        }
	} else {
		$tax_title = get_the_archive_title();
	}

	// POST HEADER

	include( locate_template('inc/acf-header.php') );
			
	// SHOW THE CONTENT ABOVE WITHOUT SIDEBAR
    if( ! $hannah_cd_sidebar_show ) :

		if( ! $page_title || ! $page_content && ! empty( get_the_archive_description() ) ) { ?>

		<div class="archive-header">
			<div class="container">
				
				<?php // ARCHIVE TITLE 
				
				if( ! $page_title ) { ?>
					<?php if( $hannah_cd_header && $hannah_cd_header_default ) { ?>
						<h2><?php echo $tax_title; ?></h2>
					<?php } else { ?>
						<h1><?php echo $tax_title; ?></h1>
					<?php } ?>
				<?php } 
																											  
				// CONTENT  

				if( ! $page_content && ! empty( get_the_archive_description() ) ) { ?>
					<p><?php the_archive_description() ; ?></p>
				<?php }  ?>
				
			</div>
		</div>

	<?php }

	endif;

	// POST LIST

	if( $custom_layout || $custom_layout === false ) : ?>

		<div class="content" id="content-scroll">

			<section <?php post_class(); ?>>
				<div class="container"<?php if( $layout_masonry || $layout_grid || $layout_metro ) { ?> id="masonry-layout"<?php } ?>>

					<?php if( $hannah_cd_sidebar_show ) { ?>
						<div class="has-sidebar col-md-9<?php if( $hannah_cd_sidebar_pos ) { ?> has-sidebar-right<?php } ?>">
					<?php } ?>

						<article id="page-<?php the_ID(); ?>">
					   
							<?php // SHOW THE CONTENT NEXT TO THE ACTIVE SIDEBAR
                            if( $hannah_cd_sidebar_show ) :

								// ARCHIVE TITLE 

								if( ! $page_title ) { ?>
									<header class="page-header">
										<?php if( $hannah_cd_header && $hannah_cd_header_default ) { ?>
											<h2><?php echo $tax_title; ?></h2>
                                        <?php } else { ?>
                                            <h1><?php echo $tax_title; ?></h1>
										<?php } ?>
									</header>
								<?php }

								// CONTENT  

								if( ! $page_content && ! empty( get_the_archive_description() ) ) { ?>

									<div class="wpcontent showtop">
										<?php the_archive_description(); ?>
									</div>

								<?php }

							endif; 
                            
                            // FEATURED SLIDER
                            
							include( locate_template('inc/acf-featured-slider.php') );

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

							endif;
                            
                            // CONTENT BELOW 

							if( ACF_GF('content_below', $field_id) ) { ?>

								<div class="wpcontent showbottom">
									<?php echo ACF_GF('content_below', $field_id);	?>
								</div>

							<?php } 
                        
                            // CONTENT GRID

                            if( ACF_GF('content_grid_rows', $field_id) ) { ?>

                                <div class="content-grid">
                                    <div class="container">
                                        <div class="row">
                                            <?php include( locate_template( 'inc/acf-area-content-grid.php' ) ); ?>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>			

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
