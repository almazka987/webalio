<?php // RANDOM AD BANNER

$area_ad_label = ACF_GSF('area_ad_label', 'option');
$rows = ACF_GSF('area_ad_banner', 'option'); // get all the rows

if( empty( $rows ) ) {

    echo '<div class="alert alert-warning">' . esc_html__( 'No content selected', 'hannah-cd' ) . '.</div>';

} else {    

    $rand_row = $rows[ array_rand( $rows ) ]; // get a random row

    // get the sub field value
    $rand_row_image = $rand_row['ad_banner_img' ];
    $rand_row_link = $rand_row['ad_banner_link' ];

    if( $rand_row_link ) { echo '<a href="' . esc_url( $rand_row_link ) . '" target="_blank">'; }
        echo '<img src="' . esc_url( $rand_row_image['url'] ) . '" alt="' . esc_attr( $rand_row_image['alt'] ) . '">';
    if( $rand_row_link ) { echo '</a>'; }

    if( $area_ad_label ) { ?>

        <div class="ad-banner-label">
            <span><?php echo esc_html( $area_ad_label ); ?></span>
        </div>

    <?php }
} ?>