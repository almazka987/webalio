<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_pages_widget" );' ) );

class hannah_Cd_Pages_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_pages_widget',
			'&#10026; ' . esc_html__( 'Recent / Popular Pages', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show recent or popular pages.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		$amount = $instance['amount'];
		$type = $instance['type'];
		if( isset( $hide_views ) ) $hide_views = $instance[ 'hide_views' ] ? 'true' : 'false';

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */

		if ( $type == 'popular' ) {
			$args = array(
				'post_type' => 'page',
				'meta_key' => 'post_views_count', // by views count
				'posts_per_page' => $amount,
				'orderby' => 'meta_value_num', // order by views
				'order' => 'DESC'
			);
		} else {
			$args = array(
				'post_type' => 'page',
				'posts_per_page' => $amount,
				'orderby' => 'date', // order by date
			);
		}

		$my_posts_query = new WP_Query( $args );

		if ( $my_posts_query->have_posts() ) :

			?>

			<div class="page-widget">
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
						
						<?php if(  isset( $instance[ 'hide_views' ] ) && ! 'true' == $instance[ 'hide_views' ] ) { ?>
                            <p>
								<span class="widget-meta">
									<span class="fa fa-eye"></span>
									<?php echo hannah_cd_getPostViews( get_the_ID() ); ?>
								</span>
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
		$instance['hide_views'] = ( ! empty( $new_instance['hide_views'] ) ) ? strip_tags( $new_instance['hide_views'] ) : '';

		return $instance;

	}

	/* Backend Widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'Recent Pages';
		if ( isset( $instance[ 'amount' ] ) ) $amount = $instance[ 'amount' ]; 
			else $amount = '4';
		if ( isset( $instance[ 'type' ] ) ) $type = $instance[ 'type' ]; 
			else $type = 'recent';
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
					<?php esc_html_e( 'Popular', 'hannah-cd' ); ?>
				</option>
			</select>
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