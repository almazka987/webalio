<!DOCTYPE html>

<html <?php hannah_cd_html_tag_schema(); // schema.org type ?> <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="generator" content="Theme: <?php echo HANNAH_CD_THEME . ' | Version: ' . HANNAH_CD_VER; ?>" />
    <!-- <?php echo hannah_cd_theme_support(); ?> -->
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php 
		global $hannah_cd_header_full;
		
		$topbar = ACF_GF('topbar_show', 'option');
		$image_white = ACF_GF('logo_white', 'option');
		$image_normal = ACF_GF('logo_normal', 'option'); 
		$logo_white_width = ACF_GF('logo_white_width', 'option'); 
		$logo_normal_width = ACF_GF('logo_normal_width', 'option');
		$logo_teaser_text = ACF_GF('logo_teaser_text', 'option');
		$top_search = ACF_GF('top_search_show', 'option');
	
		$top_menu_none = ACF_GF('top_menu_show', 'option') == 'none';
		$top_menu_social = ACF_GF('top_menu_show', 'option') == 'instead_social';
		$top_menu_breadcrumb = ACF_GF('top_menu_show', 'option') == 'instead_breadcrumb';
		
        $menu_style = ACF_GF('menu_style', 'option');
    
		wp_head(); 
    
        if( class_exists('acf') ) {
            hannah_cd_setPostViews( get_the_ID() ); // set post view counter 
        }
    ?>    

</head>

<body <?php body_class(); ?>>
	
    <?php // LOGO OVERLAY 
	
	if( ACF_GF('logo_overlay_show', 'option') ) { ?>
        <div class="logo-overlay">
            <div class="logo-overlay-img">
           	  	<?php 
					if( !empty( $image_white ) ) : 
                    	echo '<img src="' . esc_url( $image_white['url'] ) . '" alt="' .  esc_attr( $image_white['alt'] ) . '" width="' .  esc_attr( $logo_white_width ) . '" />';
                	else : 
                	 	echo '<div class="logo-title">' . get_bloginfo() . '</div>';
                	endif; 
                ?>

				<i class="fa fa-spin fa-circle-o-notch"></i>
            </div>
        </div>
	<?php } ?>
    
	<div class="top-wrapper<?php if( $menu_style == 'style_3' ) { ?> menu-style-3<?php } elseif( $menu_style == 'style_2' ) { ?> menu-style-2<?php } else { ?> menu-style-1<?php } ?>">

		<?php // TOP LAYER

		if( ACF_GF('top_layer_show', 'option') ) {

			get_template_part( 'inc/acf', 'top-layer' );

		} 
        
        // TOPBAR

		if( ! $topbar ) { ?>
			<div class="topbar">
				<div class="container">

					<?php if( $top_menu_none === NULL && $top_menu_social === NULL || $top_menu_none || $top_menu_social ) { ?>

						<div class="left">

							<?php // BREADCRUMB 
								hannah_cd_breadcrumb(); 
							?>

						</div>

					<?php } ?>

					<?php if( $top_menu_none === NULL && $top_menu_breadcrumb === NULL || $top_menu_none || $top_menu_breadcrumb ) { ?>

						<div class="right">

							<?php // SOCIAL PROFILES
																																	
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
							<?php endif; ?>

						</div>

					<?php } ?>

					<?php if( $top_menu_social || $top_menu_breadcrumb ) {

						// OPTIONAL TOP MENU 
						
						if( $top_menu_breadcrumb ) {
							$top_menu_class = 'top-menu left';
						} else {
							$top_menu_class = 'top-menu';
						}

						$theme_location = 'top_menu';
						if( has_nav_menu( $theme_location ) ) {
							wp_nav_menu( array( 
								'container_class' => $top_menu_class, 
								'container_id' => 'top-menu', 
								'menu_class'=> 'top-menu-list', 
								'theme_location' => 'top_menu',
								'depth' => 1
							));
						} else {
							// if no theme location is selected
							echo '<div class="top-menu">';
								echo '<ul class="top-menu-list">';
									echo '<li>';
										echo '<a href="#">' . esc_html__( 'Assign the primary menu to show menu items.', 'hannah-cd' ) . '</a>';
									echo '</li>';
								echo '</ul>';
							echo '</div>';
						}

					} ?>

				</div>
			</div>
		<?php } 
        
        // MENU STYLE 2

        if( $menu_style == 'style_2' ) { ?>

        <div class="main-logo">
			<div class="container">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logo">

					<?php include( locate_template('inc/acf-logo.php') ); ?>

				</a>
			</div>
		</div>
        
        <?php } ?>
        
		<header class="navbar navbar-fixed-top">
			<div class="container">

				<?php // LOGO SWITCH ?>

				<div class="navbar-header">
                    
                    <?php // MENU STYLE 1

                    if( $menu_style == 'style_1' || $menu_style === NULL ) { ?>
                    
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logo">

                            <?php include( locate_template('inc/acf-logo.php') ); ?>

                        </a>
                
                    <?php } ?>

					<div class="mobile-menu-spacer">

						<?php // MOBILE MENU TOGGLE ?>

						<button type="button" class="nav-icon navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
							<i class="fa fa-bars"></i>
							<i class="fa fa-close"></i>
						</button>
                        
                        <?php // MOBILE LOGO - MENU STYLE 2 OR 3

                        if( $menu_style == 'style_2' || $menu_style == 'style_3' ) { ?>

                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logo">

                                <?php include( locate_template('inc/acf-logo.php') ); ?>

                            </a>

                        <?php }
                        
                        if ( class_exists( 'WooCommerce' ) && ! ACF_GF('show_woocommerce_basket', 'option') ) { 
						
							// MOBILE WOOCOMMERCE SHOPPING CART ?>
				
							<button class="nav-icon cart-button">
								<?php do_action( 'wc_shopping_cart_icon' ); ?>
							</button>
							
						<?php } else {
						
							// MOBILE SEARCH ICON

							if( ! $top_search ) { ?>
								<button class="nav-icon top-search"><i class="fa fa-search"></i></button>
							<?php } 
						
						} ?>

					</div>

				</div>

				<div class="collapse navbar-collapse" id="navbar-collapse">
					
					<?php // NAVBAR ICONS 
					
					if ( class_exists( 'WooCommerce' ) || ACF_GF('show_woocommerce_login_icon', 'option') || ! $top_search ) { ?>
					
						<div class="navbar-icons">

							<?php if ( class_exists( 'WooCommerce' ) ) { 

								// WOOCOMMERCE SHOPPING CART 
                                if ( ! ACF_GF('show_woocommerce_basket', 'option') ) { ?>

                                    <button class="nav-icon cart-button">
                                        <?php do_action( 'wc_shopping_cart_icon' ); ?>
                                    </button>

								<?php }
                        
                                // WOOCOMMERCE MY ACCOUNT 
								if ( ACF_GF('show_woocommerce_login_icon', 'option') ) { ?>
									<div class="account-cart-wrapper">
									
										<?php if ( is_user_logged_in() ) { ?>
											<a class="nav-icon account-button" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php echo esc_attr__('My Account', 'hannah-cd'); ?>">
												<i class="fa fa-user-circle-o"></i>
											</a>
										<?php } else { ?>
											<a class="nav-icon account-button" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php echo esc_attr__('Login / Register', 'hannah-cd'); ?>">
												<i class="fa fa-user-circle-o"></i>
											</a>
										<?php }

										// WOOCOMMERCE LOGIN / REGISTER ?>

										<div class="woocommerce-account-cart">
											<?php 
												echo do_shortcode( '[woocommerce_my_account]' ); 
											?>
										</div>
										
									</div>
    							<?php 

								}
							} ?>

							<?php // SEARCH ICON
																															  
							if( ! $top_search ) { ?>
								<button class="nav-icon top-search"><i class="fa fa-search"></i></button>
							<?php } ?>

						</div>
					
					<?php } ?>

					<?php // LANDINGPAGE SCROLLMENU
					
					if( is_page_template( 'landingpage.php' ) ) { ?>

						<div id="primary-menu" class="main-menu">
							<ul class="nav navbar-nav navbar-right">

								<?php if( ACF_HR('landingpage_menu') ) : 
									$count = 0;
									while ( ACF_HR('landingpage_menu') ) { the_row();

										$home_menu_name = ACF_GSF('landingpage_menu_item'); 
										$lp_section_link_type = ACF_GSF('lp_section_link_type'); 
										$lp_section_link_url = ACF_GSF('lp_section_link_url'); 
										$lp_section_link_intern = ACF_GSF('lp_section_link_intern'); 
										$lp_section_number = ACF_GSF('lp_section_number');
										
										// add class to the first li
                                                                          
										$count = $count +1;
																		  
										if( $count == 1 ) {
											$li_class = 'active'; 
										} else {
											$li_class = ''; 
										}

										// get type of link

										if( $lp_section_link_type == 'extern_link' ) {
											$link_output = $lp_section_link_url;
										} elseif( $lp_section_link_type == 'intern_link' ) {
											$link_output = $lp_section_link_intern;
										} else {
											$link_output = '#section_' . $lp_section_number;
										} ?>										

										<li class="<?php echo esc_attr( $li_class ); ?>">
											<a class="section-scroll" href="<?php echo esc_url( $link_output ); ?>"<?php if( $lp_section_link_type == 'extern_link' ) { ?> target="_blank"<?php } ?>>
												<?php if( $home_menu_name ) {
                                                    echo esc_html( $home_menu_name );
                                                } ?>
											</a>  
											
										</li>
										
									<?php } 
								endif; ?>

							</ul>
						</div>

					<?php // DEFAULT WP MENU
																	  
					} else {
	
						$theme_location = 'primary_menu';
						if( has_nav_menu( $theme_location ) ) {
							wp_nav_menu( array( 
								'container_class' => 'main-menu', 
								'container_id' => 'primary-menu', 
								'menu_class'=> 'nav navbar-nav navbar-right', 
								'theme_location' => 'primary_menu' 
							));
						} else {
							// if no theme location is selected
							echo '<div class="main-menu">';
								echo '<ul class="nav navbar-nav navbar-right">';
									echo '<li>';
										echo '<a href="#">' . esc_html__( 'Assign the primary menu to show menu items.', 'hannah-cd' ) . '</a>';
									echo '</li>';
								echo '</ul>';
							echo '</div>';
						}

					} ?>

				</div>
			</div>
		</header>
        
        <?php // MENU STYLE 3

        if( $menu_style == 'style_3' ) { ?>

        <div class="main-logo">
			<div class="container">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logo">

					<?php include( locate_template('inc/acf-logo.php') ); ?>

				</a>
			</div>
		</div>
        
        <?php } ?>

	</div>
	
	<?php // LEADING AREA ABOVE
	
	if( ACF_GF('leading_area_show', 'option') ) { 
     	if( ACF_HR('add_leading_area', 'option') ) : 
			while ( ACF_HR('add_leading_area', 'option') ) { the_row();
      		
				if( ACF_GSF('leading_area_position', 'option') == 'above_header' ) {
					get_template_part( 'inc/acf', 'leading-area' );
				}
				
        	} 
		endif;
	} ?>
