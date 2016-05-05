<?php
/*
Template Name: Main Template
*/
?>
<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
<!-- begin Content -->
<div class="content">
	<?php while ( have_posts() ) : the_post(); ?>
		<article>
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>
</div><!-- end Content -->
<?php endif; ?>

<?php get_footer(); ?>