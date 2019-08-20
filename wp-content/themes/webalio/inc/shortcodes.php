<?php

/**** ALIO SHORTCODES AREA ****/

add_shortcode( 'alio_text_block', 'alio_text_block' );
function alio_text_block( $atts, $atb_content = null ) {
	extract( shortcode_atts( array(
	    'id' => '',
	), $atts ) );
	$out = '';

	if ( $id ) {
        $id = intval( $id );
        $alio_text_block = get_field( 'alio_text_block' );
        $atb_item = $alio_text_block[$id - 1];
        $atb_lnk_id = ( $atb_item['atb_lnk_id'] ) ? ' id="lnk_' . $atb_item['atb_lnk_id'] . '"' : '';

        if ( $atb_item['atb_content'] ) {
            $out .= '<div class="container shortcode-box">
                        <div class="row">
                            <div class="' . $atb_item['atb_class'] . '">';
            if ( $atb_item['atb_title'] ) {
                $out .= '<' . $atb_item['atb_tag'] . $atb_lnk_id . '>' . $atb_item['atb_title'] . '</' . $atb_item['atb_tag'] . '>';
            }
            $out .= $atb_item['atb_content'] . '</div>
                            </div>
                        </div>';
        }
    }

	return $out;
}

add_shortcode('alio_form_block', 'alio_form_block');
function alio_form_block( $atts, $afb_content = null ) {
	extract( shortcode_atts( array(
		'id' => '',
	), $atts ) );

	$out = '';

    if ( $id ) {
        $id = intval($id);
        $afb_field = get_field('alio_form_block');
        $afb = $afb_field[$id - 1];
        $afb_class = ( isset( $afb['afb_class'] ) ) ? $afb['afb_class'] : 'col-md-12';
        $afb_tag = ( isset( $afb['afb_tag'] ) ) ? $afb['afb_tag'] : 'h2';
        $afb_add_class = ( isset( $afb['afb_additional_class'] ) ) ? ' ' . $afb['afb_additional_class'] : '';
        $bt_class = ( isset( $afb['afb_bottom_shape'] ) ) ? ' no-wave' : '';
        $afb_section = ( isset( $afb['afb_section'] ) ) ? $afb['afb_section'] : false;
        $afb_title = ( isset( $afb['afb_title'] ) ) ? $afb['afb_title'] : false;

        if ( $afb_section ) {
            $out .= '<section class="' . $afb_section . ' shortcode-box">
					<div class="bg-top"></div>
						<div class="bg-middle">';
        }
        $afb_lnk_id = ( isset( $afb['afb_lnk_id'] ) ) ? ' id="lnk_' . $afb['afb_lnk_id'] . '"' : '';

        if ( isset( $afb['afb_content'] ) ) {
            $out .= '<div class="container shortcode-box' . $afb_add_class . '">
					<div class="row">
						<div class="' . $afb_class . '">';
            if ( $afb_title ) {
                $out .= '<' . $afb_tag . $afb_lnk_id . '>' . $afb_title . '</' . $afb_tag . '>';
            }
            $out .= do_shortcode( $afb['afb_content'] );
            $out .= '</div>
			</div>
		</div>';
        }
        if ( $afb_section ) {
            $out .= '</div>
			<div class="bg-bottom' . $bt_class . '"></div>
		</section>';
        }
    }

	return $out;
}

add_shortcode('alio_three_columns_area', 'alio_three_columns_area');
function alio_three_columns_area( $atts, $atca_content = null ){
	extract( shortcode_atts( array(
		'id' => '',
	), $atts ) );

    $out = '';

    if ( $id ) {
        $id = intval($id);
        $atca = get_field('alio_three_columns_area');
        $atca_item = $atca[$id - 1];
        $atca_hover_style = ( ! $atca_item['atca_hover_style'] ) ? " no-dynamic-opacity" : "";
        $atca_lnk_id = ( $atca_item['atca_lnk_id'] ) ? ' id="lnk_' . $atca_item['atca_lnk_id'] . '"' : '';
        $atca_section = $atca_item['atca_section'];
        $atca_title = $atca_item['atca_title'];
        $atca_tag = $atca_item['atca_tag'];
        $bt_class = ( $atca_item['atca_bottom_shape'] ) ? ' no-wave' : '';
        $class_box = ( $atca_item['atca_section'] ) ? '' : ' shortcode-box';
        $atca_blocks = $atca_item['alio_three_columns_block'];

        if ( ! empty( $atca_blocks ) && is_array( $atca_blocks ) ) {
            if ( $atca_section ) {
                $out .= '<section class="' . $atca_section . ' shortcode-box">
						<div class="bg-top"></div>
							<div class="bg-middle">';
            }

            $out .= '<div class="container">';
            if ( $atca_title ) {
                $out .= '<' . $atca_tag . $atca_lnk_id . '>' . $atca_title . '</' . $atca_tag . '>';
            }
            $out .= '<div class="three-columns' . $class_box . $atca_hover_style . '">';
            $out .= '<div class="row">';

            foreach ( $atca_blocks as $atcb ) {
                $atcb_img = ( $atcb['atcb_img'] ) ? wp_get_attachment_image( $atcb['atcb_img']['id'], 'medium' ) : '';
                $atcb_content = $atcb['atcb_content'];
                $atcb_tag = $atcb['atcb_tag'];
                $atcb_title = $atcb['atcb_title'];

                if ( $atcb_content && $atcb_img ) {
                    $out .= '<div class="col-sm-4"><div class="item">' . $atcb_img;

                    if ( $atcb_title ) {
                        $out .= '<' . $atcb_tag . '>' . $atcb_title . '</' . $atcb_tag . '>';
                    }

                    $out .= $atcb_content;
                    $out .= '</div></div>';
                }
            }

            $out .= '</div></div></div>';

            if ( $atca_section ) {
                $out .= '</div>
				<div class="bg-bottom' . $bt_class . '"></div>
			</section>';
            }
        }
    }

	return $out;
}

add_shortcode( 'alio_works_area', 'alio_works_area' );
function alio_works_area( $atts, $awa_content = null ) {
	extract( shortcode_atts( array(
		'id' => '',
	), $atts ) );

	$out = '';

    if ( $id ) {
        $id = intval($id);
        $alio_works_area = get_field('alio_works_area');
        $awa = $alio_works_area[$id - 1];
        $awa_lnk_id = ( $awa['awa_lnk_id'] ) ? ' id="lnk_' . $awa['awa_lnk_id'] . '"' : '';
        $bt_class = ( isset( $awa['$awa_bottom_shape'] ) ) ? ' no-wave' : '';
        $class_box = ( $awa['awa_section'] ) ? '' : ' shortcode-box';
        $awa_tag = $awa['awa_tag'];

        if ( $awa['awa_section'] ) {
            $out .= '<section class="' . $awa['awa_section'] . ' shortcode-box">
					<div class="bg-top"></div>
						<div class="bg-middle">';
        }

        $out .= '<div class="isotope-block' . $class_box . '">';

        if ( $awa['awa_title'] ) {
            $out .= '<' . $awa_tag . $awa_lnk_id . '>' . $awa['awa_title'] . '</' . $awa_tag . '>';
        }

        $terms = get_terms( 'workscategory' );
        $count = count( $terms );

        if ( $count > 0 ) {
            $out .= '<ul id="filters">';
            $out .= '<li class="filter selected" data-filter="all"><a href="#" data-filter="*" class="selected">' . __("Все", "webalio") . '</a></li>';
            foreach ( $terms as $term ) {
                $out .= "<li><a href='#' data-filter='.".$term->slug."'>" . $term->name . "</a></li>\n";
            }
            $out .= '</ul>';
        }

        $args = array(
            'post_type' => 'works',
            'posts_per_page' => $awa['awa_count_posts'],
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
                $out .= '<div class="' . $cat_nm . 'item col-xs-12 col-sm-6 col-md-4">
						<div class="holder">
							<div class="image-block">';
                if ( has_post_thumbnail() ) {
                    $out .= get_the_post_thumbnail( null, 'sizeThumb' );
                } else {
                    $out .= '<img src="' . get_template_directory_uri() . '/img/image.png" alt="' . get_the_title() . '">';
                }
                $out .= '<div class="img-hover-overlay"></div>';
                $out .= '<div class="icons-holder">
			<a class="hover-icon" target="" href="' . get_permalink() . '"><i class="fa fa-arrow-right" aria-hidden="true"></i><small>' . __("Подробнее...", "webalio") . '</small></a>
						<a class="lnk-zoom hover-icon" href="' . wp_get_attachment_url( get_post_thumbnail_id() ) . '" title="' . get_the_title() . '" rel="prettyPhoto[gallery]"><i class="fa fa-search-plus" aria-hidden="true"></i><small>' . __("Увеличить", "webalio") . '</small></a>
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
        if ( $awa['awa_section'] ) {
            $out .= '</div>
			<div class="bg-bottom' . $bt_class . '"></div>
		</section>';
        }
    }

	return $out;
}

add_shortcode('alio_divider', 'alio_divider');
function alio_divider( $atts, $ad_content = null ) {
	extract( shortcode_atts( array(
		'id' => '',
	), $atts ) );
    $out = '';

    if ( $id ) {
        $id = intval($id);
        $alio_divider = get_field('alio_divider');
        $atb_item = $alio_divider[$id - 1];
        $ad_style = ( $atb_item['ad_style'] ) ? $atb_item['ad_style'] : 'empty';
        $marg_top = ( $atb_item['ad_top'] ) ? 'margin-top: ' . $atb_item['ad_top'] . 'px;' : '';
        $marg_bottom = ( $atb_item['ad_bottom'] ) ? 'margin-bottom: ' . $atb_item['ad_bottom'] . 'px;' : '';
        $css_style = '';

        if ( $marg_top || $marg_bottom ) {
            $css_style = ' style="' . $marg_top . ' ' . $marg_bottom . '"';
        }

        $out = '<div class="divider ' . $ad_style . '"' . $css_style . '></div>';
    }

	return $out;
}

