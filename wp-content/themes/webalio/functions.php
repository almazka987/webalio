<?php

// require files
require_once( get_stylesheet_directory() . '/inc/assets.php');
require_once( get_stylesheet_directory() . '/inc/register-post-type.php');
require_once( get_stylesheet_directory() . '/inc/shortcodes.php');
require_once( get_stylesheet_directory() . '/lib/Mobile_Detect.php' );
require_once( get_stylesheet_directory() . '/lib/wp_bootstrap_navwalker.php' );

if ( ! function_exists( 'pr' ) ) {
	function pr($val) {
		echo '<pre>';
		print_r($val);
		echo '</pre>';
	}
}

// Scripts preload
add_action('wp_head', function () {
    global $wp_scripts;
    foreach($wp_scripts->queue as $handle) {
        $script = $wp_scripts->registered[$handle];
        //-- Weird way to check if script is being enqueued in the footer.
        if($script->extra['group'] === 1) {
            //-- If version is set, append to end of source.
            $source = $script->src . ($script->ver ? "?ver={$script->ver}" : "");
            //-- Spit out the tag.
            echo "<link rel='preload' href='{$source}' as='script' onload='var script = document.createElement('script'); script.src = this.href; document.body.appendChild(script);'/>\n";
        }
    }
}, 1);

// Styles preload
function add_rel_preload($html, $handle, $href, $media) {
    if (is_admin()) {
        return $html;
    } else {
        $html = <<<EOT
<link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'" id='$handle' href='$href' type='text/css' media='all' />
EOT;
        return $html;
    }
}
add_filter( 'style_loader_tag', 'add_rel_preload', 10, 4 );

// ignoring wpcf7 errors
add_filter( 'wpcf7_validate_configuration', '__return_false' );

// translate custom
add_action( 'after_setup_theme', 'add_translations' );
function add_translations() {
    load_theme_textdomain( 'webalio', get_stylesheet_directory() . '/languages' );
}

// qTranslate-X fix menu link title
add_filter( 'nav_menu_link_attributes', 'translate_btn_title_fix', 10, 4 );

function translate_btn_title_fix( $atts, $item, $args ){
    if (isset($item->item_lang)) {
        $atts['title'] = $item->attr_title;
    }

    return $atts;
}

// add images thumbnails
add_theme_support( 'post-thumbnails' );
add_image_size( 'sizeThumb', 300, 320, array( 'top', 'left' ) );

// register menu
function theme_register_nav_menu() {
	register_nav_menu( 'primary', 'Primary Menu' );
}
add_action( 'after_setup_theme', 'theme_register_nav_menu' );

// register sidebars
function register_alio_sidebars() {

	register_sidebar(
		array(
			'id' => 'footer3_sidebar',
			'name' => 'Footer 3  column',
			'description' => 'Drag widgets to add them in the sidebar',
			'before_widget' => '<div id="%1$s" class="foot widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>'
		)
	);
}
add_action( 'widgets_init', 'register_alio_sidebars' );
