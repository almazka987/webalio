<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_facebook_widget" );' ) );

class hannah_Cd_Facebook_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_facebook_widget',
			'&#10026; ' . esc_html__( 'Facebook Feed', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show the latest posts of a facebook fan page timeline.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$widget_id = $this->id;
		
		$amount = $instance['amount'];
		$fb_id = $instance['fb_id'];
		$app_id = $instance['app_id'];
		$app_secret_code = $instance['app_secret_code'];
		$likes_count = $instance['likes_count'] ? 'true' : 'false';
		$comments_count = $instance['comments_count'] ? 'true' : 'false';
		$media = $instance['media'] ? 'true' : 'false';
		$attachment = $instance['attachment'] ? 'true' : 'false';
		
		// Get access token
		$access_token = $app_id . '|' . $app_secret_code; // https://developers.facebook.com/tools/accesstoken
		
		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */

		// GET FACEBOOK TIMELINE DATA FROM USER PAGE
		// Get the recent timeline posts. --> /v2.10/me/
		// https://developers.facebook.com/tools/explorer/
		
		$token = substr( $access_token, 30 ); // trim the access token
		$transient_id = 'my_facebook_user_transient_' . esc_html( $fb_id ) . '_' . esc_html( $amount ) . '_token_' . esc_html( $token ) . '_instance_' . $widget_id;
		$transient_id_2 = 'my_facebook_post_transient_' . esc_html( $fb_id ) . '_' . esc_html( $amount ) . '_token_' . esc_html( $token ) . '_instance_' . $widget_id;

		if ( false === ( $fb_user_data = get_transient( $transient_id ) ) || false === ( $timeline = get_transient( $transient_id_2 ) ) ) {

			$args = array(
				'timeout' => 30,
			);

			$url = 'https://graph.facebook.com/v2.10/' . esc_html( $fb_id ) . '?fields=name,cover,description,fan_count,picture{url,width,height},link,posts.limit(' . esc_html( $amount ) . '){likes.summary(true),comments.summary(true),created_time,description,full_picture,link,message,name,picture,shares,source,permalink_url}&access_token=' . esc_html( $access_token );			
			$data = json_decode( wp_remote_retrieve_body( wp_remote_get( $url, $args ) ), true );
			
			//print_r($data);
			
			if ( isset( $data ) || isset( $data['posts']['data'] ) ) {
				
				// get user data
				
				$fb_user_data = array(
					'fb_user_name' 		=> $data['name'],
					'fb_user_avatar' 	=> $data['picture']['data']['url'],			
					'fb_user_link' 		=> $data['link'],
				);
				
				set_transient( $transient_id, $fb_user_data, 12 * HOUR_IN_SECONDS );
				
				// get timeline posts data
				
				$timeline_data = $data['posts']['data'];
				$timeline = array();

				foreach ( $timeline_data as $post ) {
					$timeline[] = array(						
						'created_time' 	=> $post['created_time'],
						'full_picture' 	=> $post['full_picture'],
						'link' 			=> $post['link'],
						'message' 		=> $post['message'],
						'name' 			=> isset( $post['name'] ) ? $post['name'] : '',
						'picture' 		=> $post['picture'],
						'permalink_url' => $post['permalink_url'],
						'likes' 		=> $post['likes']['summary']['total_count'],
						'comments' 		=> $post['comments']['summary']['total_count'],
					);
				}

				set_transient( $transient_id_2, $timeline, 12 * HOUR_IN_SECONDS );

			} elseif( isset( $data['error']['message'] ) ) {
				// error message
				$data_status = $data['error']['message'];
				echo '<div class="alert alert-warning">' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $data_status . '</div>';
				
			} else {
				$fb_user_data = false;
				$timeline = false;
			}

		}

		?>

		<div class="facebook-widget">		
			<?php if ( $timeline ) : ?>
				<ul>
				<?php foreach ( $timeline as $post ) : ?>
					<li class="facebook-item">
					
						<div class="fb-image">
						
							<a rel="nofollow" href="<?php echo esc_url( $fb_user_data['fb_user_link'] ); ?>" target="_blank">
								<img class="fb-avatar" src="<?php echo esc_url( $fb_user_data['fb_user_avatar'] ); ?>" alt="<?php echo esc_attr( $fb_user_data['fb_user_name'] ); ?>">
							</a>

							<div class="fb-user">
								<a target="_blank" href="<?php echo esc_url( $fb_user_data['fb_user_link'] ); ?>"><?php echo esc_html( $fb_user_data['fb_user_name'] ); ?></a>
								<span>
									<?php 
										$wp_date_format = get_option('date_format');   
										$wp_time_format = get_option('time_format');

										$date = strtotime( $post['created_time'] );
										echo date( $wp_date_format . ' ' . $wp_time_format, esc_html( $date ) );
									?>
								</span>
							</div>
							
						</div>
					
						<div class="fb-content">
						
							<?php if( isset( $post['message'] ) ? $post['message'] : '' ) { ?>
								<div class="fb-text">
									<?php echo $post['message']; ?>
								</div>
							<?php } ?>
							
							<?php if( ! 'true' == $instance[ 'attachment' ] ) { ?>
							
								<?php if( isset( $post['full_picture'] ) ? $post['full_picture'] : '' || isset( $post['name'] ) ? $post['name'] : '' ) { ?>
								
									<div class="fb-attachment">

										<?php if( ! 'true' == $instance[ 'media' ] ) { 
											if( isset( $post['full_picture'] ) ? $post['full_picture'] : '' ) { ?>
												<div class="fb-media">
													<?php 
														// get images
														echo '<a rel="nofollow" target="_blank" href="' . esc_url( $post['permalink_url'] ) . '"><img src="' . esc_url( $post['full_picture'] ) . '" alt=""></a>';
													?>
												</div>
										<?php }
										} ?>

										<div class="fb-attachment-title">
											<?php
												// get title
												echo '<a rel="nofollow" target="_blank" href="' . esc_url( $post['permalink_url'] ) . '">' . esc_html( $post['name'] ) . '</a>';
											?>
										</div>

									</div>
									
								<?php } ?>
								
							<?php } ?>
							
							<?php if( ! 'true' == $instance[ 'likes_count' ] || ! 'true' == $instance[ 'comments_count' ] ) { ?>
								<div class="fb-counts">
									<?php if( ! 'true' == $instance[ 'likes_count' ] ) { ?>
										<span><i class="fa fa-thumbs-o-up"></i> <?php echo esc_html( $post['likes'] ) . ' ' . esc_html__( 'Likes', 'hannah-cd' ); ?></span>
									<?php } ?>
									<?php if( ! 'true' == $instance[ 'comments_count' ] ) { ?>
										<span><i class="fa fa-comment-o"></i> <?php echo esc_html( $post['comments'] ) . ' ' . esc_html__( 'Comments', 'hannah-cd' ); ?></span>
									<?php } ?>
								</div>
							<?php } ?>
							
						</div>
						
					</li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<?php

		echo $after_widget;

	}

	/* Sanitize widget form values as they are saved */

	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['amount'] = strip_tags( $new_instance['amount'] );
		$instance['fb_id'] = strip_tags( $new_instance['fb_id'] );
		$instance['app_id'] = strip_tags( $new_instance['app_id'] );
		$instance['app_secret_code'] = strip_tags( $new_instance['app_secret_code'] );
		$instance['likes_count'] = ( ! empty( $new_instance['likes_count'] ) ) ? strip_tags( $new_instance['likes_count'] ) : '';
		$instance['comments_count'] = ( ! empty( $new_instance['comments_count'] ) ) ? strip_tags( $new_instance['comments_count'] ) : '';
		$instance['media'] = ( ! empty( $new_instance['media'] ) ) ? strip_tags( $new_instance['media'] ) : '';
		$instance['attachment'] = ( ! empty( $new_instance['attachment'] ) ) ? strip_tags( $new_instance['attachment'] ) : '';

		return $instance;

	}

	/* Backend Widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'Facebook Posts';
		if ( isset( $instance[ 'amount' ] ) ) $amount = $instance[ 'amount' ]; 
			else $amount = '6';
		if ( isset( $instance[ 'fb_id' ] ) ) $fb_id = $instance[ 'fb_id' ]; 
			else $fb_id = '';
		if ( isset( $instance[ 'app_id' ] ) ) $app_id = $instance[ 'app_id' ]; 
			else $app_id = '';
		if ( isset( $instance[ 'app_secret_code' ] ) ) $app_secret_code = $instance[ 'app_secret_code' ]; 
			else $app_secret_code = '';
		if ( isset( $instance[ 'likes_count' ] ) ) $likes_count = $instance[ 'likes_count' ]; 
			else $likes_count = $instance[ 'likes_count' ] = 'false';
		if ( isset( $instance[ 'comments_count' ] ) ) $comments_count = $instance[ 'comments_count' ]; 
			else $comments_count = $instance[ 'comments_count' ] = 'false';
		if ( isset( $instance[ 'media' ] ) ) $media = $instance[ 'media' ]; 
			else $media = $instance[ 'media' ] = 'false';
		if ( isset( $instance[ 'attachment' ] ) ) $attachment = $instance[ 'attachment' ]; 
			else $attachment = $instance[ 'attachment' ] = 'false';

		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title', 'hannah-cd' ); ?>:
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'amount' ) ); ?>">
				<?php esc_html_e( 'Amount', 'hannah-cd' ); ?>:
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'amount' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'amount' ) ); ?>" type="text" value="<?php echo esc_attr( $amount ); ?>" />
		</p>
		<p>
			<input class="checkbox" <?php if ( isset( $attachment ) && $attachment == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'attachment' ); ?>" name = "<?php echo $this->get_field_name( 'attachment' ); ?>" value = "true" type = "checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'attachment' ) ); ?>">
				<?php esc_html_e( 'Hide attachment box', 'hannah-cd' ); ?>
			</label> 
		</p>
		<p>
			<input class="checkbox" <?php if ( isset( $media ) && $media == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'media' ); ?>" name = "<?php echo $this->get_field_name( 'media' ); ?>" value = "true" type = "checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'media' ) ); ?>">
				<?php esc_html_e( 'Hide attached media', 'hannah-cd' ); ?>
			</label> 
		</p>
		<p>
			<input class="checkbox" <?php if ( isset( $likes_count ) && $likes_count == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'likes_count' ); ?>" name = "<?php echo $this->get_field_name( 'likes_count' ); ?>" value = "true" type = "checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'likes_count' ) ); ?>">
				<?php esc_html_e( 'Hide Likes Count', 'hannah-cd' ); ?>
			</label> 
		</p>
		<p>
			<input class="checkbox" <?php if ( isset( $comments_count ) && $comments_count == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'comments_count' ); ?>" name = "<?php echo $this->get_field_name( 'comments_count' ); ?>" value = "true" type = "checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'comments_count' ) ); ?>">
				<?php esc_html_e( 'Hide Comments Count', 'hannah-cd' ); ?>
			</label> 
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'fb_id' ) ); ?>">
				<?php 
					esc_html_e( 'Facebook', 'hannah-cd' ); 
					echo ' ';
					esc_html_e( 'ID', 'hannah-cd' ); 
				?>:
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'fb_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'fb_id' ) ); ?>" type="text" value="<?php echo esc_attr( $fb_id ); ?>" />
			<br>
			<small><?php esc_html_e( 'Page URL', 'hannah-cd' ); ?>: https://www.facebook.com/[ID]</small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'app_id' ) ); ?>">
				<?php 
					esc_html_e( 'Facebook', 'hannah-cd' );
					echo ' ';
					esc_html_e( 'App ID', 'hannah-cd' );  
				?>: ( <a href="//developers.facebook.com/tools/accesstoken" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'app_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'app_id' ) ); ?>" type="text" value="<?php echo esc_attr( $app_id ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'app_secret_code' ) ); ?>">
				<?php 
					esc_html_e( 'Facebook', 'hannah-cd' ); 
					echo ' ';
					esc_html_e( 'App Secret Code', 'hannah-cd' );
				?>: ( <a href="//developers.facebook.com/tools/accesstoken/" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'app_secret_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'app_secret_code' ) ); ?>" type="text" value="<?php echo esc_attr( $app_secret_code ); ?>" />
		</p>
		<?php 

	}

}