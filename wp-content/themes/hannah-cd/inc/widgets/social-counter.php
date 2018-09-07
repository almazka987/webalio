<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_social_counter_widget" );' ) );

class hannah_Cd_Social_Counter_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_social_counter_widget',
			'&#10026; ' . esc_html__( 'Social Counter', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show the follower count of your social profiles.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$column = $instance['column'];   
		$style = $instance['style'];
		$fans_count = $instance['fans_count'] ? 'true' : 'false';
		$comments_count = $instance['comments_count'] ? 'true' : 'false';
		$posts_count = $instance['posts_count'] ? 'true' : 'false';
		
		$nl_count = $instance['nl_count'];
		
		// facebook
		$fb_id = $instance['fb_id'];
		$app_id = $instance['app_id'];
		$app_secret_code = $instance['app_secret_code'];
		$access_token = $app_id . '|' . $app_secret_code; // https://developers.facebook.com/tools/accesstoken
			
		// google plus
		$gp_user_id = $instance['gp_user_id'];
		$gp_api_key = $instance['gp_api_key'];
		
		// youtube
		$yt_channel_id = $instance['yt_channel_id'];
		$yt_api_key = $instance['yt_api_key'];
		
		// twitter
		require_once( get_template_directory() . '/inc/widgets/twitter-api-exchange.php' );
		$tw_username = $instance['tw_username'];
		$tw_access_token = $instance['tw_access_token'];
		$tw_access_token_secret = $instance['tw_access_token_secret'];
		$tw_consumer_key = $instance['tw_consumer_key'];
		$tw_consumer_secret = $instance['tw_consumer_secret'];
		$tw_settings = array(
			'oauth_access_token' 		=> $tw_access_token,
			'oauth_access_token_secret' => $tw_access_token_secret,
			'consumer_key' 				=> $tw_consumer_key,
			'consumer_secret' 			=> $tw_consumer_secret
		);
		
		// pinterest
		$pin_access_token = $instance['pin_access_token'];
		
		// instagram
		$inst_access_token = $instance['inst_access_token'];
		$inst_username = '';
		if ( $inst_access_token && $inst_access_token !== '' ) {
			$inst_username = explode( '.', $inst_access_token );
			$inst_username = $inst_username[0];
		}
		
		// vimeo
		$vim_user_id = $instance['vim_user_id'];
		$vim_access_token = $instance['vim_access_token'];
		
		// dribbble
		$dri_user_id = $instance['dri_user_id'];
		$dri_access_token = $instance['dri_access_token'];
		
		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */
		
		// FACEBOOK DATA
		// *************************************************************************

		$token_fb = substr( $access_token, 30 ); // trim the access token
		$transient_id_fb = 'my_social_counter_transient_fb_' . esc_html( $fb_id ) . '_token_' . esc_html( $token_fb );

		if ( false === ( $fb_data = get_transient( $transient_id_fb ) ) ) {

			$args = array(
				'timeout' => 30,
			);

			if( $fb_id && $app_id && $app_secret_code ) {
				$fb_url = 'https://graph.facebook.com/v2.10/' . esc_html( $fb_id ) . '?fields=fan_count,link&access_token=' . esc_html( $access_token );			
				$fb_get_data = json_decode( wp_remote_retrieve_body( wp_remote_get( $fb_url, $args ) ), true );
			}
			
			//print_r($fb_get_data);

			if ( isset( $fb_get_data['fan_count'] ) ) {

				$fb_data = array(
					'fb_fan_count' => $fb_get_data['fan_count'],
					'fb_link' => $fb_get_data['link'],
				);

				set_transient( $transient_id_fb, $fb_data, 12 * HOUR_IN_SECONDS );

			} elseif( isset( $fb_get_data['error']['message'] ) ) {

				$fb_data_status = $fb_get_data['error']['message'];
				$fb_error = esc_html__( 'Facebook', 'hannah-cd' ) . ' ' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $fb_data_status;

			} else {

				$fb_data = false;

			}

		}

		// GOOGLE PLUS DATA
		// *************************************************************************

		$token_gp = substr( $gp_api_key, 30 ); // trim the access token
		$transient_id_gp = 'my_social_counter_transient_gb_' . esc_html( $gp_user_id ) . '_token_' . esc_html( $token_gp );

		if ( false === ( $gp_data = get_transient( $transient_id_gp ) ) ) {

			$args = array(
				'timeout' => 30,
			);

			if( $gp_user_id && $gp_api_key ) { 
				$gp_url = 'https://www.googleapis.com/plus/v1/people/' . esc_html( $gp_user_id ) . '?key=' . esc_html( $gp_api_key );
				$gp_get_data = json_decode( wp_remote_retrieve_body( wp_remote_get( $gp_url, $args ) ), true );
			}

			if ( isset( $gp_get_data['circledByCount'] ) ) {

				$gp_data = array(
					'gp_plusone_count' => $gp_get_data['circledByCount'],
					'gp_link' => $gp_get_data['url']
				);

				set_transient( $transient_id_gp, $gp_data, 12 * HOUR_IN_SECONDS );

			} elseif( isset( $gp_get_data['error']['message'] ) ) {
				
				$gp_data_status = $gp_get_data['error']['message'];
				$gp_error = esc_html__( 'Google Plus', 'hannah-cd' ) . ' ' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $gp_data_status;
				
			} else {

				$gp_data = false;

			}

		}

		// YOUTUBE DATA
		// *************************************************************************

		$token_yt = substr( $yt_api_key, 30 ); // trim the access token
		$transient_id_yt = 'my_social_counter_transient_yt_' . esc_html( $yt_channel_id ) . '_token_' . esc_html( $token_yt );

		if ( false === ( $yt_data = get_transient( $transient_id_yt ) ) ) {

			$args = array(
				'timeout' => 30,
			);

			if( $yt_channel_id && $yt_api_key ) {
				$yt_url = 'https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=' . esc_html( $yt_channel_id ) . '&key=' . esc_html( $yt_api_key );
				$yt_get_data = json_decode( wp_remote_retrieve_body( wp_remote_get( $yt_url, $args ) ), true );
			}

			if ( isset( $yt_get_data['items'][0]['statistics']['subscriberCount'] ) ) {

				$yt_data = array(
					'yt_follower_count' => $yt_get_data['items'][0]['statistics']['subscriberCount'],
					'yt_link' => $yt_get_data['items'][0]['id']
				);

				set_transient( $transient_id_yt, $yt_data, 12 * HOUR_IN_SECONDS );

			} elseif( isset( $yt_get_data['error']['errors']['0']['message'] ) ) {
				
				$yt_data_status = $yt_get_data['error']['errors']['0']['message'];
				$yt_error = esc_html__( 'YouTube', 'hannah-cd' ) . ' ' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $yt_data_status;
				
			} else {

				$yt_data = false;

			}

		}

		// TWITTER DATA
		// *************************************************************************

		$token_tw = substr( $tw_access_token, 10 ) . substr( $tw_access_token_secret, 10 ) . substr( $tw_consumer_key, 10 ) . substr( $tw_consumer_secret, 10 ); // trim the access tokens
		$transient_id_tw = 'my_social_counter_transient_tw_' . esc_html( $tw_username ) . '_token_' . esc_html( $token_tw );

		if ( false === ( $tw_data = get_transient( $transient_id_tw ) ) ) {

			$args = array(
				'timeout' => 30,
			);

			if( $tw_username && $tw_access_token && $tw_access_token_secret && $tw_consumer_key && $tw_consumer_secret ) {
				$tw_url = "https://api.twitter.com/1.1/users/lookup.json";
				$tw_url_fields = '?screen_name=' . esc_html( $tw_username );
				$tw_requestMethod = "GET";
				$tw_twitter = new TwitterAPIExchange( $tw_settings );
				$tw_get_data = json_decode( $tw_twitter->setGetfield( $tw_url_fields )->buildOauth( $tw_url, $tw_requestMethod )->performRequest(), $assoc = TRUE );
			}

			if ( isset( $tw_get_data[0]['followers_count'] ) ) {

				$tw_data = array(
					'tw_follower_count' => $tw_get_data[0]['followers_count'],
					'tw_name' => $tw_get_data[0]['screen_name']
				);

				set_transient( $transient_id_tw, $tw_data, 12 * HOUR_IN_SECONDS );

			} elseif( isset( $tw_get_data['errors']['0']['message'] ) ) {
				
				$tw_data_status = $tw_get_data['errors']['0']['message'];
				$tw_error = esc_html__( 'Twitter', 'hannah-cd' ) . ' ' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $tw_data_status;
				
			} else {

				$tw_data = false;

			}

		}

		// PINTEREST DATA
		// *************************************************************************

		$token_pin = substr( $pin_access_token, 30 ); // trim the access token
		$transient_id_pin = 'my_social_counter_transient_pin_' . esc_html( $token_pin );

		if ( false === ( $pin_data = get_transient( $transient_id_pin ) ) ) {

			$args = array(
				'timeout' => 30,
			);

			if( $pin_access_token ) {
				$pin_url = 'https://api.pinterest.com/v1/me/?access_token=' . esc_html( $pin_access_token ) . '&fields=url,counts,bio,image,username';
				$pin_get_data = json_decode( wp_remote_retrieve_body( wp_remote_get( $pin_url, $args ) ), true );
			}

			if ( isset( $pin_get_data['data']['counts']['followers'] ) ) {

				$pin_data = array(
					'pin_follower_count' => $pin_get_data['data']['counts']['followers'],
					'pin_link' => $pin_get_data['data']['url']
				);

				set_transient( $transient_id_pin, $pin_data, 12 * HOUR_IN_SECONDS );

			} elseif( isset( $pin_get_data['message'] ) ) {
				
				$pin_data_status = $pin_get_data['message'];
				$pin_error = esc_html__( 'Pinterest', 'hannah-cd' ) . ' ' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $pin_data_status;
				
			} else {

				$pin_data = false;

			}

		}

		// INSTAGRAM DATA
		// *************************************************************************

		$token_inst = substr( $inst_access_token, 30 ); // trim the access token
		$transient_id_inst = 'my_social_counter_transient_inst_' . esc_html( $token_inst );

		if ( false === ( $inst_data = get_transient( $transient_id_inst ) ) ) {

			$args = array(
				'timeout' => 30,
			);

			if( $inst_access_token ) {
				$inst_url = 'https://api.instagram.com/v1/users/' . esc_html( $inst_username ) . '/?access_token=' . esc_html( $inst_access_token );
				$inst_get_data = json_decode( wp_remote_retrieve_body( wp_remote_get( $inst_url, $args ) ), true );
			}

			if ( isset( $inst_get_data['data']['counts']['followed_by'] ) ) {

				$inst_data = array(
					'inst_follower_count' => $inst_get_data['data']['counts']['followed_by'],
					'inst_name' => $inst_get_data['data']['username']
				);

				set_transient( $transient_id_inst, $inst_data, 12 * HOUR_IN_SECONDS );

			} elseif( isset( $inst_get_data['meta']['error_message'] ) ) {
				
				$inst_data_status = $inst_get_data['meta']['error_message'];
				$inst_error = esc_html__( 'Instagram', 'hannah-cd' ) . ' ' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $inst_data_status;
				
			} else {

				$inst_data = false;

			}

		}

		// VIMEO DATA
		// *************************************************************************

		$token_vim = substr( $vim_access_token, 30 ); // trim the access token
		$transient_id_vim = 'my_social_counter_transient_vim_' . esc_html( $vim_user_id ) . '_token_' . esc_html( $token_vim );

		if ( false === ( $vim_data = get_transient( $transient_id_vim ) ) ) {

			$args = array(
				'timeout' => 30,
			);

			if( $vim_user_id && $vim_access_token ) {
				$vim_url = 'https://api.vimeo.com/users/' . esc_html( $vim_user_id ) . '/?access_token=' . esc_html( $vim_access_token );
				$vim_get_data = json_decode( wp_remote_retrieve_body( wp_remote_get( $vim_url, $args ) ), true );
			}

			if ( isset( $vim_get_data['metadata']['connections']['followers']['total'] ) ) {

				$vim_data = array(
					'vim_follower_count' => $vim_get_data['metadata']['connections']['followers']['total'],
					'vim_link' => $vim_get_data['link']
				);

				set_transient( $transient_id_vim, $vim_data, 12 * HOUR_IN_SECONDS );

			} elseif( isset( $vim_get_data['error'] ) ? $vim_get_data['error'] : '' ) {
				
				$vim_data_status = $vim_get_data['error'];
				$vim_error = esc_html__( 'Vimeo', 'hannah-cd' ) . ' ' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $vim_data_status;
				
			} else {

				$vim_data = false;

			}

		}

		// DRIBBBLE DATA
		// *************************************************************************

		$token_dri = substr( $dri_access_token, 30 ); // trim the access token
		$transient_id_dri = 'my_social_counter_transient_dri_' . esc_html( $dri_user_id ) . '_token_' . esc_html( $token_dri );

		if ( false === ( $dri_data = get_transient( $transient_id_dri ) ) ) {

			$args = array(
				'timeout' => 30,
			);

			if( $dri_user_id && $dri_access_token ) {
				$dri_url = 'https://api.dribbble.com/v1/users/' . esc_html( $dri_user_id ) . '/?access_token=' . esc_html( $dri_access_token );
				$dri_get_data = json_decode( wp_remote_retrieve_body( wp_remote_get( $dri_url, $args ) ), true );
			}

			if ( isset( $dri_get_data['followers_count'] ) ) {

				$dri_data = array(
					'dri_follower_count' => $dri_get_data['followers_count'],
					'dri_link' => $dri_get_data['html_url']
				);

				set_transient( $transient_id_dri, $dri_data, 12 * HOUR_IN_SECONDS );

			} elseif( isset( $dri_get_data['message'] ) ) {
				
				$dri_data_status = $dri_get_data['message'];
				$dri_error = esc_html__( 'Dribbble', 'hannah-cd' ) . ' ' . esc_html__( 'Error', 'hannah-cd' ) . ': ' . $dri_data_status;
				
			} else {

				$dri_data = false;

			}

		}

		?>

		<div class="social-counter-widget colored <?php if( $column == 'column_2' ) { ?>column-2<?php } elseif( $column == 'column_3' ) { ?>column-3<?php } ?> <?php if( $style == 'style_2' ) { ?>style-2<?php } else { ?>style-1<?php } ?>">
			<ul>
			
				<?php if( $fb_id && $app_id && $app_secret_code ) { ?>
					<li class="social-counter-item fa-facebook">
						<a rel="nofollow" target="_blank" href="<?php echo esc_url( $fb_data['fb_link'] ); ?>" title="<?php echo esc_html__( 'Facebook', 'hannah-cd' ); ?>">
							<span class="sc-icon fa fa-facebook"></span>
							<span class="sc-count"><?php echo hannah_cd_format_count( esc_html( $fb_data['fb_fan_count'] ) ); ?></span>
							<span class="sc-type"><?php echo esc_html__( 'Fans', 'hannah-cd' ); ?></span>
							<span class="sc-icon-hover"><i class="fa fa-facebook"></i></span>
						</a>
					</li>
				<?php } ?>
				
				<?php if( $gp_user_id && $gp_api_key ) { ?>
					<li class="social-counter-item fa-google-plus">
						<a rel="nofollow" target="_blank" href="<?php echo esc_url( $gp_data['gp_link'] ); ?>" title="<?php echo esc_html__( 'Google Plus', 'hannah-cd' ); ?>">
							<span class="sc-icon fa fa-google-plus"></span>
							<span class="sc-count"><?php echo hannah_cd_format_count( esc_html( $gp_data['gp_plusone_count'] ) ); ?></span>
							<span class="sc-type"><?php echo esc_html__( 'Follower', 'hannah-cd' ); ?></span>
							<span class="sc-icon-hover"><i class="fa fa-google-plus"></i></span>
						</a>
					</li>
				<?php } ?>
				
				<?php if( $tw_username && $tw_access_token && $tw_access_token_secret && $tw_consumer_key && $tw_consumer_secret ) { ?>
					<li class="social-counter-item fa-twitter">
						<a rel="nofollow" target="_blank" href="https://twitter.com/<?php echo esc_html( $tw_data['tw_name'] ); ?>" title="<?php echo esc_html__( 'Twitter', 'hannah-cd' ); ?>">
							<span class="sc-icon fa fa-twitter"></span>
							<span class="sc-count"><?php echo hannah_cd_format_count( esc_html( $tw_data['tw_follower_count'] ) ); ?></span>
							<span class="sc-type"><?php echo esc_html__( 'Follower', 'hannah-cd' ); ?></span>
							<span class="sc-icon-hover"><i class="fa fa-twitter"></i></span>
						</a>
					</li>
				<?php } ?>
				
				<?php if( $yt_channel_id && $yt_api_key ) { ?>
					<li class="social-counter-item fa-youtube">
						<a rel="nofollow" target="_blank" href="https://www.youtube.com/channel/<?php echo esc_html( $yt_data['yt_link'] ); ?>" title="<?php echo esc_html__( 'YouTube', 'hannah-cd' ); ?>">
							<span class="sc-icon fa fa-youtube"></span>
							<span class="sc-count"><?php echo hannah_cd_format_count( esc_html( $yt_data['yt_follower_count'] ) ); ?></span>
							<span class="sc-type"><?php echo esc_html__( 'Subscribers', 'hannah-cd' ); ?></span>
							<span class="sc-icon-hover"><i class="fa fa-youtube"></i></span>
						</a>
					</li>
				<?php } ?>
				
				<?php if( $inst_access_token ) { ?>
					<li class="social-counter-item fa-instagram">
						<a rel="nofollow" target="_blank" href="https://www.instagram.com/<?php echo esc_html( $inst_data['inst_name'] ); ?>" title="<?php echo esc_html__( 'Instagram', 'hannah-cd' ); ?>">
							<span class="sc-icon fa fa-instagram"></span>
							<span class="sc-count"><?php echo hannah_cd_format_count( esc_html( $inst_data['inst_follower_count'] ) ); ?></span>
							<span class="sc-type"><?php echo esc_html__( 'Follower', 'hannah-cd' ); ?></span>
							<span class="sc-icon-hover"><i class="fa fa-instagram"></i></span>
						</a>
					</li>
				<?php } ?>
				
				<?php if( $pin_access_token ) { ?>
					<li class="social-counter-item fa-pinterest">
						<a rel="nofollow" target="_blank" href="<?php echo esc_url( $pin_data['pin_link'] ); ?>" title="<?php echo esc_html__( 'Pinterest', 'hannah-cd' ); ?>">
							<span class="sc-icon fa fa-pinterest"></span>
							<span class="sc-count"><?php echo hannah_cd_format_count( esc_html( $pin_data['pin_follower_count'] ) ); ?></span>
							<span class="sc-type"><?php echo esc_html__( 'Follower', 'hannah-cd' ); ?></span>
							<span class="sc-icon-hover"><i class="fa fa-pinterest"></i></span>
						</a>
					</li>
				<?php } ?>
				
				<?php if( $vim_user_id && $vim_access_token ) { ?>
					<li class="social-counter-item fa-vimeo">
						<a rel="nofollow" target="_blank" href="<?php echo esc_url( $vim_data['vim_link'] ); ?>" title="<?php echo esc_html__( 'Vimeo', 'hannah-cd' ); ?>">
							<span class="sc-icon fa fa-vimeo"></span>
							<span class="sc-count"><?php echo hannah_cd_format_count( esc_html( $vim_data['vim_follower_count'] ) ); ?></span>
							<span class="sc-type"><?php echo esc_html__( 'Follower', 'hannah-cd' ); ?></span>
							<span class="sc-icon-hover"><i class="fa fa-vimeo"></i></span>
						</a>
					</li>
				<?php } ?>
				
				<?php if( $dri_user_id && $dri_access_token ) { ?>
					<li class="social-counter-item fa-dribbble">
						<a rel="nofollow" target="_blank" href="<?php echo esc_url( $dri_data['dri_link'] ); ?>" title="<?php echo esc_html__( 'Dribbble', 'hannah-cd' ); ?>">
							<span class="sc-icon fa fa-dribbble"></span>
							<span class="sc-count"><?php echo hannah_cd_format_count( esc_html( $dri_data['dri_follower_count'] ) ); ?></span>
							<span class="sc-type"><?php echo esc_html__( 'Follower', 'hannah-cd' ); ?></span>
							<span class="sc-icon-hover"><i class="fa fa-dribbble"></i></span>
						</a>
					</li>
				<?php } ?>
				
				<?php if( ! empty( $nl_count ) ) { ?>
					<li class="social-counter-item fa-envelope-o">
						<a rel="nofollow" target="_blank" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html__( 'Newsletter', 'hannah-cd' ); ?>">
							<span class="sc-icon fa fa-envelope-o"></span>
							<span class="sc-count"><?php echo hannah_cd_format_count( esc_html( $nl_count ) ); ?></span>
							<span class="sc-type"><?php echo esc_html__( 'Subscribers', 'hannah-cd' ); ?></span>
							<span class="sc-icon-hover"><i class="fa fa-envelope-o"></i></span>
						</a>
					</li>
				<?php } ?>
				
				<?php if( ! 'true' == $instance[ 'fans_count' ] ) { ?>
					<li class="social-counter-item fa-heart-o">
						<a rel="nofollow" target="_blank" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_html__( 'Total Fans', 'hannah-cd' ); ?>">
							<span class="sc-icon fa fa-heart-o"></span>
							<span class="sc-count">
								<?php 
									if( isset( $fb_data['fb_fan_count'] ) ) $count_1 = $fb_data['fb_fan_count'];
									else $count_1 = 0;
																   
									if( isset( $gp_data['gp_plusone_count'] ) ) $count_2 = $gp_data['gp_plusone_count'];
									else $count_2 = 0;
																   
									if( isset( $tw_data['tw_follower_count'] ) ) $count_3 = $tw_data['tw_follower_count'];
									else $count_3 = 0;
																   
									if( isset( $yt_data['yt_follower_count'] ) ) $count_4 = $yt_data['yt_follower_count'];
									else $count_4 = 0;
																   
									if( isset( $inst_data['inst_follower_count'] ) ) $count_5 = $inst_data['inst_follower_count'];
									else $count_5 = 0;
																   
									if( isset( $pin_data['pin_follower_count'] ) ) $count_6 = $pin_data['pin_follower_count'];
									else $count_6 = 0;
																   
									if( isset( $vim_data['vim_follower_count'] ) ) $count_7 = $vim_data['vim_follower_count'];
									else $count_7 = 0;
																   
									if( isset( $dri_data['dri_follower_count'] ) ) $count_8 = $dri_data['dri_follower_count'];
									else $count_8 = 0;
																   
									if( ! empty( $nl_count ) ) $count_9 = $nl_count;
									else $count_9 = 0;					   
																   
									echo hannah_cd_format_count( esc_html( 
										$count_1 + $count_2 + $count_3 + $count_4 + $count_5 + $count_6 + $count_7 + $count_8 + $count_9
									) );
								?>
							</span>
							<span class="sc-type"><?php echo esc_html__( 'Fans', 'hannah-cd' ); ?></span>
							<span class="sc-icon-hover"><i class="fa fa-heart-o"></i></span>
						</a>
					</li>
				<?php } ?>
				
				<?php if( ! 'true' == $instance[ 'comments_count' ] ) { ?>
					<li class="social-counter-item fa-comment-o">
						<?php 
							$comments = wp_count_comments();
							$comment_count = $comments->total_comments
						?>
						<a rel="nofollow" target="_blank" href="#" title="<?php echo esc_html__( 'Comments', 'hannah-cd' ); ?>">
							<span class="sc-icon fa fa-comment-o"></span>
							<span class="sc-count"><?php echo hannah_cd_format_count( esc_html( $comment_count ) ); ?></span>
							<span class="sc-type"><?php echo esc_html__( 'Comments', 'hannah-cd' ); ?></span>
							<span class="sc-icon-hover"><i class="fa fa-comment-o"></i></span>
						</a>
					</li>
				<?php } ?>
				
				<?php if( ! 'true' == $instance[ 'posts_count' ] ) { ?>
					<li class="social-counter-item fa-pencil-square-o">
						<?php 
							$posts = wp_count_posts();
							$post_count = $posts->publish
						?>
						<a rel="nofollow" target="_blank" href="#" title="<?php echo esc_html__( 'Posts', 'hannah-cd' ); ?>">
							<span class="sc-icon fa fa-pencil-square-o"></span>
							<span class="sc-count"><?php echo hannah_cd_format_count( esc_html( $post_count ) ); ?></span>
							<span class="sc-type"><?php echo esc_html__( 'Posts', 'hannah-cd' ); ?></span>
							<span class="sc-icon-hover"><i class="fa fa-pencil-square-o"></i></span>
						</a>
					</li>
				<?php } ?>
				
			</ul>
			
			<?php
				// facebook error
				if( isset( $fb_error ) ? $fb_error : '' ) {
					echo '<div class="alert alert-warning">' . esc_html( $fb_error ) . '</div>';
				}

				// google plus error
				if( isset( $gp_error ) ? $gp_error : '' ) {
					echo '<div class="alert alert-warning">' . esc_html( $gp_error ) . '</div>';
				}

				// youtube error
				if( isset( $yt_error ) ? $yt_error : '' ) {
					echo '<div class="alert alert-warning">' . esc_html( $yt_error ) . '</div>';
				}

				// twitter error
				if( isset( $tw_error ) ? $tw_error : '' ) {
					echo '<div class="alert alert-warning">' . esc_html( $tw_error ) . '</div>';
				}

				// pinterest error
				if( isset( $pin_error ) ? $pin_error : '' ) {
					echo '<div class="alert alert-warning">' . esc_html( $pin_error ) . '</div>';
				}

				// instagram error
				if( isset( $inst_error ) ? $inst_error : '' ) {
					echo '<div class="alert alert-warning">' . esc_html( $inst_error ) . '</div>';
				}

				// vimeo error
				if( isset( $vim_error ) ? $vim_error : '' ) {
					echo '<div class="alert alert-warning">' . esc_html( $vim_error ) . '</div>';
				}

				// dribbble error
				if( isset( $dri_error ) ? $dri_error : '' ) {
					echo '<div class="alert alert-warning">' . esc_html( $dri_error ) . '</div>';
				}

			?>			
			
		</div>

		<?php

		echo $after_widget;

	}

	/* Sanitize widget form values as they are saved */

	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['column'] = strip_tags( $new_instance['column'] );
		$instance['style'] = strip_tags( $new_instance['style'] );
		
		$instance['nl_count'] = strip_tags( $new_instance['nl_count'] );
		$instance['fans_count'] = ( ! empty( $new_instance['fans_count'] ) ) ? strip_tags( $new_instance['fans_count'] ) : '';
		$instance['comments_count'] = ( ! empty( $new_instance['comments_count'] ) ) ? strip_tags( $new_instance['comments_count'] ) : '';
		$instance['posts_count'] = ( ! empty( $new_instance['posts_count'] ) ) ? strip_tags( $new_instance['posts_count'] ) : '';
		
		// facebook
		$instance['fb_id'] = strip_tags( $new_instance['fb_id'] );
		$instance['app_id'] = strip_tags( $new_instance['app_id'] );
		$instance['app_secret_code'] = strip_tags( $new_instance['app_secret_code'] );

		// google plus
		$instance['gp_user_id'] = strip_tags( $new_instance['gp_user_id'] );
		$instance['gp_api_key'] = strip_tags( $new_instance['gp_api_key'] );

		// youtube
		$instance['yt_channel_id'] = strip_tags( $new_instance['yt_channel_id'] );
		$instance['yt_api_key'] = strip_tags( $new_instance['yt_api_key'] );

		// twitter
		$instance['tw_username'] = strip_tags( $new_instance['tw_username'] );
		$instance['tw_access_token'] = strip_tags( $new_instance['tw_access_token'] );
		$instance['tw_access_token_secret'] = strip_tags( $new_instance['tw_access_token_secret'] );
		$instance['tw_consumer_key'] = strip_tags( $new_instance['tw_consumer_key'] );
		$instance['tw_consumer_secret'] = strip_tags( $new_instance['tw_consumer_secret'] );
		
		// pinterest
		$instance['pin_access_token'] = strip_tags( $new_instance['pin_access_token'] );
		
		// instagram
		$instance['inst_access_token'] = strip_tags( $new_instance['inst_access_token'] );
		
		// vimeo
		$instance['vim_user_id'] = strip_tags( $new_instance['vim_user_id'] );
		$instance['vim_access_token'] = strip_tags( $new_instance['vim_access_token'] );
		
		// dribbble
		$instance['dri_user_id'] = strip_tags( $new_instance['dri_user_id'] );
		$instance['dri_access_token'] = strip_tags( $new_instance['dri_access_token'] );
		
		return $instance;

	}

	/* Backend Widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'My Social Counts';
		
		if ( isset( $instance[ 'column' ] ) ) $column = $instance[ 'column' ]; 
			else $column = 'column_3';
		
		if ( isset( $instance[ 'style' ] ) ) $style = $instance[ 'style' ]; 
			else $style = 'style_2';
		
		if ( isset( $instance[ 'nl_count' ] ) ) $nl_count = $instance[ 'nl_count' ]; 
			else $nl_count = '';
		if ( isset( $instance[ 'fans_count' ] ) ) $fans_count = $instance[ 'fans_count' ]; 
			else $fans_count = $instance[ 'fans_count' ] = 'false';
		if ( isset( $instance[ 'comments_count' ] ) ) $comments_count = $instance[ 'comments_count' ]; 
			else $comments_count = $instance[ 'comments_count' ] = 'false';
		if ( isset( $instance[ 'posts_count' ] ) ) $posts_count = $instance[ 'posts_count' ]; 
			else $posts_count = $instance[ 'posts_count' ] = 'false';
		
		// facebook
		if ( isset( $instance[ 'fb_id' ] ) ) $fb_id = $instance[ 'fb_id' ]; 
			else $fb_id = '';
		if ( isset( $instance[ 'app_id' ] ) ) $app_id = $instance[ 'app_id' ]; 
			else $app_id = '';
		if ( isset( $instance[ 'app_secret_code' ] ) ) $app_secret_code = $instance[ 'app_secret_code' ]; 
			else $app_secret_code = '';
		
		// google plus
		if ( isset( $instance[ 'gp_user_id' ] ) ) $gp_user_id = $instance[ 'gp_user_id' ]; 
			else $gp_user_id = '';
		if ( isset( $instance[ 'gp_api_key' ] ) ) $gp_api_key = $instance[ 'gp_api_key' ]; 
			else $gp_api_key = '';
		
		// youtube
		if ( isset( $instance[ 'yt_channel_id' ] ) ) $yt_channel_id = $instance[ 'yt_channel_id' ]; 
			else $yt_channel_id = '';
		if ( isset( $instance[ 'yt_api_key' ] ) ) $yt_api_key = $instance[ 'yt_api_key' ]; 
			else $yt_api_key = '';
		
		// twitter
		if ( isset( $instance[ 'tw_username' ] ) ) $tw_username = $instance[ 'tw_username' ]; 
			else $tw_username = '';
		if ( isset( $instance[ 'tw_access_token' ] ) ) $tw_access_token = $instance[ 'tw_access_token' ]; 
			else $tw_access_token = '';
		if ( isset( $instance[ 'tw_access_token_secret' ] ) ) $tw_access_token_secret = $instance[ 'tw_access_token_secret' ]; 
			else $tw_access_token_secret = '';
		if ( isset( $instance[ 'tw_consumer_key' ] ) ) $tw_consumer_key = $instance[ 'tw_consumer_key' ]; 
			else $tw_consumer_key = '';
		if ( isset( $instance[ 'tw_consumer_secret' ] ) ) $tw_consumer_secret = $instance[ 'tw_consumer_secret' ]; 
			else $tw_consumer_secret = '';
		
		// pinterest
		if ( isset( $instance[ 'pin_access_token' ] ) ) $pin_access_token = $instance[ 'pin_access_token' ]; 
			else $pin_access_token = '';
			
		// instagram
		if ( isset( $instance[ 'inst_access_token' ] ) ) $inst_access_token = $instance[ 'inst_access_token' ]; 
			else $inst_access_token = '';
			
		// vimeo
		if ( isset( $instance[ 'vim_user_id' ] ) ) $vim_user_id = $instance[ 'vim_user_id' ]; 
			else $vim_user_id = '';
		if ( isset( $instance[ 'vim_access_token' ] ) ) $vim_access_token = $instance[ 'vim_access_token' ]; 
			else $vim_access_token = '';
			
		// dribbble
		if ( isset( $instance[ 'dri_user_id' ] ) ) $dri_user_id = $instance[ 'dri_user_id' ]; 
			else $dri_user_id = '';
		if ( isset( $instance[ 'dri_access_token' ] ) ) $dri_access_token = $instance[ 'dri_access_token' ]; 
			else $dri_access_token = '';

		?>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title', 'hannah-cd' ); ?>:
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
     		
     	<p>
      		<label for="<?php echo $this->get_field_id('style'); ?>"><?php esc_html_e( 'Style', 'hannah-cd' ); ?>:
        		<select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>" type="text">
          			<option value="style_1" <?php echo ( $style == 'style_1') ? 'selected' : ''; ?>><?php esc_html_e( 'Style', 'hannah-cd' ); ?> 1</option>
          			<option value="style_2" <?php echo ( $style == 'style_2') ? 'selected' : ''; ?>><?php esc_html_e( 'Style', 'hannah-cd' ); ?> 2</option>
        		</select>                
      		</label>
     	</p>
		
		<p>
      		<label for="<?php echo $this->get_field_id('column'); ?>"><?php esc_html_e( 'Columns', 'hannah-cd' ); ?>:
        		<select class="widefat" id="<?php echo $this->get_field_id('column'); ?>" name="<?php echo $this->get_field_name('column'); ?>" type="text">
          			<option value="column_1" <?php echo ( $column == 'column_1') ? 'selected' : ''; ?>>1 <?php esc_html_e( 'Column', 'hannah-cd' ); ?></option>
          			<option value="column_2" <?php echo ( $column == 'column_2') ? 'selected' : ''; ?>>2 <?php esc_html_e( 'Columns', 'hannah-cd' ); ?></option>
          			<option value="column_3" <?php echo ( $column == 'column_3') ? 'selected' : ''; ?>>3 <?php esc_html_e( 'Columns', 'hannah-cd' ); ?></option>
        		</select>                
      		</label>
     	</p>
		
		<p>
			<input class="checkbox" <?php if ( isset( $fans_count ) && $fans_count == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'fans_count' ); ?>" name = "<?php echo $this->get_field_name( 'fans_count' ); ?>" value = "true" type = "checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'fans_count' ) ); ?>">
				<?php esc_html_e( 'Hide total fan count', 'hannah-cd' ); ?>
			</label> 
		</p>
		
		<p>
			<input class="checkbox" <?php if ( isset( $comments_count ) && $comments_count == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'comments_count' ); ?>" name = "<?php echo $this->get_field_name( 'comments_count' ); ?>" value = "true" type = "checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'comments_count' ) ); ?>">
				<?php esc_html_e( 'Hide comments count', 'hannah-cd' ); ?>
			</label> 
		</p>
		
		<p>
			<input class="checkbox" <?php if ( isset( $posts_count ) && $posts_count == 'true' ) { echo 'checked="checked"'; } ?> id = "<?php echo $this->get_field_id( 'posts_count' ); ?>" name = "<?php echo $this->get_field_name( 'posts_count' ); ?>" value = "true" type = "checkbox" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_count' ) ); ?>">
				<?php esc_html_e( 'Hide posts count', 'hannah-cd' ); ?>
			</label> 
		</p>
		
		<?php /* NEWSLETTER */ ?>
		
		<h4>&#8660; <?php esc_html_e( 'Newsletter', 'hannah-cd' ); ?></h4>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'nl_count' ) ); ?>">
				<?php esc_html_e( 'Subscriber Count', 'hannah-cd' ); ?>:
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'nl_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'nl_count' ) ); ?>" type="number" value="<?php echo esc_attr( $nl_count ); ?>" />
		</p>
		
		<?php /* FACEBOOK */ ?>
		
		<h4>&#8660; 
			<?php 
				esc_html_e( 'Connect to', 'hannah-cd' );
				echo ' ';
				esc_html_e( 'Facebook', 'hannah-cd' ); 
			?>
		</h4>
		
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
				<?php esc_html_e( 'App ID', 'hannah-cd' ); ?>: ( <a href="//developers.facebook.com/tools/accesstoken" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'app_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'app_id' ) ); ?>" type="text" value="<?php echo esc_attr( $app_id ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'app_secret_code' ) ); ?>">
				<?php esc_html_e( 'App Secret Code', 'hannah-cd' ); ?>: ( <a href="//developers.facebook.com/tools/accesstoken/" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'app_secret_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'app_secret_code' ) ); ?>" type="text" value="<?php echo esc_attr( $app_secret_code ); ?>" />
		</p>
		
		<?php /* GOOGLE PLUS */ ?>
		
		<h4>&#8660; 
			<?php 
				esc_html_e( 'Connect to', 'hannah-cd' );
				echo ' ';
				esc_html_e( 'Google Plus', 'hannah-cd' ); 
			?>
		</h4>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'gp_user_id' ) ); ?>">
				<?php 
					esc_html_e( 'Google Plus', 'hannah-cd' );
					echo ' ';
					esc_html_e( 'User ID', 'hannah-cd' ); 
				?>: 
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'gp_user_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'gp_user_id' ) ); ?>" type="text" value="<?php echo esc_attr( $gp_user_id ); ?>" />
			<br>
			<small><?php esc_html_e( 'Page URL', 'hannah-cd' ); ?>: https://plus.google.com/.../[ID]</small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'gp_api_key' ) ); ?>">
				<?php esc_html_e( 'API Key', 'hannah-cd' ); ?>: ( <a href="//developers.google.com/places/web-service/get-api-key" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'gp_api_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'gp_api_key' ) ); ?>" type="text" value="<?php echo esc_attr( $gp_api_key ); ?>" />
		</p>
		
		<?php /* YOUTUBE */ ?>
		
		<h4>&#8660; 
			<?php 
				esc_html_e( 'Connect to', 'hannah-cd' );
				echo ' ';
				esc_html_e( 'YouTube', 'hannah-cd' ); 
			?>
		</h4>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'yt_channel_id' ) ); ?>">
				<?php 
					esc_html_e( 'YouTube', 'hannah-cd' );
					echo ' ';
					esc_html_e( 'Channel ID', 'hannah-cd' ); 
				?>: 
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'yt_channel_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'yt_channel_id' ) ); ?>" type="text" value="<?php echo esc_attr( $yt_channel_id ); ?>" />
			<br>
			<small><?php esc_html_e( 'Channel URL', 'hannah-cd' ); ?>: https://www.youtube.com/channel/[ID]</small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'yt_api_key' ) ); ?>">
				<?php esc_html_e( 'API Key', 'hannah-cd' ); ?>: ( <a href="//console.developers.google.com/apis/" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'yt_api_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'yt_api_key' ) ); ?>" type="text" value="<?php echo esc_attr( $yt_api_key ); ?>" />
		</p>
		
		<?php /* TWITTER */ ?>
		
		<h4>&#8660; 
			<?php 
				esc_html_e( 'Connect to', 'hannah-cd' );
				echo ' ';
				esc_html_e( 'Twitter', 'hannah-cd' ); 
			?>
		</h4>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tw_username' ) ); ?>">
				<?php 
					esc_html_e( 'Twitter', 'hannah-cd' );
					echo ' ';
					esc_html_e( 'Username', 'hannah-cd' ); 
				?>:
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tw_username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tw_username' ) ); ?>" type="text" value="<?php echo esc_attr( $tw_username ); ?>" />
			<br>
			<small><?php esc_html_e( 'Page URL', 'hannah-cd' ); ?>: https://twitter.com/[Username]</small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tw_access_token' ) ); ?>">
				<?php esc_html_e( 'Access Token', 'hannah-cd' ); ?>: ( <a href="//developer.twitter.com/en/docs/basics/authentication/guides/access-tokens" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tw_access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tw_access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $tw_access_token ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tw_access_token_secret' ) ); ?>">
				<?php esc_html_e( 'Access Token Secret', 'hannah-cd' ); ?>: ( <a href="//developer.twitter.com/en/docs/basics/authentication/guides/access-tokens" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tw_access_token_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tw_access_token_secret' ) ); ?>" type="text" value="<?php echo esc_attr( $tw_access_token_secret ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tw_consumer_key' ) ); ?>">
				<?php esc_html_e( 'Consumer Key', 'hannah-cd' ); ?>: ( <a href="//developer.twitter.com/en/docs/basics/authentication/guides/access-tokens" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tw_consumer_key' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tw_consumer_key' ) ); ?>" type="text" value="<?php echo esc_attr( $tw_consumer_key ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tw_consumer_secret' ) ); ?>">
				<?php esc_html_e( 'Consumer Key Secret', 'hannah-cd' ); ?>: ( <a href="//developer.twitter.com/en/docs/basics/authentication/guides/access-tokens" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'tw_consumer_secret' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'tw_consumer_secret' ) ); ?>" type="text" value="<?php echo esc_attr( $tw_consumer_secret ); ?>" />
		</p>
		
		<?php /* PINTEREST */ ?>
		
		<h4>&#8660; 
			<?php 
				esc_html_e( 'Connect to', 'hannah-cd' );
				echo ' ';
				esc_html_e( 'Pinterest', 'hannah-cd' ); 
			?>
		</h4>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'pin_access_token' ) ); ?>">
				<?php esc_html_e( 'Access Token', 'hannah-cd' ); ?>: ( <a href="//developers.pinterest.com/tools/access_token/" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pin_access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pin_access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $pin_access_token ); ?>" />
		</p>
		
		<?php /* INSTAGRAM */ ?>
		
		<h4>&#8660; 
			<?php 
				esc_html_e( 'Connect to', 'hannah-cd' );
				echo ' ';
				esc_html_e( 'Instagram', 'hannah-cd' ); 
			?>
		</h4>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'inst_access_token' ) ); ?>">
				<?php esc_html_e( 'Access Token', 'hannah-cd' ); ?>: ( <a href="//instagram.pixelunion.net" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'inst_access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'inst_access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $inst_access_token ); ?>" />
		</p>
		
		<?php /* VIMEO */ ?>
		
		<h4>&#8660; 
			<?php 
				esc_html_e( 'Connect to', 'hannah-cd' );
				echo ' ';
				esc_html_e( 'Vimeo', 'hannah-cd' ); 
			?>
		</h4>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'vim_user_id' ) ); ?>">
				<?php 
					esc_html_e( 'Vimeo', 'hannah-cd' );
					echo ' ';
					esc_html_e( 'User ID', 'hannah-cd' ); 
				?>:
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'vim_user_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vim_user_id' ) ); ?>" type="text" value="<?php echo esc_attr( $vim_user_id ); ?>" />
			<br>
			<small><?php esc_html_e( 'User URL', 'hannah-cd' ); ?>: https://vimeo.com/[ID]</small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'vim_access_token' ) ); ?>">
				<?php esc_html_e( 'Access Token', 'hannah-cd' ); ?>: ( <a href="//developer.vimeo.com/apps" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'vim_access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'vim_access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $vim_access_token ); ?>" />
		</p>
		
		<?php /* DRIBBBLE */ ?>
		
		<h4>&#8660; <?php 
				esc_html_e( 'Connect to', 'hannah-cd' );
				echo ' ';
				esc_html_e( 'Dibbble', 'hannah-cd' ); 
			?>
		</h4>
		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'dri_user_id' ) ); ?>">
				<?php 
					esc_html_e( 'Dibbble', 'hannah-cd' );
					echo ' ';
					esc_html_e( 'User ID', 'hannah-cd' ); 
				?>: 
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'dri_user_id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dri_user_id' ) ); ?>" type="text" value="<?php echo esc_attr( $dri_user_id ); ?>" />
			<br>
			<small><?php esc_html_e( 'User URL', 'hannah-cd' ); ?>: https://dribbble.com/[ID]</small>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'dri_access_token' ) ); ?>">
				<?php esc_html_e( 'Access Token', 'hannah-cd' ); ?>: ( <a href="//dribbble.com/account/applications/new" target="_blank"><?php esc_html_e( 'Get here', 'hannah-cd' ); ?></a> )
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'dri_access_token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dri_access_token' ) ); ?>" type="text" value="<?php echo esc_attr( $dri_access_token ); ?>" />
		</p>
		
		<?php 

	}

}