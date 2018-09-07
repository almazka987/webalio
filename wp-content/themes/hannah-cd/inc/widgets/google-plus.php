<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_google_plus_widget" );' ) );

class hannah_Cd_Google_Plus_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_google_plus_widget',
			'&#10026; ' . esc_html__( 'Google Plus Feed', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show the latest activities of a google plus user page.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		$amount = $instance['amount'];
		$user_id = $instance['user_id'];
		
		$api_key = $instance['api_key'];
		$likes_count = $instance['likes_count'] ? 'true' : 'false';
		
		$comments_count = $instance['comments_count'] ? 'true' : 'false';
		$media = $instance['media'] ? 'true' : 'false';
		$attachment = $instance['attachment'] ? 'true' : 'false';
		
		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */

		// GET GOOGLE PLUS USER ACTIVITIES
		// Get the latest activities. --> /plus/v1/people/
		// https://developers.google.com/+/web/api/rest/latest/activities
		
		$key = substr( $api_key, 30 ); // trim the api key
		$transient_id = 'my_google_plus_transient_' . esc_html( $user_id ) . '_' . esc_html( $amount ) . '_' . esc_html( $key );

		if ( false === ( $activities = get_transient( $transient_id ) ) ) {

			$args = array(
				'timeout' => 30,
			);

			$url = 'https://www.googleapis.com/plus/v1/people/' . esc_html( $user_id ) . '/activities/public?maxResults=' . esc_html( $amount ) . '&fields=items&key=' . esc_html( $api_key );
			$data = json_decode( wp_remote_retrieve_body( wp_remote_get( $url, $args ) ), true );
			
			//print_r($data);
		
			if ( isset( $data['items'] ) ) {
				$activities_data = $data['items'];
				$activities = array();

				foreach ( $activities_data as $post ) {
					$activities[] = array(			
						'created_time' 	=> $post['published'],			
						'username' 		=> $post['actor']['displayName'],
						'user_url' 		=> $post['actor']['url'],
						'user_avatar' 	=> $post['actor']['image'],
						'text' 			=> $post['object']['content'],
						'url' 			=> $post['url'],
						'comment_count' => $post['object']['replies']['totalItems'],
						'plus_count' 	=> $post['object']['plusoners']['totalItems'],
						'share_count' 	=> $post['object']['resharers']['totalItems'],
						'attachment'	=> $post['object']['attachments'], 
							// foreach = ['attachments']['0-X']['image']['url']
							// foreach = ['attachments']['0-X']['displayName']
							// foreach = ['attachments']['0-X']['objectType']
					);
				}

				set_transient( $transient_id, $activities, 12 * HOUR_IN_SECONDS );

			} elseif( isset( $data['error']['message'] ) ) {
				// error message
				$data_status = $data['error']['message'];
				echo '<div class="alert alert-warning">' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $data_status . '</div>';
				
			} else {
				$activities = false;
			}

		}

		?>

		<div class="google-plus-widget">
		
			<?php if ( $activities ) : ?>
				<ul>
				<?php foreach ( $activities as $post ) : ?>
					<li class="google-plus-item">
					
						<div class="gp-image">
						
							<a rel="nofollow" href="<?php echo esc_url( $post['user_url'] ); ?>" target="_blank">
								<img class="gp-avatar" src="<?php echo esc_url( implode('', $post['user_avatar']) ); ?>" alt="<?php echo esc_attr( $post['username'] ); ?>">
							</a>

							<div class="gp-user">
								<a target="_blank" href="<?php echo esc_url( $post['user_url'] ); ?>"><?php echo esc_html( $post['username'] ); ?></a>
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
					
						<div class="gp-content">
						
							<?php if( isset( $post['text'] ) ? $post['text'] : '' ) { ?>
								<div class="gp-text">
									<?php echo $post['text']; ?>
								</div>
							<?php } ?>
							
							<?php
								// get attachment type
								foreach( $post['attachment'] as $att_type ) {
									if( $att_type['objectType'] == 'article' ) {
										$att_article = true;
									} else {
										$att_article = false;
									}
								}
							?>
														
							<?php if( ! 'true' == $instance[ 'attachment' ] ) { ?>
							
								<?php if( isset( $post['media'] ) ? $post['media'] : '' || isset( $post['attachment'] ) ? $post['attachment'] : '' ) { ?>
								
									<?php if( $att_article == true ) { ?>
										<div class="gp-attachment">
									<?php } ?>
									
											<?php if( ! 'true' == $instance[ 'media' ] ) { 
												if( isset( $post['attachment'] ) ? $post['attachment'] : '' ) { ?>
												<div class="gp-media">
													<?php 
														// get image
														$image = '';
														foreach( $post['attachment'] as $post_att ) {
															$image .= '<a rel="nofollow" target="_blank" href="' . esc_url( $post_att['url'] ) . '"><img src="' . esc_url( $post_att['image']['url'] ) . '" alt=""></a>';
														}
														echo $image; 
													?>
												</div>
											<?php }
											} ?>

											<?php
												// get title
												$title = '';
												foreach( $post['attachment'] as $post_att ) {
													if( $post_att['objectType'] == 'article' ) {
														$title .= '<div class="gp-attachment-title"><a rel="nofollow" target="_blank" href="' . esc_url( $post_att['url'] ) . '">' . esc_html( $post_att['displayName'] ) . '</a></div>';
													}
												}
												echo $title;
											?>
										
									<?php if( $att_article == true ) { ?>
										</div>
									<?php } ?>
									
								<?php } ?>
								
							<?php } ?>
							
							<?php if( ! 'true' == $instance[ 'likes_count' ] || ! 'true' == $instance[ 'comments_count' ] ) { ?>
								<div class="gp-counts">
									<?php if( ! 'true' == $instance[ 'likes_count' ] ) { ?>
										<span><i class="fa fa-thumbs-o-up"></i> <?php echo esc_html( $post['plus_count'] ) . ' ' . esc_html__( 'Likes', 'hannah-cd' ); ?></span>
									<?php } ?>
									<?php if( ! 'true' == $instance[ 'comments_count' ] ) { ?>
										<span><i class="fa fa-comment-o"></i> <?php echo esc_html( $post['comment_count'] ) . ' ' . esc_html__( 'Comments', 'hannah-cd' ); ?></span>
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
		$instance['user_id'] = strip_tags( $new_instance['user_id'] );
		$instance['api_key'] = strip_tags( $new_instance['api_key'] );
		$instance['likes_count'] = ( ! empty( $new_instance['likes_count'] ) ) ? strip_tags( $new_instance['likes_count'] ) : '';
		$instance['comments_count'] = ( ! empty( $new_instance['comments_count'] ) ) ? strip_tags( $new_instance['comments_count'] ) : '';
		$instance['media'] = ( ! empty( $new_instance['media'] ) ) ? strip_tags( $new_instance['media'] ) : '';
		$instance['attachment'] = ( ! empty( $new_instance['attachment'] ) ) ? strip_tags( $new_instance['attachment'] ) : '';

		return $instance;

	}

	/* Backend Widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'Google Plus Posts';
		if ( isset( $instance[ 'amount' ] ) ) $amount = $instance[ 'amount' ]; 
			else $amount = '5';
		if ( isset( $instance[ 'user_id' ] ) ) $user_id = $instance[ 'user_id' ]; 
			else $user_id = '';
		if ( isset( $instance[ 'api_key' ] ) ) $api_key = $instance[ 'api_key' ]; 
			else $api_key = '';
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
			<label for="<?php echo esc_attr( $this->get_field_id( 'user_id' ) ); ?>">
				<?php 
					esc_html_e( 'Google Plus', 'hannah-cd' ); 
					echo ' ';
					esc_html_e( 'User ID', 'hannah-cd' ); 
				?>: 
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'user_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'user_id' ) ); ?>" type="text" value="<?php echo esc_attr( $user_id ); ?>" />
			<br>
			<small><?php esc_html_e( 'Page URL', 'hannah-cd' ); ?>: https://plus.google.com/.../[ID]</small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'api_key' ) ); ?>">
				<?php 
					esc_html_e( 'Google Plus', 'hannah-cd' );
					echo ' ';
					esc_html_e( 'API Key', 'hannah-cd' ); 
				?>: ( <a href="//developers.google.com/places/web-service/get-api-key" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'api_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'api_key' ) ); ?>" type="text" value="<?php echo esc_attr( $api_key ); ?>" />
		</p>
		<?php 

	}

}