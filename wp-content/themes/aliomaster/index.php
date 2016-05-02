<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
		<div class="content">
			 <?php while ( have_posts() ) : the_post(); ?>
					<?php //the_content(); ?>
			 <?php endwhile; ?>
		</div>
<?php endif; ?>

<?php get_footer(); ?>