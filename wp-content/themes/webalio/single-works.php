<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
		<div class="content container">
			<?php while ( have_posts() ) : the_post(); ?>
				<h2><?php _e("Описание проекта", "webalio"); ?></h2>
				<?php the_content(); ?>
				<?php 
				$images = ( get_field( 'gallery' ) ) ? get_field( 'gallery' ) : '';
				$live_website_link = ( get_field( 'live_website_link' ) ) ? get_field( 'live_website_link' ) : '';
				?>
				<?php if( $images ): ?>
				<div class="gallery-box">
				<hr>
				<h3><?php _e("Скриншоты:", "webalio"); ?></h3>
					<ul class="single-gallery">
						<?php foreach( $images as $image ): ?>
							<li>
								<a href="<?php echo $image['url']; ?>" class="layer" rel="prettyPhoto[gallery]"><i class="fa fa-search-plus" aria-hidden="true"></i></a>
								<img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
								<p><?php echo $image['caption']; ?></p>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>
				<?php if ( $live_website_link ): ?>
					<?php
                        $categs = get_the_terms( get_the_ID(), 'workscategory' );
                        $plugin_categ = false;
                        $app_categ = false;
                        foreach ( $categs as $value ) {
                            if ( $value->slug == 'plugins' ) {
                                $plugin_categ = true;
                            }
                            if ( $value->slug == 'apps' ) {
                                $app_categ = true;
                            }
                        }
                        $regexp = '/(https?:)?(\/\/)?((github|wordpress.org)[^\/]*\/)/';
                        preg_match( $regexp, $live_website_link, $url_filter );
                        if ( !empty( $url_filter ) && is_array($url_filter ) ) {
                            $site = '';
                            switch ( $url_filter[4] ) {
                                case 'wordpress.org':
                                    $site = 'WordPress.org';
                                    break;
                                case 'github':
                                    $site = 'GitHub.com';
                                    break;
                            }
                            if ( $plugin_categ ) {
                                $text = __("Страница плагина на " . $site, "webalio");
                            }
                            if ( $app_categ ) {
                                $text = __("Страница приложения на " . $site, "webalio");
                            }
                        } else {
                            $text = __("Перейти к просмотру живого сайта", "webalio");
                        }
					?>
					<a href="<?php echo $live_website_link; ?>" class="live-site-lnk inline-lnk" target="blank"><?php echo $text; ?></a> | 
                <?php endif; ?>
                    <a href="<?php echo get_site_url() . "/#lnk_works"; ?>"><?php _e("Вернуться к списку работ", "webalio"); ?></a>
			 <?php endwhile; ?>
			<?php echo do_shortcode( '[alio_divider bottom="50"]' ); ?>
		</div>
<?php endif; ?>

<?php get_footer(); ?>