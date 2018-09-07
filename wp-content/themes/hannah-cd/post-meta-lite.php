<?php 
/*
*************************************** 
Displaying for post metas lite
***************************************
*/ 
?>

<div class="blog-post-meta">

	<?php // AUTHOR
    
    if( ! ACF_GF('post_author_meta_show', 'option') ) { 
        $author_id = $post->post_author; ?>              
        <div class="blog-post-metabox meta-author">
            <div class="blog-post-meta-icon">
                <a href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>" title="<?php echo esc_html_e('Author', 'hannah-cd') . ': ' . get_the_author_meta( 'display_name' , $author_id ); ?>">
					<?php echo get_avatar( get_the_author_meta( 'user_email', $author_id ), 46 ); ?>
				</a>
            </div>
        </div>
    <?php }
    
    // COMMENTS
    
    if( ! ACF_GF('post_comments_meta_show', 'option') ) { ?>
        <div class="blog-post-metabox meta-comments" title="<?php echo esc_html__('Comments', 'hannah-cd'); ?>">
            <div class="blog-post-meta-icon">
                <i class="icon fa fa-comment-o"></i>
				<span><a href="<?php the_permalink(); ?>#comments"><?php comments_number( '0', '1', '%' ); ?></a></span>
            </div>
        </div>
    <?php }
    
    // VIEWS
    
    if( ! ACF_GF('post_views_meta_show', 'option') ) { 
        $views_count = hannah_cd_getPostViews( get_the_ID() ); 
        $from = array('Views', 'View'); 
        $to = array('', ''); ?>
        <div class="blog-post-metabox meta-views" title="<?php echo esc_html__('Views', 'hannah-cd'); ?>">
            <div class="blog-post-meta-icon">
				<i class="icon fa fa-eye"></i>
				<span><?php echo $replace = strtolower( str_replace($from, $to, $views_count) );  ; ?></span>
            </div>
        </div>
    <?php }
    
    // RATING
    
    if( ! ACF_GF('post_rating_meta_show', 'option') ) { ?>
        <div class="blog-post-metabox meta-rating" title="<?php echo esc_html__('Score', 'hannah-cd'); ?>">
            <div class="blog-post-meta-icon">
                <i class="icon fa fa-star-o"></i>
                <span><?php echo hannah_cd_get_ratings( get_the_ID() ); ?></span>
            </div>
        </div>
    <?php }
    
    // LIKES
    
    if( ! ACF_GF('post_like_meta_show', 'option') ) { ?>
        <div class="blog-post-metabox meta-likes" title="<?php echo esc_html__('Likes', 'hannah-cd'); ?>">
            <div class="blog-post-meta-icon">
                <i class="icon fa fa-heart-o"></i>
                <span><?php hannah_cd_like_count( get_the_ID() ); ?></span>
            </div>
        </div>
    <?php } ?>

</div>