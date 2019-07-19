<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
		<div class="content work">
            <div class="container">
                <?php while ( have_posts() ) : the_post(); ?>
                    <h2 class="content-page-heading"><?php _e("Описание проекта", "webalio"); ?></h2>
                <div class="row">
                    <div class="col-md-8">
                        <div class="work-about">
                            <?php the_content(); ?>
                        </div>
                        <!-- /.work-about -->
                    </div>
                    <!-- /.col-md-8 -->
                    <div class="col-md-4">
                        <div class="work-info">
                            <?php $live_website_link = ( get_field( 'live_website_link' ) ) ? get_field( 'live_website_link' ) : '';

                            if ( $live_website_link ): ?>
                                <?php
                                $categs = get_the_terms( get_the_ID(), 'workscategory' ); ?>
                                <?php if ( $categs ) : ?>
                                    <h3><?php _e("Категории", "webalio"); ?></h3>
                                <?php endif; ?><!-- /$categs -->
                                <?php
                                $plugin_categ = false;
                                $app_categ = false;
                                ?>
                                <ul class="point-list">
                                <?php foreach ( $categs as $value ) :
                                if ( $value->slug == 'plugins' ) {
                                    $plugin_categ = true;
                                }
                                if ( $value->slug == 'apps' ) {
                                    $app_categ = true;
                                }
                                ?>
                                 <li>
                                     <?php echo $value->name; ?>
                                 </li>
                                <?php endforeach; ?>
                                </ul>
                                <?php
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
                                        $text = __("Страница плагина на ", "webalio") . $site;
                                    }
                                    if ( $app_categ ) {
                                        $text = __("Страница приложения на ", "webalio") . $site;
                                    }
                                } else {
                                    $text = __("Перейти к просмотру живого сайта", "webalio");
                                }
                                ?>
                                <hr>
                                <div class="work-links">
                                    <a href="<?php echo $live_website_link; ?>" class="live-site-lnk inline-lnk" target="blank"><?php echo $text; ?></a><br>
                            <?php endif; ?><!-- $live_website_link -->
                            <a href="<?php echo get_site_url() . "/#lnk_works"; ?>"><?php _e("Вернуться к списку работ", "webalio"); ?></a>
                            </div><!-- /.work-links -->
                        </div>
                        <!-- /.work-info -->
                    </div>
                    <!-- /.col-md-4 -->
                </div>
                <!-- /.row -->

				<?php 
				$images = ( get_field( 'gallery' ) ) ? get_field( 'gallery' ) : '';
				?>
				<?php if( $images ): ?>
				<div class="work-gallery">
				<hr>
				<h3><?php _e("Скриншоты:", "webalio"); ?></h3>
                <ul>
                    <?php foreach( $images as $image ): ?>
                    <li>
                        <a href="<?php echo $image['url']; ?>" class="layer" rel="prettyPhoto[gallery]"><i class="fa fa-search-plus" aria-hidden="true"></i></a>
                        <img src="<?php echo $image['sizes']['thumbnail']; ?>" alt="<?php echo $image['alt']; ?>" />
                        <p><?php echo $image['caption']; ?></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
                </div><!-- /.work-gallery -->
                <?php endif; ?>
			 <?php endwhile; ?>
			<?php echo do_shortcode( '[alio_divider bottom="50"]' ); ?>
        </div><!-- /.container -->
    </div><!-- /.content -->

<?php endif; ?>

<?php get_footer(); ?>
