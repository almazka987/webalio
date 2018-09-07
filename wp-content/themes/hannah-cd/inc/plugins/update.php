<?php 

/*****************************************************************/
/* TGMPA - DISMISSABLE NOTIFICATION FIX */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_tgmpa_required_plugin_notice' ) ) :

    function hannah_cd_tgmpa_required_plugin_notice() {
        
        // The problem of TGMPA is, with the latest version you can't distinguish between recommended and required plugins, if you want to disable the notification only for recommended plugins.
        // This solution show the notification again, if a required plugin is only inactive.
        
        global $current_user;

        if( $current_user ) {
            $activation_notice_dismissed = get_user_meta( $current_user->ID, 'tgmpa_dismissed_notice_hannah-cd', true );

            $hannah_helper_plugin = is_plugin_active('hannah-cd-helper/hannah-cd-helper.php');
            
            if ( ! $hannah_helper_plugin && $activation_notice_dismissed == true ) {
                update_user_meta( $current_user->ID, 'tgmpa_dismissed_notice_hannah-cd', false, true );
            }
        }
        
    }

endif;

add_action('admin_notices', 'hannah_cd_tgmpa_required_plugin_notice');


/*****************************************************************/
/* UPDATE OLD PAGE TEMPLATE ASSIGNMENT */
/*****************************************************************/

if ( ! function_exists('hannah_cd_update_old_page_templates') ) :

	function hannah_cd_update_old_page_templates() {
						
		$curr_page_template_name = get_post_meta( get_the_ID(), '_wp_page_template', true );
		$old_default_page = metadata_exists( 'post', get_the_ID(), 'content_rows' ); // check if the sections exist
		
		// check the current page is assigned to the [DEFAULT PAGE TEMPLATE] and the metadata [content_rows] is exist
		if( $curr_page_template_name == 'default' && $old_default_page ) {
			// set the old [DEFAULT PAGE TEMPLATE] to the new [SECTIONS PAGE TEMPLATE]
			update_post_meta( get_the_ID(), '_wp_page_template', 'page-sections.php', 'default' );
		}

		// check the current page is assigned to the [CLASSIC PAGE TEMPLATE]
		if( $curr_page_template_name == 'page-classic.php' ) {
			// set the old [CLASSIC PAGE TEMPLATE] to the new [DEFAULT PAGE TEMPLATE]
			update_post_meta( get_the_ID(), '_wp_page_template', 'default', 'page-classic.php' );
		}
        
	}

endif;

add_action('add_meta_boxes', 'hannah_cd_update_old_page_templates');
add_action('wp', 'hannah_cd_update_old_page_templates');


/*****************************************************************/
/* UPDATE OLD HEADER STYLE */
/*****************************************************************/

if ( ! function_exists('hannah_cd_update_old_header_style') ) :

	function hannah_cd_update_old_header_style() {
						
		$old_wide_header = get_post_meta( get_the_ID(), 'wide_header', true );
		$old_full_page_header = get_post_meta( get_the_ID(), 'full_page_header', true );
		
		// check the option [wide_header] is true
		if( $old_wide_header ) {
			// set the new field value to [header_style = wide] and delete old field value
			update_post_meta( get_the_ID(), 'header_style', 'wide', 'box' );
			delete_post_meta( get_the_ID(), 'wide_header', true );
		}
        
        // check the option [full_page_header] is true
		if( $old_full_page_header ) {
			// set the new field value to [header_style = full_page] and delete old field value
			update_post_meta( get_the_ID(), 'header_style', 'full_page', 'box' );
			delete_post_meta( get_the_ID(), 'full_page_header', true );
		}
        
	}

	add_action('add_meta_boxes', 'hannah_cd_update_old_header_style');
	add_action('wp', 'hannah_cd_update_old_header_style');

endif;