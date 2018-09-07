<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_categories_widget" );' ) );

class hannah_Cd_Categories_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_categories_widget',
			'&#10026; ' . esc_html__( 'Categories', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show your post categories.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $categories, $instance ) {

		extract( $categories );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$cat_exclude = $instance['cat_exclude'];
		$hide_empty_cat = $instance[ 'hide_empty_cat' ] ? 'true' : 'false';
		$hide_image = $instance[ 'hide_image' ] ? 'true' : 'false';
		$hide_post_count = $instance[ 'hide_post_count' ] ? 'true' : 'false';
		if( isset( $hide_child_cat ) ) $hide_child_cat = $instance[ 'hide_child_cat' ] ? 'true' : 'false';
		
		/* hide empty categories */
		
		if( 'true' == $instance[ 'hide_empty_cat' ] ) { 
			$hide_empty = 1; 
		} else { 
			$hide_empty = 0; 
		}
		
		/* hide child categories */
		
		if( isset( $instance[ 'hide_child_cat' ] ) && ! 'true' == $instance[ 'hide_child_cat' ] ) { 
			$hide_childs = ''; 
		} else { 
			$hide_childs = 0; 
		}

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */

		$categories = get_categories( array(
			'orderby' 		=> 'name',
			'order'   		=> 'ASC',
			'hide_empty'  	=> $hide_empty,
			'exclude'       => $cat_exclude,
			'hierarchical' 	=> true,
			'parent' 		=> $hide_childs,
		));
		
		echo '<div class="category-widget"><ul>';
			
			foreach ( $categories as $category ) {

			// get term fields
			$taxonomy_image = ACF_GF('taxonomy_image', "category_{$category->cat_ID}");
			$bg_image = wp_get_attachment_image_src( $taxonomy_image, 'hannah_cd_thumb_min', false, '' );
			
			// get image data
			$image = ACF_GF('taxonomy_image', "category_{$category->cat_ID}");
			if (!is_array($image)) { $image = acf_get_attachment($image); }

		?>
				
				<?php if( 'true' == $instance[ 'hide_image' ] && 'true' == $instance[ 'hide_post_count' ] ) { ?>
					<?php // image = hide & postcount = hide ?>
					<li class="no-cimg no-ccount">
				<?php } elseif( 'true' == $instance[ 'hide_image' ] && ! 'true' == $instance[ 'hide_post_count' ] ) { ?>
					<?php // image = hide & postcount = show ?>
					<li class="no-cimg">
				<?php } elseif( ! 'true' == $instance[ 'hide_image' ] && 'true' == $instance[ 'hide_post_count' ] ) { ?>
					<?php // image = show & postcount = hide ?>
					<li class="no-ccount">
				<?php } else { ?>
					<?php // image = show & postcount = show ?>
					<li>
				<?php } ?>
					<?php if( ! 'true' == $instance[ 'hide_image' ] && $bg_image ) { ?>
						<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
							<img src="<?php echo esc_url( $bg_image[0] ) ?>" alt="<?php echo esc_attr( $image['alt'] ) ?>" />
						</a>
					<?php } elseif( ! 'true' == $instance[ 'hide_image' ] && ! $bg_image ) { ?>
						<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
							<div class="no-thumb"><div class="letter"><span><?php echo mb_strimwidth( esc_html( $category->name ), 0, 1 ); ?></span></div></div>
						</a>
					<?php } ?>

					<?php if( 'true' == $instance[ 'hide_image' ] && 'true' == $instance[ 'hide_post_count' ] ) {
						// image = hide & postcount = hide
						echo '<a class="category-title no-cimg no-ccount" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';

					} elseif( 'true' == $instance[ 'hide_image' ] && ! 'true' == $instance[ 'hide_post_count' ] ) {
						// image = hide & postcount = show
						echo '<a class="category-title no-cimg" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
						
						if( $category->category_count > 1 ) echo '<span>' . $category->category_count . ' ' . esc_html__( 'Posts', 'hannah-cd' ) . '</span>';
						else echo '<span>' . $category->category_count . ' ' . esc_html__( 'Post', 'hannah-cd' ) . '</span>';

					} elseif( ! 'true' == $instance[ 'hide_image' ] && 'true' == $instance[ 'hide_post_count' ] ) {
						// image = show & postcount = hide
						echo '<a class="category-title no-count" href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';

					} else {
						// image = show & postcount = show
						echo '<a class="category-title" href="' . esc_url( get_category_link( $category->term_id ) ) . '">';
						
							if( $category->category_count > 1 ) echo esc_html( $category->name ) . '<span>' . $category->category_count . ' ' . esc_html__( 'Posts', 'hannah-cd' ) . '</span>';
							else echo esc_html( $category->name ) . '<span>' . $category->category_count . ' ' . esc_html__( 'Post', 'hannah-cd' ) . '</span>';
						
						echo '</a>';

					} ?>

				</li>

		<?php } 
		
		echo '</ul></div>';

		echo $after_widget;

	}

	/* Sanitize widget form values as they are saved */

	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['cat_exclude'] = strip_tags( $new_instance['cat_exclude'] );
		$instance['hide_empty_cat'] = ( ! empty( $new_instance['hide_empty_cat'] ) ) ? strip_tags( $new_instance['hide_empty_cat'] ) : '';
		$instance['hide_image'] = ( ! empty( $new_instance['hide_image'] ) ) ? strip_tags( $new_instance['hide_image'] ) : '';
		$instance['hide_post_count'] = ( ! empty( $new_instance['hide_post_count'] ) ) ? strip_tags( $new_instance['hide_post_count'] ) : '';
		$instance['hide_child_cat'] = ( ! empty( $new_instance['hide_child_cat'] ) ) ? strip_tags( $new_instance['hide_child_cat'] ) : '';

		return $instance;

	}

	/* Backend Widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'Categories';
		if ( isset( $instance[ 'cat_exclude' ] ) ) $cat_exclude = $instance[ 'cat_exclude' ]; 
			else $cat_exclude = '';
		if ( isset( $instance[ 'hide_empty_cat' ] ) ) $hide_empty_cat = $instance[ 'hide_empty_cat' ]; 
			else $hide_empty_cat = $instance[ 'hide_empty_cat' ] = 'false';
		if ( isset( $instance[ 'hide_image' ] ) ) $hide_image = $instance[ 'hide_image' ]; 
			else $hide_image = $instance[ 'hide_image' ] = 'false';
		if ( isset( $instance[ 'hide_post_count' ] ) ) $hide_post_count = $instance[ 'hide_post_count' ]; 
			else $hide_post_count = $instance[ 'hide_post_count' ] = 'false';
		if ( isset( $instance[ 'hide_child_cat' ] ) ) $hide_child_cat = $instance[ 'hide_child_cat' ]; 
			else $hide_child_cat = $instance[ 'hide_child_cat' ] = 'false';

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'cat_exclude' ) ); ?>">
				<?php esc_html_e( 'Exclude Categories:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cat_exclude' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cat_exclude' ) ); ?>" type="text" value="<?php echo esc_attr( $cat_exclude ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_empty_cat' ) ); ?>">
				<?php esc_html_e( 'Hide empty categories:', 'hannah-cd' ); ?>
			</label> 
			<input class="checkbox" <?php if ( isset( $hide_empty_cat ) && $hide_empty_cat == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'hide_empty_cat' ); ?>" name = "<?php echo $this->get_field_name( 'hide_empty_cat' ); ?>" value = "true" type = "checkbox" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_image' ) ); ?>">
				<?php esc_html_e( 'Hide Image:', 'hannah-cd' ); ?>
			</label> 
			<input class="checkbox" <?php if ( isset( $hide_image ) && $hide_image == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'hide_image' ); ?>" name = "<?php echo $this->get_field_name( 'hide_image' ); ?>" value = "true" type = "checkbox" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_post_count' ) ); ?>">
				<?php esc_html_e( 'Hide Postcount:', 'hannah-cd' ); ?>
			</label> 
			<input class="checkbox" <?php if ( isset( $hide_post_count ) && $hide_post_count == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'hide_post_count' ); ?>" name = "<?php echo $this->get_field_name( 'hide_post_count' ); ?>" value = "true" type = "checkbox" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_child_cat' ) ); ?>">
				<?php esc_html_e( 'Hide Child Categories:', 'hannah-cd' ); ?>
			</label> 
			<input class="checkbox" <?php if ( isset( $hide_child_cat ) && $hide_child_cat == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'hide_child_cat' ); ?>" name = "<?php echo $this->get_field_name( 'hide_child_cat' ); ?>" value = "true" type = "checkbox" />
		</p>

		<?php 

	}

}