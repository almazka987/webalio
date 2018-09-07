<?php 
/*
*************************************** 
Displaying for post metas
***************************************
* @ schema.org
* -> itemtype = Person
* -> itemprop = author
* -> itemprop = image
* -> itemprop = name
*/ 
?>

<div class="blog-post-meta">

	<?php // AUTHOR 
	
	if( ! ACF_GF('post_author_meta_show', 'option') ) {
		$author_id = $post->post_author; ?>  
	
        <div class="blog-post-metabox meta-author" itemprop="author" itemscope itemtype="http://schema.org/Person">
            <div class="blog-post-meta-icon">
                <?php echo get_avatar( get_the_author_meta( 'user_email', $author_id ), 36, null, null, array('extra_attr' => 'itemprop="image"') ); ?>
            </div>
            <div class="blog-post-meta-content">
                <?php echo esc_html_e( 'by', 'hannah-cd' ); ?> 
                <a href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>">
                    <span itemprop="name"><?php esc_html( the_author_meta( 'display_name' , $author_id ) ); ?></span>
                </a>
            </div>
        </div>
	
    <?php } 
    
    // COMMENTS
    
    if( ! ACF_GF('post_comments_meta_show', 'option') && comments_open() ) { ?>
        <div class="blog-post-metabox meta-comments">
            <div class="blog-post-meta-icon">
                <i class="icon fa fa-comment-o"></i>
            </div>
            <div class="blog-post-meta-content">
                <span><a href="<?php the_permalink(); ?>#comments"><?php comments_number( esc_html__( 'No comments', 'hannah-cd' ), esc_html__( 'One comment', 'hannah-cd' ), esc_html__( '% comments', 'hannah-cd' ) ); ?></a></span>
            </div>
        </div>
    <?php }
    
    // VIEWS 
    
    if( ! ACF_GF('post_views_meta_show', 'option') ) { ?>
        <div class="blog-post-metabox meta-views">
            <div class="blog-post-meta-icon">
                <i class="icon fa fa-eye"></i>
            </div>
            <div class="blog-post-meta-content">
                <span><?php echo hannah_cd_getPostViews( get_the_ID() ); ?></span>
            </div>
        </div>
    <?php }
    
    // RATING
    
    if( ! ACF_GF('post_rating_meta_show', 'option') ) { ?>
        <div class="blog-post-metabox meta-rating">
            <div class="blog-post-meta-icon">
                <i class="icon fa fa-star-o"></i>
            </div>
            <div class="blog-post-meta-content">
                <span><?php echo hannah_cd_get_ratings( get_the_ID() ); ?>&nbsp;&nbsp;<?php echo esc_html_e('Score', 'hannah-cd'); ?></span>
            </div>
        </div>
    <?php }
    
    // LIKES
    
    if( ! ACF_GF('post_like_meta_show', 'option') ) { ?>
        <div class="blog-post-metabox meta-likes">
            <div class="blog-post-meta-icon">
                <i class="icon fa fa-heart-o"></i>
            </div>
            <div class="blog-post-meta-content">
                <span><?php hannah_cd_like_count( get_the_ID() ); ?>&nbsp;&nbsp;<?php echo esc_html_e("Likes", "hannah-cd"); ?></span>
            </div>
        </div>
    <?php } ?>

</div>