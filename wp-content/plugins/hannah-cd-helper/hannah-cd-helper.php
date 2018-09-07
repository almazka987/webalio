<?php
/**
 * Plugin Name: Hannah CD Helper
 * Description: Adds shortcode support to use within a theme
 * Version: 1.2
 * Author: Martin Jost
 * Author URI: http://www.creative-dive.de
 * Text Domain: hannah-cd-helper
 * Domain Path: /languages
 */


/*****************************************************************/
/* CREATE TABLE FOR POST RATING */
/*****************************************************************/

function hannah_cd_createPostRatingTable() {
	
	global $wpdb;
	
	// create db table prefix (wp_)
	$search_table = $wpdb->prefix . 'hannah_cd_post_ratings';
	
	// check if same tables already exsist
	if( $wpdb->get_var( "SHOW TABLES LIKE '$search_table'" ) != $search_table ) {
		
		// set charset
		if ( ! empty( $wpdb->charset ) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty( $wpdb->collate ) )
			$charset_collate .= " COLLATE $wpdb->collate";
 
		$sql = "CREATE TABLE " . $search_table . " (
			`user_ip` VARCHAR(15) NOT NULL,
			`post_id` BIGINT(20) UNSIGNED NOT NULL,
			KEY `post_id`(`post_id`),
			KEY `user_ip`(`user_ip`)
		) $charset_collate;";
		
		// include wp db functions
		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		// register new table with wpdb object
		if ( ! isset( $wpdb->hannah_cd_post_ratings ) ) {
			$wpdb->hannah_cd_post_ratings = $search_table; 
			$wpdb->tables[] = str_replace( $wpdb->prefix, '', $search_table ); 
		}
		
	}
}

register_activation_hook(__FILE__, 'hannah_cd_createPostRatingTable');


/*****************************************************************/
/* SEMINAR SHORTCODE - [seminar] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_seminar_shortcode' ) ) :

	function hannah_cd_seminar_shortcode( $atts ) {
		ob_start();
	
		if( ACF_HR('add_custom_seminar_date') ):
			while ( ACF_HR('add_custom_seminar_date') ) { the_row();
			
				$date = DateTime::createFromFormat('Ymd', ACF_GSF('custom_seminar_date'));
				echo '<option>' . $date->format('m.d.Y') . '</option>';
				
			} 
		endif;
	
		$sc = ob_get_contents();
		ob_end_clean();
		return $sc;
	}

endif;

add_shortcode( 'seminar', 'hannah_cd_seminar_shortcode' );


/*****************************************************************/
/* BUTTON SHORTCODE - [button] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_Button' ) ) :

	function hannah_cd_Button($atts, $content = null) {
	   	extract(shortcode_atts(array('link' => '#'), $atts));
	   	return '<a class="button post-button" href="' . $link . '">' . do_shortcode($content) . '</a>';
	}

endif;

add_shortcode('button', 'hannah_cd_Button');


/*****************************************************************/
/* NESTED UNORDERED LIST SHORTCODE - [ulist] */
/*****************************************************************/

function hannah_cd_list_icon_lists( $atts, $content = null ) {

    extract( shortcode_atts( array(
		'icon' => 'fa-check-circle'
		), $atts)
	);
	
    $ulist = '<div class="ulist" data-icon="' . $icon . '">';
		$ulist .= do_shortcode($content);
    $ulist .= '</div>';
	
    //return $ulist;

	// remove paragraphs between shortcode container
	$find_p = array('<p>', '</p>');
	$remove_p = array('', '');

	$clean_output = str_replace($find_p, $remove_p, $ulist);
	return $clean_output;

}

add_shortcode('ulist', 'hannah_cd_list_icon_lists');


/*****************************************************************/
/* NESTED ORDERED LIST SHORTCODE - [olist] */
/*****************************************************************/

function hannah_cd_olist( $atts, $content = null ) {

    $olist = '<div class="olist">';
		$olist .= do_shortcode($content);
    $olist .= '</div>';
	
    return $olist;

}

add_shortcode('olist', 'hannah_cd_olist');


/*****************************************************************/
/* TABMENU SHORTCODE - [tabmenu] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_tabmenu' ) ) :

	$tabmenu_count = '1'; // start counter
	function hannah_cd_tabmenu( $atts, $content = null ) {
	
		global $tabmenu_count;

		ob_start();

		echo '<ul id="tabmenu-' . $tabmenu_count . '" class="nav nav-tabs" data-tabs="tabs">' . do_shortcode($content) . '</ul>';

		$tabmenu_count ++; // end counter

		$sc_icon = ob_get_contents();
		ob_end_clean();
		return $sc_icon;

	}

endif;

add_shortcode('tabmenu', 'hannah_cd_tabmenu');


/*****************************************************************/
/* TABS SHORTCODE - [tab] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_tab' ) ) :


	$tab_counter = '1'; // start counter
	
	function hannah_cd_tab( $atts, $content = null ) {
		
		global $tab_counter;

		ob_start();

		if($tab_counter == 1){
			echo '<li class="active"><a data-target="#tab-' . $tab_counter . '" data-toggle="tab" href="#tab-' . $tab_counter . '">';
		} elseif($tab_counter > 1) {
			echo '<li><a data-target="#tab-' . $tab_counter . '" data-toggle="tab" href="#tab-' . $tab_counter . '">';
		}

		echo do_shortcode($content) . '</a></li>';
	
		$tab_counter ++; // end counter

		$sc_icon = ob_get_contents();
		ob_end_clean();
		return $sc_icon;
	}

endif;

add_shortcode('tab', 'hannah_cd_tab');


/*****************************************************************/
/* TAB CONTENT SHORTCODE - [tab-content] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_tabcontent' ) ) :

	function hannah_cd_tabcontent( $atts, $content = null ) {
		return '<div class="tab-content">' . do_shortcode($content) . '</div>';
	}

endif;

add_shortcode('tab-content', 'hannah_cd_tabcontent');


/*****************************************************************/
/* TAB PANEL SHORTCODE - [tab-pane] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_tabpane' ) ) :

	$tab_count = '1'; // start counter

	function hannah_cd_tabpane( $atts, $content = null ) {

		global $tab_count;
		global $active_class;
		
		// add active class to the first div
		if($tab_count == 1){$active_class = 'in active';}
		if($tab_count > 1){$active_class = '';}

		ob_start();
	
		echo '<div id="tab-' . $tab_count . '" class="tab-pane fade ' . $active_class . '">';
		
		echo do_shortcode($content) . '</p></div>';

		$tab_count ++; // end counter

		$sc_icon = ob_get_contents();
		ob_end_clean();
		return $sc_icon;
	}

endif;

add_shortcode('tab-pane', 'hannah_cd_tabpane');


/*****************************************************************/
/* ALERT SHORTCODE - [alert] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_Alert' ) ) :

	function hannah_cd_Alert($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type' => 'success',
				'type' => 'info',
				'type' => 'warning',
				'type' => 'danger'
			), $atts)
		);

    	return '<div class="alert alert-' . $type . '" role="alert">' . do_shortcode($content) . '</div>';
	}

endif;

add_shortcode('alert', 'hannah_cd_Alert');


/*****************************************************************/
/* VIDEO SHORTCODE - [video-embed] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_Video' ) ) :

	function hannah_cd_Video($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type' => 'youtube',
				'type' => 'vimeo',
				'link' => '#'
			), $atts)
		);

		$output = '<div class="post-video"><div class="embed-responsive embed-responsive-16by9">';

			switch( $type ){
				case 'youtube' : 
					$output .= '<iframe style="width:100%" width="560" height="460" src="https://www.youtube.com/embed/' . esc_html( $link ) . '?rel=0&showinfo=0&autohide=1" allowfullscreen></iframe>';
					break;
				case 'vimeo' : 
					$output .= '<iframe style="width:100%" width="640" height="460" src="https://player.vimeo.com/video/' . esc_html( $link ) . '" allowfullscreen></iframe>';
					break;
				default:
					$output .= '';
					break;
			}

		$output .= '</div></div>';	

    	return $output;

	}

endif;

add_shortcode('video-embed', 'hannah_cd_Video');


/*****************************************************************/
/* ICON SHORTCODE - [icon] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_Icon' ) ) :

	function hannah_cd_Icon($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type' => '#',
				'size' => '#'
			), $atts)
		);

    	return '<i class="fa ' . $type . ' fa-' . $size . 'x"></i>';

	}

endif;

add_shortcode('icon', 'hannah_cd_Icon');


/*****************************************************************/
/* DROPCAP SHORTCODE - [dropcap] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_Dropcap' ) ) :

	function hannah_cd_Dropcap($atts, $content = null) {

    	return '<p><span class="dropcap">' . do_shortcode($content) . '</span>';

	}

endif;

add_shortcode('dropcap', 'hannah_cd_Dropcap');


/*****************************************************************/
/* LEAD-IN SHORTCODE - [leadin] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_Leadin' ) ) :

	function hannah_cd_Leadin($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'align' => '#',
			), $atts)
		);

    	return '<div class="leadin ' . $align . '">' . do_shortcode($content) . '</div>';

	}

endif;

add_shortcode('leadin', 'hannah_cd_Leadin');


/*****************************************************************/
/* ACCORDION SHORTCODE - [acc] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_accordion' ) ) :

	$acc_id_count = '1'; // start counter
	
	function hannah_cd_accordion( $atts, $content = null ) {
	
		global $acc_id_count;

		ob_start();

		echo '<div class="panel-group accordion" id="accordion' . $acc_id_count . '">' . do_shortcode($content) . '</div>';

		$acc_id_count ++; // end counter

		$sc_icon = ob_get_contents();
		ob_end_clean();
		return $sc_icon;

	}

endif;

add_shortcode('acc', 'hannah_cd_accordion');


/*****************************************************************/
/* ACCORDION ITEM SHORTCODE - [acc-item] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_accitem' ) ) :

	$acc_count = '1'; // start counter
	
	function hannah_cd_accitem($atts, $content = null) {

		global $acc_id_count;
		global $acc_count;
		global $active_class;
		
		// add active class to the first div
		if($acc_count == 1){$active_class = 'in';}
		if($acc_count > 1){$active_class = '';}

		extract(shortcode_atts(
			array(
				'item' => '#'
			), $atts)
		);

		$output = '<div class="panel panel-default">';
		
			$output .= '<div class="panel-heading">';
				$output .= '<div class="panel-title">';
					$output .= '<a data-toggle="collapse" data-parent="#accordion' . $acc_id_count . '" href="#collapse' . $acc_count . '">' . $item . '</a>';
				$output .= '</div>';
			$output .= '</div>';
			
			$output .= '<div id="collapse' . $acc_count . '" class="panel-collapse collapse ' . $active_class . '">';
				$output .= '<div class="panel-body"><p>' . do_shortcode($content) . '</p></div>';
			$output .= '</div>';

		$output .= '</div>';	

		$acc_count ++; // end counter

    	return $output;

	}

endif;

add_shortcode('acc-item', 'hannah_cd_accitem');


/*****************************************************************/
/* TOGGLE MENU SHORTCODE - [toggle] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_toggle' ) ) :

	$togg_id_count = '1'; // start counter
	
	function hannah_cd_toggle( $atts, $content = null ) {
	
		global $togg_id_count;

		ob_start();

		echo '<div class="panel-group toggle-menu" id="toggle' . $togg_id_count . '">' . do_shortcode($content) . '</div>';

		$togg_id_count ++; // end counter

		$sc_icon = ob_get_contents();
		ob_end_clean();
		return $sc_icon;

	}

endif;

add_shortcode('toggle', 'hannah_cd_toggle');


/*****************************************************************/
/* TOGGLE MENU ITEM SHORTCODE - [toggle-item] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_toggleitem' ) ) :

	$togg_count = '1'; // start counter
	
	function hannah_cd_toggleitem($atts, $content = null) {

		global $togg_id_count;
		global $togg_count;
		global $active_class;

		extract(shortcode_atts(
			array(
				'item' => '#',
				'collapse' => ''
			), $atts)
		);
		
		if( $collapse == 'no' ) {
			$collapse_class = 'in';
			$toggle_class = '';
		} else {
			$collapse_class = '';
			$toggle_class = 'collapsed';
		}

		$output = '<div class="panel panel-default">';
		
			$output .= '<div class="panel-heading">';
				$output .= '<div class="panel-title">';
					$output .= '<a class="' . $toggle_class . '" data-toggle="collapse" href="#collapse-toggle' . $togg_count . '"><i class="fa fa-plus"></i><i class="fa fa-minus"></i>' . $item . '</a>';
				$output .= '</div>';
			$output .= '</div>';
			
		
			$output .= '<div id="collapse-toggle' . $togg_count . '" class="panel-collapse collapse ' . $collapse_class . '">';
				$output .= '<div class="panel-body"><p>' . do_shortcode($content) . '</p></div>';
			$output .= '</div>';

		$output .= '</div>';	

		$togg_count ++; // end counter

    	return $output;

	}

endif;

add_shortcode('toggle-item', 'hannah_cd_toggleitem');


/*****************************************************************/
/* COLUMNS SHORTCODE - [column] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_column' ) ) :
	
	function hannah_cd_column( $atts, $content = null ) {

		ob_start();

		echo '<div class="post-column">' . do_shortcode($content) . '</div>';

		$sc_icon = ob_get_contents();
		ob_end_clean();
		return $sc_icon;

	}

endif;

add_shortcode('column', 'hannah_cd_column');


/*****************************************************************/
/* COLUMNS SHORTCODE - [col] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_col' ) ) :

	function hannah_cd_col($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'size' => '1',
			), $atts)
		);

    	return '<div class="col-' . $size . '">' . do_shortcode($content) . '</div>';
	}

endif;

add_shortcode('col', 'hannah_cd_col');


/*****************************************************************/
/* HIGHLIGHT / MARK SHORTCODE - [mark] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_highlight' ) ) :

	function hannah_cd_highlight( $atts, $content = null ) {
		return '<mark>' . do_shortcode($content) . '</mark>';
	}

endif;

add_shortcode('mark', 'hannah_cd_highlight');


/*****************************************************************/
/* DEVIDER SHORTCODE - [divider] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_divider' ) ) :

	function hannah_cd_divider($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type' => '#',
			), $atts)
		);

		if( $content ) {
    		return '<div class="divider with-content ' . $type . '">' . do_shortcode($content) . '</div>';
		} else {
			return '<div class="divider ' . $type . '"></div>';
		}

	}

endif;

add_shortcode('divider', 'hannah_cd_divider');


/*****************************************************************/
/* POST LIST SHORTCODE - [post-list] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_post_list' ) ) :

	function hannah_cd_post_list( $atts ) {
	

		extract( shortcode_atts( array (
			'type' => 'post',
			'order' => 'DESC',
			'orderby' => 'position',
			'count' => -1,
			'column' => '2',
			'post_ids' => ''
		), $atts ) );

		
		$options = array(
			'post_type' => $type,
			'order' => $order,
			'orderby' => $orderby,
			'posts_per_page' => $count,
			'ignore_sticky_posts' => 1
		);
						
		
		if( $post_ids ) {
			$options['post__in'] = explode(',', $post_ids);
		}
		
		
		$query = new WP_Query( $options );
		
		if ( $query->have_posts() ) { 
			
			if( $column == 'none' || $column == '1' ) {
				$row_style = 'no-margin';
			} else {
				$row_style = '';
			}
			
			$list_count = '1'; // start counter
			
			$content = '<div class="post-list-wrapper "><div class="row ' .  $row_style  . '">';
								
				while ( $query->have_posts() ) : $query->the_post();
			
					$excerpt = get_the_excerpt();
					$title = get_the_title();
			
					if( $column == 'none' ) {

						$column = 'col-none';
						$thumb_size = 'medium';
						$excerpt_lenght = '150';
						$readmore = '';
						$list = '0';

					} elseif( $column == '1' ) {

						$column = 'col-md-12';
						$thumb_size = 'large';
						$excerpt_lenght = '200';
						$readmore = '1';
						$list = '1';

					} elseif( $column == '2' ) { 

						$column = 'col-md-6';
						$thumb_size = 'medium';
						$excerpt_lenght = '0';
						$readmore = '';
						$list = '2';

					} elseif( $column == '3' ) { 

						$column = 'col-md-4';
						$thumb_size = 'medium';
						$excerpt_lenght = '0';
						$readmore = '';
						$list = '3';

					} elseif( $column == '4' ) { 

						$column = 'col-md-3';
						$thumb_size = 'medium';
						$excerpt_lenght = '0';
						$readmore = '';
						$list = '4';
						
					} 
					
					$link = get_the_permalink();
					$image_id = get_post_thumbnail_id();
					$image_uri = wp_get_attachment_image_src($image_id, $thumb_size, false);
					$image_url = $image_uri[0];
					$letter = mb_strimwidth( $title, 0, 1 );
			
					$content .= '<div class="post-list-teaser-box ' . $column . '">';
			
						if( $image_uri ) {
							$content .= '<a class="post-list-teaser-box-bg" href="' . $link . '" style="background-image:url(' . $image_url . ')"><div class="hover"></div></a>';
						} else {
							$content .= '<a class="post-list-teaser-box-bg no-img" href="' . $link . '"><div class="letter"><span>' . $letter . '</span></div><div class="hover"></div></a>';
						}
			
						$content .= '<div class="post-list-content">';
							$content .= '<a class="post-list-title" href="' . $link . '">' . $title . '</a>';
			
							$content .= '<p>';
							if( $excerpt_lenght > '0' ) {
								$content .= mb_strimwidth( $excerpt, 0, $excerpt_lenght, '...' );
							}
							$content .= '</p>';
								
							if( $readmore == '1' ) {
								$content .= '<a class="btn" href="' . $link . '">Read more</a>';
							}
			
						$content .= '</div>';
					$content .= '</div>';
			
			
					if( $list == '2' && $list_count % 2 == 0) {
						$content .= '<div class="clear"></div>';
					}
					if( $list == '3' && $list_count % 3 == 0) {
						$content .= '<div class="clear"></div>';
					}
					if( $list == '4' && $list_count % 4 == 0) {
						$content .= '<div class="clear"></div>';
					}
			
			
				$list_count ++; // end counter
			
				endwhile;
			
				wp_reset_postdata();
			
			$content .= '</div></div>';
			
		}
		
		return $content;
		
	}

endif;

add_shortcode( 'post-list', 'hannah_cd_post_list' );


/*****************************************************************/
/* GOOGLE MAPS SHORTCODE - [maps] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_maps' ) ) :

	function hannah_cd_maps($atts, $content = null) {

		extract(shortcode_atts(array(
               "width" => '100%',
               "height" => '350px',
               "link" => '#'
   		), $atts));

		$content = '<div class="google-maps">';
				$content .= '<iframe src="' . $link . '" scrolling="no" style="width:' . $width . ';height:' . $height . '"></iframe>';
		$content .= '</div>';

		return $content;

	}

endif;

add_shortcode('maps', 'hannah_cd_maps');


/*****************************************************************/
/* GALLERY SHORTCODE - [gallery-carousel] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_gallery' ) ) :

	$gallery_count = '1'; // start counter

	function hannah_cd_gallery( $atts, $content = null ) {

		extract(shortcode_atts(array(
		   "column" => '1',
		   "autoplay" => 'false',
		   "items" => '1',
		   "nav" => 'false'
   		), $atts));
		
		global $gallery_count;
		
		if( $items == '1' ) {
			$responsive_0 = '1';
			$responsive_768 = '1';
		} elseif( $items == '2' ) {
			$responsive_0 = '1';
			$responsive_768 = '2';
		} else {
			$responsive_0 = '1';
			$responsive_768 = '3';
		}
		
		$gallery_wrap = '<div class="gallery-carousel gal-count-' . $gallery_count . '">' . do_shortcode($content) . '</div>';
		$gallery_script = '<script>
			(function( $ ) {
				$(function() {
						
					$(".gallery-carousel.gal-count-' . $gallery_count . ' .gallery.owl-carousel").owlCarousel({
						items: ' . $column . ',
						nav : ' . $nav . ',
						navText : false,
						dots : false,
						loop : false,
						slideSpeed : 400,
						autoplay : ' . $autoplay . ',
						autoplayTimeout : 5000,
						autoplayHoverPause : true,
						autoHeight : false,
						responsiveClass : true,
						responsive : {
							0: {
								items: ' . $responsive_0 . ',
							},
							768: {
								items: ' . $responsive_768 . ',
							},
							992: {
								items: ' . $column . ',
							}
						},
					});	
					
				});
			})(jQuery);		
		
		</script>';
		
		$gallery_count ++; // end counter
		
		$output = array( $gallery_wrap, $gallery_script );		
		
		return implode('', $output);
	}

endif;

add_shortcode('gallery-carousel', 'hannah_cd_gallery');


/*****************************************************************/
/* COUNTDOWN SHORTCODE - [countdown] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_countdown' ) ) :

	$countdown_count = '1'; // start counter

	function hannah_cd_countdown( $atts, $content = null ) {

		extract(shortcode_atts(array(
		   "the_date" => '2099/12/24',
		   "size" => '1',
		   "style" => '1',
   		), $atts));
		
		global $countdown_count;
		
		if( $style == '1' ) {
			$date_format = '%D' . ' ' . esc_html__( 'days', 'hannah-cd' ) . ' ' . '%-H' . ' ' . esc_html__( 'h', 'hannah-cd' ) . ' ' . '%M' . ' ' . esc_html__( 'min', 'hannah-cd' ) . ' ' . '%S' . ' ' . esc_html__( 'sec', 'hannah-cd' );
		} elseif( $style == '2' ) {
			$date_format = '%w' . ' ' . esc_html__( 'weeks', 'hannah-cd' ) . ' ' . '%-H' . ' ' . esc_html__( 'h', 'hannah-cd' ) . ' ' . '%M' . ' ' . esc_html__( 'min', 'hannah-cd' ) . ' ' . '%S' . ' ' . esc_html__( 'sec', 'hannah-cd' );
		} elseif( $style == '3' ) {
			$date_format = '%m' . ' ' . esc_html__( 'months', 'hannah-cd' ) . ' ' . '%W' . ' ' . esc_html__( 'weeks', 'hannah-cd' ) . ' ' . '%-H' . ' ' . esc_html__( 'h', 'hannah-cd' ) . ' ' . '%M' . ' ' . esc_html__( 'min', 'hannah-cd' ) . ' ' . '%S' . ' ' . esc_html__( 'sec', 'hannah-cd' );
		} elseif( $style == '4' ) {
			$date_format = '%Y' . ' ' . esc_html__( 'years', 'hannah-cd' ) . ' ' . '%M' . ' ' . esc_html__( 'months', 'hannah-cd' ) . ' ' . '%W' . ' ' . esc_html__( 'weeks', 'hannah-cd' ) . ' ' . '%-H' . ' ' . esc_html__( 'h', 'hannah-cd' ) . ' ' . '%M' . ' ' . esc_html__( 'min', 'hannah-cd' ) . ' ' . '%S' . ' ' . esc_html__( 'sec', 'hannah-cd' );
		} elseif( $style == '5' ) {
			$date_format = '%D' . ' ' . esc_html__( 'days', 'hannah-cd' ) . ' ' . '%H:%M:%S';
		} elseif( $style == '6' ) {
			$date_format = '%w' . ' ' . esc_html__( 'weeks', 'hannah-cd' ) . ' ' . '%H:%M:%S';
		} elseif( $style == '7' ) {
			$date_format = '%m' . ' ' . esc_html__( 'months', 'hannah-cd' ) . ' ' . '%H:%M:%S';
		} elseif( $style == '8' ) {
			$date_format = '%Y' . ' ' . esc_html__( 'years', 'hannah-cd' ) . ' ' . '%H:%M:%S';
		} else {
			$date_format = '%D' . ' ' . esc_html__( 'days', 'hannah-cd' ) . ' ' . '%H:%M:%S';
		}
		
		$countdown_html = '<div class="countdown-inline"><span class="size-' . $size . '" id="clock-' . $countdown_count . '">' . do_shortcode($content) . '</span></div>';
		$countdown_script = '<script>
			( function($) {
			
				$(document).ready(function() {
						
					$("#clock-' . $countdown_count . '").countdown("' . esc_html( $the_date ) . '", function(event) {
    					$(this).text(
      						event.strftime("' . esc_html( $date_format ) . '")
						);	
					});		
					
				});
			
			})(jQuery);
		
		</script>';
		
		$countdown_count ++; // end counter
		
		$output = array( $countdown_html, $countdown_script );		
		
		return implode('', $output);
	}

endif;

add_shortcode('countdown', 'hannah_cd_countdown');


/*****************************************************************/
/* EMAIL ENCODE SHORTCODE - [email-encode] */
/*****************************************************************/

if ( ! function_exists( 'hannah_cd_email_encode' ) ) :

	// create antispam email addresses

	function hannah_cd_email_encode( $atts, $content = null ) {
		
		$email_fields = shortcode_atts( array(
			'user_id' => '',
			'email' => ''
		), $atts);
		
		$userid = $email_fields['user_id'];
		$e_mail = $email_fields['email'];
		
		if( $userid !=='' && $e_mail =='' ) {
			$emailaddress = get_the_author_meta( 'user_email', $userid );
			return '<a href="mailto:' . antispambot( $emailaddress ) . '">' . antispambot( $emailaddress ) . '</a>';
		}
		
		if( $userid =='' && $e_mail !=='' ) {
			return '<a href="mailto:' . antispambot( $e_mail ) . '">' . antispambot( $e_mail ) . '</a>';
		} else {
			return '';
		}
		
	}

endif;

add_shortcode('email-encode', 'hannah_cd_email_encode');

