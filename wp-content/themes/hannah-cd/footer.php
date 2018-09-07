<?php 
/*
*************************************** 
Displaying the footer for all pages
***************************************
* @ schema.org
* -> itemtype = Organization
* -> itemprop = publisher
* -> itemprop = name
* -> itemtype = ImageObject
* -> itemprop = url
*/ 

        // ENDING AREA

        if( ACF_GF('ending_area_show', 'option') ) { 
            if( ACF_HR('add_ending_area', 'option') ) : 
                while( ACF_HR('add_ending_area', 'option') ) { the_row();
                    get_template_part( 'inc/acf', 'ending-area' );
                } 
            endif;
        }

        // MAP SECTION

        if( ACF_GF('map_show', 'option') && ACF_GF('map_api_key', 'option') ) {
            if( ACF_HR('maps', 'option') ) : 
                while( ACF_HR('maps', 'option') ) { the_row(); 	
                    if( ACF_GSF('map_position', 'option') == 'bottom' ) {
                        get_template_part( 'inc/acf', 'map' );
                    }
                }
            endif;
        } ?>

    </div><?php // DIV class="content" END ?>

    <footer>

        <?php // FULL WIDTH FOOTERBAR TOP

        if( is_active_sidebar( 'instagram-bar-top' ) ) : ?>
            <section class="footerbar footerbar-top">
                <?php dynamic_sidebar( 'instagram-bar-top' ); ?>
            </section>
        <?php endif;

        // FOOTER SIDEBAR

        if( ! ACF_GF('footer_sidebar_show', 'option') ) { ?>
            <section class="footer-sidebar">
                <div class="container">
                    <div class="row">

                        <?php if( ACF_GF('footer_sidebar_column', 'option') == 'col_1' ) {
                            $footerbar_col = 'col-md-12';
                        } elseif( ACF_GF('footer_sidebar_column', 'option') == 'col_2' ) {
                            $footerbar_col = 'col-md-6';
                        } elseif( ACF_GF('footer_sidebar_column', 'option') == 'col_4' ) {
                            $footerbar_col = 'col-md-3';
                        } else {
                            $footerbar_col = 'col-md-4';
                        }

                        if( ACF_GF('footer_sidebar_column', 'option') == 'col_1' ) {
                            $footer_widget_area_1 = true;
                            $footer_widget_area_2 = false; 
                            $footer_widget_area_3 = false; 
                            $footer_widget_area_4 = false;
                        } elseif( ACF_GF('footer_sidebar_column', 'option') == 'col_2' ) {
                            $footer_widget_area_1 = true;
                            $footer_widget_area_2 = true; 
                            $footer_widget_area_3 = false; 
                            $footer_widget_area_4 = false;
                        } elseif( ACF_GF('footer_sidebar_column', 'option') == 'col_4' ) {
                            $footer_widget_area_1 = true;
                            $footer_widget_area_2 = true; 
                            $footer_widget_area_3 = true; 
                            $footer_widget_area_4 = true;
                        } else {
                            $footer_widget_area_1 = true;
                            $footer_widget_area_2 = true; 
                            $footer_widget_area_3 = true; 
                            $footer_widget_area_4 = false;
                        }     

                        // FOOTER WIDGETS 1                                 

                        if( is_active_sidebar( 'sidebar-left' ) ) : 
                            if( $footer_widget_area_1 ) { ?>
                                <div class="footer-col <?php echo esc_html( $footerbar_col ); ?>">
                                    <?php dynamic_sidebar( 'sidebar-left' ); ?>
                                </div>
                            <?php }
                        endif;                  

                        // FOOTER WIDGETS 2              

                        if( is_active_sidebar( 'sidebar-middle' ) ) : 
                            if( $footer_widget_area_1 || $footer_widget_area_2 ) { ?>
                                <div class="footer-col <?php echo esc_html( $footerbar_col ); ?>">
                                    <?php dynamic_sidebar( 'sidebar-middle' ); ?>
                                </div>
                            <?php }
                        endif;                  

                        // FOOTER WIDGETS 3              

                        if( is_active_sidebar( 'sidebar-right' ) ) : 
                            if( $footer_widget_area_1 && $footer_widget_area_2 && $footer_widget_area_3 ) { ?>
                                <div class="footer-col <?php echo esc_html( $footerbar_col ); ?>">
                                    <?php dynamic_sidebar( 'sidebar-right' ); ?>
                                </div>
                            <?php }
                        endif;                  

                        // FOOTER WIDGETS 4              

                        if( is_active_sidebar( 'sidebar-last' ) ) : 
                            if( $footer_widget_area_1 && $footer_widget_area_2 && $footer_widget_area_3 && $footer_widget_area_4 ) { ?>
                                <div class="footer-col <?php echo esc_html( $footerbar_col ); ?>">
                                    <?php dynamic_sidebar( 'sidebar-last' ); ?>
                                </div>
                            <?php }
                        endif; 

                        if( ! is_active_sidebar( 'sidebar-left' ) && ! is_active_sidebar( 'sidebar-middle' ) && ! is_active_sidebar( 'sidebar-right' ) && ! is_active_sidebar( 'sidebar-last' ) ) :
                            echo esc_html__( 'Add widgets or disable the Footerbar by the theme settings.', 'hannah-cd' );
                        endif; ?>

                    </div>
                </div>
            </section>
        <?php }

        // FULL WIDTH FOOTERBAR BOTTOM

        if( is_active_sidebar( 'instagram-bar' ) ) : ?>
            <section class="footerbar footerbar-bottom">
                <?php dynamic_sidebar( 'instagram-bar' ); ?>
            </section>
        <?php endif; ?>

        <section class="footer text-center<?php if( ACF_GF('social_footer_icons_show', 'option') ) { ?> no-profiles<?php } ?>">
            <div class="container">
                <div class="row">

                    <?php // SOCIAL PROFILES

                    if( ! ACF_GF('social_footer_icons_show', 'option') ):
                        if( ACF_HR('socialbar_column_show', 'option') ): ?>
                            <div class="socialbar">

                                <?php while ( ACF_HR('socialbar_column_show', 'option') ) { the_row();

                                    $socialbar_column_link = ACF_GSF('socialbar_column_link', 'option'); 
                                    $socialbar_column_icon = ACF_GSF('socialbar_column_icon', 'option'); 

                                    if( $socialbar_column_link ) { ?>
                                        <a href="<?php echo esc_url( $socialbar_column_link ); ?>" class="fa <?php echo esc_html( $socialbar_column_icon ); ?>" target="_blank"></a>
                                    <?php }

                                } ?>

                            </div>
                        <?php endif;
                    endif;

                    // FOOTER MENU

                    $theme_location = 'footer_menu';
                    if ( has_nav_menu( $theme_location ) ) {
                        wp_nav_menu( array( 
                            'theme_location' => 'footer_menu',
                            'depth' => 1
                        ));
                    } else {
                        echo esc_html__( 'Assign the footer menu to show menu items.', 'hannah-cd' );
                    }

                    // COPYRIGHT

                    if( ! ACF_GF('copyright_show', 'option') ) {

                        $copyright_year = ACF_GF('copyright_year', 'option'); 
                        $copyright_name = ACF_GF('copyright_name', 'option'); 
                        $logo_schema = ACF_GF('logo_schema', 'option'); 
                        $logo_schema_width = ACF_GF('logo_schema_width', 'option'); ?>

                        <div class="copyright" itemprop="publisher" itemscope itemtype="http://schema.org/Organization">

                            <?php if( !empty($logo_schema) ): ?>
                                <div itemprop="logo" itemscope itemtype="http://schema.org/ImageObject">
                                    <img itemprop="url" src="<?php echo esc_url( $logo_schema['url'] ); ?>" alt="<?php echo esc_html( $logo_schema['alt'] ); ?>" width="<?php if($logo_schema_width){ ?><?php echo esc_html( $logo_schema_width ); ?><?php } else { ?>150<?php } ?>" />
                                </div>
                            <?php endif; ?>

                            <?php echo '&copy; ';

                            if( $copyright_year == date("Y") ) {
                                echo esc_html( $copyright_year );
                            } elseif( $copyright_year != date("Y") ) {
                                echo esc_html( $copyright_year ) . '-' . esc_html( date("Y") );
                            } else {
                                echo '2015 - ' . esc_html( date("Y") );
                            }

                            echo '-';

                            if( $copyright_name ) { ?>
                                <span itemprop="name"><?php echo esc_html( $copyright_name ); ?></span>
                            <?php } else { ?>
                                Creative-Dive
                            <?php } ?>

                        </div>
                    <?php } ?>

                </div>
            </div>
        </section>
        
    </footer>
    
    <?php // SOCIAL PROFILE SIDEBAR

	if( ! ACF_GF('social_profile_sidebar', 'option') ) :
		if( ACF_HR('socialbar_column_show', 'option') ) : 
			$social_profile_sidebar_colored = ACF_GF('social_profile_sidebar_colored', 'option');
			$social_profile_sidebar_align = ACF_GF('social_profile_sidebar_align', 'option'); ?>
			
			<div class="social-profile-sidebar<?php if( ! $social_profile_sidebar_colored ) { ?> colored<?php } ?><?php if( $social_profile_sidebar_align ) { ?> right<?php } ?>">

				<?php while ( ACF_HR('socialbar_column_show', 'option') ) { the_row();
																		   
					$socialbar_column_link = ACF_GSF('socialbar_column_link', 'option'); 
					$socialbar_column_icon = ACF_GSF('socialbar_column_icon', 'option');  
					$socialbar_column_label = ACF_GSF('socialbar_column_label', 'option');
																		   
					if( $socialbar_column_link ) { ?>
						<a href="<?php echo esc_url( $socialbar_column_link ); ?>" target="_blank">
							<span class="social-profile-sidebar-icon fa <?php echo esc_html( $socialbar_column_icon ); ?>"></span>
							<?php if( $socialbar_column_label ) { ?>
								<span class="social-profile-sidebar-label"><span><?php echo esc_html( $socialbar_column_label ); ?></span></span>
							<?php } ?>
						</a>
					<?php } 
																		   
				} ?>

			</div>
			
		<?php endif;
	endif;

    // OVERLAY SEARCH
	
	if( ! ACF_GF('top_search_show', 'option') ) { ?>
        <div class="top-search-form">
            <div class="top-search-form-wrapper">
               	<div class="top-search-form-center">
                	<?php get_search_form(); ?>
				</div>
            </div>
        </div>
	<?php }

    // MODAL WINDOW

	get_template_part( 'inc/acf', 'popup' );

	// EXIT POPUP

	get_template_part( 'inc/acf', 'exit-popup' );

	// WOOCOMMERCE SLIDE OUT SHOPPING CART

	if ( class_exists( 'WooCommerce' ) ) { ?>
		<div class="woocommerce-shopping-cart" data-empty-bag-txt="<?php esc_html_e( 'No products in the cart.', 'hannah-cd' ); ?>">
            <div class="woocommerce-shopping-cart-close">&times;</div>
			<div class="woocommerce-shopping-cart-title"><?php echo esc_html__( 'Cart', 'hannah-cd' ); ?></div>
			<?php the_widget( 'WC_Widget_Cart' ); ?>
		</div>
		<div class="cart-overlay"></div>
    <?php }

    // SCROLL TO TOP

	if( ! ACF_GF('scrolltotop_show', 'option') ) { ?>
		<div class="scrolltop"></div>
	<?php }

    // MOBILE CHECK ?>

	<div class="mobile-check"></div>

	<?php wp_footer(); ?>
	
</body>
</html>
