<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_posts_widget" );' ) );

class hannah_Cd_Posts_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_posts_widget',
			'&#10026; ' . esc_html__( 'Recent / Popular Posts V.1', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show recent or popular posts.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {
	
		// acf widget name
		$widget_id = 'hannah_cd_posts_widget';
	
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$amount = $instance['amount'];
		$type = $instance['type'];
		if( isset( $hide_comments ) ) $hide_comments = $instance[ 'hide_comments' ] ? 'true' : 'false';
		if( isset( $hide_likes ) ) $hide_likes = $instance[ 'hide_likes' ] ? 'true' : 'false';
		if( isset( $hide_rating ) ) $hide_rating = $instance[ 'hide_rating' ] ? 'true' : 'false';
		if( isset( $hide_views ) ) $hide_views = $instance[ 'hide_views' ] ? 'true' : 'false';

		// acf fields
		$get_postformat = ACF_GF('widget_postformat_exclude', 'widget_' . $widget_id);

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */
		
		// postformat exclude
		$postformat_exclude = array();
		if ( is_array( $get_postformat ) || is_object( $get_postformat ) ) {
			foreach( $get_postformat as $postformat ) {
				array_push( $postformat_exclude, $postformat['value'] );
			}
		}

		if ( $type == 'popular' ) {
			$args = array(
				'post_type' => 'post',
				'meta_key' => 'post_views_count', // by views count
				'posts_per_page' => $amount,
				'orderby' => 'meta_value_num', // order by views
				'order' => 'DESC',
				'ignore_sticky_posts' => 1,
				'tax_query' => array(
					array(
						'taxonomy' 	=> 'post_format',
						'field' 	=> 'slug',
						'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
						'operator' 	=> 'NOT IN'
					)
				),
			);
		} elseif ( $type == 'likes' ) {
			$args = array(
				'post_type' => 'post',
				'meta_key' => '_like_btn', // by likes count
				'posts_per_page' => $amount,
				'orderby' => 'meta_value_num', // order by likes count
				'order' => 'DESC',
				'ignore_sticky_posts' => 1,
				'tax_query' => array(
					array(
						'taxonomy' 	=> 'post_format',
						'field' 	=> 'slug',
						'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
						'operator' 	=> 'NOT IN'
					)
				),
			);
		} elseif ( $type == 'rating' ) {
			$args = array(
				'post_type' => 'post',
				'meta_key' => 'post_rating', // by post rating (rating / votes count = post rating)
				'posts_per_page' => $amount,
				'orderby' => 'meta_value_num', // order by rating value
				'order' => 'DESC',
				'ignore_sticky_posts' => 1,
				'tax_query' => array(
					array(
						'taxonomy' 	=> 'post_format',
						'field' 	=> 'slug',
						'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
						'operator' 	=> 'NOT IN'
					)
				),
			);
		} elseif ( $type == 'comment' ) {
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $amount,
				'orderby' => 'comment_count', // order by comment count
				'order' => 'DESC',
				'ignore_sticky_posts' => 1,
				'tax_query' => array(
					array(
						'taxonomy' 	=> 'post_format',
						'field' 	=> 'slug',
						'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
						'operator' 	=> 'NOT IN'
					)
				),
			);
		} else {
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => $amount,
				'orderby' => 'date', // order by date,
				'ignore_sticky_posts' => 1,
				'tax_query' => array(
					array(
						'taxonomy' 	=> 'post_format',
						'field' 	=> 'slug',
						'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
						'operator' 	=> 'NOT IN'
					)
				),
			);
		}

		$my_posts_query = new WP_Query( $args );

		if ( $my_posts_query->have_posts() ) :

			?>

			<div class="posts-widget">
				<ul>
				
				<?php while ( $my_posts_query->have_posts() ) : $my_posts_query->the_post(); ?>
				
					<li>
					
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>"><?php echo the_post_thumbnail( 'hannah_cd_thumb_min' ); ?></a>
							<?php else : 
							$post_title = get_the_title();
						?>
							<a href="<?php the_permalink(); ?>">
								<div class="no-thumb"><div class="letter"><span><?php echo mb_strimwidth( esc_html( $post_title ), 0, 1 ); ?></span></div></div>
							</a>
						<?php endif; ?>
					
						<a class="post-title" href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
						
						<p>
							<?php echo wp_trim_words( get_the_excerpt(), 8 ); ?>
						</p>
						
						<?php if( ! 'true' == $instance[ 'hide_comments' ] || ! 'true' == $instance[ 'hide_likes' ] || ! 'true' == $instance[ 'hide_rating' ] || ! 'true' == $instance[ 'hide_views' ] ) { ?>
                            <p>
                              	
                               	<?php if( isset( $instance[ 'hide_comments' ] ) && ! 'true' == $instance[ 'hide_comments' ] ) { ?>
                               		<span class="widget-meta">
										<span class="fa fa-commenting-o"></span>
										<?php comments_number( esc_html__( 'No comments', 'hannah-cd' ), esc_html__( 'One comment', 'hannah-cd' ), esc_html__( '% comments', 'hannah-cd' ) ); ?>
									</span>
                              	<?php } ?>
                              	
                               	<?php if ( isset( $instance[ 'hide_likes' ] ) && ! 'true' == $instance[ 'hide_likes' ]  ) { ?>
                               		<span class="widget-meta">
										<span class="fa fa-heart-o"></span>
										<?php hannah_cd_like_count( get_the_ID() ); ?>
										<?php esc_html_e( 'Likes', 'hannah-cd' ); ?>
									</span>
                            	<?php } ?>
                              	
                               	<?php if ( isset( $instance[ 'hide_rating' ] ) && ! 'true' == $instance[ 'hide_rating' ] ) { ?>
                               		<span class="widget-meta">
										<span class="fa fa-star-o"></span>
										<?php hannah_cd_get_ratings( get_the_ID() ); ?>
										<?php esc_html_e( 'Stars', 'hannah-cd' ); ?>
									</span>
                            	<?php } ?>
                              	
                               	<?php if ( isset( $instance[ 'hide_views' ] ) && ! 'true' == $instance[ 'hide_views' ] ) { ?>
                               		<span class="widget-meta">
										<span class="fa fa-eye"></span>
										<?php echo hannah_cd_getPostViews( get_the_ID() ); ?>
									</span>
                            	<?php } ?>
                            	
                            </p>
						<?php } ?>
						
					</li>
					
				<?php endwhile; ?>
				
				</ul>
			</div>

			<?php

		endif;

		wp_reset_postdata();

		echo $after_widget;

	}

	/* Sanitize widget form values as they are saved */

	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['amount'] = strip_tags( $new_instance['amount'] );
		$instance['type'] = strip_tags( $new_instance['type'] );
		$instance['hide_comments'] = ( ! empty( $new_instance['hide_comments'] ) ) ? strip_tags( $new_instance['hide_comments'] ) : '';
		$instance['hide_likes'] = ( ! empty( $new_instance['hide_likes'] ) ) ? strip_tags( $new_instance['hide_likes'] ) : '';
		$instance['hide_rating'] = ( ! empty( $new_instance['hide_rating'] ) ) ? strip_tags( $new_instance['hide_rating'] ) : '';
		$instance['hide_views'] = ( ! empty( $new_instance['hide_views'] ) ) ? strip_tags( $new_instance['hide_views'] ) : '';

		return $instance;

	}

	/* Backend Widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'Recent Posts';
		if ( isset( $instance[ 'amount' ] ) ) $amount = $instance[ 'amount' ]; 
			else $amount = '4';
		if ( isset( $instance[ 'type' ] ) ) $type = $instance[ 'type' ]; 
			else $type = 'recent';
		if ( isset( $instance[ 'hide_comments' ] ) ) $hide_comments = $instance[ 'hide_comments' ]; 
			else $hide_comments = $instance[ 'hide_comments' ] = 'false';
		if ( isset( $instance[ 'hide_likes' ] ) ) $hide_likes = $instance[ 'hide_likes' ]; 
			else $hide_likes = $instance[ 'hide_likes' ] = 'true';
		if ( isset( $instance[ 'hide_rating' ] ) ) $hide_rating = $instance[ 'hide_rating' ]; 
			else $hide_rating = $instance[ 'hide_rating' ] = 'true';
		if ( isset( $instance[ 'hide_views' ] ) ) $hide_views = $instance[ 'hide_views' ]; 
			else $hide_views = $instance[ 'hide_views' ] = 'true';

		?>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'amount' ) ); ?>">
				<?php esc_html_e( 'Amount:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'amount' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'amount' ) ); ?>" type="text" value="<?php echo esc_attr( $amount ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>">
				<?php esc_html_e( 'Type:', 'hannah-cd' ); ?>
			</label> 
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>">
				<option <?php if ( $type == 'recent' ) echo 'selected="selected"'; ?> value="recent">
					<?php esc_html_e( 'Recent', 'hannah-cd' ); ?>
				</option>
				<option <?php if ( $type == 'popular' ) echo 'selected="selected"'; ?> value="popular">
					<?php esc_html_e( 'Popular by most viewed', 'hannah-cd' ); ?>
				</option>
				<option <?php if ( $type == 'likes' ) echo 'selected="selected"'; ?> value="likes">
					<?php esc_html_e( 'Popular by most liked', 'hannah-cd' ); ?>
				</option>
				<option <?php if ( $type == 'rating' ) echo 'selected="selected"'; ?> value="rating">
					<?php esc_html_e( 'Popular by most rated', 'hannah-cd' ); ?>
				</option>
				<option <?php if ( $type == 'comment' ) echo 'selected="selected"'; ?> value="comment">
					<?php esc_html_e( 'Popular by most commented', 'hannah-cd' ); ?>
				</option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_comments' ) ); ?>">
				<?php esc_html_e( 'Hide Comments:', 'hannah-cd' ); ?>
			</label> 
			<input class="checkbox" <?php if ( isset( $hide_comments ) && $hide_comments == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'hide_comments' ); ?>" name = "<?php echo $this->get_field_name( 'hide_comments' ); ?>" value = "true" type = "checkbox" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_likes' ) ); ?>">
				<?php esc_html_e( 'Hide Likes:', 'hannah-cd' ); ?>
			</label> 
			<input class="checkbox" <?php if ( isset( $hide_likes ) && $hide_likes == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'hide_likes' ); ?>" name = "<?php echo $this->get_field_name( 'hide_likes' ); ?>" value = "true" type = "checkbox" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_rating' ) ); ?>">
				<?php esc_html_e( 'Hide Rating:', 'hannah-cd' ); ?>
			</label> 
			<input class="checkbox" <?php if ( isset( $hide_rating ) && $hide_rating == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'hide_rating' ); ?>" name = "<?php echo $this->get_field_name( 'hide_rating' ); ?>" value = "true" type = "checkbox" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_views' ) ); ?>">
				<?php esc_html_e( 'Hide Views:', 'hannah-cd' ); ?>
			</label> 
			<input class="checkbox" <?php if ( isset( $hide_views ) && $hide_views == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'hide_views' ); ?>" name = "<?php echo $this->get_field_name( 'hide_views' ); ?>" value = "true" type = "checkbox" />
		</p>

		<?php 

	}

}