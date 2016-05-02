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
<section class="odd">
<div class="bg-top"></div>
<div class="bg-middle">	
<div class="container">
<div class="row">
<div class="col-md-12">
	<div class="works">
		<h2 id="works">Мои работы:</h2>
		<ul id="filter">
			<li class="filter active" data-filter="all"><span>Все</span></li>
			<li class="filter" data-filter=".sites"><span>Сайты-визитки</span></li>
			<li class="filter" data-filter=".lendings"><span>Лендинги</span></li>
			<li class="filter" data-filter=".eshops"><span>Интернет-магазины</span></li>
		</ul>
		<ul id="container">
			<li></li>
		</ul>
	</div>
</div>
</div>
</div>
</div>
<div class="bg-bottom"></div>
</section>
<?php get_footer(); ?>