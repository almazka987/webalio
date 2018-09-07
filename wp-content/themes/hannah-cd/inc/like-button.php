<?php

/*****************************************************************/
/* ADD WP AJAX LIBRARY */
/*****************************************************************/

function hannah_cd_add_wp_ajax() {
	wp_localize_script('hannah_cd_main', 'like_ajax_data', array('wp_ajaxurl' => admin_url('admin-ajax.php'))); // wp ajax script
}

add_action( 'wp_head', 'hannah_cd_add_wp_ajax' );

  	
/*****************************************************************/
/* LIKE FUNCTION */
/*****************************************************************/

// likebutton output

function hannah_cd_like_btn($post_id, $extra_class = '') {

  	$like_data = hannah_cd_like_btn_get_data($post_id);

  	?>

	<div class="like-button">
        <div class="like-button-wrapper">
            <button class="<?php echo esc_attr( $extra_class ); ?>like-btn" data-liked-label="<?php esc_attr_e('Liked', 'hannah-cd'); ?>" data-like-label="<?php esc_attr_e('Like', 'hannah-cd'); ?>" data-pid="<?php echo esc_attr( $post_id ); ?>" data-get-like="<?php echo esc_attr( ($like_data['liked']) ) ? 'get_it_back' : 'get_it'; ?>" data-like-count="<?php echo esc_attr( $like_data['count'] ); ?>">
                
                <?php if($like_data['liked']) { ?>
                    <i class="fa fa-heart"></i>
                <?php } else { ?>
                    <i class="fa fa-heart-o"></i>
                <?php } ?>
				<span class="like-btn-content">
                    <span class="like-btn-label">
                        <?php echo esc_html( ($like_data['liked']) ) ? esc_html_e("Liked", "hannah-cd") : esc_html_e("Like", "hannah-cd"); ?>
                    </span>
                    <span class="like-btn-count <?php if( ! $like_data['count']) echo 'hidden'; ?>">
                        <?php echo esc_html( $like_data['count'] );  ?>
                    </span>
				</span>
                
            </button>
        </div>
	</div>

	<?php
}

// like cout output for post meta

function hannah_cd_like_count($post_id, $extra_class = '') {

  	$like_data = hannah_cd_like_btn_get_data($post_id);

  	?>

		<?php echo esc_html( $like_data['count'] ); ?>

	<?php
}

// likebutton request

function hannah_cd_like_btn_request() {

  	$post_id = $_POST['like_pid'];
  	$like_action = $_POST['like_action'];

  	if($post_id && $like_action) {
    	switch($like_action) {
      		case 'get_it':
        		echo wp_send_json( array(
					'status' 	=> 200, 
					'message' 	=> hannah_cd_like_btn_get_it( $post_id )
				));
      		break;
      		case 'get_it_back':
        		echo wp_send_json( array(
					'status' 	=> 200,
					'message' 	=> hannah_cd_like_btn_get_it_back( $post_id )
				));
      		break;
      		case 'get_data':
        		echo wp_send_json( array(
					'status' 	=> 200, 
					'message' 	=> hannah_cd_like_btn_get_data( $post_id )
				));
      		break;
    	}
  	} else {
    	echo wp_send_json( array(
			'status'		=> 422, 
			'message' 	=> 'Invalid data'
		));
  	}
}

add_action( 'wp_ajax_like_btn_request', 'hannah_cd_like_btn_request' );
add_action( 'wp_ajax_nopriv_like_btn_request', 'hannah_cd_like_btn_request' );

// get like data from post

function hannah_cd_like_btn_get_data( $post_id = false ) {

  	$like_count = get_post_meta($post_id, '_like_btn', true);
  	if(!$like_count) add_post_meta($post_id, '_like_btn', 0, true);
  	$liked = hannah_cd_like_btn_liked($post_id);
  	$like_data = array('count' => $like_count, 'liked' => $liked);
	return $like_data;

}

// check if user has liked

function hannah_cd_like_btn_liked( $post_id = false ) {

  	return isset($_COOKIE['like_btn_'. $post_id]);

}

// make a new like

function hannah_cd_like_btn_get_it( $post_id = false ) {

  	$like_data = hannah_cd_like_btn_get_data($post_id);
  	if($like_data['liked']) return $like_data;
  	update_post_meta($post_id, '_like_btn', $like_data['count'] + 1);
  	$cookie_expire_on = time() + 30 * 60 * 1000; // after 30 minutes
  	setcookie('like_btn_'. $post_id, $post_id, $cookie_expire_on, '/');
	
	return hannah_cd_like_btn_get_data($post_id);

}

// remove the like 

function hannah_cd_like_btn_get_it_back( $post_id = false ) {

	$like_data = hannah_cd_like_btn_get_data($post_id);
	
  	if($like_data['liked'] && ($like_data['count'] > 0)) {
    	update_post_meta($post_id, '_like_btn', $like_data['count'] - 1);
    	setcookie('like_btn_'. $post_id, $post_id, 1, '/');
    	return hannah_cd_like_btn_get_data($post_id);
	} else {
		return $like_data; 
	}

} 