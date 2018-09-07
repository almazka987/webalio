<?php 
/*
*************************************** 
Displaying for all search results
***************************************
*/ 

get_header();

	if ( have_posts() ) : ?>

        <div class="content" id="content-scroll">
			<section <?php post_class(); ?>>
                <div class="container">

                    <?php if( $hannah_cd_sidebar_show ) { ?>
                        <div class="has-sidebar col-md-9<?php if( $hannah_cd_sidebar_pos ) { ?> has-sidebar-right<?php } ?>">
                    <?php } ?>

						<article id="page-<?php the_ID(); ?>">

							<header class="page-header">
								<h1><?php printf( esc_html__( 'Search Results for: %s', 'hannah-cd' ), get_search_query() ); ?></h1>
							</header>

							<?php // SEARCH CONTENT

							while ( have_posts() ) : the_post();
								get_template_part( 'content', 'search' );
							endwhile; 

							// PAGINATION

							hannah_cd_pagination(); ?>
							
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

    <?php endif;
			
get_footer(); ?>