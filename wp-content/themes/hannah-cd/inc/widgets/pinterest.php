<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_pinterest_widget" );' ) );

class hannah_Cd_Pinterest_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_pinterest_widget',
			'&#10026; ' . esc_html__( 'Pinterest User Pins', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show the latest pinterest pins from your account.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$widget_id = $this->id;
		 
		if ( isset( $instance[ 'column' ] ) ) $column_pin = $instance[ 'column' ]; 
		else $column_pin = 'column_3';
		
		$amount = $instance['amount'];
		$access_token = $instance['access_token'];
		
		if( $column_pin == 'column_1') {
			$column_class = 'column-1';
		} elseif( $column_pin == 'column_2') {
			$column_class = 'column-2';
		} elseif( $column_pin == 'column_4') {
			$column_class = 'column-4';
		} else {
			$column_class = 'column-3';
		}

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */
		
		// GET All PINs FROM USER
		// Return the logged in user's Pins --> /v1/me/pins/
		// https://developers.pinterest.com/tools/api-explorer/
		
		$token = substr( $access_token, 30 ); // trim the access token
		$transient_id = 'my_pinterest_user_pins_transient_' . esc_html( $amount ) . '_token_' . esc_html( $token ) . '_instance_' . $widget_id;
		
		if ( false === ( $pin_data_array = get_transient( $transient_id ) ) ) {

			$args = array(
				'timeout' => 30,
			);			

			$url = 'https://api.pinterest.com/v1/me/pins/?access_token=' . esc_html( $access_token ) . '&limit=' . esc_html( $amount ) . '&fields=image,url,original_link,note,counts';
			$data = json_decode( wp_remote_retrieve_body( wp_remote_get( $url, $args ) ), true );			
			
			if ( isset( $data['data'] ) ) {
			
				$pin_data = $data['data'];
				$pin_data_array = array();

				foreach ( $pin_data as $pin ) {
					$pin_data_array[] = array(
						'image' 		=> $pin['image']['original']['url'],
						'image_width' 	=> $pin['image']['original']['width'],
						'image_height'	=> $pin['image']['original']['height'],
						'url' 			=> $pin['url'],
						'original_link' => $pin['original_link'],
						'note' 			=> $pin['note'],
						'repins' 		=> $pin['counts']['saves'],
						//'comments' 		=> $pin['counts']['comments'],
					);
				}

				set_transient( $transient_id, $pin_data_array, 12 * HOUR_IN_SECONDS );
				
			} elseif( isset( $data['message'] ) ) {
				
				// error message
				$pin_status = $data['message'];
				echo '<div class="alert alert-warning">' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $pin_status . '</div>';
				
				
			} else {
				
				$pin_data_array = false;
				
			}
		
		}

		?>
		
		<div class="pinterest-widget">
			<div class="pinterest-grid <?php echo $column_class; ?>">

				<?php if ( $pin_data_array ) : ?>
					<?php foreach ( $pin_data_array as $pin ) : ?>
						<div class="pinterest-item">
							<a rel="nofollow" href="<?php echo esc_url( $pin['url'] ); ?>" target="_blank" style="background-image:url(<?php echo esc_url( $pin['image'] ); ?>)" title="<?php echo esc_attr( $pin['note'] ); ?>">
								<span class="pinterest-counts">
									<?php if( $pin['repins'] <= 0 ) { ?>
										<span><i class="fa fa-plus"></i></span>
									<?php } else { ?>
										<span><i class="fa fa-heart-o"></i> <?php echo hannah_cd_format_count( esc_html( $pin['repins'] ) ); ?></span>
									<?php } ?>
								</span>
							</a>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>

			</div>
		</div>

		<?php

		echo $after_widget;

	}

	/* Sanitize widget form values as they are saved */

	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['column_pin'] = strip_tags( $new_instance['column_pin'] );
		$instance['amount'] = strip_tags( $new_instance['amount'] );
		$instance['access_token'] = strip_tags( $new_instance['access_token'] );

		return $instance;

	}

	/* Backend Widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'Pinterest Pins';
		if ( isset( $instance[ 'column_pin' ] ) ) $column_pin = $instance[ 'column_pin' ]; 
			else $column_pin = 'column_3';
		if ( isset( $instance[ 'amount' ] ) ) $amount = $instance[ 'amount' ]; 
			else $amount = '9';
		if ( isset( $instance[ 'access_token' ] ) ) $access_token = $instance[ 'access_token' ]; 
			else $access_token = '';

		?>
		<p>
			<strong><?php esc_html_e( 'Info', 'hannah-cd' ); ?></strong>: 
			<?php esc_html_e( 'If this widget located inside the "Footerbar Full-Size" and the amount of images is set bigger than 10 images, the widget items will displayed as a carousel.', 'hannah-cd' ); ?>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title', 'hannah-cd' ); ?>:
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
      		<label for="<?php echo $this->get_field_id('column_pin'); ?>"><?php esc_html_e( 'Columns', 'hannah-cd' ); ?>:
        		<select class="widefat" id="<?php echo $this->get_field_id('column_pin'); ?>" name="<?php echo $this->get_field_name('column_pin'); ?>" type="text">
          			<option value="column_1" <?php echo ( $column_pin == 'column_1') ? 'selected' : ''; ?>>1 <?php esc_html_e( 'Column', 'hannah-cd' ); ?></option>
          			<option value="column_2" <?php echo ( $column_pin == 'column_2') ? 'selected' : ''; ?>>2 <?php esc_html_e( 'Columns', 'hannah-cd' ); ?></option>
          			<option value="column_3" <?php echo ( $column_pin == 'column_3') ? 'selected' : ''; ?>>3 <?php esc_html_e( 'Columns', 'hannah-cd' ); ?></option>
          			<option value="column_4" <?php echo ( $column_pin == 'column_4') ? 'selected' : ''; ?>>4 <?php esc_html_e( 'Columns', 'hannah-cd' ); ?></option>
        		</select>                
      		</label>
     	</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'amount' ) ); ?>">
				<?php esc_html_e( 'Amount', 'hannah-cd' ); ?>:
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'amount' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'amount' ) ); ?>" type="text" value="<?php echo esc_attr( $amount ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>">
				<?php 
					esc_html_e( 'Pinterest', 'hannah-cd' ); 
					echo ' ';
					esc_html_e( 'Access Token', 'hannah-cd' ); 
				?>: ( <a href="//developers.pinterest.com/tools/access_token/" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $access_token ); ?>" />
		</p>
		<?php 

	}

}