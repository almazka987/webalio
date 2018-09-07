<?php
/*
* Template Name: Event Registration Page
* 
*************************************** 
Displaying for event dates
***************************************
*/ 

get_header();

$event_col_right = ACF_GF('event_column_direction') == 'right';

while ( have_posts() ) : the_post();

	// PAGE HEADER

	include( locate_template('inc/acf-header.php') );

	// PAGE CONTENT ?>

	<div class="content" id="content-scroll">
        <section <?php post_class(); ?>>
            <div class="container">

                <div class="page-content <?php if( $event_col_right ) { ?> right<?php } ?>">
                    <article id="page-<?php the_ID(); ?>">                    

                        <?php // FEATURED SLIDER
                            
				        include( locate_template('inc/acf-featured-slider.php') );
                        
                        // TITLE

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
                        
                        // CONTENT BELOW 

						if( ACF_GF('content_below') ) { ?>

							<div class="wpcontent showbottom">
								<?php echo ACF_GF('content_below');	?>
							</div>

						<?php } 
                        
                        // CONTENT GRID
                        
                        if( ACF_GF('content_grid_rows') ) { ?>
                        
                            <div class="content-grid">
                                <div class="container">
                                    <div class="row">
                                        <?php include( locate_template( 'inc/acf-area-content-grid.php' ) ); ?>
                                    </div>
                                </div>
                            </div>
                        
                        <?php } 
                        
                        // COMMENTS

                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        } ?>

				    </article>
                </div>

                <?php // EVENT REGISTRATION CONTENT 
                
                $event_title = ACF_GF('custom_seminar_title');
                $event_instructor_title = ACF_GF('seminar_instructor_title'); ?>

                <div class="page-thumbnail<?php if( $event_col_right ) { ?> right<?php } ?>">
                    <div class="event-registration">
                       
                        <?php // SEMINAR TITLE
                        
                        if( $event_title ) {
                            echo '<div class="widget-title">' . esc_html( $event_title ) . '</div>';
                        } 
                        
                        // EVENTS EXIST (DATES)
                        
                        if( ACF_HR('add_custom_seminar_date') ) { ?>
                            <ul>
                                <?php while( ACF_HR('add_custom_seminar_date') ) : the_row();
                                                                                   
                                    $date = ACF_GSF('custom_seminar_date'); // DateTime::createFromFormat('Ymd', ACF_GSF('custom_seminar_date'));
                                    $time_from = ACF_GSF('custom_seminar_time_from'); // DateTime::createFromFormat('H:i:s', ACF_GSF('custom_seminar_time_from'));
                                    $time_to = ACF_GSF('custom_seminar_time_to'); // DateTime::createFromFormat('H:i:s', ACF_GSF('custom_seminar_time_to'));

                                    $wp_date_format = get_option('date_format');   
                                    $wp_time_format = get_option('time_format');	

                                    $get_the_date = date( $wp_date_format, strtotime( $date ) );
                                    $get_the_time_from = date( $wp_time_format, strtotime( $time_from ) );
                                    $get_the_time_to = date( $wp_time_format, strtotime( $time_to ) ); ?>

                                    <li>
                                        <?php // date [$date->format('m.d.Y')]
                                        echo '<i class="icon fa fa-calendar"></i><strong>' . esc_html( $get_the_date ) . '</strong><br>';

                                        // time from [$time_from->format('g:i a')]
                                        if( $time_from ) {
                                            echo esc_html( $get_the_time_from );
                                        } 
                                        
                                        // time to [$time_to->format('g:i a')]                              
                                        if( $time_to ) {
                                            echo ' - ' . esc_html( $get_the_time_to );
                                        } ?>
                                    </li>
                                
                                <?php endwhile; ?>
                            </ul>

                        <?php // EVENTS DO NOT EXIST
                                                                      
                        } else { ?>
                            <ul>
                                <li class="nodate">
                                    <i class="icon fa fa-calendar"></i>
                                    <?php echo esc_html_e( 'Currently no dates are available.', 'hannah-cd' ) ?>
                                </li>
                            </ul>
                        <?php } ?>
                    </div>

                    <?php // INSTRUCTORS
                    
                    if( ACF_HR('seminar_user_show') ) { ?>
                        <div class="contact-user">
                            
                            <?php if( $event_instructor_title ) {                              
                                echo '<div class="widget-title">' . esc_html( $event_instructor_title ) . '</div>';
                            }
    
                            while( ACF_HR('seminar_user_show') ) : the_row();
                                                                         
                                $event_user_name = ACF_GSF('seminar_user_name');  
                                $event_user_title = ACF_GSF('seminar_user_title'); 
                                $event_user_image_shape = ACF_GSF('seminar_user_image_shape'); 
                                $image = ACF_GSF('seminar_user_image');
                                if( ! is_array( $image ) ) { 
                                    $image = acf_get_attachment( $image ); 
                                } ?>

                                <div class="contact-person">
                                    <?php // SQUARE IMAGE

                                    if( $event_user_image_shape == 'square' ) { ?>

                                        <img alt="<?php echo esc_attr( $image['alt'] ); ?>" src="<?php echo esc_url( $image['url'] ); ?>">

                                    <?php 

                                    // ROUND IMAGE

                                    } else { ?>

                                        <div class="contact-person-image" style="background-image: url(<?php echo esc_url( $image['url'] ); ?>)"></div>

                                    <?php } ?>
                                    
                                    <span class="person"><?php echo esc_html( $event_user_name ); ?></span>
                                    <span class="person-title"><?php echo esc_html( $event_user_title ); ?></span>
                                </div>

                            <?php endwhile;  ?>
                            
                        </div>
                    <?php }
                    
                    // ADDITIONAL CONTENT
                    
                    $event_additional_content_title = ACF_GF('seminar_additional_content_title');
                    $event_additional_content = ACF_GF('seminar_additional_content');
                    
                    if( $event_additional_content_title ) {
                        echo '<div class="widget-title">' . esc_html( $event_additional_content_title ) . '</div>';
                    }
                        
                    if( $event_additional_content ) { ?>
                        <div class="contact-user-content">
                            <?php echo ACF_GF('seminar_additional_content'); ?>
                        </div>
                    <?php } ?>

                </div>
                
            </div>
        </section>

<?php endwhile; 
				
get_footer(); ?>