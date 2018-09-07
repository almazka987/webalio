<?php 
/*
*************************************** 
Displaying for author meta 
***************************************
*/

if( ! ACF_GF('author_bio_show', 'option') ) { 

    $author_id = get_the_author_meta( 'ID' ); ?>
    
    <div class="author-section">

        <div class="special-title">
            <span><?php echo esc_html__( 'The Author', 'hannah-cd' ); ?></span>
        </div>

        <div class="author-info">

            <div class="author-user">    
                <div class="author-heading"><?php esc_html_e( 'Published by', 'hannah-cd' ); ?></div>
                <div class="author-avatar">
                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), 76 ); ?>
                </div>
                <div class="author-title"><?php echo get_the_author(); ?></div>
            </div>

            <div class="author-description">
                <?php the_author_meta( 'description' ); ?>
                <a class="author-link" href="<?php echo esc_url( get_author_posts_url( esc_html( $author_id ) ) ); ?>" rel="author">
                    <?php printf( esc_html__( 'View all posts by %s', 'hannah-cd' ), get_the_author() ); ?>
                </a>

                <?php // SOCIAL USER PROFILES

                if( ACF_HR('user_social_profiles', 'user_' . $author_id ) ) : ?>

                    <div class="socialbar">

                        <?php while ( ACF_HR('user_social_profiles', 'user_' . $author_id) ) { the_row();

                            $socialbar_user_link = ACF_GSF('user_social_profiles_link', 'user_' . $author_id); 
                            $socialbar_user_icon = ACF_GSF('user_social_profiles_icon', 'user_' . $author_id);
                            $socialbar_user_label = ACF_GSF('user_social_profiles_label', 'user_' . $author_id);

                            if( $socialbar_user_link ) { ?>
                                <a href="<?php echo esc_url( $socialbar_user_link ); ?>" target="_blank"<?php if( $socialbar_user_label ) { ?> title="<?php echo esc_html( $socialbar_user_label ) . ' ' . esc_html__( 'Profile', 'hannah-cd' ) . ' ' . esc_html__( 'of', 'hannah-cd' ) . ' ' . get_the_author(); ?>"<?php } ?>>
                                    <i class="fa <?php echo esc_html( $socialbar_user_icon ); ?>"></i>
                                </a>
                            <?php } 

                        } ?>

                    </div>

                <?php endif; ?>

            </div>

        </div>
        
    </div>

<?php } ?>