<?php 
/*
*************************************** 
Displaying for post format: image
***************************************
*/ 

get_header(); ?>

   	<div class="content">
		<div class="attach-image attach-<?php the_ID(); ?>">
			<div class="attachment-image">

				<?php // SOCIAL SHAREBAR ?>

				<?php if( ! ACF_GF('social_postbar_show', 'option') ) { ?>
					<div class="postbar">
						<div class="social-postbar">
							<div class="social-postbar-label"><?php esc_html_e( 'Share', 'hannah-cd' ); ?>:</div> 
							<?php hannah_cd_social_share_bar( get_the_ID() ); ?>
						</div>
					</div>
				<?php } ?>

				<?php if ( has_post_thumbnail() ) :

					$upload_dir = wp_upload_dir();

					$size = 'full';

					$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
					$post_thumbnail_meta = wp_get_attachment_metadata ( $post_thumbnail_id );
					$main_file = $post_thumbnail_meta [ 'file' ];
					$base_url = trailingslashit ( $upload_dir['baseurl'] );

					if ( ! isset($post_thumbnail_meta [ 'sizes' ][ $size ] ) ) {
						$size = 'full';
					}

					$imgInfo = $size === 'full' ? $post_thumbnail_meta : $post_thumbnail_meta [ 'sizes' ][ $size ];
					$filename = basename ( $imgInfo[ 'file' ] );
					$width = $imgInfo[ 'width' ];
					$height = $imgInfo[ 'height' ];
					$file = $base_url . $filename;

				?>

					<?php // TUMBNAIL ?>

					<?php the_post_thumbnail( 'full', array( 'class' => 'post_thumbnail_common', 'alt' => get_the_title() , 'title' => get_the_title() ) ); ?>

					<?php // IMAGE META DATA ?>

					<p>
						<?php esc_html_e( 'Full Image Resolution', 'hannah-cd' ); ?>: 
						<a target="_blank" href="<?php echo esc_url( $file ); ?>"><?php echo esc_html( $width ); ?> x <?php echo esc_html( $height ); ?></a>
					</p>

				<?php else : ?>

					<p><?php esc_html_e( 'No image found', 'hannah-cd' ); ?></p>

				<?php endif; ?>

				<div class="attach-bottom">

					<?php // FOOTER MENU ?>

					<?php wp_nav_menu( array( 'theme_location' => 'footer_menu' ) ); ?>

					<?php // COPYRIGHT ?>

					<?php if( ! ACF_GF('copyright_show', 'option') ) { ?>

						<?php $copyright_year = ACF_GF('copyright_year', 'option'); ?>
						<?php $copyright_name = ACF_GF('copyright_name', 'option'); ?>

						<div class="copyright">
							&copy; 
							<?php if( $copyright_year ) { ?>
								<?php echo esc_html( $copyright_year ); ?> - <?php echo esc_html( date("Y") ); ?>
							<?php } else { ?>
								2016 - <?php echo esc_html( date("Y") ); ?>
							<?php } ?> 
							- 
							<?php if( $copyright_name ) { ?>
								<?php echo esc_html( $copyright_name ); ?>
							<?php } else { ?>
								Creative-Dive
							<?php } ?>
						</div>
					<?php } ?>

				</div>

			</div>

		</div>

		<div class="attach-right">

			<?php // TITLE ?>

			<h1><?php the_title(); ?></h1>

			<?php // CONTENT ?>

			<?php the_content(); ?>

			<?php // COMMENTS ?>

			<?php comments_template(); ?>

		</div>

<?php get_footer(); ?>
