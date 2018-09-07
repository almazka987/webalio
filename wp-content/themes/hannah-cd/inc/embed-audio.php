<?php 
/*
*************************************** 
Displaying for embed audios
***************************************
*/ 

while ( ACF_HR('embed_audio_show') ) { the_row();
                                                                
    $soundcloud = ACF_GSF('soundcloud_string');                
    $spotify = ACF_GSF('spotify_string'); 
    $internal = ACF_GSF('internal_audio');                               
                                      
    // INTERNAL AUDIO
                                      
    if( ACF_GSF('audio_type') == 'intern' ) { ?>

        <div class="embed-responsive embed-responsive-4by3">
            <div class="wordpress-audio" <?php if( isset( $internal['sizes']['large'] ) ) { ?>style="background-image:url(<?php echo $internal['sizes']['large']; ?>)"<?php } ?>>
                <?php if( ! isset( $internal['sizes']['large'] ) ) { ?>
                    <div class="play animated pulse infinite"><div class="player"></div></div>
                <?php }
                echo do_shortcode( '[audio src="' . esc_html( $internal['url'] ) . '"][/audio]' ); ?>
            </div>
        </div>  

    <?php } 

    // SOUNDCLOUD AUDIO                                         

    if( ACF_GSF('audio_type') == 'soundcloud' ) { ?>

        <div class="embed-responsive embed-responsive-4by3">
            <?php // creating soundcloud iframe with javascript after click on the thumbnail ?>
            <div class="audio-embed soundcloud-audio" id="<?php echo esc_html( $soundcloud ); ?>">
                <div class="play"><div class="player"></div></div>
            </div>
        </div>

    <?php } 

    // SPOTIFY AUDIO                                         

    if( ACF_GSF('audio_type') == 'spotify' ) { ?>

        <div class="embed-responsive embed-responsive-4by3">
            <?php // creating spotify iframe with javascript after click on the thumbnail ?>
            <div class="audio-embed spotify-audio" id="<?php echo esc_html( $spotify ); ?>">
                <div class="play"><div class="player"></div></div>
            </div>
        </div>

    <?php } 

} ?>

    
