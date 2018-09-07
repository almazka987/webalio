<?php
/*
* Template Name: Landing Page
*/ 

get_header();

$thumb_right = ACF_GF('page_thumbnail_alignment') == 'right';
$thumb_hide = ACF_GF('hide_page_thumbnail');

while ( have_posts() ) : the_post();

    // PAGE HEADER

    include( locate_template('inc/acf-header.php') );

    // PAGE CONTENT ?>

	<div class="content" id="content-scroll">

		<?php // WP CONTENT SWITCH (if this section a part of flexible layout)
        
        global $hannah_cd_switch;
        
        if( ACF_HR('content_rows') ) {
            $hannah_cd_switch = '';
            while( ACF_HR('content_rows') ) { the_row();
                $hannah_cd_switch .= ACF_GSF('show_wp_content_here');
            }
        }

        if( $hannah_cd_switch ) {
            // nothing
        } else { ?>
					
            <section <?php post_class(); ?>>
                <div class="container">

                    <article id="page-<?php the_ID(); ?>">                       

                        <div class="page-content <?php if( ! get_the_post_thumbnail() || $thumb_hide ) { ?>p-full<?php } ?><?php if( $thumb_right ) { ?> right<?php } ?>">

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
                
                            // COMMENTS

                            if ( comments_open() || get_comments_number() ) {
                                comments_template();
                            } ?>
                            
                        </div>
                        
                        <?php // THUMBNAIL
                
                        if( get_the_post_thumbnail() ) { 
                            if( ! $thumb_hide ) { ?>
                                <div class="page-thumbnail<?php if( $thumb_right ) { ?> right<?php } ?>">
                                    <?php echo get_the_post_thumbnail( $post->ID, 'large' ); 
                                    
                                    // CONTENT BELOW SIDE
						
                                    if( ACF_GF('content_below') ) { ?>

                                        <div class="wpcontent showbottom">
                                            <?php echo ACF_GF('content_below');	?>
                                        </div>

                                    <?php } ?>
                                </div>
                            <?php }
                        } 
                        
                        // THUMBNAIL DISABLED
                
                        if( ! get_the_post_thumbnail() || $thumb_hide ) { 
                            
                            // CONTENT BELOW FULL
						
                            if( ACF_GF('content_below') ) { ?>

                                <div class="wpcontent showbottom">
                                    <?php echo ACF_GF('content_below');	?>
                                </div>

                            <?php }
                            
                        } ?>
                        
                    </article>

                </div>
            </section>

		<?php }
		
		// FLEXIBLE LAYOUT SECTIONS
		
		include( locate_template('inc/acf-flexible-layout.php') );
        
endwhile; 
				
get_footer(); ?>
