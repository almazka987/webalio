<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_author_widget" );' ) );

class hannah_Cd_Author_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_author_widget',
			'&#10026; ' . esc_html__( 'About Author', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show more about the author.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {
		
		// acf widget name
		$widget_id = 'hannah_cd_author_widget';
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$name = $instance['name'];
		$text = $instance['text'];
		if( isset( $radio_button ) ) $radio_button = $instance['radio_button'] ? 'radio_option_1' : 'radio_option_2';
		
		// acf fields
		$bg_image = ACF_GF('widget_author_image', 'widget_' . $widget_id);
        $bg_image_thumb = wp_get_attachment_image_src( $bg_image, 'medium', false, '' );
        
		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */

		?>

			<div class="about-author-widget <?php if ( isset( $instance[ 'radio_button' ] ) && 'radio_option_2' == $instance[ 'radio_button' ] ) { ?>round<?php } ?>">

				<?php if( ! empty( $bg_image ) ) : ?>
					<?php 
					
					// ORIGINAL IMAGE
					
					if ( isset( $instance[ 'radio_button' ] ) && 'radio_option_1' == $instance[ 'radio_button' ]  ) { ?>
					
						<div class="author-image">
							<img src="<?php echo esc_url( $bg_image_thumb[0] ); ?>" alt="<?php echo esc_html( $name ); ?>" />
						</div>
						
					<?php 
					
					// ROUND IMAGE
					
					} else { ?>
					
						<div class="author-image" style="background-image: url(<?php echo esc_url( $bg_image_thumb[0] ); ?>)"></div>
						
					<?php } ?>
					
				<?php endif; ?>
				
				<div class="author-title"><?php echo esc_html( $name ); ?></div>
				<div class="author-text"><?php echo esc_html( $text ); ?></div>

			</div>

		<?php

		echo $after_widget;

	}

	/* Sanitize widget form values as they are saved */

	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['name'] = strip_tags( $new_instance['name'] );
		$instance['text'] = strip_tags( $new_instance['text'] );
		$instance['radio_button'] = strip_tags( $new_instance['radio_button'] );

		return $instance;

	}

	/* Backend Widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'About Me';
		if ( isset( $instance[ 'name' ] ) ) $name = $instance[ 'name' ]; 
			else $name = 'I\'m Hannah, I blog about fashion.';
		if ( isset( $instance[ 'text' ] ) ) $text = $instance[ 'text' ]; 
			else $text = 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.';
		if ( isset( $instance[ 'radio_button' ] ) ) $radio_button = $instance[ 'radio_button' ]; 
			else $radio_button = 'radio_option_1';

		?>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>">
				<?php esc_html_e( 'About Author Title:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'name' ) ); ?>" type="text" value="<?php echo esc_attr( $name ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>">
				<?php esc_html_e( 'About Author Text:', 'hannah-cd' ); ?>
			</label> 
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_html( $text ); ?></textarea>
		</p>
		
		<hr>
		
		<p>
			<label for="<?php echo $this->get_field_id('radio_option_1'); ?>">
				<?php esc_html_e( 'Original image', 'hannah-cd' ); ?>:
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'radio_option_1' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'radio_button' ) ); ?>" type="radio" value="radio_option_1" <?php if ( isset( $radio_button ) && $radio_button == 'radio_option_1' ) { echo 'checked="checked"'; } ?> />
			</label>
			
			&nbsp;&nbsp;&nbsp;
			
			<label for="<?php echo $this->get_field_id('radio_option_2'); ?>">
				<?php esc_html_e( 'Rounded image', 'hannah-cd' ); ?>:
				<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'radio_option_2' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name('radio_button') ); ?>" type="radio" value="radio_option_2" <?php if ( isset( $radio_button ) && $radio_button == 'radio_option_2' ) { echo 'checked="checked"'; } ?> />
			</label>
		</p>
		
		<hr>

		<?php 

	}

}