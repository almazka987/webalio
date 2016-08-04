<?php

/**** ALIO SHORTCODES AREA ****/

add_shortcode( 'alio_text_block', 'alio_text_block' );
function alio_text_block( $atts, $atb_content = null ) {
	extract( shortcode_atts( array(
		'atb_class' => 'col-md-12',
		'atb_lnk_id' => '',
		'atb_title' => '',
		'atb_tag' => 'h2',
	), $atts ) );
	$out = '';

	$atb_lnk_id = ( $atb_lnk_id ) ? ' id="lnk_' . $atb_lnk_id . '"' : '';

	if ( $atb_content ) {
		$out .= '<div class="container shortcode-box">
					<div class="row">
						<div class="' . $atb_class . '">';
		if ( $atb_title ) {
			$out .= '<' . $atb_tag . $atb_lnk_id . '>' . $atb_title . '</' . $atb_tag . '>';
		}
		$out .= $atb_content . '</div>
						</div>
					</div>';
	}
	return $out;
}

add_shortcode('alio_form_block', 'alio_form_block');
function alio_form_block( $atts, $afb_content = null ) {
	extract( shortcode_atts( array(
		'afb_class' => 'col-md-12',
		'afb_lnk_id' => '',
		'afb_title' => '',
		'afb_tag' => 'h2',
		'afb_section' => '',
		'afb_bottom_shape' => '',
		'afb_additional_class' => '',
	), $atts ) );
	$out = '';
	$add_class = ( $afb_additional_class ) ? ' ' . $afb_additional_class : '';
	$bt_class = ( $afb_bottom_shape ) ? ' no-wave' : '';
	if ( $afb_section ) {
		$out .= '<section class="' . $afb_section . ' shortcode-box">
					<div class="bg-top"></div>
						<div class="bg-middle">';
	}
	$afb_lnk_id = ( $afb_lnk_id ) ? ' id="lnk_' . $afb_lnk_id . '"' : '';

	if ( $afb_content ) {
		$out .= '<div class="container shortcode-box' . $afb_add_class . '">
					<div class="row">
						<div class="' . $afb_class . '">';
		if ( $afb_title ) {
			$out .= '<' . $afb_tag . $afb_lnk_id . '>' . $afb_title . '</' . $afb_tag . '>';
		}
		$out .= do_shortcode( $afb_content );
		$out .= '</div>
			</div>
		</div>';
	}
	if ( $afb_section ) {
		$out .= '</div>
			<div class="bg-bottom' . $bt_class . '"></div>
		</section>';
	}
	return $out;
}

add_shortcode('alio_three_columns_block', 'alio_three_columns_block');
function alio_three_columns_block( $atts, $atcb_content = null ){
	extract( shortcode_atts( array(
		'atcb_title' => '',
		'atcb_tag' => 'h3',
		'atcb_img' => '',
	), $atts ) );
	$out = '';

	$atcb_img = ( $atcb_img ) ? wp_get_attachment_url( $atcb_img ) : '';

	if ( $atcb_content && $atcb_img ) {
		$out .= '<div class="col-md-4 item">
					<img src="' . $atcb_img . '" alt="">';
		if ( $atcb_title ) {
			$out .= '<' . $atcb_tag . '>' . $atcb_title . '</' . $atcb_tag . '>';
		}
		$out .= $atcb_content;
		$out .= '</div>';
	}

	return $out;
}

add_shortcode('alio_three_columns_area', 'alio_three_columns_area');
function alio_three_columns_area( $atts, $atca_content = null ){
	extract( shortcode_atts( array(
		'atca_lnk_id' => '',
		'atca_title' => '',
		'atca_tag' => 'h2',
		'atca_section' => '',
		'atca_bottom_shape' => '',
	), $atts ) );
	$atca_lnk_id = ( $atca_lnk_id ) ? ' id="lnk_' . $atca_lnk_id . '"' : '';
	$bt_class = ( $atca_bottom_shape ) ? ' no-wave' : '';
	$class_box = ( $atca_section ) ? '' : ' shortcode-box';
	$out = '';

	if ( $atca_content ) {
		if ( $atca_section ) {
			$out .= '<section class="' . $atca_section . ' shortcode-box">
						<div class="bg-top"></div>
							<div class="bg-middle">';
		}
		$out .= '<div class="container three-columns' . $class_box . '">';
		if ( $atca_title ) {
			$out .= '<' . $atca_tag . $atca_lnk_id . '>' . $atca_title . '</' . $atca_tag . '>';
		}
		$out .= '<div class="row">';
		$arr = explode( '|', $atca_content );
		if ( is_array( $arr ) ) {
			foreach ( $arr as $value ) {
				$out .= do_shortcode( $value );
			}
		}
		$out .= '</div></div>';
		if ( $atca_section ) {
			$out .= '</div>
				<div class="bg-bottom' . $bt_class . '"></div>
			</section>';
		}
	}

	return $out;
}

add_shortcode( 'alio_works_area', 'alio_works_area' );
function alio_works_area( $atts, $awa_content = null ) {
	extract( shortcode_atts( array(
		'awa_lnk_id' => '',
		'awa_title' => '',
		'awa_tag' => 'h2',
		'awa_section' => '',
		'awa_bottom_shape' => '',
		'awa_count_posts' => -1,
	), $atts ) );
	$awa_lnk_id = ( $awa_lnk_id ) ? ' id="lnk_' . $awa_lnk_id . '"' : '';
	$bt_class = ( $awa_bottom_shape ) ? ' no-wave' : '';
	$class_box = ( $awa_section ) ? '' : ' shortcode-box';
	$out = '';

	if ( $awa_section ) {
		$out .= '<section class="' . $awa_section . ' shortcode-box">
					<div class="bg-top"></div>
						<div class="bg-middle">';
	}
	$out .= '<div class="isotope-block' . $class_box . '">';
	if ( $awa_title ) {
		$out .= '<' . $awa_tag . $awa_lnk_id . '>' . $awa_title . '</' . $awa_tag . '>';
	}

	$terms = get_terms( 'workscategory' );
	$count = count( $terms );
	if ( $count > 0 ) {
		$out .= '<ul id="filters">';
		$out .= '<li class="filter selected" data-filter="all"><a href="#" data-filter="*" class="selected">Все</a></li>';
		foreach ( $terms as $term ) {
			$out .= "<li><a href='#' data-filter='.".$term->slug."'>" . $term->name . "</a></li>\n";
		}
		$out .= '</ul>';
	}

	$args = array(
		'post_type' => 'works',
		'posts_per_page' => $awa_count_posts,
	);
	$query = new WP_Query( $args );

	if( $query->have_posts() ) {
		$out .= '<div class="isotope container">
					<div id="isotope-list" class="row">';
		while ( $query->have_posts() ) {
			$query->the_post();
			$categ = get_the_terms( get_the_ID(), 'workscategory' );
			$cat_nm = '';
			if ( is_array( $categ ) ) {
				foreach ( $categ as $key => $obj ) {
					$cat_nm .= $obj->slug . ' ';
				}
			}
			$out .= '<div class="' . $cat_nm . 'item col-sm-6 col-md-4">
						<div class="holder">
							<div class="image-block">';
			if ( has_post_thumbnail() ) {
				$out .= get_the_post_thumbnail( $id, 'sizeThumb' );
			} else {
				$out .= '<img src="' . get_template_directory_uri() . '/img/image.png" alt="' . get_the_title() . '">';
			}
			$out .= '<div class="img-hover-overlay"></div>';
			$out .= '<div class="icons-holder">
			<a class="hover-icon" target="" href="' . get_permalink() . '"><i class="fa fa-arrow-right" aria-hidden="true"></i><small>Подробнее...</small></a>
						<a class="lnk-zoom hover-icon" href="' . wp_get_attachment_url( get_post_thumbnail_id() ) . '" title="' . get_the_title() . '" rel="prettyPhoto[gallery]"><i class="fa fa-search-plus" aria-hidden="true"></i><small>Увеличить</small></a>
					</div>';
			$out .= '<div class="meta-info">
						<div class="add-middle-align">
							<h3 class="the-title">' . get_the_title() . '</h3>
						</div>
					</div>';
			$out .= '</div>
				</div>
			</div><!-- end of item -->';
		}
		$out .= '</div></div><!-- end of container -->';
	}
	wp_reset_query();

	$out .= '</div><!-- end of isotope-block -->';
	if ( $awa_section ) {
		$out .= '</div>
			<div class="bg-bottom' . $bt_class . '"></div>
		</section>';
	}

	return $out;
}

add_shortcode('alio_divider', 'alio_divider');
function alio_divider( $atts, $ad_content = null ) {
	extract( shortcode_atts( array(
		'ad_style' => 'empty',
		'ad_top' => '',
		'ad_bottom' => '',
	), $atts ) );
	$ad_style = ( $ad_style ) ? $ad_style : 'empty';
	$marg_top = ( $ad_top ) ? 'margin-top: ' . $ad_top . 'px;' : '';
	$marg_bottom = ( $ad_bottom ) ? 'margin-bottom: ' . $ad_bottom . 'px;' : '';
	$css_style ='';
	if ( $marg_top || $marg_bottom ) {
		$css_style = ' style="' . $marg_top . ' ' . $marg_bottom . '"';
	}
	$out = '<div class="divider ' . $ad_style . '"' . $css_style . '></div>';
	return $out;
}

