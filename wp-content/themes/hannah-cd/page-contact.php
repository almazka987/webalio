<?php
/*
* Template Name: Contact Page
* 
*************************************** 
Displaying for contact form
***************************************
*/ 

get_header();

$contact_col_right = ACF_GF('contact_column_direction') == 'right';

while ( have_posts() ) : the_post();

	// PAGE HEADER

	include( locate_template('inc/acf-header.php') );

	// PAGE CONTENT ?>

	<div class="content" id="content-scroll">
		<section <?php post_class(); ?>>
			<div class="container">                

                <div class="page-content <?php if( $contact_col_right ) { ?> right<?php } ?>">
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

                <?php // CONTACT CONTENT 
                
                $contact_person_title = ACF_GF('contact_person_title');
                $contact_address_title = ACF_GF('contact_address_title');
                $contact_address_show = ACF_GF('contact_map_show'); ?>

                <div class="page-thumbnail<?php if( $contact_col_right ) { ?> right<?php } ?>">
                    <div class="contact-page">

                        <?php // CONTACT PERSON

                        if( ACF_HR('contact_person_show') ) { ?>
                            <div class="contact-user">

                                <?php if( $contact_person_title ) {                              
                                    echo '<div class="widget-title">' . esc_html( $contact_person_title ) . '</div>';
                                }
                                
                                while( ACF_HR('contact_person_show') ) { the_row();

                                    $contact_person_name = ACF_GSF('contact_person_name');  
                                    $contact_person_occ = ACF_GSF('contact_person_occ'); 
                                    $contact_person_image_shape = ACF_GSF('contact_person_image_shape'); 
                                    $image = ACF_GSF('contact_person_image');

                                    if( ! is_array( $image ) ) { 
                                        $image = acf_get_attachment( $image ); 
                                    } ?>

                                    <div class="contact-person">

                                        <?php // SQUARE IMAGE

                                        if( $contact_person_image_shape == 'square' ) { ?>

                                            <img alt="<?php echo esc_attr( $image['alt'] ); ?>" src="<?php echo esc_url( $image['url'] ); ?>">

                                        <?php 

                                        // ROUND IMAGE

                                        } else { ?>

                                            <div class="contact-person-image" style="background-image: url(<?php echo esc_url( $image['url'] ); ?>)"></div>

                                        <?php } ?>

                                        <span class="person"><?php echo esc_html( $contact_person_name ); ?></span>
                                        <span class="person-title"><?php echo apply_filters( 'the_content', ACF_GSF('contact_person_occ') ); ?></span>
                                    </div>

                                <?php } ?>

                            </div>
                        <?php }

                        // ADDRESS FIELDS
                        
                        if( $contact_address_title ) {                              
                            echo '<div class="widget-title">' . esc_html( $contact_address_title ) . '</div>';
                        }

                        if( $contact_address_show ) {
                            if( ACF_GF('map_show', 'option') && ACF_GF('map_api_key', 'option') ) {
                                if( ACF_HR('maps', 'option') ) : 
                                    while( ACF_HR('maps', 'option') ) { the_row(); 

                                        if( ACF_HR('locations', 'option') ) :
                                            while( ACF_HR('locations', 'option') ) : the_row(); 
                                                $location = ACF_GSF('map', 'option'); 
                                                $map_detail = ACF_GSF('map_detail', 'option');
                                                $map_title = ACF_GSF('map_title', 'option'); 
                                                $map_adress = ACF_GSF('map_adress', 'option'); 
                                                $map_phone = ACF_GSF('map_phone', 'option'); 
                                                $map_mail = ACF_GSF('map_mail', 'option'); 
                                                $map_link = ACF_GSF('map_link', 'option'); ?>

                                                <address>
                                                    <?php if( $map_detail == 'map' ) {

                                                        $address = explode( "," , $location['address']);
                                                        if( isset( $address[0] ) ) echo $address[0].', <br>'; // street + number
                                                        if( isset( $address[1] ) ) echo $address[1].', <br>'; //city
                                                        if( isset( $address[2] ) ) echo $address[2]; // state + zip

                                                    } else {

                                                        if( $map_title ) { ?>
                                                            <div class="map-row">
                                                                <strong><span><?php echo esc_html( $map_title ); ?></span></strong>
                                                            </div>
                                                        <?php } 
                                                        if( $map_adress ) { ?>
                                                            <div class="map-row">
                                                                <i class="fa fa-1x fa-map-marker"></i>
                                                                <span><?php echo esc_html( $map_adress ); ?></span>
                                                            </div>
                                                        <?php } 
                                                        if( $map_phone ) { ?>
                                                            <div class="map-row">
                                                                <i class="fa fa-1x fa-phone"></i>
                                                                <span><?php echo esc_html( $map_phone ); ?></span>
                                                            </div>
                                                        <?php } 
                                                        if( $map_mail ) { ?>
                                                            <div class="map-row">
                                                                <i class="fa fa-1x fa-envelope"></i>
                                                                <span><?php echo antispambot( esc_html( $map_mail ) ); ?></span> 
                                                            </div>
                                                        <?php } 
                                                        if( $map_link ) { ?>
                                                            <div class="map-row">
                                                                <a class="iframe-lightbox" href="https://maps.google.com/maps?q=<?php echo $location['address']; ?>" target="_blank">  
                                                                    <i class="fa fa-1x fa-map-pin"></i>
                                                                    <span><?php esc_html_e( 'Open on Google Maps', 'hannah-cd' ); ?></span> 
                                                                </a>
                                                            </div>
                                                        <?php }

                                                    } ?>
                                                </address>

                                            <?php endwhile;
                                        endif;

                                    }
                                endif; 
                            }
                        }
                    
                        // ADDITIONAL CONTENT

                        $contact_additional_content_title = ACF_GF('contact_additional_content_title');
                        $contact_additional_content = ACF_GF('contact_additional_content');

                        if( $contact_additional_content_title ) {
                            echo '<div class="widget-title">' . esc_html( $contact_additional_content_title ) . '</div>';
                        }

                        if( $contact_additional_content ) { ?>
                            <div class="contact-user-content">
                                <?php echo ACF_GF('contact_additional_content'); ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
                
            </div>
        </section>

<?php endwhile; 
				
get_footer(); ?>