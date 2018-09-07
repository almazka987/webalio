<?php 
/*
*************************************** 
Displaying for all default pages
***************************************
*/ 

get_header(); ?>

	<?php while ( have_posts() ) : the_post();

        include( locate_template('content-page.php') );

    endwhile; ?>

<?php get_footer(); ?>
