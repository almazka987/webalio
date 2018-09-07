<?php

/*****************************************************************/
/* POST RATING */
/*****************************************************************/

global $search_table;

// add post rating class

class hannah_cd_PostRating {

	private $STATUS_SUCCESS = 1;
	private $STATUS_ALREADY_VOTED = 0;
	private $STATUS_UNKNOWN = -1;
	private $STATUS_ERROR = 2;
	
	public function __construct() {

		// add head script
		add_action( 'wp_head', array( $this, 'hannah_cd_post_rating_script' ) );
	   
		// get wp ajax
		add_action( 'wp_ajax_post_rating', array( $this, '_hannah_cd_post_voting' ) );
		add_action( 'wp_ajax_nopriv_post_rating', array( $this, '_hannah_cd_post_voting' ) );

	}
	
	public function hannah_cd_post_rating_script() {
		
		// wp ajax script

		wp_localize_script( 'hannah_cd_main', 'pr_ajax_data', array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'codes' => array(
				'SUCCESS' 		=> $this->STATUS_SUCCESS,
				'ALREADY_VOTED' => $this->STATUS_ALREADY_VOTED,
				'UNKNOWN' 		=> $this->STATUS_UNKNOWN,
				'ERROR' 		=> $this->STATUS_ERROR
			),
			'messages' => array(
				'success' 		=> esc_html__('Thanks for rating.', 'hannah-cd'),
				'already_voted' => esc_html__('You have already voted.', 'hannah-cd'),
				'unknown' 		=> esc_html__('An error has occurred.', 'hannah-cd'),
				'error' 		=> esc_html__('It is something went wrong, try again.', 'hannah-cd')
			)
		));

	}
	
	// get rating cookie
	
	public function hannah_cd_getCookie( $post_id ) {
		return 'p_rating_' . $post_id;
	}
	
	// get table name
	
	public function hannah_cd_getTable() {
		global $wpdb;
		return $wpdb->prefix . 'hannah_cd_post_ratings'; // name of db table
	}

	// get post id and user ip from db
		
	public function hannah_cd_getVote( $post_id, $user_ip ) {
		global $wpdb;
		$search_table = $this->hannah_cd_getTable();
		return $wpdb->get_row($wpdb->prepare("SELECT `post_id` FROM $search_table WHERE `user_ip` = %s AND `post_id` = %d LIMIT 0, 1", $user_ip, $post_id));
	}
	
	public function _hannah_cd_post_voting() {
		global $wpdb;
		$search_table = $this->hannah_cd_getTable();

		// support for older wp versions

		if (! defined('WEEK_IN_SECONDS')) {
			define('WEEK_IN_SECONDS', 7 * 24 * 60 * 60);
		}
		
		$post_id = intval(@$_POST['post_id']); // post id
		$rating = intval(@$_POST['rating']); // rating value (1-5)
		$IP = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']; // user ip

		$cookie = $this->hannah_cd_getCookie($post_id);

		// if rating success, set cookie

		if (isset($_COOKIE[$cookie]) || $this->hannah_cd_getVote($post_id, $IP) !== null) {
			setcookie($cookie, 'true', time() + WEEK_IN_SECONDS, '/');
			die(json_encode(array('status' => $this->STATUS_ALREADY_VOTED)));
		}

		// get current rating and increase it

		$rating_curr = intval(get_post_meta($post_id, 'post_rating', true));
		$votes_curr = intval(get_post_meta($post_id, 'post_rating_count', true));

		// if no rating or votes, or is invalid

		if ((empty($rating_curr) && $rating_curr !== 0) || (empty($votes_curr) && $votes_curr !== 0) || $rating > 5 || $rating < 1) {
			die(json_encode(array(
				'status' 		=> $this->STATUS_ERROR,
				'votes_curr' 	=> $votes_curr,
				'rating_curr' 	=> $rating_curr
			)));
		}

		// update new rating

		update_post_meta($post_id, 'post_rating', $rating_curr + $rating);
		update_post_meta($post_id, 'post_rating_count', $votes_curr + 1);

		// add new vote in db and set cookie for a week

		$wpdb->insert($search_table, array(
				'user_ip' => $IP,
				'post_id' => $post_id
			),
			array('%s', '%d')
		);
		setcookie($cookie, 'true', time() + WEEK_IN_SECONDS, '/');

		// return the success status

		die(json_encode(array(
			'status' => $this->STATUS_SUCCESS,
			'votes' => $votes_curr + 1,
			'total' => $rating_curr + $rating,
			'result' => ( $rating_curr + $rating ) / ( $votes_curr + 1 )
		)));
	}

	function hannah_cd_rating_output() {

		global $post;
	
		// get post rating data

		$rating = get_post_meta($post->ID, 'post_rating', true);
		$vote_count = get_post_meta($post->ID, 'post_rating_count', true);

		if ($rating === '') {
			$rating = 0;
			add_post_meta($post->ID, 'post_rating', 0);
		}
	
		if ($vote_count === '') {
			$vote_count = 0;
			add_post_meta($post->ID, 'post_rating_count', 0);
		}
	
		$vote_count = intval($vote_count);
		$rating = intval($rating);
	
		if ($vote_count === 0) {
			$result = 0;
		} else {
			$result = $rating / $vote_count;
		}
	
		// show the rich snippets data only, if 1 vote exsist

		$snippets = $vote_count !== 0;
		?>
	
		<div class="post-rating" <?php if($snippets) echo 'itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"'; ?>>
		
			<?php if( $vote_count == 0 ) { ?>
				<div class="post-rating-stars">
            <?php } else { ?>
                <div class="post-rating-stars has-votes">
            <?php } ?>
				<div class="post-rating-stars-wrapper" data-curr-pid="<?php echo $post->ID; ?>">
                    <div class="post-rating-layer" style="width: <?php echo esc_html( (100 - $result * 100 / 5) ); ?>%"></div>
                    <a href="#" data-value="1" title="<?php echo esc_attr_e('1 Star', 'hannah-cd'); ?>"><i class="fa fa-star"></i></a>
                    <a href="#" data-value="2" title="<?php echo esc_attr_e('2 Stars', 'hannah-cd'); ?>"><i class="fa fa-star"></i></a>
                    <a href="#" data-value="3" title="<?php echo esc_attr_e('3 Stars', 'hannah-cd'); ?>"><i class="fa fa-star"></i></a>
                    <a href="#" data-value="4" title="<?php echo esc_attr_e('4 Stars', 'hannah-cd');?>"><i class="fa fa-star"></i></a>
                    <a href="#" data-value="5" title="<?php echo esc_attr_e('5 Stars', 'hannah-cd'); ?>"><i class="fa fa-star"></i></a>
				</div>
			</div>
			
			<div class="post-rating-content">

				<span class="rating-title" <?php if( $snippets ) echo 'itemprop="name"'; ?>>
					<a href="<?php the_permalink() ?>" class="<?php if( $snippets ) echo 'fn url'; ?>">
						<?php the_title() ?>
					</a>
				</span>
				
				<?php echo esc_html_e('Score', 'hannah-cd') ?>:
                <span class="post-rating-all" <?php if( $snippets) echo 'itemprop="ratingValue"'; ?>>
                    <?php echo esc_html( is_int($result) ? $result : number_format($result, 2) ); ?>
                </span>
                 / 
                <span <?php if($snippets) echo 'itemprop="bestRating"' ?>>5</span>
                
                (<span class="post-rating-count" <?php if( $snippets ) echo 'itemprop="ratingCount"' ?>><?php echo esc_html( $vote_count ); ?></span><?php if( $vote_count == 1 ) { ?><?php echo esc_html_e('vote', 'hannah-cd') ?><?php } else { ?><?php echo esc_html_e('votes', 'hannah-cd') ?><?php } ?>)
			
			</div>
	
		</div>
	
	<?php
			
	}
	
	
  
}


// GET RATING RESULTS
// output for post meta

function hannah_cd_get_ratings() {
	
	global $post;
	
	// get post rating data

	$rating = get_post_meta($post->ID, 'post_rating', true);
	$vote_count = get_post_meta($post->ID, 'post_rating_count', true);

	if ($rating === '') {
		$rating = 0;
		add_post_meta($post->ID, 'post_rating', 0);
	}

	if ($vote_count === '') {
		$vote_count = 0;
		add_post_meta($post->ID, 'post_rating_count', 0);
	}

	$vote_count = intval($vote_count);
	$rating = intval($rating);

	if ($vote_count === 0) {
		$result = 0;
	} else {
		$result = $rating / $vote_count;
	}

	echo esc_html( is_int($result) ? $result : number_format($result, 2) );
	echo ' / 5';
}


// create an instance
$hannah_cd_postrating = new hannah_cd_PostRating();

if ( ! function_exists( 'post_rating' ) ) : 

	function post_rating() {
		global $hannah_cd_postrating;
		$hannah_cd_postrating->hannah_cd_rating_output();
	}

endif;