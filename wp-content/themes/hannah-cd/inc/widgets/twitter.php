<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_twitter_widget" );' ) );

class hannah_Cd_Twitter_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_twitter_widget',
			'&#10026; ' . esc_html__( 'Twitter Feed', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show the latest twitter tweets of a user.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$widget_id = $this->id;
		
		$amount = $instance['amount'];
		$media = $instance['media'] ? 'true' : 'false';
		$likes_count = $instance['likes_count'] ? 'true' : 'false';
		$retweet_count = $instance['retweet_count'] ? 'true' : 'false';
		$tweet_hashtags = $instance['tweet_hashtags'] ? 'true' : 'false';
		
		require_once( get_template_directory() . '/inc/widgets/twitter-api-exchange.php' );
		$username = $instance['username'];
		$access_token = $instance['access_token'];
		$access_token_secret = $instance['access_token_secret'];
		$consumer_key = $instance['consumer_key'];
		$consumer_secret = $instance['consumer_secret'];

		// Get access tokens and keys -> https://dev.twitter.com/apps/
		$settings = array(
			'oauth_access_token' 		=> $access_token,
			'oauth_access_token_secret' => $access_token_secret,
			'consumer_key' 				=> $consumer_key,
			'consumer_secret' 			=> $consumer_secret
		);		

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */

		// GET TWITTER DATA FROM USER
		// Get the most recent tweets from a users timeline. --> /1.1/statuses/user_timeline.json
		// https://dev.twitter.com/rest/reference/get/statuses/user_timeline
		
		$token = substr( $access_token, 10 ) . substr( $access_token_secret, 10 ) . substr( $consumer_key, 10 ) . substr( $consumer_secret, 10 ); // trim the access tokens
		$transient_id = 'my_twitter_transient_' . esc_html( $username ) . '_' . esc_html( $amount ) . '_token_' . esc_html( $token ) . '_instance_' . $widget_id;

		if ( false === ( $tweets = get_transient( $transient_id ) ) ) {
		
			$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
			$url_fields = '?tweet_mode=extended&screen_name=' . esc_html( $username ) . '&count=' . esc_html( $amount );
			$requestMethod = "GET";
			$twitter = new TwitterAPIExchange( $settings );
			$data = json_decode( $twitter->setGetfield( $url_fields )->buildOauth( $url, $requestMethod )->performRequest(), $assoc = TRUE );
			
			//print_r($data);
			
			if ( isset( $data ) && ! isset( $data['errors'] ) ) {
				
				$twitter_data = $data;
				$tweets = array();

				foreach ( $twitter_data as $tweet ) {
					$tweets[] = array(
						'created_at' 	=> $tweet['created_at'],
						'text' 			=> $tweet['full_text'],
						'hashtags' 		=> isset( $tweet['entities']['hashtags'] ) ? $tweet['entities']['hashtags'] : '', 
							// foreach = ['hashtags']['0-X']['text']
						'image' 		=> isset( $tweet['entities']['media'] ) ? $tweet['entities']['media'] : '', 
							// foreach = ['media']['0-X']['media_url_https']
						'urls' 			=> $tweet['entities']['urls'], 
							// foreach = ['urls']['0-X']['url']
						'username' 		=> $tweet['user']['name'],
						'screen_name' 	=> $tweet['user']['screen_name'],
						'user_avatar' 	=> $tweet['user']['profile_image_url_https'],
						'retweet' 		=> $tweet['retweet_count'],
						'likes' 		=> $tweet['favorite_count'],
					);
				}

				set_transient( $transient_id, $tweets, 12 * HOUR_IN_SECONDS );

			} elseif( isset( $data['errors']['0']['message'] ) ) {
				
				// error message
				$data_status = $data['errors']['0']['message'];
				echo '<div class="alert alert-warning">' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $data_status . '</div>';
				
			} else {
				$tweets = false;
			}

		}

		?>

		<div class="twitter-widget">
			<?php if ( $tweets ) : ?>
				<ul>
				<?php foreach ( $tweets as $tweet ) : ?>
					<li class="twitter-item">
					
						<div class="tweet-image">
						
							<a rel="nofollow" href="https://twitter.com/<?php echo esc_html( $tweet['screen_name'] ); ?>" target="_blank">
								<img class="tweet-avatar" src="<?php echo esc_url( $tweet['user_avatar'] ); ?>" alt="<?php echo esc_attr( $tweet['username'] ); ?>">
							</a>

							<div class="tweet-user">
								<a target="_blank" href="https://twitter.com/<?php echo esc_html( $tweet['screen_name'] ); ?>"><?php echo esc_html( $tweet['username'] ); ?></a>
								<span>
									<?php 
										$wp_date_format = get_option('date_format');   
										$wp_time_format = get_option('time_format');

										$date = strtotime( $tweet['created_at'] );
										echo date( $wp_date_format . ' ' . $wp_time_format, esc_html( $date ) );
									?>
								</span>
							</div>
							
						</div>
						
						<div class="tweet-content">
						
							<?php 
								if( isset( $tweet['text'] ) ) {
									$excerpt = $tweet['text'];

									// removing the urls and hashtags from the text string
									$find = array('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', '/#\S+ */');
									$replace = array('', '');
									//$replace = array('<a href="$0" target="_blank" title="$0">$0</a>', '');
									$excerpt = preg_replace( $find, $replace, $excerpt );

									echo $excerpt;	
								}
		
								if( ! 'true' == $instance[ 'tweet_hashtags' ] ) {
									// get hashtags
									if( isset( $tweet['hashtags'] ) ? $tweet['hashtags'] : '' ) {
										$hashtags = '';
										foreach( $tweet['hashtags'] as $htag ) {
											$hashtags .= '<a target="_blank" href="https://twitter.com/hashtag/' . esc_html( $htag['text'] ) . '?src=hash">#' . esc_html( $htag['text'] ) . "</a> ";
										}
										echo $hashtags;
									}
								}
		
								if( isset( $tweet['urls'] ) ) {
									// get url
									$urls = '';
									foreach( $tweet['urls'] as $tweet_url ) {
										$urls .= '<a rel="nofollow" target="_blank" href="' . esc_url( $tweet_url['url'] ) . '">... ' . esc_html__( 'Read more', 'hannah-cd' ) . '</a>';
									}
									echo $urls;
								}
							?>
							
							<?php if( ! 'true' == $instance[ 'media' ] ) { ?>
								<div class="tweet-media">
									<?php // get images
										if( isset( $tweet['image'] ) ? $tweet['image'] : '' ) {
											$image = '';
											foreach( $tweet['image'] as $tweet_img ) {
												$image .= '<a rel="nofollow" target="_blank" href="' . esc_url( $tweet_img['url'] ) . '"><img src="' . esc_url( $tweet_img['media_url_https'] ) . '" alt=""></a>';
											}
											echo $image;
										}
									?>
								</div>
							<?php } ?>
							
							<?php if( ! 'true' == $instance[ 'likes_count' ] || ! 'true' == $instance[ 'retweet_count' ] ) { ?>
								<div class="tweet-counts">
									<?php if( ! 'true' == $instance[ 'likes_count' ] ) { 
										if( isset( $tweet['likes'] ) ) { ?>
											<span><i class="fa fa-thumbs-o-up"></i> <?php echo esc_html( $tweet['likes'] ) . ' ' . esc_html__( 'Likes', 'hannah-cd' ); ?></span>
									<?php }
									} ?>
									<?php if( ! 'true' == $instance[ 'retweet_count' ] ) { 
										if( isset( $tweet['retweet'] ) ) { ?>
											<span><i class="fa fa-retweet"></i> <?php echo esc_html( $tweet['retweet'] ) . ' ' . esc_html__( 'Retweet', 'hannah-cd' ); ?></span>
									<?php }
									} ?>
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
		$instance['media'] = ( ! empty( $new_instance['media'] ) ) ? strip_tags( $new_instance['media'] ) : '';
		$instance['likes_count'] = ( ! empty( $new_instance['likes_count'] ) ) ? strip_tags( $new_instance['likes_count'] ) : '';
		$instance['retweet_count'] = ( ! empty( $new_instance['retweet_count'] ) ) ? strip_tags( $new_instance['retweet_count'] ) : '';
		$instance['tweet_hashtags'] = ( ! empty( $new_instance['tweet_hashtags'] ) ) ? strip_tags( $new_instance['tweet_hashtags'] ) : '';
		$instance['username'] = strip_tags( $new_instance['username'] );
		$instance['access_token'] = strip_tags( $new_instance['access_token'] );
		$instance['access_token_secret'] = strip_tags( $new_instance['access_token_secret'] );
		$instance['consumer_key'] = strip_tags( $new_instance['consumer_key'] );
		$instance['consumer_secret'] = strip_tags( $new_instance['consumer_secret'] );

		return $instance;

	}

	/* Backend Widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'Twitter Tweets';
		if ( isset( $instance[ 'amount' ] ) ) $amount = $instance[ 'amount' ]; 
			else $amount = '5';
		if ( isset( $instance[ 'media' ] ) ) $media = $instance[ 'media' ]; 
			else $media = $instance[ 'media' ] = 'false';
		if ( isset( $instance[ 'likes_count' ] ) ) $likes_count = $instance[ 'likes_count' ]; 
			else $likes_count = $instance[ 'likes_count' ] = 'false';
		if ( isset( $instance[ 'retweet_count' ] ) ) $retweet_count = $instance[ 'retweet_count' ]; 
			else $retweet_count = $instance[ 'retweet_count' ] = 'false';
		if ( isset( $instance[ 'tweet_hashtags' ] ) ) $tweet_hashtags = $instance[ 'tweet_hashtags' ]; 
			else $tweet_hashtags = $instance[ 'tweet_hashtags' ] = 'false';
		if ( isset( $instance[ 'username' ] ) ) $username = $instance[ 'username' ]; 
			else $username = '';
		if ( isset( $instance[ 'access_token' ] ) ) $access_token = $instance[ 'access_token' ]; 
			else $access_token = '';
		if ( isset( $instance[ 'access_token_secret' ] ) ) $access_token_secret = $instance[ 'access_token_secret' ]; 
			else $access_token_secret = '';
		if ( isset( $instance[ 'consumer_key' ] ) ) $consumer_key = $instance[ 'consumer_key' ]; 
			else $consumer_key = '';
		if ( isset( $instance[ 'consumer_secret' ] ) ) $consumer_secret = $instance[ 'consumer_secret' ]; 
			else $consumer_secret = '';

		?>
		<p>
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
			<input class="checkbox" <?php if ( isset( $tweet_hashtags ) && $tweet_hashtags == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'tweet_hashtags' ); ?>" name = "<?php echo $this->get_field_name( 'tweet_hashtags' ); ?>" value = "true" type = "checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'tweet_hashtags' ) ); ?>">
				<?php esc_html_e( 'Hide Hashtags', 'hannah-cd' ); ?>
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
			<input class="checkbox" <?php if ( isset( $retweet_count ) && $retweet_count == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'retweet_count' ); ?>" name = "<?php echo $this->get_field_name( 'retweet_count' ); ?>" value = "true" type = "checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'retweet_count' ) ); ?>">
				<?php esc_html_e( 'Hide Retweet Count', 'hannah-cd' ); ?>
			</label> 
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>">
				<?php 
					esc_html_e( 'Twitter', 'hannah-cd' ); 
					echo ' ';
					esc_html_e( 'Username', 'hannah-cd' ); 
				?>:
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
			<br>
			<small><?php esc_html_e( 'Page URL', 'hannah-cd' ); ?>: https://twitter.com/[Username]</small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>">
				<?php 
					esc_html_e( 'Twitter', 'hannah-cd' ); 
					echo ' ';
					esc_html_e( 'Access Token', 'hannah-cd' ); 
				?>: ( <a href="//developer.twitter.com/en/docs/basics/authentication/guides/access-tokens" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $access_token ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'access_token_secret' ) ); ?>">
				<?php 
					esc_html_e( 'Twitter', 'hannah-cd' ); 
					echo ' ';
					esc_html_e( 'Access Token Secret', 'hannah-cd' ); 
				?>: ( <a href="//developer.twitter.com/en/docs/basics/authentication/guides/access-tokens" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'access_token_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'access_token_secret' ) ); ?>" type="text" value="<?php echo esc_attr( $access_token_secret ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>">
				<?php 
					esc_html_e( 'Twitter', 'hannah-cd' ); 
					echo ' ';
					esc_html_e( 'Consumer Key', 'hannah-cd' ); 
				?>: ( <a href="//developer.twitter.com/en/docs/basics/authentication/guides/access-tokens" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumer_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_key' ) ); ?>" type="text" value="<?php echo esc_attr( $consumer_key ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>">
				<?php 
					esc_html_e( 'Twitter', 'hannah-cd' ); 
					echo ' ';
					esc_html_e( 'Consumer Key Secret', 'hannah-cd' ); 
				?>: ( <a href="//developer.twitter.com/en/docs/basics/authentication/guides/access-tokens" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'consumer_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'consumer_secret' ) ); ?>" type="text" value="<?php echo esc_attr( $consumer_secret ); ?>" />
		</p>
		<?php 

	}

}