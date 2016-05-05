<?php

/**** ALIO SHORTCODES AREA ****/

add_shortcode('alio_text_block', 'alio_text_block');
function alio_text_block( $atts, $content = null ){
	extract( shortcode_atts( array(
		'class' => 'col-md-12',
		'lnk_id' => '',
		'title' => '',
		'tag' => 'h2',
	), $atts ) );
	$out = '';

	$lnk_id = ( $lnk_id ) ? ' id="#lnk_' . $lnk_id . '"' : '';

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
		'section' => '',
		'lnk_id' => '',
		'title' => '',
		'tag' => 'h2',
	), $atts ) );
	$lnk_id = ( $lnk_id ) ? ' id="#lnk_' . $lnk_id . '"' : '';
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
				<div class="bg-bottom"></div>
			</section>';
		}
	}

	return $out;
}

add_shortcode('alio_works_grid', 'alio_works_grid');
function alio_works_grid( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'heading' => '',
		'count_posts' => 6,
	), $atts ) );
	$output = '';

	$output .= '<div class="categories_section">';
	$output .= '<div class="isotope_block">';
	if ( $heading ) {
		$output .= '<h2>' . $heading . '</h2>';
	}
	$output .= '<ul id="filters">';
	$output .= '<li><a href="#" data-filter="*" class="selected">All</a></li>';

	$terms = get_terms("category");
	$count = count($terms);
	if ( $count > 0 ) {
		foreach ( $terms as $term ) {
			$output .= "<li><a href='#' data-filter='.".$term->slug."'>" . $term->name . "</a></li>\n";
		}
	}
	$output .= '</ul>';

	$the_query = new WP_Query( 'posts_per_page = ' . $count_posts );

	if ( $the_query->have_posts() ) {
		$output .= '<div class="isotope container">';
		$output .= '<div id="isotope-list" class="row">';
		while ( $the_query->have_posts() ) {
			$the_query->the_post(); 
			$termsArray = get_the_terms( $post->ID, "category" );
			$termsString = "";
			foreach ( $termsArray as $term ) {
				$termsString .= $term->slug.' ';
			}
			$output .= '<div class="' . $termsString . ' item col-sm-6 col-md-4"><div class="grid_content"><figure>';
			if ( has_post_thumbnail() ) {
				$output .= get_the_post_thumbnail( $id, 'sizeThumb' );
			} else {
				$output .= '<img src="' . get_template_directory_uri() . '/img/default-thumbnail-middle.jpg" alt="">';
			}
			$output .= '<figcaption><a href="' . get_permalink() . '" class="text_box">';
			$output .= '<h3>' . get_the_title() . '</h3>';
			$output .= '<p class="descr">' . the_excerpt_max_charlength(100) . '</p>';
			$output .= '<i class="fa fa-chevron-down"></i></a></figcaption></figure></div></div> <!-- end item -->';
		}
		$output .= '</div> <!-- end isotope-list -->';
		$output .= '</div></div></div>';
	}

	return $output;
}

add_shortcode('alio_works_area', 'alio_works_area');
function alio_works_area( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'section' => '',
		'title' => '',
		'lnk_id' => '',
		'tag' => 'h2',
		'count_posts' => 6,
	), $atts ) );
	$lnk_id = ( $lnk_id ) ? ' id="#lnk_' . $lnk_id . '"' : '';
	$class_box = ( $section ) ? '' : ' shortcode-box';
	$out = '';

	if ( $section ) {
		$out .= '<section class="' . $section . ' shortcode-box">
					<div class="bg-top"></div>
						<div class="bg-middle">';
	}
	$out .= '<div class="container' . $class_box . '">';
	if ( $title ) {
		$out .= '<' . $tag . $lnk_id . '>' . $title . '</' . $tag . '>';
	}
	$out .= '<div class="row">';
	$out .= '<div class="col-md-12 works">';
	$terms = get_terms( 'workscategory' );
	$count = count( $terms );
	if ( $count > 0 ) {
		$out .= '<ul id="filter">';
		$out .= '<li class="filter active" data-filter="all"><span>Все</span></li>';
		foreach ( $terms as $term ) {
			$out .= '<li class="filter data-filter=".' . $term->slug . '">' . $term->name . '</li>';
		}
		$out .= '</ul>';
	}

	$args = array(
		'post_type' => 'works',
		'posts_per_page' => $count_posts,
	);
	$query = new WP_Query( $args );

	$out .= '<ul id="mixContainer">';
	if( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$categ = get_the_terms( get_the_ID(), 'workscategory' );
			$cat_nm = '';
			if ( is_array( $categ ) ) {
				foreach ( $categ as $key => $obj ) {
					$cat_nm .= ' ' . $obj->slug;
				}
			}
			$out .= '<li class="mix' . $cat_nm . '">';
			if ( has_post_thumbnail() ) {
				$out .= get_the_post_thumbnail( $id, 'sizeThumb' );
			} else {
				$out .= '<img src="' . get_template_directory_uri() . '/img/image.png" alt="' . get_the_title() . '">';
			}
			$out .= '<span class="layer"><h4>' . get_the_title() . '</h4>
					<a href="' . get_permalink() . '" class="stage-lnk link" target="_blank"><b></b><span>Подробнее</span></a>
					<a href="" class="stage-lnk zoom" rel="prettyPhoto[gallery]"><b></b><span>Увеличить скриншот</span></a>
				</span>
			</li>';
		}
	}
	wp_reset_query();
	$out .= '</ul>';

	$out .= '</div>';
	$out .= '</div></div>';
	if ( $section ) {
		$out .= '</div>
			<div class="bg-bottom"></div>
		</section>';
	}

	return $out;
}

	/*<div class="container three-columns">
		<div class="row">
			<div class="col-md-4 item">
				<img src="<?php bloginfo('template_url') ?>/img/antenna.png" height="159" width="159" alt="//">
				<h3>Знаю и умею:</h3>
				<ul>
					<li>HTML, HTML5, CSS</li>
					<li>SASS, Compass, GIT</li>
					<li>JS, jQuery</li>
					<li>WordPress, Bootstrap</li>
					<li>PHP, MySQL</li>
					<li>Adobe Photoshop</li>
				</ul>
			</div>
			<div class="col-md-4 item">
				<img src="<?php bloginfo('template_url') ?>/img/rocket.png" height="159" width="159" alt="//">
				<h3>В итоге:</h3>
				<ul>
					<li>Качественный валидный HTML5/CSS код, оптимизированный для поисковых машин</li>
					<li>Оптимизированная графика, изображения оптимального веса и качества для web</li>
					<li>js-скрипты на основе библиотеки jQuery</li>
				</ul>
			</div>
			<div class="col-md-4 item">
				<img src="<?php bloginfo('template_url') ?>/img/astronavt-mini.png" height="159" width="159" alt="//">
				<h3>Мой подход</h3>
				<p>В подходе к делам я перфекционистка, поэтому особое внимание уделяю структурированности кода, комментариям, грамотным именам классов.<br>
				Также в работе мне помогает такое качество, как усидчивость.
				</p>
			</div>
		</div>

	</div>*/


/*add_shortcode('wpm_appealing_block', 'wpm_appealing_block');
function wpm_appealing_block( $atts, $content = null ){
	extract( shortcode_atts( array(
		'image' => '',
		'heading_text' => '',
		'heading2' => '',
		'url_link' => '',
		'text_link' => '',
	), $atts ) );

	$image_id = wpm_get_image_id( $image );
	$image_thumb = wp_get_attachment_image_src( $image_id, 'sizeApBox' );
	$out = '<div class="wpm_appealing_block"><div class="container">';
			if ( $image ) {

				$out .= '<div class="img_sector">
							<img src="' . $image_thumb[0] . '" alt="">
						</div>';
			}
			$out .= '<div class="content_sector">';
			if ( $heading_text ) {
				$out .= '<h2>' . $heading_text . '</h2>';
			}
			if ( $heading2 ) {
				$out .= '<h3>Turning back the clock just became easier than ever before.</h3>';
			}
			if ( $url_link && $text_link ) {
				$out .= '<a href="' . $url_link . '">' . $text_link . '</a>';
			}
			$out .= '</div></div></div>';

	return $out;
}

add_shortcode('wpm_physicians_block', 'wpm_physicians_block');
function wpm_physicians_block( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'heading' => '',
	), $atts ) );
	$out = '';
	$args = array(
		'posts_per_page' => -1,
		'post_type' => 'physicians',
	);
	$query = new WP_Query( $args );
	if ( $heading ) {
		$out .= '<h2 class="heading">' . $heading . '</h2>';
	}

	if( $query->have_posts() ) {
		$out .= '<div class="container">';
		$out .= '<div class="photos_sector row">';
		$i=0;
			while ( $query->have_posts() ) { $query->the_post();
				$i = ( $i < 2 ) ? $i + 1 : 0;
				$out .= '<div class="col-sm-6 col-md-4 photos_item">';
				$out .= '<a href="' . get_the_permalink() . '">';
					if ( has_post_thumbnail() ) {
						$out .= get_the_post_thumbnail( $id, 'sizePortfolio' );
					} else {
						$out .= '<img src="' . get_template_directory_uri() . '/img/default-thumbnail.jpg" alt="">';
					}
				$out .= '</a>';
				$out .= '<p class="name">' . get_the_title() . '</p>';
				$out .= '<a href="' . get_the_permalink() . '" class="learn_more_lnk">Learn More</a>';
				$out .= '</div>';
				if ( $i == 0 ) {
					$out .= '<div class="clearfix visible-md-block visible-lg-block"></div>';
				}
			}
		$out .= '</div></div>';
	}
	wp_reset_query();

	return $out;
}

add_shortcode('wpm_menu_line', 'wpm_menu_line');
function wpm_menu_line( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'menu_slug' => 'menu-line',
	), $atts ) );

	$out = '';
	$args = array(
		'menu'              => $menu_slug,
		'echo'              => 0,
		'theme_location'    => '',
		'container'         => 'div',
		'container_class'   => 'wpm_menu_line',
		'container_id'      => '',
		'menu_class'        => 'nav navbar-nav',
		'walker'            => '',
	);
	$out = wp_nav_menu( $args );

	return $out;
}

add_shortcode('wpm_category_grid', 'wpm_category_grid');
function wpm_category_grid( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'heading' => '',
		'count_posts' => 6,
	), $atts ) );
	$output = '';

	$output .= '<div class="categories_section">';
	$output .= '<div class="isotope_block">';
	if ( $heading ) {
		$output .= '<h2>' . $heading . '</h2>';
	}
	$output .= '<ul id="filters">';
	$output .= '<li><a href="#" data-filter="*" class="selected">All</a></li>';

	$terms = get_terms("category");
	$count = count($terms);
	if ( $count > 0 ) {
		foreach ( $terms as $term ) {
			$output .= "<li><a href='#' data-filter='.".$term->slug."'>" . $term->name . "</a></li>\n";
		}
	}
	$output .= '</ul>';

	$the_query = new WP_Query( 'posts_per_page = ' . $count_posts );

	if ( $the_query->have_posts() ) {
		$output .= '<div class="isotope container">';
		$output .= '<div id="isotope-list" class="row">';
		while ( $the_query->have_posts() ) {
			$the_query->the_post(); 
			$termsArray = get_the_terms( $post->ID, "category" );
			$termsString = "";
			foreach ( $termsArray as $term ) {
				$termsString .= $term->slug.' ';
			}
			$output .= '<div class="' . $termsString . ' item col-sm-6 col-md-4"><div class="grid_content"><figure>';
			if ( has_post_thumbnail() ) {
				$output .= get_the_post_thumbnail( $id, 'sizeThumb' );
			} else {
				$output .= '<img src="' . get_template_directory_uri() . '/img/default-thumbnail-middle.jpg" alt="">';
			}
			$output .= '<figcaption><a href="' . get_permalink() . '" class="text_box">';
			$output .= '<h3>' . get_the_title() . '</h3>';
			$output .= '<p class="descr">' . the_excerpt_max_charlength(100) . '</p>';
			$output .= '<i class="fa fa-chevron-down"></i></a></figcaption></figure></div></div> <!-- end item -->';
		}
		$output .= '</div> <!-- end isotope-list -->';
		$output .= '</div></div></div>';
	}

	return $output;
}

add_shortcode('wpm_links_line', 'wpm_links_line');
function wpm_links_line( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' => '',
		'left_text' => '',
		'left_link' => '',
		'right_text' => '',
		'right_link' => '',
	), $atts ) );
	$out = '';
	$class = ( $type ) ? ' ' . $type : '';
	if ( $left_text && $left_link && $right_text && $right_link ) {
		$out .= '<div class="links_line_sector">
					<ul class="links_container container' . $class . '">
						<li class="link_box"><a href="' . $left_link . '"><span>' . $left_text . '</span></a></li>
						<li class="link_box"><a href="' . $right_link . '"><span>' . $right_text . '</span></a></li>
					</ul>
				</div>';
	}
	return $out;
}

add_shortcode('wpm_content_block', 'wpm_content_block');
function wpm_content_block( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'heading' => '',
		'image_url' => '',
		'image_position' => 'left',
	), $atts ) );
	$image_id = wpm_get_image_id( $image_url );
	$image_thumb = wp_get_attachment_image_src( $image_id, 'sizePortfolio' );

	$out = '';
	$out .= '<div class="container box_container">';
	$out .= '<div class="row">';
	$out .= '<div class="cont">';
	if ( $image_position == 'right' ) {
		if ( $heading || $content ) {
			$out .= '<div class="content_container col-sm-6 col-md-8">';
				if ( $heading ) {
					$out .= '<h2>' . $heading . '</h2>';
				}
				if ( $content ) {
					$out .= '<p>' . $content . '</p>';
				}
			$out .= '</div>';
		}
		if ( $image_url ) {
			$out .= '<div class="img_container col-md-4"><img src="' . $image_thumb[0] . '" alt=""></div>';
		}
	}
	if ( $image_position == 'left' ) {
		if ( $image_url ) {
			$out .= '<div class="img_container col-md-4"><img src="' . $image_thumb[0] . '" alt=""></div>';
		}
		if ( $heading || $content ) {
			$out .= '<div class="content_container col-md-8">';
				if ( $heading ) {
					$out .= '<h2>' . $heading . '</h2>';
				}
				if ( $content ) {
					$out .= '<p>' . $content . '</p>';
				}
			$out .= '</div>';
		}
	}

	$out .= '</div></div></div>';
	return $out;
}

add_shortcode('wpm_text_block', 'wpm_text_block');
function wpm_text_block( $atts, $content = null ) {
	$out = ( $content ) ? '<div class="container wpm_text_block">' . $content . '</div>' : '';

	return $out;
}

add_shortcode('wpm_hot_buttons_block', 'wpm_hot_buttons_block');
function wpm_hot_buttons_block( $atts, $content = null ) {
	$out = '';
	if ( $content ) {
		$out .= '<div class="hot_buttons container">';
		$arr = explode( ',', $content );
		if ( is_array( $arr ) ) {
			foreach ( $arr as $value ) {
				$out .= do_shortcode( $value );
			}
		}
		$out .= '</div>';
	}
	return $out;
}

add_shortcode('wpm_hot_button', 'wpm_hot_button');
function wpm_hot_button( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'heading' => '',
		'heading2' => '',
		'image_url' => '',
		'link' => '',
	), $atts ) );
	$out = '';

	if ( $image_url && $heading && $heading2 && $link ) {
		$image_id = wpm_get_image_id( $image_url );
		$image_thumb = wp_get_attachment_image_src( $image_id, 'sizeHotBox' );
		$out .= '<a href="' . $link . '" class="button_item">
					<div class="img_top"><img src="' . $image_thumb[0] . '" alt=""></div>
					<div class="text"><div class="inter_text" href=""><span class="head1">' . $heading . '</span><span class="head2">' . $heading2 . '</span></div></div>';
		$out .= '</a>';
	}
	

	return $out;
}

add_shortcode('wpm_before_after', 'wpm_before_after');
function wpm_before_after( $atts, $content = null ) {
	$out = '';
	if ( $content ) {
		$out .= '<div class="container bef_aft">';
		$out .= '<div class="before_afters row">';
		$arr = explode( '|', $content );
		if ( is_array( $arr ) ) {
			foreach ( $arr as $value ) {
				$out .= do_shortcode( $value );
			}
		}
		$out .= '</div></div>';
	}
	return $out;
}

add_shortcode('wpm_before_after_box', 'wpm_before_after_box');
function wpm_before_after_box( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'title' => '',
		'before_img' => '',
		'after_img' => '',
	), $atts ) );
	$out = '';

	if ( $title && $before_img && $after_img ) {
		$before_image_id = wpm_get_image_id( $before_img );
		$after_image_id = wpm_get_image_id( $after_img );
		$image_thumb_before = wp_get_attachment_image_src( $before_image_id, 'sizeBeforeAfter' );
		$image_thumb_after = wp_get_attachment_image_src( $after_image_id, 'sizeBeforeAfter' );

		$out .= '<div class="bef_after_item col-sm-6 col-md-6">';
		$out .= '<div class="title_block">
					<h2>' . $title . '</h2><span class="title_line"></span>
				</div><div class="images_block">
					<div class="left_img"><img src="' . $image_thumb_before[0] . '" alt=""></div>
					<div class="right_img"><img src="' . $image_thumb_after[0] . '" alt=""></div>
				</div>';
		if ( $content ) {
			$out .= '<div class="text_block">
						<p>' . $content . '</p>
					</div>';
		}
		$out .= '</div>';
	}

	return $out;
}*/