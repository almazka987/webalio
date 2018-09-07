<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_banner_widget" );' ) );

class Hannah_Cd_Banner_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_banner_widget',
			'&#10026; ' . esc_html__( 'Ad Banner', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Banner rotation for Ads. The banners are displayed in a random order when more than one is selected.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {

		// acf widget name
		$widget_id = 'hannah_cd_banner_widget';
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$ad_label = $instance['ad_label'];

		

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */

		?>

			<div class="banner-widget">
			
				<?php if( $ad_label ) { ?>
					<div class="banner-widget-layer">
						<span><?php echo esc_html( $ad_label ); ?></span>
					</div>
				<?php } ?>
				
				<div class="banner-widget-content">
				
					<?php
					
						$rows = ACF_GF('ad_banner_show', 'widget_' . $widget_id ); // get all the rows
						
                        if( ! empty( $rows ) ) {                
        
                            $rand_row = $rows[ array_rand( $rows ) ]; // get a random row

                            // get the sub field value
                            $rand_row_image = $rand_row['ad_banner_img'];
                            $rand_row_link = $rand_row['ad_banner_link'];

                            $rand_row_type = $rand_row['ad_banner_type'];
                            $rand_row_html = $rand_row['ad_banner_html_code'];

                            if( $rand_row_type == 'ad_type_img'  ) {

                                if( $rand_row_link ) {
                                    echo '<a href="' . esc_url( $rand_row_link ) . '" target="_blank">';
                                }

                                    echo '<img src="' . esc_url( $rand_row_image['url'] ) . '" alt="' . esc_attr( $rand_row_image['alt'] ) . '">';

                                if( $rand_row_link ) {
                                    echo '</a>';
                                }

                            } elseif ( $rand_row_type == 'ad_type_html'  ) {

                                echo hannah_cd_kses( $rand_row_html );

                            }
                            
                        } else {
                            
                            echo '<div class="alert alert-warning">' . esc_html__( 'No content selected', 'hannah-cd' ) . '.</div>';
                            
                        }
								
					?>
					
				</div>
			</div>

		<?php

		echo $after_widget;

	}

	/* Sanitize widget form values as they are saved */

	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['ad_label'] = strip_tags( $new_instance['ad_label'] );

		return $instance;

	}

	/* Backend Widge */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'Banner';
		if ( isset( $instance[ 'ad_label' ] ) ) $ad_label = $instance[ 'ad_label' ]; 
			else $ad_label = 'Advertising';

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'ad_label' ) ); ?>">
				<?php esc_html_e( 'Label of Advertising:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'ad_label' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'ad_label' ) ); ?>" type="text" value="<?php echo esc_attr( $ad_label ); ?>" />
		</p>

		<?php 

	}

}