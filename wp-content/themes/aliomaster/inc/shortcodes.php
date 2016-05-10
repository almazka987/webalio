<?php

/**** ALIO SHORTCODES AREA ****/

add_shortcode('alio_text_block', 'alio_text_block');
function alio_text_block( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'class' => 'col-md-12',
		'lnk_id' => '',
		'title' => '',
		'tag' => 'h2',
	), $atts ) );
	$out = '';

	$lnk_id = ( $lnk_id ) ? ' id="lnk_' . $lnk_id . '"' : '';

	if ( $content ) {
		$out .= '<div class="container shortcode-box">
					<div class="row">
						<div class="' . $class . '">';
		if ( $title ) {
			$out .= '<' . $tag . $lnk_id . '>' . $title . '</' . $tag . '>';
		}
		$out .= $content . '</div>
						</div>
					</div>';
	}
	return $out;
}

add_shortcode('alio_form_block', 'alio_form_block');
function alio_form_block( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'bottom_shape' => '',
		'class' => 'col-md-12',
		'additional_class' => '',
		'lnk_id' => '',
		'title' => '',
		'section' => '',
		'tag' => 'h2',
	), $atts ) );
	$out = '';
	$add_class = ( $additional_class ) ? ' ' . $additional_class : '';
	$bt_class = ( $bottom_shape ) ? ' no-wave' : '';
	if ( $section ) {
		$out .= '<section class="' . $section . ' shortcode-box">
					<div class="bg-top"></div>
						<div class="bg-middle">';
	}
	$lnk_id = ( $lnk_id ) ? ' id="lnk_' . $lnk_id . '"' : '';

	if ( $content ) {
		$out .= '<div class="container shortcode-box' . $add_class . '">
					<div class="row">
						<div class="' . $class . '">';
		if ( $title ) {
			$out .= '<' . $tag . $lnk_id . '>' . $title . '</' . $tag . '>';
		}
		$out .= do_shortcode( $content );
		$out .= '</div>
			</div>
		</div>';
	}
	if ( $section ) {
		$out .= '</div>
			<div class="bg-bottom' . $bt_class . '"></div>
		</section>';
	}
	return $out;
}

add_shortcode('alio_three_columns_block', 'alio_three_columns_block');
function alio_three_columns_block( $atts, $content = null ){
	extract( shortcode_atts( array(
		'title' => '',
		'img' => '',
		'tag' => 'h3',
	), $atts ) );
	$out = '';

	if ( $content && $img ) {
		$out .= '<div class="col-md-4 item">
					<img src="' . $img . '" alt="">';
		if ( $title ) {
			$out .= '<' . $tag . '>' . $title . '</' . $tag . '>';
		}
		$out .= $content;
		$out .= '</div>';
	}

	return $out;
}

add_shortcode('alio_three_columns_area', 'alio_three_columns_area');
function alio_three_columns_area( $atts, $content = null ){
	extract( shortcode_atts( array(
		'bottom_shape' => '',
		'section' => '',
		'lnk_id' => '',
		'title' => '',
		'tag' => 'h2',
	), $atts ) );
	$lnk_id = ( $lnk_id ) ? ' id="lnk_' . $lnk_id . '"' : '';
	$bt_class = ( $bottom_shape ) ? ' no-wave' : '';
	$class_box = ( $section ) ? '' : ' shortcode-box';
	$out = '';

	if ( $content ) {
		if ( $section ) {
			$out .= '<section class="' . $section . ' shortcode-box">
						<div class="bg-top"></div>
							<div class="bg-middle">';
		}
		$out .= '<div class="container three-columns' . $class_box . '">';
		if ( $title ) {
			$out .= '<' . $tag . $lnk_id . '>' . $title . '</' . $tag . '>';
		}
		$out .= '<div class="row">';
		$arr = explode( '|', $content );
		if ( is_array( $arr ) ) {
			foreach ( $arr as $value ) {
				$out .= do_shortcode( $value );
			}
		}
		$out .= '</div></div>';
		if ( $section ) {
			$out .= '</div>
				<div class="bg-bottom' . $bt_class . '"></div>
			</section>';
		}
	}

	return $out;
}

add_shortcode('alio_works_area', 'alio_works_area');
function alio_works_area( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'bottom_shape' => '',
		'section' => '',
		'title' => '',
		'lnk_id' => '',
		'tag' => 'h2',
		'count_posts' => 6,
	), $atts ) );
	$lnk_id = ( $lnk_id ) ? ' id="lnk_' . $lnk_id . '"' : '';
	$bt_class = ( $bottom_shape ) ? ' no-wave' : '';
	$class_box = ( $section ) ? '' : ' shortcode-box';
	$out = '';

	if ( $section ) {
		$out .= '<section class="' . $section . ' shortcode-box">
					<div class="bg-top"></div>
						<div class="bg-middle">';
	}
	$out .= '<div class="isotope-block' . $class_box . '">';
	if ( $title ) {
		$out .= '<' . $tag . $lnk_id . '>' . $title . '</' . $tag . '>';
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
		'posts_per_page' => $count_posts,
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
						<a class="hover-icon" target="" href="' . get_permalink() . '"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
						<a class="lnk-zoom hover-icon" href="' . wp_get_attachment_url( get_post_thumbnail_id() ) . '" title="' . get_the_title() . '" rel="prettyPhoto[gallery]"><i class="fa fa-search-plus" aria-hidden="true"></i></a>
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
	if ( $section ) {
		$out .= '</div>
			<div class="bg-bottom' . $bt_class . '"></div>
		</section>';
	}

	return $out;
}

add_shortcode('alio_divider', 'alio_divider');
function alio_divider( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'style' => 'empty',
		'top' => '',
		'bottom' => '',
	), $atts ) );
	$style = ( $style ) ? $style : 'empty';
	$marg_top = ( $top ) ? 'margin-top: ' . $top . 'px;' : '';
	$marg_bottom = ( $bottom ) ? 'margin-bottom: ' . $bottom . 'px;' : '';
	$css_style ='';
	if ( $marg_top || $marg_bottom ) {
		$css_style = ' style="' . $marg_top . ' ' . $marg_bottom . '"';
	}
	$out = '<div class="divider ' . $style . '"' . $css_style . '></div>';
	return $out;
}

