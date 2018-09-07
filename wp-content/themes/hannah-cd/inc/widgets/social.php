<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_social_widget" );' ) );

class hannah_Cd_Social_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_social_widget',
			'&#10026; ' . esc_html__( 'Social', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show your social links.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */

		?>

			<div class="social-widget">

				<?php if( ACF_HR('socialbar_column_show', 'option') ) : ?>
    
					<?php while ( ACF_HR('socialbar_column_show', 'option') ) { the_row(); ?>

                        <?php $socialbar_column_link = ACF_GSF('socialbar_column_link', 'option'); ?>
                        <?php $socialbar_column_icon = ACF_GSF('socialbar_column_icon', 'option'); ?>

                        <?php if( $socialbar_column_link ) { ?>
                            <a href="<?php echo esc_url( $socialbar_column_link ); ?>" class="fa <?php echo esc_html( $socialbar_column_icon ); ?>" target="_blank"></a>
                        <?php } ?>

                    <?php } ?>

                <?php endif; ?>

			</div>

		<?php

		echo $after_widget;

	}

	/* Sanitize widget form values as they are saved. */

	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;

	}

	/* Backend widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; else $title = 'Social Profiles';
		
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<?php esc_html_e( 'Manage your social profiles in WP admin &rarr; Theme Settings &rarr; Social', 'hannah-cd' ); ?>
		</p>

		<?php 

	}

}