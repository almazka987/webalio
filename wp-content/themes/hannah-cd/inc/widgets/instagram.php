<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_instagram_widget" );' ) );

class hannah_Cd_Instagram_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_instagram_widget',
			'&#10026; ' . esc_html__( 'Instagram', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show instagram photos from your account.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$widget_id = $this->id;
		 
		if ( isset( $instance[ 'column' ] ) ) $column_inst = $instance[ 'column' ]; 
		else $column_inst = 'column_3';
		
		$amount = $instance['amount'];
		$access_token = $instance['access_token'];

		$username = '';
		if ( $access_token && $access_token !== '' ) {
			$username = explode( '.', $access_token );
			$username = $username[0];
		}
		
		if( $column_inst == 'column_1') {
			$column_class = 'column-1';
		} elseif( $column_inst == 'column_2') {
			$column_class = 'column-2';
		} elseif( $column_inst == 'column_4') {
			$column_class = 'column-4';
		} else {
			$column_class = 'column-3';
		}
				
		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */

		// GET INSTAGRAM DATA FROM USER
		// Get the most recent media of a user. --> /users/user-id/media/recent
		// https://www.instagram.com/developer/endpoints/users/#get_users_media_recent
		
		$token = substr( $access_token, 30 ); // trim the access token
		$transient_id = 'my_instagram_transient_' . $amount . '_token_' . $token . '_instance_' . $widget_id;

		if ( false === ( $instagram = get_transient( $transient_id ) ) ) {

			$args = array(
				'timeout' => 30,
			);

			$url = 'https://api.instagram.com/v1/users/' . $username . '/media/recent/?access_token=' . $access_token . '&count=' . $amount;
			$data = json_decode( wp_remote_retrieve_body( wp_remote_get( $url, $args ) ), true );
			
			//print_r($data);
			
			if ( isset( $data['data'] ) ) {
				
				$insta_data = $data['data'];
				$instagram = array();

				foreach ( $insta_data as $insta ) {
					$instagram[] = array(
						'image' 		=> $insta['images']['standard_resolution']['url'],
						'url' 			=> $insta['link'],
						'likes' 		=> $insta['likes']['count'],
						'comments' 		=> $insta['comments']['count'],
						'caption_text' 	=> $insta['caption']['text'],
						'username' 		=> $insta['user']['username'],
						'user_avatar' 	=> $insta['user']['profile_picture'],
					);
				}

				set_transient( $transient_id, $instagram, 12 * HOUR_IN_SECONDS );

			} elseif( isset( $data['meta']['error_message'] ) ) {
				
				// error message
				$data_status = $data['meta']['error_message'];
				echo '<div class="alert alert-warning">' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $data_status . '</div>';
				
			} else {
				$instagram = false;
			}

		}

		?>

		<div class="instagram-widget">
			<div class="instagram-grid <?php echo $column_class; ?>">
			
				<?php if ( $instagram ) : ?>
					<?php foreach ( $instagram as $insta ) : ?>
						<div class="instagram-item">
							<a rel="nofollow" href="<?php echo esc_url( $insta['url'] ); ?>" target="_blank" style="background-image:url(<?php echo esc_url( $insta['image'] ); ?>)" title="<?php echo esc_attr( $insta['caption_text'] ); ?>">
                                <span class="instagram-counts">
                                    <?php if( $insta['likes'] <= 0 ) { ?>
                                        <span><i class="fa fa-plus"></i></span>
                                    <?php } else { ?>
                                        <span><i class="fa fa-heart-o"></i> <?php echo hannah_cd_format_count( esc_html( $insta['likes'] ) ); ?></span>
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
		$instance['column'] = strip_tags( $new_instance['column'] );
		$instance['amount'] = strip_tags( $new_instance['amount'] );
		$instance['access_token'] = strip_tags( $new_instance['access_token'] );

		return $instance;

	}

	/* Backend Widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'Instagram Photos';
		if ( isset( $instance[ 'column_inst' ] ) ) $column_inst = $instance[ 'column_inst' ]; 
			else $column_inst = 'column_3';
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
      		<label for="<?php echo $this->get_field_id('column_inst'); ?>"><?php esc_html_e( 'Columns', 'hannah-cd' ); ?>:
        		<select class="widefat" id="<?php echo $this->get_field_id('column_inst'); ?>" name="<?php echo $this->get_field_name('column_inst'); ?>" type="text">
          			<option value="column_1" <?php echo ( $column_inst == 'column_1') ? 'selected' : ''; ?>>1 <?php esc_html_e( 'Column', 'hannah-cd' ); ?></option>
          			<option value="column_2" <?php echo ( $column_inst == 'column_2') ? 'selected' : ''; ?>>2 <?php esc_html_e( 'Columns', 'hannah-cd' ); ?></option>
          			<option value="column_3" <?php echo ( $column_inst == 'column_3') ? 'selected' : ''; ?>>3 <?php esc_html_e( 'Columns', 'hannah-cd' ); ?></option>
          			<option value="column_4" <?php echo ( $column_inst == 'column_4') ? 'selected' : ''; ?>>4 <?php esc_html_e( 'Columns', 'hannah-cd' ); ?></option>
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
					esc_html_e( 'Instagram', 'hannah-cd' ); 
					echo ' ';
					esc_html_e( 'Access Token', 'hannah-cd' ); 
				?>: ( <a href="//instagram.pixelunion.net" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $access_token ); ?>" />
		</p>
		<?php 

	}

}