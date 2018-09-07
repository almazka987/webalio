<?php 
/*
*************************************** 
Displaying the comments 
***************************************
*/ 

if ( post_password_required() ) {
	return;
} ?>

<div id="comments" class="comments-area">

    <?php if( have_comments() ) : ?>
        <div class="special-title">
            <span>
                <?php
                    printf( _nx( 'One comment', '%1$s comments', get_comments_number(), 'comments title', 'hannah-cd' ),
                        number_format_i18n( get_comments_number() ), get_the_title() );
                ?>
            </span>
        </div>

        <ol class="comment-list">
            <?php wp_list_comments( array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 56,
            ) ); ?>
        </ol>
    <?php endif;
    
    if( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
        <p class="no-comments">
			<?php esc_html_e( 'Comments are closed.', 'hannah-cd' ); ?>
		</p>
    <?php endif;
    
    the_comments_navigation();
    
    comment_form(); ?>

</div>
