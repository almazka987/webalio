<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_newsletter_widget" );' ) );

class hannah_Cd_Newsletter_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_newsletter_widget',
			'&#10026; ' . esc_html__( 'Newsletter', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show a subscription form.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {

		// acf widget name
		$widget_id = 'hannah_cd_newsletter_widget';
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$text_before = $instance['text_before'];
		$text_after = $instance['text_after'];

		// acf fields
		$bg_image = ACF_GF('widget_nl_bg_image', 'widget_' . $widget_id);

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */

		?>

			<div class="newsletter-widget"<?php if( ! empty( $bg_image ) ) { ?> style="background-image:url(<?php echo esc_url( $bg_image['url'] ); ?>)"<?php } ?>>
				<div class="newsletter-widget-content">

					<span><?php echo esc_html( $text_before ); ?></span>

					<?php if( ACF_HR('newsletter_form_show', 'widget_' . $widget_id) ) : 
						while ( ACF_HR('newsletter_form_show', 'widget_' . $widget_id) ) { 

							/* include afc newsletter select */ 
							get_template_part( 'inc/acf', 'newsletter' );

						}
					endif; ?>

					<span><?php echo esc_html( $text_after ); ?></span>

				</div>
			</div>

		<?php

		echo $after_widget;

	}

	/* Sanitize widget form values as they are saved */

	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['text_before'] = strip_tags( $new_instance['text_before'] );
		$instance['text_after'] = strip_tags( $new_instance['text_after'] );

		return $instance;

	}

	/* Backend Widge */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'Newsletter';
		if ( isset( $instance[ 'text_before' ] ) ) $text_before = $instance[ 'text_before' ]; 
			else $text_before = '';
		if ( isset( $instance[ 'text_after' ] ) ) $text_after = $instance[ 'text_after' ]; 
			else $text_after = '';

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text_before' ) ); ?>">
				<?php esc_html_e( 'Text before Form:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text_before' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_before' ) ); ?>" type="text" value="<?php echo esc_attr( $text_before ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text_after' ) ); ?>">
				<?php esc_html_e( 'Text after Form:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text_after' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text_after' ) ); ?>" type="text" value="<?php echo esc_attr( $text_after ); ?>" />
		</p>

		<?php 

	}

}