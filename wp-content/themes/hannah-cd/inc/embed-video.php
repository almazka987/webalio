<?php 
/*
*************************************** 
Displaying for embed videos
***************************************
*/ 

while ( ACF_HR('embed_videos_show') ) { the_row();

    $youtube = ACF_GSF('youtube_string'); 
    $vimeo = ACF_GSF('vimeo_string'); 
               
    // clean the video strings from slashes
    $youtube_clear_string = str_replace( '/', '', $youtube );
    $vimeo_clear_string = str_replace( '/', '', $vimeo );
                                       
    $internal = ACF_GSF('internal_video'); 

    // INTERNAL VIDEO             

    if( ACF_GSF('video_type') == 'intern' ) { ?>

        <div class="wordpress-video">
            <?php echo do_shortcode( '[video width="1920" height="1080" src="' . esc_html( $internal ) . '"][/video]' ); ?>
        </div> 

    <?php } 

    // EXTERNAL VIDEO                                         

    if( ACF_GSF('video_type') == 'youtube' || ACF_GSF('video_type') == 'vimeo' ) { ?>

        <div class="embed-responsive embed-responsive-16by9">
            <?php // creating video iframe with javascript after click on the video thumbnail
                if( ACF_GSF('video_type') == 'youtube' ) { ?>
                <div class="video-embed youtube-video" id="<?php echo esc_html( $youtube_clear_string ); ?>">
                    <div class="play"></div>
                </div>
            <?php } elseif( ACF_GSF('video_type') == 'vimeo' ) { ?>
                <div class="video-embed vimeo-video" id="<?php echo esc_html( $vimeo_clear_string ); ?>">
                    <div class="play"></div>
                </div>
            <?php } ?>
        </div>

    <?php } 

} ?>

    
