<?php // TAXONOMY CAROUSEL

$teaser_column = ACF_GSF('area_cat_tag_teaser_column', 'option'); 
$area_cat_tag_teaser_output = ACF_GSF('area_cat_tag_teaser_output', 'option');
$area_cat_tag_teaser_hide_empty = ACF_GSF('area_cat_tag_teaser_hide_empty', 'option');
if( $area_cat_tag_teaser_hide_empty ) { $hide_empty = 1; } else { $hide_empty = 0; }

$teaser_cat_filter = ACF_GSF('area_cat_tag_teaser_cat_filter', 'option');
$teaser_tag_filter = ACF_GSF('area_cat_tag_teaser_tag_filter', 'option');

// category teaser

if( $area_cat_tag_teaser_output == 'cats' ) {

    $args = array(
        'hierarchical'	=> 1,
        'orderby'		=> 'include', // order by user
        'order'			=> 'ASC',
        'hide_empty'	=> $hide_empty,
    );

    // filter categories by id
    if( $teaser_cat_filter ) 
    $args['include'] = $teaser_cat_filter;

    $ct_teaser = get_categories( $args );

    // get the count of teaser
    if( $teaser_cat_filter ) {
        $teaser_count = count( $teaser_cat_filter );
    } else {
        $teaser_count = count( $ct_teaser );
    }										

// tag teaser

} elseif( $area_cat_tag_teaser_output == 'tags' ) {										

    $args = array(
        'hierarchical'	=> 1,
        'orderby'		=> 'include', // order by user
        'order'			=> 'ASC',
        'hide_empty'	=> $hide_empty,
    );

    // filter tags by id
    if( $teaser_tag_filter ) 
    $args['include'] = $teaser_tag_filter;

    $ct_teaser = get_tags( $args );		

    // get the count of teaser
    if( $teaser_tag_filter ) {
        $teaser_count = count( $teaser_tag_filter );
    } else {
        $teaser_count = count( $ct_teaser );
    }

}

$get_carousel = false;

// get column
if( $teaser_column == 'col_1' ) {

    $column_count = 'col-md-12';
    $teaser_column_count = 1;
    $item_count = '1';

} elseif( $teaser_column == 'col_2' ) { 

    $column_count = 'col-md-6';
    $teaser_column_count = 2;
    $item_count = '2';

} else { 

    $column_count = 'col-md-4';
    $teaser_column_count = 3;
    $item_count = '3';

}

if( $teaser_count > $teaser_column_count ) {
    $get_carousel = true;
} 

foreach ( $ct_teaser as $teaser ) {

    // get term fields
    if( $area_cat_tag_teaser_output == 'cats' ) {
        $taxonomy_image = ACF_GF('taxonomy_image', "category_{$teaser->cat_ID}");
        $bg_image = wp_get_attachment_image_src( $taxonomy_image, 'large', false, '' ); 
        $get_the_link = get_category_link( $teaser->term_id );	
    } else {
        $tag_taxonomy = $teaser->taxonomy;
        $tag_term_id = $teaser->term_id;
        $taxonomy_image = ACF_GF('taxonomy_image', $tag_taxonomy . '_' . $tag_term_id);
        $bg_image = wp_get_attachment_image_src( $taxonomy_image, 'large', false, '' );
        $get_the_link = get_tag_link( $teaser->term_id );	
    } ?>

    <div class="area-carousel-box <?php echo esc_html( $column_count ); ?>">
        <a href="<?php echo esc_url( $get_the_link ); ?>" class="area-carousel-content" <?php if ( $bg_image ) { ?>style="background-image: url(<?php echo esc_url( $bg_image[0] ); ?>)"<?php } ?>>
            <?php if( ! $bg_image ) { ?>
                <div class="letter"><span><?php echo mb_strimwidth( esc_html( $teaser->name ) , 0, 1 ) ?></span></div>
            <?php } ?>
            <div class="hover"></div>
        </a>

        <a href="<?php echo esc_url( $get_the_link ); ?>"><h4><?php echo esc_html( $teaser->name ); ?></h4></a>        
    </div>

<?php } ?>