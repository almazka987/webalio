
<?php // GOOGLE MAP SECTION

    hannah_cd_content_visibility();
    global $hannah_cd_visibility, $hannah_cd_visibility_cases;

    if( ! empty( $hannah_cd_visibility ) ) {
        foreach( $hannah_cd_visibility as $display ) :
            if( $hannah_cd_visibility_cases[ $display ] ) : ?>

                <section class="map-content text-center<?php if( ACF_GSF('map_position', 'option') == 'top' ) { ?> top<?php } ?>">

                    <?php if( ACF_HR('locations', 'option') ): ?>
                        <div class="google-map">
                            <?php while ( ACF_HR('locations', 'option') ) : the_row(); 

                                $location = ACF_GSF('map', 'option'); 
                                $map_detail = ACF_GSF('map_detail', 'option');
                                $map_title = ACF_GSF('map_title', 'option'); 
                                $map_adress = ACF_GSF('map_adress', 'option'); 
                                $map_phone = ACF_GSF('map_phone', 'option'); 
                                $map_mail = ACF_GSF('map_mail', 'option'); 
                                $map_link = ACF_GSF('map_link', 'option'); ?>

                                <div class="marker" data-lat="<?php echo esc_attr( $location['lat'] ); ?>" data-lng="<?php echo esc_attr( $location['lng'] ); ?>">

                                    <div class="map-box">
                                        <div class="map-address">
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
                                                        <a href="https://maps.google.com/maps?q=<?php echo $location['address']; ?>" target="_blank">  
                                                            <i class="fa fa-1x fa-map-pin"></i>
                                                            <span><?php esc_html_e( 'Open on Google Maps', 'hannah-cd' ); ?></span> 
                                                        </a>
                                                    </div>
                                                <?php }
                                            } ?>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>

                </section>

            <?php endif; 

        endforeach;
    }

?>
