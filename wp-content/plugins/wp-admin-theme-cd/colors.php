<?php 

// get the selected theme color from wp admin

$get_option = get_option( 'wp_admin_theme_settings_options' );
$custom_theme_color = $get_option['theme_color'];
$custom_theme_bg_start_color = $get_option['theme_background'];
$custom_theme_bg_end_color = $get_option['theme_background_end'];
$theme_css = $get_option['css_admin'];

if ( isset( $toolbar ) ? $toolbar : '' );
else $toolbar = $get_option['toolbar'];

if ( isset( $toolbar_wp_icon ) ? $toolbar_wp_icon : '' );
else $toolbar_wp_icon = $get_option['toolbar_wp_icon'];

if ( isset( $toolbar_icon ) ? $toolbar_icon : '' );
else $toolbar_icon = $get_option['toolbar_icon'];

if ( isset( $spacing ) ? $spacing : '' );
else $spacing = $get_option['spacing'];

if ( isset( $webfont ) ? $webfont : '' );
else $webfont = $get_option['google_webfont'];

?>

<?php if( $custom_theme_bg_start_color && $custom_theme_bg_end_color ) { ?>

/****************************************/
/* CSS Background-Body-Gradient */
/****************************************/

body.wp-admin {
    background: linear-gradient(to bottom right, <?php echo esc_html( $custom_theme_bg_start_color ); ?>, <?php echo esc_html( $custom_theme_bg_end_color ); ?>)!important;
	background-repeat: no-repeat!important;
    background-attachment: fixed!important;
}

<?php } ?>

<?php if( $custom_theme_color ) { ?>

/****************************************/
/* CSS Background-Color */
/****************************************/

input[type="radio"]:checked:before,
#adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, 
#adminmenu li.current a.menu-top, 
.folded #adminmenu li.wp-has-current-submenu, 
.folded #adminmenu li.current.menu-top, 
#adminmenu .wp-menu-arrow, 
#adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, 
#adminmenu .wp-menu-arrow div,
.wrap h1:after,
.theme-browser .theme.active .theme-name,
.widget.open .widget-top,
#available-widgets .widget:hover .widget-top,
.widgets-chooser li.widgets-chooser-selected,
.menu li.menu-item-edit-active .menu-item-handle,
.wp-core-ui .attachment.details .check, .wp-core-ui .attachment.selected .check:focus, .wp-core-ui .media-frame.mode-grid .attachment.selected .check,
.post-state,
.theme-browser .theme.add-new-theme a:hover:after, .theme-browser .theme.add-new-theme a:focus:after,
.acf-field-group .acf-label label:after,
.acf-radio-list label.selected,
#adminmenu div.wp-menu-image .wp-menu-img-wrap {
	background-color: <?php echo esc_html( $custom_theme_color ); ?>;
}

/****************************************/
/* CSS Background-Color - IMPORTANT */
/****************************************/

.wrap .add-new-h2, 
.wrap .add-new-h2:active, 
.wrap .page-title-action, 
.wrap .page-title-action:active,
#minor-publishing-actions input, 
#major-publishing-actions input, 
#minor-publishing-actions .preview,
.wp-core-ui .button-primary,
.wp-core-ui button.button.button-primary
.wp-core-ui input.button.button-primary,
button.button.button-hero,
.wp-core-ui .button-primary[disabled],
.acf-switch.-on,
.switch-light.switch-yoast-seo a, .switch-toggle.switch-yoast-seo a,
.select2-container--default .select2-results__option--highlighted[aria-selected],
.acf-image-uploader .acf-actions a,
.acf-field-object.open > .handle,
.acf-box .footer,
.composer-switch a,
.wpat-logout-button {
	background-color: <?php echo esc_html( $custom_theme_color ); ?>!important;
}

/****************************************/
/* CSS Border-Color */
/****************************************/

#adminmenu .wp-submenu, 
.folded #adminmenu a.wp-has-current-submenu:focus + .wp-submenu, 
.folded #adminmenu .wp-has-current-submenu .wp-submenu,
.plugins .active th.check-column, .plugin-update-tr.active td,
.theme-browser .theme.active,
.menu li.menu-item-edit-active .menu-item-handle,
.acf-radio-list label.selected {
	border-color: <?php echo esc_html( $custom_theme_color ); ?>;
}

/****************************************/
/* CSS Border-Color - IMPORTANT */
/****************************************/

.wrap .add-new-h2, 
.wrap .add-new-h2:active, 
.wrap .page-title-action, 
.wrap .page-title-action:active,
#minor-publishing-actions input, 
#major-publishing-actions input, 
#minor-publishing-actions .preview,
.wp-core-ui .button-primary,
.wp-core-ui button.button.button-primary
.wp-core-ui input.button.button-primary,
.widget.open .widget-top,
#available-widgets .widget .widget-top:hover,
.acf-field-object.open > .handle {
	border-color: <?php echo esc_html( $custom_theme_color ); ?>!important;
}

/****************************************/
/* CSS Border-Right-Color - IMPORTANT */
/****************************************/

#adminmenu .wp-has-submenu.opensub:after {
	border-right-color: <?php echo esc_html( $custom_theme_color ); ?>!important;
}

/****************************************/
/* CSS BOX-SHADOW */
/****************************************/

.wp-core-ui .attachment.details {
	box-shadow: inset 0 0 0 3px #fff, inset 0 0 0 7px <?php echo esc_html( $custom_theme_color ); ?>;
}

/****************************************/
/* CSS COLOR */
/****************************************/

a, .wp-core-ui .button-link, .media-menu > a, .media-frame a,
#adminmenu a:hover, 
#adminmenu li.menu-top.wp-not-current-submenu > a:focus, 
#adminmenu .wp-submenu a:hover, 
#adminmenu .wp-submenu a:focus, 
#adminmenu li.opensub > a.menu-top,
#adminmenu div.wp-menu-image:before,
.wrap h1,
table.widefat tr:hover td a:not(.submitdelete):not(.delete):not(.vim-u),
h2,
.theme-browser .theme.add-new-theme a:hover span:after, .theme-browser .theme.add-new-theme a:focus span:after,
.acf-field-message > .acf-label label {
	color: <?php echo esc_html( $custom_theme_color ); ?>;
}

/****************************************/
/* CSS COLOR - IMPORTANT */
/****************************************/

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove,
.acf-tab-wrap.-left .acf-tab-group li a,
.acf-field-group .acf-label label,
#woocommerce_dashboard_status .wc_status_list li a strong {
	color: <?php echo esc_html( $custom_theme_color ); ?>;
}

/****************************************/
/* RTL - CSS Border-Left-Color - IMPORTANT */
/****************************************/

.rtl #adminmenu .wp-has-submenu.opensub:after {
	border-right-color: transparent!important;
	border-left-color: <?php echo esc_html( $custom_theme_color ); ?>!important;
}

/****************************************/
/* RTL - CSS Border-Right-Color - IMPORTANT */
/****************************************/

.rtl #adminmenu .wp-submenu {
	border-left-color: transparent!important;
	border-right-color: <?php echo esc_html( $custom_theme_color ); ?>!important;
}

<?php } ?>

<?php if( $toolbar ) { ?>

	/****************************************/
	/* Remove the Toolbar */
	/****************************************/

	html.wp-toolbar {
		padding-top: 0px!important
	}

	body.wp-admin {
		padding-top: 50px!important;
	}

	#wpadminbar {
		display:none!important
	}

	.vc_fullscreen .vc_navbar, .vc_subnav-fixed {
		top: 0px!important;
	}
	
	@media only screen and (max-width: 782px) {
	
		body.wp-admin {
			padding-top: 46px!important;
		}
	
		#wpadminbar {
			display:block!important
		}
		
		.wpat-logout {
			display:none!important
		}
	
	}
	
	@media only screen and (max-width: 600px) {
	
		body.wp-admin {
			padding-top: 0px!important;
		}
	
	}

<?php } ?>

<?php if( $spacing ) { ?>

	/****************************************/
	/* Remove the Spacing */
	/****************************************/

	body.wp-admin {
		padding: 0px!important;
	}

<?php } ?>

<?php if( $spacing && $toolbar ) { ?>

	html.wp-toolbar {
		padding-top: 0px!important
	}
	
	/****************************************/
	/* Logout Button */
	/****************************************/
	
	.wpat-logout {
		top: 0px;
		right: 0px;
		z-index: 1;
	}
	
	.wpat-logout-button {
		position: relative;
		background: #4777CD;
		width: 29px;
    	height: 29px;
		text-align: center
	}
	
	.wpat-logout-button:before {
		content: "\f110";
		font-family: dashicons;
		color: #fff;
		font-size: 20px		
	}
	
	.wpat-logout-content {
		position: absolute;
		top: -100px;
		right: 29px;
    	height: 19px;
    	padding: 5px;
		background: #4777CD
	}
	
	.wpat-logout-content a {
		margin: 0px 3px;
	}
	
	.wpat-logout:hover .wpat-logout-content {
		top: 0px;
	}
	
	@media only screen and (max-width: 782px) {
	
		.wpat-logout {
			display:none!important
		}
	
	}


<?php } elseif( $spacing && ! $toolbar ) { ?>

	html.wp-toolbar {
		padding-top: 50px!important
	}

<?php } ?>


<?php if( $toolbar_wp_icon ) { ?>

	/****************************************/
	/* Remove the Toolbar WP Icon */
	/****************************************/

	#wp-admin-bar-wp-logo {
		display: none!important;
	}

<?php } ?>


<?php if( $toolbar_icon ) { ?>

	/****************************************/
	/* Custom Toolbar Icon */
	/****************************************/

	#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
		content: '';
		background-image: url('<?php echo esc_html( $toolbar_icon ); ?>');
		background-position: center center;
		background-repeat: no-repeat;
		background-size: cover;
		position: absolute;
		top: 50%;
		margin-top: -10px;
    	width: 26px;
    	height: 26px;
	}

<?php } ?>


<?php if( $webfont ) { ?>

	/****************************************/
	/* Custom Google Webfont */
	/****************************************/

	body {
		font-family: "<?php echo str_replace( '+', ' ', esc_html( $webfont ) ); ?>"!important
	}

<?php } ?>


<?php if( $theme_css ) { ?>

/****************************************/
/* Custom CSS BY USER */
/****************************************/

<?php echo esc_html( $theme_css ); ?>

<?php } ?>