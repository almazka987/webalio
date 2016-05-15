<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
		<div class="content container">
			 <?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
					<?php 
					$images = get_field('gallery');
					if( $images ): ?>
					<div class="gallery-box">
					<hr>
					<h3>Скриншоты:</h3>
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
			 <?php endwhile; ?>
			<?php echo do_shortcode( '[alio_divider bottom="50"]' ); ?>
		</div>
<?php endif; ?>

<?php get_footer(); ?>