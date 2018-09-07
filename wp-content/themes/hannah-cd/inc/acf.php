<?php

/*****************************************************************/
/* SPEED UP THE SETTINGS PAGES */
/*****************************************************************/

/* removing the default wp custom fields */
add_filter('acf/settings/remove_wp_meta_box', '__return_true');


/*****************************************************************/
/* ACF LOCALOZATION */
/*****************************************************************/

function hannah_cd_acf_settings_localization( $localization ) { 
	
	return true; 

}

add_filter('acf/settings/l10n', 'hannah_cd_acf_settings_localization');


/*****************************************************************/
/* SET TEXTDOMAIN TO EXPORTED FIELD GROUPS */
/*****************************************************************/

function hannah_cd_acf_settings_textdomain( $domain ) { 
	
	return 'hannah-cd'; 

} 

add_filter('acf/settings/l10n_textdomain', 'hannah_cd_acf_settings_textdomain');


/*****************************************************************/
/* SET API KEY FOR ACF GOOGLE MAPS */
/*****************************************************************/

function hannah_cd_acf_map( $api ){
	
	$api['key'] = ACF_GF('map_api_key', 'option') ;
	
	return $api;
	
}

add_filter('acf/fields/google_map/api', 'hannah_cd_acf_map');


/*****************************************************************/
/* CHECK ACF IS ACTIVE */
/*****************************************************************/

function is_acf() { 
	
	return function_exists( 'get_field' ) ? true : false; 
	
}


/*****************************************************************/
/* CHANGE FUNCTION FROM [ get_field() ] TO [ ACF_GF() ] */
/*****************************************************************/

function ACF_GF( $field, $post_id = null ) {
	
	if ( ! is_acf() ) { return false; }
	
	if ( get_field( $field, $post_id ) ) { 
		return get_field( $field, $post_id ); 
	} else { 
		return false; 
	}
	
}


/*****************************************************************/
/* CHANGE FUNCTION FROM [ get_sub_field() ] TO [ ACF_GSF() ] */
/*****************************************************************/

function ACF_GSF( $field, $post_id = null ) {
	
	if ( ! is_acf() ) { return false; }
	
	if ( get_sub_field( $field ) ) { 
		return get_sub_field( $field );
	} else { 
		return false; 
	}
	
}


/*****************************************************************/
/* CHANGE FUNCTION FROM [ have_rows() ] TO [ ACF_HR() ] */
/*****************************************************************/

function ACF_HR( $field, $post_id = null ) {
	
	if ( ! is_acf() ) { return false; }
	
	if ( have_rows( $field, $post_id ) ) { 
		return have_rows( $field, $post_id ); 
	} else { 
		return false; 
	}
	
}


/*****************************************************************/
/* SAFLY APPLY wp_kses_post TO ALL ACF USER FIELDS */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_acf_kses_post' ) ) :

    function hannah_cd_acf_kses_post( $value = '', $post_id = '', $field = '' ) {        
        
        // exception for option header and footer code
        $header_code = get_field_object('header_code', 'option');
        $footer_code = get_field_object('footer_code', 'option');
        
        if( isset( $field['key'] ) && $field['key'] == $header_code['key'] || isset( $field['key'] ) && $field['key'] == $footer_code['key'] ) {
            return $value;
        }
        
        // escaping all fields  
        if( is_array( $value ) ) {
            return array_map('hannah_cd_acf_kses_post', $value);
        }

        return wp_kses_post( $value );

    }

endif;

add_filter('acf/update_value', 'hannah_cd_acf_kses_post', 10, 4);


/*****************************************************************/
/* LOADING ACF PRO FROM THEME FILES INSTEAD OF THE WP PLUGINS */
/*****************************************************************/

include_once( get_template_directory() . '/inc/plugins/acf/acf.php' ); // path to the acf plugin of the [ MAIN THEME ]


/*****************************************************************/
/* ACF SETTINGS THEME PATH */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_acf_settings_path' ) ) :

    function hannah_cd_acf_settings_path( $path ) {

        $path = get_template_directory() . '/inc/plugins/acf/'; // [ MAIN THEME ] acf plugin path
        
        return $path;

    }

endif;

add_filter('acf/settings/path', 'hannah_cd_acf_settings_path');


/*****************************************************************/
/* ACF SETTINGS THEME DIR PATH */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_acf_settings_dir' ) ) :

    function hannah_cd_acf_settings_dir( $dir ) {

        $dir = get_template_directory_uri() . '/inc/plugins/acf/'; // [ MAIN THEME ] acf plugin dir path
        
        return $dir;

    }

endif;

add_filter('acf/settings/dir', 'hannah_cd_acf_settings_dir');


/*****************************************************************/
/* SAVE ACF FIELD GROUPS AS JSON FILE AT THEME FOLDER */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_acf_json_save_point' ) ) :

	function hannah_cd_acf_json_save_point( $path ) {
        
        $dev_mode = ACF_GF('mode_custom_fields_json', 'option');
        
        if( is_child_theme() && $dev_mode ) {
            // [ CHILD THEME ] > save the custom fields in the [ CHILD THEME JSON ] folder
            $path = get_stylesheet_directory() . '/acf-json';
        } else {
            // [ MAIN THEME ] > save the custom fields in the [ MAIN THEME JSON ] folder
            $path = get_template_directory() . '/inc/acf-json';
        }
        
		return $path;
        
	}

endif;

add_filter('acf/settings/save_json', 'hannah_cd_acf_json_save_point');


/*****************************************************************/
/* LOADING SWITCH FOR ACF FIELD GROUPS FROM PHP OR JSON FILE */
/*****************************************************************/

add_filter('acf/settings/load_json', function( $paths ) {
    
    $dev_mode = ACF_GF('mode_custom_fields_json', 'option');
    
    // load basic [ MAIN THEME ] field groups from the [ MAIN THEME JSON ] folder
    $paths = array( get_template_directory() . '/inc/acf-json' );
    
    // load custom additional [ CHILD THEME ] field groups from the [ CHILD THEME JSON ] folder
    if( is_child_theme() && $dev_mode ) {
        $paths[] = get_stylesheet_directory() . '/acf-json';
    }

    // WITHOUT ACTIVATED DEV MODE --> load all fields from PHP file by the [ MAIN THEME ]
    if( ! $dev_mode ) {
        // load all field groups from PHP exported file for theme users
        include_once( get_template_directory() . '/inc/acf-field-groups.php' );
    }
    
    // [ CHILD THEME ] with custom PHP field groups
    /*if( is_child_theme() && $dev_mode ) {
        include_once( get_stylesheet_directory() . '/your-custom-php-field-groups.php' );
    }*/    
    
    return $paths;
    
});


/*****************************************************************/
/* LOAD ACF FIELD GROUPS FROM THEME FOLDER JSON FILES */
/*****************************************************************/

/*if ( ! function_exists( 'hannah_cd_acf_json_load_point' ) ) :

    function hannah_cd_acf_json_load_point( $paths ) {

        // load all field groups from JSON files for theme developer
        unset($paths[0]); // remove original path (optional)
        $paths[] = get_template_directory() . '/inc/acf-json'; // custom JSON file folder path
        return $paths;

    }

endif;	

add_filter('acf/settings/load_json', 'hannah_cd_acf_json_load_point');*/


/*****************************************************************/
/* ACF HIDE ADMIN CUSTOM FIELDS FOR THEME USER */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_acf_hide_admin' ) ) :

    function hannah_cd_acf_hide_admin() {
        
        $dev_mode = ACF_GF('mode_custom_fields_json', 'option');
        
        if( ! $dev_mode ) {
            // hide ACF custom fields for theme users
            acf_update_setting('show_admin', false); 
        } else {        
            // show ACF custom fields for theme developer
            acf_update_setting('show_admin', true); 
        }
        
    }

endif;


/*****************************************************************/
/* CALL FUNCTIONS ON ACF INIT ACTION */
/*****************************************************************/
 
if ( ! function_exists( 'hannah_cd_acf_init' ) ) :

    function hannah_cd_acf_init() {

        hannah_cd_acf_hide_admin();

    }

endif;

add_action('acf/init', 'hannah_cd_acf_init');


/*****************************************************************/
/* GET THE CURRENTLY IDS */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_get_the_ids' ) ) :

	function hannah_cd_get_the_ids() {

		global $hannah_cd_field_id;

		if ( class_exists( 'WooCommerce' ) ) {
			$is_shop = is_shop();
			$is_woocommerce = is_woocommerce();
		} else {
			$is_shop = false;
			$is_woocommerce = false;
		}
		
		if( $is_shop ) {

			$hannah_cd_field_id = get_option( 'woocommerce_shop_page_id' ); 

		} elseif( $is_woocommerce || is_category() || is_tag() || is_tax() ) {
			
			$queried_object = get_queried_object(); 
			$hannah_cd_field_id = $queried_object->taxonomy . '_' . $queried_object->term_id; 

		} else {

			$hannah_cd_field_id = ''; 

		}

	}

	add_action( 'template_redirect', 'hannah_cd_get_the_ids' );

endif;


/*****************************************************************/
/* PAGE HEADER */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_header' ) ) : 

	function hannah_cd_header() {
		
		global $hannah_cd_header, $hannah_cd_header_full, $hannah_cd_header_fullscreen, $hannah_cd_header_wide, $hannah_cd_header_default;		
				
		if ( is_search() ) { 
			
			// headers are disabled for search pages
			
		} else {	
		
			global $hannah_cd_field_id;

			$header_is_true = ACF_GF('header_show', $hannah_cd_field_id);            
            $header_style = ACF_GF('header_style', $hannah_cd_field_id);
            
            $header_full_is_true = false;
            $header_wide_is_true = false;
            $header_fullscreen_is_true = false;
            
            if( $header_style == 'full_page' || $header_style == 'fullscreen' ) $header_full_is_true = true;
            if( $header_style == 'wide' ) $header_wide_is_true = true;
            if( $header_style == 'fullscreen' ) $header_fullscreen_is_true = true;

			$hannah_cd_header = $header_is_true; // check which page has header
			$hannah_cd_header_full = $header_is_true && $header_full_is_true; // check which page has full header
			$hannah_cd_header_wide = $header_is_true && $header_wide_is_true; // check which page has wide header
			$hannah_cd_header_fullscreen = $header_is_true && $header_fullscreen_is_true; // check which page has wide header

            $hannah_cd_header_default = ACF_GF('header_type', $hannah_cd_field_id) == 'default';
		}

	}

endif;

add_action( 'template_redirect', 'hannah_cd_header' );


/*****************************************************************/
/* FATURED SLIDER */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_featured_slider' ) ) : 

	function hannah_cd_featured_slider() {
		
		global $hannah_cd_featured_slider;		
				
		if ( is_search() ) { 
			
			// nothing
			
		} else {	
		
			global $hannah_cd_field_id;

			$featured_slider_is_true = ACF_GF('featured_slider_show', $hannah_cd_field_id);
			$hannah_cd_featured_slider = $featured_slider_is_true; // check which page has header

		}

	}

endif;

add_action( 'template_redirect', 'hannah_cd_featured_slider' );


/*****************************************************************/
/* SIDEBAR SWITCH BY ACF */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_sidebar_show' ) ) : 

	function hannah_cd_sidebar_show() {

		/* SIDEBAR DISPLAY */
		/*****************************************************************/
		
		global $hannah_cd_sidebar_show;
	
		$side_global_show = ACF_GF('sidebar_global_show', 'option') == 'show';
		$side_global_hide = ACF_GF('sidebar_global_show', 'option') == 'hide';
		
		$side_specific_show = ACF_GF('sidebar_show') == 'show';
		$side_specific_hide = ACF_GF('sidebar_show') == 'hide';
		
		// settings overwrite for masonry layout sidebar visibility 
		if( is_archive() || is_home() ) {
			$sidebar_hidden = ACF_GF('sidebar_masonry_disable', 'option');
		} else {
			$sidebar_hidden = false;
		}
		
		// [SIDEBAR_SP] = HIDE & [SIDEBAR_GP] = SHOW
		
		if( $side_specific_hide && $side_global_show ) :
		
			$hannah_cd_sidebar_show = false;
		
		// [SIDEBAR_SP] = SHOW & [SIDEBAR_GP] = HIDE
		
		elseif( $side_specific_show && $side_global_hide ) :
		
			$hannah_cd_sidebar_show = true;
		
		// [SIDEBAR_GP] = SHOW
		
		elseif( $side_global_show ) :
		
			if( $sidebar_hidden ) {
				$hannah_cd_sidebar_show = false;
			} else {
				$hannah_cd_sidebar_show = true;
			}
		
		// [SIDEBAR_GP] = HIDE
		
		elseif( $side_global_hide ) :
		
			$hannah_cd_sidebar_show = false;
		
		// [SIDEBAR] = UNDEFINED
		
		elseif( $hannah_cd_sidebar_show === NULL ) :
		
			$hannah_cd_sidebar_show = true; // default value
		
		endif;		
		
		
		/* SIDEBAR POSITION */
		/*****************************************************************/
		
		global $hannah_cd_sidebar_pos;

		$sidepos_global_left = ACF_GF('sidebar_global_position', 'option') == 'left';
		$sidepos_global_right = ACF_GF('sidebar_global_position', 'option') == 'right';
		
		$sidepos_specific_left = ACF_GF('sidebar_position') == 'left';
		$sidepos_specific_right = ACF_GF('sidebar_position') == 'right';

		
		if( $sidepos_specific_right && $sidepos_global_left ) :
		
			$hannah_cd_sidebar_pos = true;
		
		
		elseif( $sidepos_specific_left && $sidepos_global_right ) :
		
			$hannah_cd_sidebar_pos = false;
		
		
		elseif( $sidepos_global_right ) :
		
			$hannah_cd_sidebar_pos = true;
		
		
		elseif( $sidepos_global_left ) :
	
			$hannah_cd_sidebar_pos = false;
		
		
		elseif( $hannah_cd_sidebar_pos === NULL ) :
		
			$hannah_cd_sidebar_pos = true; // default value
		
		
		endif;

	}

endif;

add_action( 'template_redirect', 'hannah_cd_sidebar_show' );

