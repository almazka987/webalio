<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_posts_trending_widget" );' ) );

class hannah_Cd_Posts_Trending_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_posts_trending_widget',
			'&#10026; ' . esc_html__( 'Trending Posts', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Shows trending posts of a specific period.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {
	
		// acf widget name
		$widget_id = 'hannah_cd_posts_trending_widget';
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		$amount = $instance['amount'];
		$days = $instance['days'];

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
		
		$args = array(
			'post_type' => 'post',
			'meta_key' => 'trend_post_views_count',
			'posts_per_page' => $amount,
			'orderby' => 'meta_value_num',
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

		$my_posts_query = new WP_Query( $args );

		if ( $my_posts_query->have_posts() ) :

			?>

			<ul class="posts-alternative-widget">

                <?php $post_counter = 1;
        
                while( $my_posts_query->have_posts() ) : $my_posts_query->the_post(); ?>

                    <li class="posts-alternative-item">
                        <a href="<?php the_permalink(); ?>">

                            <div class="posts-alternative-item-img hover-box">

                                <?php if ( has_post_thumbnail() ) :
                                    echo the_post_thumbnail( 'hannah_cd_thumb_wide' );
                                else : 
                                    $post_title = get_the_title(); ?>
                                    <div class="no-thumb">
                                        <div class="letter"><span><?php echo mb_strimwidth( esc_html( $post_title ), 0, 1 ); ?></span></div>
                                    </div>
                                <?php endif; ?>

                                <span class="post-counter"><?php echo sprintf( "%02d", esc_html( $post_counter ) ); ?></span>

                                <div class="hover"></div>

                            </div>

                            <div class="post-title"><?php the_title(); ?></div>

                        </a>
                    </li>

                    <?php $post_counter ++; 
        
                endwhile; ?>

            </ul>

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
		$instance['days'] = strip_tags( $new_instance['days'] );

		return $instance;

	}

	/* Backend Widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'Trending Posts';
		if ( isset( $instance[ 'amount' ] ) ) $amount = $instance[ 'amount' ]; 
			else $amount = '3';
		if ( isset( $instance[ 'days' ] ) ) $days = $instance[ 'days' ]; 
			else $days = '30';
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'days' ) ); ?>">
				<?php esc_html_e( 'Show trending post of the last days, ordered by postview:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'days' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'days' ) ); ?>" type="text" value="<?php echo esc_attr( $days ); ?>" />
		</p>

		<?php 

	}

}