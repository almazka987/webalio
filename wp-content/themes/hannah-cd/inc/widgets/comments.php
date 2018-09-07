<?php

add_action( 'widgets_init', create_function( '', 'register_widget( "hannah_cd_comments_widget" );' ) );

class hannah_Cd_Comments_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'hannah_cd_comments_widget',
			'&#10026; ' . esc_html__( 'Comments', 'hannah-cd' ),
			array( 'description' => esc_html__( 'Show recent comments.', 'hannah-cd' ) )
		);
	}

	/* Frontend Widget */

	public function widget( $args, $instance ) {
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		$number = $instance['number'];
		$length = $instance['length'];
		$avatar_size = $instance['avatar_size'];

		echo $before_widget;

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		/* Widget Content */

		?>

			<div class="recent-comments-widget">
				<?php
					$comment_args = array(
					   	'number' => $number,
						'status' => 'approve',
						'post_type' => array( 'post', 'page' ),
					);
		
					$comments_query = new WP_Comment_Query();
					$comments = $comments_query->query( $comment_args );
				?>
					
				<?php if ( $comments ) : ?>
                    <ul>
                    <?php foreach ( $comments as $comment ) : ?>
                        <li>
                            <?php echo get_avatar( $comment->comment_author_email, $avatar_size ); ?>
                            <a class="comment-title" href="<?php echo get_permalink( $comment->comment_post_ID ) ?>#comment-<?php echo esc_html( $comment->comment_ID ); ?>">
                                <?php echo esc_html( get_comment_author( $comment->comment_ID ) ); ?>
								<?php echo esc_html__( 'to', 'hannah-cd' ); ?>
                                <?php echo esc_html( get_the_title($comment->comment_post_ID) ); ?>
							</a>
                            <p><?php echo strip_tags( substr( apply_filters( 'get_comment_text', $comment->comment_content ), 0, $length ) ) ?> ...</p>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                        <?php esc_html__( 'No comments', 'hannah-cd' ); ?>
                <?php endif; ?>
			</div>

		<?php

		echo $after_widget;

	}

	/* Sanitize widget form values as they are saved. */

	public function update( $new_instance, $old_instance ) {
		
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
			
		$instance['number'] = strip_tags( $new_instance['number'] );
		$instance['length'] = strip_tags( $new_instance['length'] );
		$instance['avatar_size'] = strip_tags( $new_instance['avatar_size'] );

		return $instance;

	}

	/* Backend widget */

	public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) $title = $instance[ 'title' ]; 
			else $title = 'Recent Comments';

		if ( isset( $instance[ 'number' ] ) ) $number = $instance[ 'number' ]; 
			else $number = '3';
		if ( isset( $instance[ 'length' ] ) ) $length = $instance[ 'length' ]; 
			else $length = '80';
		if ( isset( $instance[ 'avatar_size' ] ) ) $avatar_size = $instance[ 'avatar_size' ]; 
			else $avatar_size = '55';
		
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>">
				<?php esc_html_e( 'Number of Comments:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>">
				<?php esc_html_e( 'Content Length:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'length' ) ); ?>" type="text" value="<?php echo esc_attr( $length ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'avatar_size' ) ); ?>">
				<?php esc_html_e( 'Avatar Size in Pixel:', 'hannah-cd' ); ?>
			</label> 
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'avatar_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'avatar_size' ) ); ?>" type="text" value="<?php echo esc_attr( $avatar_size ); ?>" />
		</p>

		<?php 

	}

}