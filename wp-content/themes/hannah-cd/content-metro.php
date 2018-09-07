<?php 
/*
*************************************** 
Displaying for all posts / if layout is metro
***************************************
*/ 

// get post thumbnail
$thumb_id = get_post_thumbnail_id();
$thumb_url = wp_get_attachment_image_src( $thumb_id, 'large', true );
$bgimage = $thumb_url[0]; 
global $hannah_cd_item_repeat_1, $hannah_cd_item_repeat_2;
?>

<a class="post-thumb<?php if( has_post_thumbnail() ) { ?> has-image<?php } ?>" href="<?php the_permalink(); ?>">

	<div class="post-bg" <?php if( has_post_thumbnail() ) { ?>style="background-image: url(<?php echo esc_url( $bgimage ); ?>)"<?php } ?>>
	
		<?php if( ! has_post_thumbnail() ) { ?>
			<div class="post-icon">

				<?php // IMAGE POSTFORMAT ?>

				<?php if ( has_post_format('image') ) : ?>

					<i class="fa fa-camera"></i>

				<?php // GALLERY POSTFORMAT ?>

				<?php elseif ( has_post_format( 'gallery' )) : ?>

					<i class="fa fa-picture-o"></i>

				<?php // VIDEO POSTFORMAT ?>

				<?php elseif ( has_post_format('video') ) : ?>

					<i class="fa fa-video-camera"></i>

				<?php // AUDIO POSTFORMAT ?>

				<?php elseif ( has_post_format('audio') ) : ?>

					<i class="fa fa-music"></i>

				<?php // LINK POSTFORMAT ?>

				<?php elseif ( has_post_format('link') ) : ?>

					<i class="fa fa-link"></i>

				<?php // QUOTE POSTFORMAT ?>

				<?php elseif ( has_post_format('quote') ) : ?>

					<i class="fa fa-quote-right"></i>

				<?php // STANDARD POSTFORMAT ?>

				<?php else : ?>

					<i class="fa fa-align-justify"></i>

				<?php endif; ?>

			</div>
		<?php } ?>
		
	</div>

	<div class="post-content">

		<?php // TITLE ?>

		<?php 
			if( $hannah_cd_item_repeat_1 && has_post_thumbnail() ) {
				// width item with image
				$title_expert_lenght = '60';
			} elseif( $hannah_cd_item_repeat_1 && ! has_post_thumbnail() ) {
				// width item without image
				$title_expert_lenght = '120';
			} elseif( $hannah_cd_item_repeat_2 && has_post_thumbnail() ) {
				// height item with image
				$title_expert_lenght = '60';
			} elseif( $hannah_cd_item_repeat_2 && ! has_post_thumbnail() ) {
				// height item without image
				$title_expert_lenght = '120';
			} else {
				// default item
				$title_expert_lenght = '40';
			}			
		
			$the_title = get_the_title();
			echo '<h2>' . mb_strimwidth( $the_title, 0, $title_expert_lenght, '...' ) . '</h2>'; 
		?>
		
		<?php if( ! has_post_thumbnail() && $hannah_cd_item_repeat_1 ) { ?>
			<p>
				<?php 
					$excerpt = get_the_excerpt();
					echo mb_strimwidth( $excerpt, 0, 250, '...' ); 
				?>
			</p>
		<?php } ?>
		
		<div class="hover"></div>		
		
	</div>

	<?php // POST META 
        
    if( ! ACF_GF('post_meta_show_archive', 'option') ) { ?>
        <div class="blog-list-meta">
            <?php get_template_part( 'post-meta-lite' ); ?>
        </div>
    <?php } ?>

</a>
