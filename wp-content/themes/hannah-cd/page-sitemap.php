<?php
/*
* Template Name: Sitemap Page
* 
*************************************** 
Displaying for a user sitemap
***************************************
*/ 

get_header();

$sitemap_menu = ACF_GF('sitemap_menu');
$sitemap_thumbnail = ACF_GF('sitemap_thumbnail');
$sitemap_pages = ACF_GF('sitemap_pages');
$sitemap_posts = ACF_GF('sitemap_posts');
$sitemap_tags = ACF_GF('sitemap_tags');
$sitemap_categories = ACF_GF('sitemap_categories');
$sitemap_archives = ACF_GF('sitemap_archives');
$sitemap_authors = ACF_GF('sitemap_authors');
$page_exclude = ACF_GF('page_exclude');
$post_exclude = ACF_GF('post_exclude');
$category_exclude = ACF_GF('category_exclude');
$tag_exclude = ACF_GF('tag_exclude');
$author_exclude = ACF_GF('author_exclude');
						
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
                        
                        // SITEMAP CONTENT

						if( ! $sitemap_menu ) { ?>
							<ul class="sitemap-index">
								<?php if( ! $sitemap_pages ) { ?><li><a class="section-scroll" href="#page-map"><?php echo esc_html_e('Pages', 'hannah-cd'); ?></a></li><?php } ?>
								<?php if( ! $sitemap_posts ) { ?><li><a class="section-scroll" href="#post-map"><?php echo esc_html_e('Posts', 'hannah-cd'); ?></a></li><?php } ?>
								<?php if( ! $sitemap_categories ) { ?><li><a class="section-scroll" href="#category-map"><?php echo esc_html_e('Categories', 'hannah-cd'); ?></a></li><?php } ?>
								<?php if( ! $sitemap_tags ) { ?><li><a class="section-scroll" href="#tag-map"><?php echo esc_html_e('Tags', 'hannah-cd'); ?></a></li><?php } ?>
								<?php if( ! $sitemap_archives ) { ?><li><a class="section-scroll" href="#archive-map"><?php echo esc_html_e('Archives', 'hannah-cd'); ?></a></li><?php } ?>
								<?php if( ! $sitemap_authors ) { ?><li><a class="section-scroll" href="#author-map"><?php echo esc_html_e('Authors', 'hannah-cd'); ?></a></li><?php } ?>
							</ul>
						<?php } ?>

						<div class="sitemap">

							<?php // PAGES

							if( ! $sitemap_pages ) { ?>
							
								<h2 id="page-map"><?php echo esc_html_e('Pages', 'hannah-cd'); ?></h2>
							
								<ul>
									<?php
										//$exclude_pages = '' . get_the_ID() . ',' . $page_exclude . ''; // exclude the sitemap url and custom page id from list
										$pages = get_pages( 
											array(
												'sort_column' => 'post_title', 
												'sort_order' => 'ASC',
												'exclude' => $page_exclude, // exclude page id
												'post_type' => 'page',
												'post_status' => 'publish'
											)
										);
													
										foreach( (array) $pages as $page ) {
											
											if( ! $sitemap_thumbnail && get_the_post_thumbnail( $page->ID ) ) {
												echo '<li class="has-thumbnail">' . get_the_post_thumbnail( $page->ID, 'hannah_cd_thumb_min' );
											} elseif( ! $sitemap_thumbnail && ! get_the_post_thumbnail( $page->ID ) ) {
												echo '<li class="has-thumbnail"><div class="no-thumb"><div class="letter"><span>' . mb_strimwidth( esc_html( $page->post_title ), 0, 1 ) . '</span></div></div>';
											} else {
												echo '<li>'; 
											}
											echo '<span><a href="' . esc_url( get_page_link( $page->ID ) ) . '">' . esc_html( $page->post_title ) . '</a></span></li>';
											
										}
													
									?>
								</ul> 
							
							<?php } 
							
							// POSTS

							if( ! $sitemap_posts ) { ?>
							
								<h2 id="post-map"><?php echo esc_html_e('Posts', 'hannah-cd'); ?></h2>
							
								<ul>
									<?php
										global $post_id;

										// postformat exclude
										$get_postformat = ACF_GF('postformat_exclude');
										$postformat_exclude = array();
										if (is_array($get_postformat) || is_object($get_postformat)) {
											foreach($get_postformat as $postformat) {
												array_push($postformat_exclude, $postformat['value']);
											}
										}

										$args = array(
											'orderby' => 'title',
											'order' => 'ASC',
											'posts_per_page' => '-1',
											'post__not_in' => $post_exclude, // exclude post id
											'ignore_sticky_posts' => 1,
											'tax_query' => array(
												array(
													'taxonomy' => 'post_format',
													'field' => 'slug',
													'terms' => $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
													'operator' => 'NOT IN'
												)
											),
										); 

										$sitemap_posts_query = new WP_Query( $args );

										if( $sitemap_posts_query->have_posts() ) :
											while( $sitemap_posts_query->have_posts() ) : $sitemap_posts_query->the_post(); 

												if( ! $sitemap_thumbnail && get_the_post_thumbnail( $post_id ) ) {
													echo '<li class="has-thumbnail"><span>' . get_the_post_thumbnail( $post_id, 'hannah_cd_thumb_min' ) . '</span>';
												} elseif( ! $sitemap_thumbnail && ! get_the_post_thumbnail( $post_id ) ) {
													$the_title = get_the_title();
													echo '<li class="has-thumbnail"><div class="no-thumb"><div class="letter"><span>' . mb_strimwidth( esc_html( $the_title ), 0, 1 ) . '</span></div></div>';
												} else {
													echo '<li>'; 
												}
												echo '<span><a href="' . get_the_permalink() . '">';
													the_title();
												echo '</a> (',
													comments_number('0', '1', '%');
												echo ')</span></li>';

											endwhile;
										endif;

										wp_reset_postdata(); 
									?>
								</ul>
							
							<?php } 
							
							// CATEGORIES

							if( ! $sitemap_categories ) { ?>
							
								<h2 id="category-map"><?php echo esc_html_e('Categories', 'hannah-cd'); ?></h2>
							
								<ul>
									<?php
										$cats = get_categories( 
											array( 
												'orderby' => 'name',
												'order' => 'ASC',
												'exclude' => $category_exclude, // exclude cat id e.g. -12
											)
										);

										foreach( $cats as $cat ) {
											echo '<li><a href="' . get_category_link( $cat ) . '">' . esc_html( $cat->cat_name ) . '</li></a>';
										}  
									?>
								</ul>
							
							<?php } 
							
							// ARCHIVES 
							
							if( ! $sitemap_archives ) { ?>
							
								<h2 id="archive-map"><?php echo esc_html_e('Archives', 'hannah-cd'); ?></h2> 
							
								<ul>   
									<?php 
										wp_get_archives( 
											array(
												'type' => 'monthly',
												'show_post_count' => true,
											)
										); 
									?>   
								</ul>  
							
							<?php } 
							
							// TAGS

							if( ! $sitemap_tags ) { ?>
							
								<h2 id="tag-map"><?php echo esc_html_e('Tags', 'hannah-cd'); ?></h2>   
							
								<ul>     
									<?php
										$tags = get_tags( 
											array(
												'orderby' => 'count', 
												'order' => 'DESC',
												'exclude' => $tag_exclude,
											)
										);
												   
										foreach( (array) $tags as $tag ) {
											echo '<li><a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" rel="tag">' . esc_html( $tag->name ) . '</a> (' . esc_html( $tag->count ) . ')</li>';
										}
									?>
								</ul> 
							
							<?php } 
							
							// AUTHORS

							if( ! $sitemap_authors ) { ?>
							
								<h2 id="author-map"><?php echo esc_html_e('Authors', 'hannah-cd'); ?></h2>
							
								<ul>
									<?php 
										wp_list_authors( array(
											//'exclude_admin' => '1',
											'optioncount' 	=> '1',
											'exclude'   => $author_exclude,
										)); 
									?>
								</ul> 
							
							<?php } ?>

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
