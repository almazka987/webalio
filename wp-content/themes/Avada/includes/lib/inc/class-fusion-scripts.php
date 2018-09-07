<?php
/**
 * Register default scripts.
 *
 * @package Fusion-Library
 * @since 1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Registers scripts.
 */
class Fusion_Scripts {

	/**
	 * Constructor.
	 */
	public function __construct() {

		add_action( 'wp', array( $this, 'init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_scripts' ) );
	}

	/**
	 * Runs on init.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function init() {

		$this->register_scripts();
		$this->enqueue_scripts();
		$this->localize_scripts();

	}

	/**
	 * An array of our scripts.
	 *
	 * @access protected
	 * @since 1.0.0
	 * @return void
	 */
	protected function register_scripts() {

		$scripts = array(
			array(
				'cssua',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/cssua.js',
				array(),
				'2.1.28',
				true,
			),
			array(
				'modernizr',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/modernizr.js',
				array(),
				'3.3.1',
				true,
			),
			array(
				'isotope',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/isotope.js',
				array( 'jquery' ),
				'3.0.0',
				true,
			),

			// Bootstrap.
			array(
				'bootstrap-collapse',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/bootstrap.collapse.js',
				array(),
				'3.1.1',
				true,
			),
			array(
				'bootstrap-modal',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/bootstrap.modal.js',
				array(),
				'3.1.1',
				true,
			),
			array(
				'bootstrap-tooltip',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/bootstrap.tooltip.js',
				array(),
				'3.3.5',
				true,
			),
			array(
				'bootstrap-popover',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/bootstrap.popover.js',
				array( 'bootstrap-tooltip', 'cssua' ),
				'3.3.5',
				true,
			),
			array(
				'bootstrap-transition',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/bootstrap.transition.js',
				array(),
				'3.3.6',
				true,
			),
			array(
				'bootstrap-tab',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/bootstrap.tab.js',
				array( 'bootstrap-transition' ),
				'3.1.1',
				true,
			),

			// jQuery.
			array(
				'jquery-waypoints',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.waypoints.js',
				array( 'jquery' ),
				'2.0.3',
				true,
			),
			array(
				'jquery-request-animation-frame',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.requestAnimationFrame.js',
				array( 'jquery' ),
				'1',
				true,
			),
			array(
				'jquery-appear',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.appear.js',
				array( 'jquery' ),
				'1',
				true,
			),
			array(
				'jquery-caroufredsel',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.carouFredSel.js',
				array( 'jquery' ),
				'6.2.1',
				true,
			),
			array(
				'jquery-cycle',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.cycle.js',
				array( 'jquery' ),
				'3.0.3',
				true,
			),
			array(
				'jquery-easing',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.easing.js',
				array( 'jquery' ),
				'1.3',
				true,
			),
			array(
				'jquery-easy-pie-chart',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.easyPieChart.js',
				array( 'jquery' ),
				'2.1.7',
				true,
			),
			array(
				'jquery-fitvids',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.fitvids.js',
				array( 'jquery' ),
				'1.1',
				true,
			),
			array(
				'jquery-flexslider',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.flexslider.js',
				array( 'jquery' ),
				'2.2.2',
				true,
			),
			array(
				'jquery-fusion-maps',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.fusion_maps.js',
				array( 'jquery' ),
				'2.2.2',
				true,
			),
			array(
				'jquery-hover-flow',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.hoverflow.js',
				array( 'jquery' ),
				'1',
				true,
			),
			array(
				'jquery-hover-intent',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.hoverintent.js',
				array( 'jquery' ),
				'1',
				true,
			),
			array(
				'jquery-lightbox',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.ilightbox.js',
				array( 'jquery' ),
				'2.2',
				true,
			),
			array(
				'jquery-infinite-scroll',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.infinitescroll.js',
				array( 'jquery' ),
				'2.1',
				true,
			),
			array(
				'jquery-mousewheel',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.mousewheel.js',
				array( 'jquery' ),
				'3.0.6',
				true,
			),
			array(
				'jquery-placeholder',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.placeholder.js',
				array( 'jquery' ),
				'2.0.7',
				true,
			),
			array(
				'jquery-touch-swipe',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.touchSwipe.js',
				array( 'jquery' ),
				'1.6.6',
				true,
			),
			array(
				'jquery-fade',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/jquery.fade.js',
				array( 'jquery' ),
				'1',
				true,
			),

			// Necessary?
			array(
				'froogaloop',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/Froogaloop.js',
				array(),
				'1',
				true,
			),
			array(
				'images-loaded',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/imagesLoaded.js',
				array(),
				'3.1.8',
				true,
			),

			// General.
			array(
				'fusion-alert',
				FUSION_LIBRARY_URL . '/assets/min/js/general/fusion-alert.js',
				array( 'jquery' ),
				'1',
				true,
			),
			array(
				'fusion-equal-heights',
				FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-equal-heights.js',
				array( 'jquery' ),
				'1',
				true,
			),
			array(
				'fusion-parallax',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/fusion-parallax.js',
				array( 'jquery-request-animation-frame' ),
				'1',
				true,
			),
			array(
				'fusion-video-bg',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/fusion-video-bg.js',
				array(),
				'1',
				true,
			),
			array(
				'fusion-video-general',
				FUSION_LIBRARY_PATH . '/assets/min/js/library/fusion-video-general.js',
				array( 'jquery-fitvids' ),
				'1',
				true,
			),
			array(
				'fusion-waypoints',
				FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-waypoints.js',
				array( 'jquery-waypoints', 'modernizr' ),
				'1',
				true,
			),
			array(
				'fusion-lightbox',
				FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-lightbox.js',
				array( 'jquery-lightbox', 'jquery-mousewheel' ),
				'1',
				true,
			),
			array(
				'fusion-carousel',
				FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-carousel.js',
				array( 'jquery-caroufredsel', 'jquery-touch-swipe' ),
				'1',
				true,
			),
			array(
				'fusion-flexslider',
				FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-flexslider.js',
				array( 'jquery-flexslider' ),
				'1',
				true,
			),
			array(
				'fusion-popover',
				FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-popover.js',
				array( 'cssua', 'bootstrap-popover' ),
				'1',
				true,
			),
			array(
				'fusion-tooltip',
				FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-tooltip.js',
				array( 'bootstrap-tooltip', 'jquery-hover-flow' ),
				'1',
				true,
			),
			array(
				'fusion-sharing-box',
				FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-sharing-box.js',
				array( 'jquery' ),
				'1',
				true,
			),
			array(
				'fusion-blog',
				FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-blog.js',
				array( 'jquery', 'isotope', 'fusion-lightbox', 'fusion-flexslider', 'jquery-infinite-scroll', 'images-loaded' ),
				'1',
				true,
			),
			array(
				'fusion-button',
				FUSION_LIBRARY_URL . '/assets/min/js/general/fusion-button.js',
				array( 'jquery', 'cssua' ),
				'1',
				true,
			),
		);
		foreach ( $scripts as $script ) {
			Fusion_Dynamic_JS::register_script(
				$script[0],
				$script[1],
				$script[2],
				$script[3],
				$script[4]
			);

		}
	}

	/**
	 * Enqueues scripts.
	 *
	 * @access protected
	 * @since 1.0.0
	 * @return void
	 */
	public function wp_enqueue_scripts() {

		if ( fusion_library()->get_option( 'status_gmap' ) ) {
			$map_protocol = 'http' . ( ( is_ssl() ) ? 's' : '' );
			$map_key = ( ( fusion_library()->get_option( 'gmap_api' ) ) ? 'key=' . fusion_library()->get_option( 'gmap_api' ) . '&' : '' );
			$map_api = $map_protocol . '://maps.googleapis.com/maps/api/js?' . $map_key . 'language=' . substr( get_locale(), 0, 2 );
			wp_register_script( 'google-maps-api', $map_api, array(), '1', true );
			wp_register_script( 'google-maps-infobox', FUSION_LIBRARY_URL . '/assets/min/js/library/infobox_packed.js', array(), '1', true );
		}

		// Conditional loading for older IE versions.
		wp_register_script( 'fusion-ie9', FUSION_LIBRARY_URL . '/assets/min/js/general/fusion-ie9.js', array(), '1', true );
		wp_enqueue_script( 'fusion-ie9' );
		wp_script_add_data( 'fusion-ie9', 'conditional', 'IE 9' );
	}

	/**
	 * Enqueues scripts.
	 *
	 * @access protected
	 * @since 1.0.0
	 * @return void
	 */
	protected function enqueue_scripts() {

		// Some general enqueue for now.
		Fusion_Dynamic_JS::enqueue_script(
			'fusion-general-global',
			FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-general-global.js',
			array( 'jquery', 'jquery-placeholder' ),
			'1',
			true
		);

		// IE 10-11.
		Fusion_Dynamic_JS::enqueue_script(
			'fusion-ie1011',
			FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-ie1011.js',
			array( 'jquery', 'cssua' ),
			'1',
			true
		);

		// Scroll to anchor, required in FB?
		Fusion_Dynamic_JS::enqueue_script(
			'fusion-scroll-to-anchor',
			FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-scroll-to-anchor.js',
			array( 'jquery', 'jquery-easing' ),
			'1',
			true
		);

		// If responsive typography is enabled.
		if ( fusion_library()->get_option( 'typography_responsive' ) || fusion_library()->get_option( 'status_fusion_slider' ) ) {
			Fusion_Dynamic_JS::enqueue_script(
				'fusion-responsive-typography',
				FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-responsive-typography.js',
				array( 'jquery' ),
				'1',
				true
			);
		}

		// If responsive is disabled.
		if ( ! fusion_library()->get_option( 'responsive' ) ) {
			Fusion_Dynamic_JS::enqueue_script(
				'fusion-non-responsive',
				FUSION_LIBRARY_PATH . '/assets/min/js/general/fusion-non-responsive.js',
				array( 'jquery' ),
				'1',
				true
			);
		}
	}

	/**
	 * Localizes scripts.
	 *
	 * @access protected
	 * @since 1.0.0
	 * @return void
	 */
	protected function localize_scripts() {

		// Localize scripts.
		Fusion_Dynamic_JS::localize_script(
			'fusion-video-bg',
			'fusionVideoBgVars',
			array(
				'status_vimeo' => fusion_library()->get_option( 'status_vimeo' ) ? fusion_library()->get_option( 'status_vimeo' ) : '0',
			)
		);
		Fusion_Dynamic_JS::localize_script(
			'fusion-equal-heights',
			'fusionEqualHeightVars',
			array(
				'content_break_point' => intval( fusion_library()->get_option( 'content_break_point' ) ),
			)
		);
		Fusion_Dynamic_JS::localize_script(
			'fusion-video-general',
			'fusionVideoGeneralVars',
			array(
				'status_vimeo' => fusion_library()->get_option( 'status_vimeo' ) ? fusion_library()->get_option( 'status_vimeo' ) : '0',
				'status_yt'    => fusion_library()->get_option( 'status_yt' ) ? fusion_library()->get_option( 'status_yt' ) : '0',
			)
		);
		Fusion_Dynamic_JS::localize_script(
			'jquery-fusion-maps',
			'fusionMapsVars',
			array(
				'admin_ajax'       => admin_url( 'admin-ajax.php' ),
				'admin_ajax_nonce' => wp_create_nonce( 'avada_admin_ajax' ),
			)
		);
		Fusion_Dynamic_JS::localize_script(
			'jquery-lightbox',
			'fusionLightboxVars',
			array(
				'lightbox_video_width'  => fusion_library()->get_option( 'lightbox_video_dimensions' ) ? Fusion_Sanitize::number( fusion_library()->get_option( 'lightbox_video_dimensions', 'width' ) ) : '1280',
				'lightbox_video_height' => fusion_library()->get_option( 'lightbox_video_dimensions' ) ? Fusion_Sanitize::number( fusion_library()->get_option( 'lightbox_video_dimensions', 'height' ) ) : '720',
			)
		);
		Fusion_Dynamic_JS::localize_script(
			'fusion-lightbox',
			'fusionLightboxVars',
			array(
				'status_lightbox'          => fusion_library()->get_option( 'status_lightbox' ) ? fusion_library()->get_option( 'status_lightbox' ) : false,
				'lightbox_gallery'         => fusion_library()->get_option( 'lightbox_gallery' ) ? fusion_library()->get_option( 'lightbox_gallery' ) : false,
				'lightbox_skin'            => fusion_library()->get_option( 'lightbox_skin' ) ? fusion_library()->get_option( 'lightbox_skin' ) : false,
				'lightbox_title'           => fusion_library()->get_option( 'lightbox_title' ) ? fusion_library()->get_option( 'lightbox_title' ) : false,
				'lightbox_arrows'          => fusion_library()->get_option( 'lightbox_arrows' ) ? fusion_library()->get_option( 'lightbox_arrows' ) : false,
				'lightbox_slideshow_speed' => fusion_library()->get_option( 'lightbox_slideshow_speed' ) ? (int) fusion_library()->get_option( 'lightbox_slideshow_speed' ) : false,
				'lightbox_autoplay'        => fusion_library()->get_option( 'lightbox_autoplay' ) ? fusion_library()->get_option( 'lightbox_autoplay' ) : false,
				'lightbox_opacity'         => fusion_library()->get_option( 'lightbox_opacity' ) ? fusion_library()->get_option( 'lightbox_opacity' ) : false,
				'lightbox_desc'            => fusion_library()->get_option( 'lightbox_desc' ) ? fusion_library()->get_option( 'lightbox_desc' ) : false,
				'lightbox_social'          => fusion_library()->get_option( 'lightbox_social' ) ? fusion_library()->get_option( 'lightbox_social' ) : false,
				'lightbox_deeplinking'     => fusion_library()->get_option( 'lightbox_deeplinking' ) ? fusion_library()->get_option( 'lightbox_deeplinking' ) : false,
				'lightbox_path'            => fusion_library()->get_option( 'lightbox_path' ) ? fusion_library()->get_option( 'lightbox_path' ) : 'vertical',
			)
		);
		Fusion_Dynamic_JS::localize_script(
			'fusion-carousel',
			'fusionCarouselVars',
			array(
				'related_posts_speed' => fusion_library()->get_option( 'related_posts_speed' ) ? (int) fusion_library()->get_option( 'related_posts_speed' ) : 5000,
				'carousel_speed' => fusion_library()->get_option( 'carousel_speed' ) ? (int) fusion_library()->get_option( 'carousel_speed' ) : 5000,
			)
		);
		Fusion_Dynamic_JS::localize_script(
			'fusion-ie1011',
			'fusionIe1011Vars',
			array(
				'form_bg_color' => fusion_library()->get_option( 'form_bg_color' ) ? fusion_library()->get_option( 'form_bg_color' ) : '#ffffff',
			)
		);

		$smooth_height = ( 'auto' === get_post_meta( fusion_library()->get_page_id(), 'pyre_fimg_width', true ) && 'half' === get_post_meta( fusion_library()->get_page_id(), 'pyre_width', true ) ) ? 'true' : 'false';
		if ( 'true' === $smooth_height ) {
			$flex_smooth_height = 'true';
		} else {
			$flex_smooth_height = ( fusion_library()->get_option( 'slideshow_smooth_height' ) ) ? 'true' : 'false';
		}

		Fusion_Dynamic_JS::localize_script(
			'fusion-flexslider',
			'fusionFlexSliderVars',
			array(
				'status_vimeo'           => fusion_library()->get_option( 'status_vimeo' ) ? fusion_library()->get_option( 'status_vimeo' ) : false,
				'page_smoothHeight'      => $smooth_height,
				'slideshow_autoplay'     => fusion_library()->get_option( 'slideshow_autoplay' ) ? fusion_library()->get_option( 'slideshow_autoplay' ) : false,
				'slideshow_speed'        => fusion_library()->get_option( 'slideshow_speed' ) ? (int) fusion_library()->get_option( 'slideshow_speed' ) : 5000,
				'pagination_video_slide' => fusion_library()->get_option( 'pagination_video_slide' ) ? fusion_library()->get_option( 'pagination_video_slide' ) : false,
				'status_yt'              => fusion_library()->get_option( 'status_yt' ) ? fusion_library()->get_option( 'status_yt' ) : false,
				'flex_smoothHeight'      => $flex_smooth_height,
			)
		);
		Fusion_Dynamic_JS::localize_script(
			'fusion-responsive-typography',
			'fusionTypographyVars',
			array(
				'site_width'             => fusion_library()->get_option( 'site_width' ) ? fusion_library()->get_option( 'site_width' ) : '1100px',
				'typography_sensitivity' => fusion_library()->get_option( 'typography_sensitivity' ) ? fusion_library()->get_option( 'typography_sensitivity' ) : 1,
				'typography_factor'      => fusion_library()->get_option( 'typography_factor' ) ? fusion_library()->get_option( 'typography_factor' ) : 1,
			)
		);
		Fusion_Dynamic_JS::localize_script(
			'fusion-blog',
			'fusionBlogVars',
			array(
				'infinite_blog_text'     => '<em>' . __( 'Loading the next set of posts...', 'Avada' ) . '</em>',
				'infinite_finished_msg'  => '<em>' . __( 'All items displayed.', 'Avada' ) . '</em>',
				'slideshow_autoplay'     => fusion_library()->get_option( 'slideshow_autoplay' ) ? fusion_library()->get_option( 'slideshow_autoplay' ) : false,
				'slideshow_speed'        => fusion_library()->get_option( 'slideshow_speed' ) ? (int) fusion_library()->get_option( 'slideshow_speed' ) : 5000,
				'pagination_video_slide' => fusion_library()->get_option( 'pagination_video_slide' ) ? fusion_library()->get_option( 'pagination_video_slide' ) : false,
				'status_yt'              => fusion_library()->get_option( 'status_yt' ) ? fusion_library()->get_option( 'status_yt' ) : false,
				'lightbox_behavior'      => fusion_library()->get_option( 'lightbox_behavior' ) ? fusion_library()->get_option( 'lightbox_behavior' ) : false,
				'blog_pagination_type'   => fusion_library()->get_option( 'blog_pagination_type' ) ? fusion_library()->get_option( 'blog_pagination_type' ) : false,
			)
		);
	}
}
