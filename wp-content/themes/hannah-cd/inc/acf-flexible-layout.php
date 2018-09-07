<?php 
/*
*************************************** 
Displaying for flexible sections on pages by acf
***************************************
*/                                            

if( ACF_HR('content_rows') ) {
    
    $lp_menu_item_count = '1'; // start counter
    
    while ( ACF_HR('content_rows') ) { the_row();
                                                 
        /**********************/ 
        /* LOGO CAROUSEL SECTION */ 
        /**********************/

		if( get_row_layout() == 'logos' ) { 

			$logo_headline = ACF_GSF('logo_headline'); 
			$logo_text = ACF_GSF('logo_text'); ?>
	
			<section class="sec logos text-center<?php if( $logo_headline || $logo_text ) { ?> padding-90<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">

					<?php if( $logo_headline || $logo_text ) { ?>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<?php if( $logo_headline ) { 
                                    echo '<h2>' . esc_html( $logo_headline ) . '</h2>';
                                } 
                                if( $logo_text ) { 
                                    echo ACF_GSF('logo_text'); // HTML output is escaped by acf_kses_post();
                                } ?>
							</div>
						</div>
					<?php }
            
                    if( ACF_HR('logo_show') ) : ?>
						<div class="section-content<?php if( ! $logo_headline && ! $logo_text ) { ?> mtop-null<?php } ?>">

							<div class="row">
								<div class="logos-owl owl-carousel">
									<?php while ( ACF_HR('logo_show') ) { the_row(); 

										$image = ACF_GSF('logo_img');
										if ( ! is_array( $image ) ) { 
                                            $image = acf_get_attachment( $image ); 
                                        }
										$logo_url = ACF_GSF('logo_url'); ?>

										<div class="logo-box">
											<?php if( $logo_url ) { ?>
												<a href="<?php echo esc_url( $logo_url ); ?>" rel="nofollow" target="_blank">
											<?php }
                                                if( ! empty( $image ) ) : ?>
													<img class="img-responsive" src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
												<?php endif;
                                            if( $logo_url ) { ?>
												</a>
											<?php } ?>
										</div>

									<?php } ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* FEATURES 1 SECTION */ 
        /**********************/ 
                                                 
        if( get_row_layout() == 'features1' ) { 

        $features1_headline = ACF_GSF('features1_headline'); 
        $features1_text = ACF_GSF('features1_text'); 
        $features1_column = ACF_GSF('features1_column'); ?>
			
			<section class="sec features-1 text-center<?php if( $features1_headline || $features1_text ) { ?> padding-120<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">
					
					<?php // get column
                    if( $features1_column == 'col_1' ) {
                        $column = 'col-md-12';
                    } elseif( $features1_column == 'col_2' ) { 
                        $column = 'col-md-6';
                    } elseif( $features1_column == 'col_3' ) { 
                        $column = 'col-md-4';
                    } elseif( $features1_column == 'col_4' ) { 
                        $column = 'col-md-3';
                    } elseif( $features1_column == 'col_5' ) { 
                        $column = 'col-md-2-4';
                    } elseif( $features1_column == 'col_6' ) { 
                        $column = 'col-md-2';
                    }
                                               
                    if( $features1_headline || $features1_text ) { ?>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <?php 
									if( $features1_headline ) { 
                                    	echo '<h2>' . esc_html( $features1_headline ) . '</h2>';
                                	} 
									if( $features1_text ) { 
										echo ACF_GSF('features1_text'); // HTML output is escaped by acf_kses_post();
                                 	} 
								?>
                            </div>
                        </div>
					<?php }
                                               
                    if( ACF_HR('features1_column_show') ): ?>
						<div class="section-content<?php if( ! $features1_headline && ! $features1_text ) { ?> mtop-null<?php } ?>">
							<div class="row">
								<?php while ( ACF_HR('features1_column_show') ) { the_row();
                                                                                 
                                    $features1_column_icon = ACF_GSF('features1_column_icon'); 
                                    $features1_column_headline = ACF_GSF('features1_column_headline'); 
                                    $features1_column_text = ACF_GSF('features1_column_text');
                                    $features1_column_link = ACF_GSF('features1_column_link');

                                    if( $features1_column_link == 'intern' ) {
                                        $url = ACF_GSF('features1_column_link_to');
                                    } elseif( $features1_column_link == 'extern' ) {
                                        $url = ACF_GSF('features1_column_url');
                                    } else {
                                        $url = false;
                                    } ?>
								
									<div class="<?php echo esc_html( $column ); ?>">
										<?php if( $features1_column_icon ) { ?>
                                            <i class="icon fa fa-5x <?php echo esc_attr( $features1_column_icon ); ?>"></i>
                                        <?php }
                                                                                 
                                        if( $features1_column_headline ) {
                                            if( $url ) { echo '<a href="' . esc_url( $url ) . '">'; }
                                                echo '<h3>';
                                                    echo esc_html( $features1_column_headline );
                                                echo '</h3>';
                                            if( $url ) { echo '</a>'; }
                                        } 
                                                                                 
                                        if( $features1_column_text ) { 
                                            echo apply_filters( 'the_content', ACF_GSF('features1_column_text') ); 
                                        } ?>
									</div>

								<?php } ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* FEATURES 2 SECTION */ 
        /**********************/
                                                
        if( get_row_layout() == 'features2' ) { 
            
            $features2_headline = ACF_GSF('features2_headline'); 
			$features2_text = ACF_GSF('features2_text'); 
            $image_alignment = ACF_GSF('features2_alignment'); ?>

			<section class="sec features-2<?php if( $features2_headline || $features2_text ) { ?> padding-120<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">
					<div class="row">  
                        
						<div class="col-md-5 text-center<?php if( $image_alignment == 'right' ) { ?> col-md-push-7<?php } ?>">

							<?php $image = ACF_GSF('features2_img');
                            if( ! is_array( $image ) ) { $image = acf_get_attachment($image); }
                            $myeffect = ACF_GSF('animated_image_effect'); 
                            $myeffectduration = ACF_GSF('animated_image_effect_duration'); 
                                               
                            if( !empty($image) ): ?>
                                <div class="<?php if( $myeffect ) { ?> wow <?php echo esc_attr( $myeffect ); ?><?php } ?>" data-wow-duration="<?php if( $myeffectduration ) { ?><?php echo esc_attr( $myeffectduration ); ?><?php } ?>s">
                                    <img class="img-responsive" src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
                                </div>
							<?php endif; ?>

						</div>
                        
						<div class="col-md-6<?php if( $image_alignment == 'right' ) { ?> col-md-pull-5<?php } ?>">
	
							<?php if( $features2_headline ) { ?>
								<h2><?php echo esc_html( $features2_headline ); ?></h2>
							<?php }
                            
                            if( $features2_text ) {
                                echo ACF_GSF('features2_text'); // HTML output is escaped by acf_kses_post();
                            }
                                               
                            if( ACF_HR('features2_column_show') ): ?>
								<div class="section-content<?php if( ! $features2_headline && ! $features2_text ) { ?> mtop-null<?php } ?>">
									
									<?php while ( ACF_HR('features2_column_show') ) { the_row();
                                                                                     
                                        $features2_column_icon = ACF_GSF('features2_column_icon'); 
                                        $features2_column_headline = ACF_GSF('features2_column_headline'); 
                                        $features2_column_text = ACF_GSF('features2_column_text'); 
                                        $features2_column_link = ACF_GSF('features2_column_link');

                                        if( $features2_column_link == 'intern' ) {
                                            $url = ACF_GSF('features2_column_link_to');
                                        } elseif( $features2_column_link == 'extern' ) {
                                            $url = ACF_GSF('features2_column_url');
                                        } else {
                                            $url = false;
                                        }
                                                                                     
                                        if( $features2_column_headline ) { ?>
											<div class="col-md-12">
												<?php if( $features2_column_icon ) { ?>
													<div class="media-left">
														<i class="fa fa-2x <?php echo esc_attr( $features2_column_icon ); ?>"></i>
													</div>
												<?php } ?>
												<div class="media-right">
													<?php if( $features2_column_headline ) {
                                                        if( $url ) { echo '<a href="' . esc_url( $url ) . '">'; }
                                                            echo '<h4>';
                                                                echo esc_html( $features2_column_headline );
                                                            echo '</h4>';
                                                        if( $url ) { echo '</a>'; }
												    }
                                                                          
                                                    if( $features2_column_text ) {
                                                        echo apply_filters( 'the_content', ACF_GSF('features2_column_text') );
                                                    } ?>
												</div>
											</div>
										<?php }
                                                                                     
                                    } ?>
		
								</div>
							<?php endif; ?>

						</div>
                        
					</div>
				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* FEATURES 3 SECTION */ 
        /**********************/
                                                
        if( get_row_layout() == 'features3' ) { 
            
            $features3_headline = ACF_GSF('features3_headline'); 
			$features3_text = ACF_GSF('features3_text'); 
            $image_alignment = ACF_GSF('features3_alignment'); ?>

			<section class="sec features-3<?php if( $features3_headline || $features3_text ) { ?> padding-120<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">
					<div class="row">

						<div class="text-center col-md-5<?php if( $image_alignment == 'right' ) { ?> col-md-push-7<?php } ?>">

							<?php $image = ACF_GSF('features3_img'); 
                            if ( ! is_array( $image ) ) { $image = acf_get_attachment($image); }
                            $myeffect = ACF_GSF('animated_image_effect'); 
                            $myeffectduration = ACF_GSF('animated_image_effect_duration');
                                               
                            if( !empty($image) ): ?>
                                <div class="<?php if( $myeffect ) { ?> wow <?php echo esc_attr( $myeffect ); ?><?php } ?>" data-wow-duration="<?php if( $myeffectduration ) { ?><?php echo esc_attr( $myeffectduration ); ?><?php } ?>s">
                                    <img class="img-responsive" src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
                                </div>
							<?php endif; ?>

						</div>

						<div class="col-md-7<?php if( $image_alignment == 'right' ) { ?> col-md-pull-5<?php } ?>">

							<?php if( $features3_headline ) { ?>
								<h2><?php echo esc_html( $features3_headline ); ?></h2>
							<?php }
                                               
                            if( $features3_text ) { ?>
								<div class="row">
									<div class="col-md-10">
										<?php echo ACF_GSF('features3_text'); // HTML output is escaped by acf_kses_post(); ?>
									</div>
								</div>
							<?php }
                                               
                            if( ACF_HR('features3_column_show') ) : ?>
								<div class="section-content<?php if( ! $features3_headline && ! $features3_text ) { ?> mtop-null<?php } ?>">
									<div class="row">
		
										<?php while ( ACF_HR('features3_column_show') ) { the_row();
                                                                                         
                                            $features3_column_icon = ACF_GSF('features3_column_icon'); 
                                            $features3_column_headline = ACF_GSF('features3_column_headline'); 
                                            $features3_column_text = ACF_GSF('features3_column_text'); 
                                            $features3_column_link = ACF_GSF('features3_column_link');

                                            if( $features3_column_link == 'intern' ) {
                                                $url = ACF_GSF('features3_column_link_to');
                                            } elseif( $features3_column_link == 'extern' ) {
                                                $url = ACF_GSF('features3_column_url');
                                            } else {
                                                $url = false;
                                            } ?>

											<div class="col-md-6">
												<?php if( $features3_column_icon ) { ?>
													<div class="media-left">
														<span class="fa-stack fa-lg">
															<i class="fa <?php echo esc_attr( $features3_column_icon ); ?>"></i>
														</span>
													</div>
												<?php } ?>
												<div class="media-right">
													<?php if( $features3_column_headline ) {
                                                        if( $url ) { echo '<a href="' . esc_url( $url ) . '">'; }
                                                            echo '<h4>';
                                                                echo esc_html( $features3_column_headline );
                                                            echo '</h4>';
                                                        if( $url ) { echo '</a>'; }
                                                    }
                                                                                         
                                                    if( $features3_column_text ) {
                                                        echo apply_filters( 'the_content', ACF_GSF('features3_column_text') );
                                                    } ?>
												</div>
											</div>

										<?php } ?>

									</div>
								</div>
							<?php endif; ?>

						</div>
					</div>
				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* BANNER SECTION */ 
        /**********************/ 
                                                 
        if( get_row_layout() == 'banner' ) { 

            $banner_headline = ACF_GSF('banner_headline'); 
            $banner_text = ACF_GSF('banner_text');
            $banner_color = ACF_GSF('banner_bg'); ?>

			<section class="sec banner padding-90"<?php if( $banner_color ) { ?> style="background-color: <?php echo esc_html( $banner_color ); ?>"<?php } ?> id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
                <?php hannah_cd_section_start(); ?>
				<div class="container">
					<div class="row">

						<?php if( $banner_headline ) { ?>
							<div class="col-md-4">
								<h2><?php echo esc_html( $banner_headline ); ?></h2>
							</div>
						<?php }
                                            
                        if( $banner_text ) { ?>
							<div class="col-md-5">
								<?php echo hannah_cd_kses( $banner_text ); ?>
							</div>
						<?php }
                                            
                        if( ACF_HR('button_show') ): ?>
							<div class="col-md-3 text-center">

								<?php while ( ACF_HR('button_show') ) {
                                    get_template_part( 'inc/acf', 'buttons' );
                                } ?>

							</div>
						<?php endif; ?>
					
					</div>
				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* REVIEWS SECTION */ 
        /*********************
        * @ schema.org
        * -> itemtype = Review
        * --> itemprop = reviewBody
        * -> itemtype = Person
        * --> itemprop = author
        * --> itemprop = name
        * -> itemtype = Product
        * --> itemprop = itemReviewed
        * -> itemtype = Rating
        * ---> itemprop = worstRating
        * ---> itemprop = bestRating
        * ---> itemprop = ratingValue
        */ 
                                                 
        if( get_row_layout() == 'reviews' ) { 

            $reviews_headline = ACF_GSF('reviews_headline'); 
            $reviews_text = ACF_GSF('reviews_text'); ?>

			<section class="sec reviews text-center<?php if( $reviews_headline || $reviews_text ) { ?> padding-90<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">
				
					<?php if( $reviews_headline || $reviews_text ) { ?>
						<div class="row">
							<div class="col-md-6 col-md-offset-3">

								<?php if( $reviews_headline ) { ?>
									<h2><?php echo esc_html( $reviews_headline ); ?></h2>
								<?php } ?>

								<?php if( $reviews_text ) {
                                    echo ACF_GSF('reviews_text'); // HTML output is escaped by acf_kses_post();
                                } ?>

							</div>
						</div>
					<?php }
                                             
                    if( ACF_HR('reviews_column_show') ): ?>
						<div class="section-content<?php if( ! $reviews_headline && ! $reviews_text ) { ?> mtop-null<?php } ?>">
							<div class="row">
								<div class="review-owl owl-carousel">

									<?php while ( ACF_HR('reviews_column_show') ) { the_row();
                                                                                   
                                        $image = ACF_GSF('reviews_column_img'); 
                                        if ( ! is_array( $image ) ) { $image = acf_get_attachment($image); }
                                        $reviews_column_headline = ACF_GSF('reviews_column_headline'); 
                                        $reviews_column_text = ACF_GSF('reviews_column_text'); 
                                        $reviews_product = ACF_GSF('reviews_product'); 
                                        $reviewdate = new DateTime(ACF_GSF('reviews_date')); ?>

										<div itemscope itemtype="http://schema.org/Review">
                                            <div class="review-box">
                                                <?php if( !empty($image) ): ?>
                                                   	<div class="review-img" style="background-image: url(<?php echo esc_url( $image['url'] ); ?>)"></div>
                                                <?php endif; ?>
												<div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"> 
                                                    <meta itemprop="worstRating" content="1"> 
                                                    <meta itemprop="bestRating" content="5">
    
                                                    <?php if( ACF_GSF('reviews_rating') == '1' ) { ?>
                                                        <i class="fa fa-star"></i>
                                                    <?php } elseif( ACF_GSF('reviews_rating') == '2' ) { ?>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    <?php } elseif( ACF_GSF('reviews_rating') == '3' ) { ?>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    <?php } elseif( ACF_GSF('reviews_rating') == '4' ) { ?>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    <?php } elseif( ACF_GSF('reviews_rating') == '5' ) { ?>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    <?php } ?>
     
                                                    <meta itemprop="ratingValue" content="<?php echo esc_html( ACF_GSF('reviews_rating') ); ?>"> 
                                                </div>
												<?php if( $reviews_product ) { ?>
                                                    <div class="review-product" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Product">
                                                        <?php echo esc_html_e( 'Reviewed', 'hannah-cd' ); ?>: <?php echo esc_html( $reviews_product ); ?>
                                                    </div>
                                                <?php }
                                                                                   
                                                if( $reviews_column_headline ) { ?>
                                                    <h3 itemscope itemtype="http://schema.org/Person" itemprop="author">
														<span itemprop="name"><?php echo esc_html( $reviews_column_headline ); ?></span>
													</h3>
                                                <?php }
                                                                                   
                                                if( $reviews_column_text ) { ?>
                                                    <p itemprop="reviewBody">
                                                        <?php echo esc_html( $reviews_column_text ); ?>
                                                    </p>
                                                <?php }
                                                                                   
                                                if( $reviewdate ) { ?>
													<time itemprop="datePublished" content="<?php echo esc_attr( date_format($reviewdate, 'Y-m-d\TH:i:s') ); ?>"><?php echo esc_html( date_format($reviewdate, 'Y-m-d\TH:i:s') ); ?></time>
                                                <?php } ?>
                                            </div>

										</div>
	
									<?php } ?>

								</div>
							</div>
						</div>
					<?php endif; ?>

				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }    
                                      
        /**********************/ 
        /* PRICES SECTION */ 
        /**********************/ 
                                      
        if( get_row_layout() == 'prices' ) {
            
            $prices_headline = ACF_GSF('prices_headline'); 
            $prices_text = ACF_GSF('prices_text'); 
            $prices_column_currency = ACF_GSF('prices_column_currency'); 
            $background_image = ACF_GSF('prices_background');
            $bg_image = wp_get_attachment_image_src( $background_image, 'large', false, '' ); ?>
			
			<section class="sec prices text-center section-overlay<?php if( $prices_headline || $prices_text ) { ?> padding-120<?php } else { ?> no-heading<?php } ?>" <?php if( $bg_image ) { ?>style="background-image:url(<?php echo $bg_image[0]; ?>)"<?php } ?> id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
                
                <?php hannah_cd_section_start(); ?>
                
				<div class="container">
				
					<?php if( $prices_headline || $prices_text ) { ?>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">

								<?php if( $prices_headline ) { ?>
									<h2><?php echo esc_html( $prices_headline ); ?></h2>
								<?php }
                                                            
                                if( $prices_text ) {
                                    echo ACF_GSF('prices_text'); // HTML output is escaped by acf_kses_post();
                                } ?>

							</div>
						</div>
					<?php }
            
                    if( ACF_HR('prices_column_show') ): ?>
						<div class="section-content<?php if( ! $prices_headline && ! $prices_text ) { ?> mtop-null<?php } ?>">
							<div class="row">

								<?php while ( ACF_HR('prices_column_show') ) { the_row();
                                                                              
                                    $prices_column_headline = ACF_GSF('prices_column_headline'); 
                                    $prices_column_price = ACF_GSF('prices_column_price'); 
                                    $prices_column_period = ACF_GSF('prices_column_period'); ?>

									<div class="<?php if( ACF_GSF('prices_column_leading') ) { ?>leading <?php } ?>price-content">
										<div class="price-box">

											<header>
												<?php if( $prices_column_headline ) { ?>
													<h4><?php echo esc_html( $prices_column_headline ); ?></h4>
												<?php } ?>
												<div class="the-price">
													<?php if( $prices_column_currency ) { ?>
														<strong class="the-price-curr"><?php echo esc_html( $prices_column_currency ); ?></strong>
													<?php }
                                                                              
                                                    if( $prices_column_price ) { ?>
														<strong class="the-price-amou"><?php echo esc_html( $prices_column_price ); ?></strong>
													<?php }
                                                                              
                                                    if( $prices_column_period ) { ?>
														<span class="the-price-deli">/</span>
														<strong class="the-price-peri"><?php echo esc_html( $prices_column_period ); ?></strong>
													<?php } ?>
												</div>
											</header>

											<?php if( ACF_HR('prices_features_show') ): ?>
												<div class="price-features">
													<ul>
														<?php while ( ACF_HR('prices_features_show') ) { the_row();
                                                            $prices_features_text = ACF_GSF('prices_features_text');
                                                                                                    
                                                            if( $prices_features_text ) { ?>
																<li>
																	<?php echo hannah_cd_kses( $prices_features_text ); ?>
																</li>
															<?php }
                                                        } ?>
													</ul>
												</div>
											<?php endif;
                                                                              
                                            if( ACF_HR('button_show') ) :
                                                while ( ACF_HR('button_show') ) {
                                                    get_template_part( 'inc/acf', 'buttons' );
                                                }
                                            endif; ?>

										</div>
									</div>

								<?php } ?>
	
							</div>
						</div>
					<?php endif; ?>

				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php } 
                                      
        /**********************/ 
        /* PIE CHARTS SECTION */
        /**********************/ 
                                      
        if( get_row_layout() == 'pie_charts' ) { 

            $pie_chart_headline = ACF_GSF('pie_chart_headline'); 
            $pie_chart_text = ACF_GSF('pie_chart_text'); ?>

			<section class="sec pie-charts text-center<?php if( $pie_chart_headline || $pie_chart_text ) { ?> padding-90<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">

					<?php if( $pie_chart_headline || $pie_chart_text ) { ?>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<?php if( $pie_chart_headline ) { ?>
									<h2><?php echo esc_html( $pie_chart_headline ); ?></h2>
								<?php }
                                                                  
                                if( $pie_chart_text ) {
                                    echo ACF_GSF('pie_chart_text'); // HTML output is escaped by acf_kses_post(); 
                                } ?>
							</div>
						</div>
					<?php } ?>

					<div class="section-content<?php if( ! $pie_chart_headline && ! $pie_chart_text ) { ?> mtop-null<?php } ?>">

						<?php if( ACF_HR('pie_chart_show') ) :
                            while ( ACF_HR('pie_chart_show') ) { the_row();
                                                                
                                $pie_title = ACF_GSF('pie_title'); 
                                $pie_number = ACF_GSF('pie_number'); 
                                $pie_type = ACF_GSF('pie_type'); 
                                $pie_percent = ACF_GSF('pie_percent'); ?>
                                
                                <div class="column pie-column">
                                    <div class="chart" data-percent="<?php echo esc_attr( $pie_percent ); ?>">
                                        <div class="chart-content">
                                            
                                            <?php if( $pie_number ) { ?><div class="chart-number"><?php echo esc_html( $pie_number ); ?></div><?php } ?>
                                            <?php if( $pie_type ) { ?>
                                                <div class="line line-center"></div>
                                                <div class="chart-type"><?php echo esc_html( $pie_type ); ?></div>
											<?php } ?>
                                        </div>
                                    </div>
									<?php if( $pie_title ) { ?><div class="chart-title"><?php echo esc_html( $pie_title ); ?></div><?php } ?>
                                </div>

                            <?php }
                        endif; ?>

					</div>

				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                       
        /**********************/ 
        /* IMAGE & VIDEO BACKGROUND SECTION */ 
        /**********************/ 

		if( get_row_layout() == 'image_sec' ) {
            
            $image_sec_headline = ACF_GSF('image_sec_headline'); 
            $image_sec_text = ACF_GSF('image_sec_text'); 
            $image_sec_align = ACF_GSF('image_sec_alignment');

            if( $image_sec_align == 'right' ) {
                $alignment = 'right';
            } elseif( $image_sec_align == 'center' ) {
                $alignment = 'center';
            } else {
                $alignment = 'left';
            }

            $background_color = ACF_GSF('background_color');
            $background_gradient_start = ACF_GSF('background_gradient_start_color');
            $background_gradient_end = ACF_GSF('background_gradient_end_color');
            $background_image = ACF_GSF('background_image');
            $bg_image = wp_get_attachment_image_src( $background_image, 'large', false, '' );
            $bg_image_featured = get_the_post_thumbnail_url( get_the_ID(), 'large' );

            $background_video = ACF_GSF('background_video'); 
            $background_video_alternate = ACF_GSF('background_video_alternate'); 
            $background_video_external = ACF_GSF('background_video_external'); 
            $background_video_external_alternate = ACF_GSF('background_video_external_alternate'); 
            $background_video_poster = ACF_GSF('backgsub_round_video_poster'); 
            
            // BACKGROUND IMAGE
            
            if( ACF_GSF('image_or_video') == 'bgimage' ) {
                if( $background_image ) { ?>
					<section class="sec image-section section-overlay padding-160" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>" <?php if( $bg_image ) { ?>style="background-image:url(<?php echo esc_url( $bg_image[0] ); ?>)"<?php } ?>>
				<?php }
    
            // BACKGROUND FEATURED IMAGE

            } elseif( ACF_GSF('image_or_video') == 'bgfeaturedimage' ) { ?>

                <section class="sec image-section section-overlay padding-160" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>" style="background-image:url(<?php echo esc_url( $bg_image_featured ); ?>)">
                
            <?php // BACKGROUND VIDEO
                
            } elseif( ACF_GSF('image_or_video') == 'bgvideo' ) {
                if( $background_video || $background_video_alternate ) { ?>
					<section class="sec image-section section-overlay padding-160" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
						<video class="video-bg" autoplay loop muted<?php if( $background_video_poster ) { ?> poster="<?php echo esc_attr( $background_video_poster ); ?>"<?php } ?>>
							<source src="<?php echo esc_attr( $background_video ); ?>" type="video/mp4">
							<?php if( $background_video_alternate ) { ?>
								<source src="<?php echo esc_url( $background_video_alternate ); ?>" type="video/webm">
							<?php } ?>
						</video>
				<?php }
                
            // BACKGROUND VIDEO EXTERN
                
            } elseif ( ACF_GSF('image_or_video') == 'bgvideoextern' ) { 
                if( $background_video_external || $background_video_external_alternate ) { ?>
					<section class="sec image-section section-overlay padding-160" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
						<video class="video-bg" autoplay loop muted<?php if( $background_video_poster ) { ?> poster="<?php echo esc_attr( $background_video_poster ); ?>"<?php } ?>>
							<source src="<?php echo esc_attr( $background_video_external ); ?>" type="video/mp4">
							<?php if( $background_video_external_alternate ){ ?>
								<source src="<?php echo esc_url( $background_video_external_alternate) ; ?>" type="video/webm">
							<?php } ?>
						</video>
				<?php }
                
            // BACKGROUND COLOR    
                
            } elseif( ACF_GSF('image_or_video') == 'bgcolor' ) { ?>        
                    <section class="sec image-section section-overlay padding-160" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>" style="background-color:<?php echo esc_html( $background_color ); ?>">
    
            <?php // BACKGROUND GRADIENT

            } elseif( ACF_GSF('image_or_video') == 'bggradient' ) { ?>

                    <section class="sec image-section section-overlay padding-160" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>" style="background: radial-gradient(ellipse at center, <?php echo esc_html( $background_gradient_start ); ?> 0%, <?php echo esc_html( $background_gradient_end ); ?> 100%);">
                        
			<?php } else { ?>
                        
                    <section class="sec image-section section-overlay padding-160" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
                        
			<?php } ?>

                <?php hannah_cd_section_start(); ?>
                        
				<div class="container <?php echo esc_html( $alignment ); ?>">
					<div class="row">
						<div class="col-md-6">

							<?php if( $image_sec_headline ) { ?>
								<h2><?php echo esc_html( $image_sec_headline ); ?></h2>
							<?php }
            
                            if( $image_sec_text ) {
                                echo ACF_GSF('image_sec_text'); // HTML output is escaped by acf_kses_post();
                            } 
            
                            if( ACF_HR('button_show') ): ?>
								<div class="section-content">
	
									<?php while ( ACF_HR('button_show') ) {
                                        get_template_part( 'inc/acf', 'buttons' );
                                    } ?>
	
								</div>
							<?php endif; ?>
					
						</div>
					</div>
				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                       
        /**********************/ 
        /* IMAGE / TEXT SECTION */ 
        /**********************/ 

		if( get_row_layout() == 'image_text' ) {
            
            $imgtxt_headline = ACF_GSF('imgtxt_headline'); 
            $imgtxt_text = ACF_GSF('imgtxt_text'); 
            $imgtxt_align = ACF_GSF('imgtxt_image_alignment');
            $img_col_width = ACF_GSF('imgtxt_column_width');
            $content_col_width = 100 - $img_col_width;

            if( $imgtxt_align == 'right' ) {
                $alignment = 'right';
            } else {
                $alignment = 'left';
            }            
           
            $imgtxt_image = ACF_GSF('imgtxt_image');
            if( ! is_array( $imgtxt_image ) ) { 
                $imgtxt_image = acf_get_attachment( $imgtxt_image ); 
            } 
                        
            $myeffect = ACF_GSF('animated_image_effect'); 
            $myeffectduration = ACF_GSF('animated_image_effect_duration'); ?> 
            
            <section class="sec image-text-section text-center padding-90" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container <?php echo esc_html( $alignment ); ?>">
						
					<div class="section-content mtop-null">
                        
                        <div class="img-column" style="width:<?php echo esc_html( $img_col_width ); ?>%">
                            <?php if( ! empty( $image ) ) { ?>
                                <div class="<?php if( $myeffect ) { ?>wow <?php echo esc_html( $myeffect ); ?><?php } ?>" <?php if( $myeffectduration ) { ?>data-wow-duration="<?php echo esc_attr( $myeffectduration ); ?>s"<?php } ?>>
                                    <img class="img-responsive" src="<?php echo esc_url( $imgtxt_image['url'] ); ?>" alt="<?php echo esc_attr( $imgtxt_image['alt'] ); ?>" />
                                </div>
                            <?php } ?>
                        </div>
                        
                        <div class="content-column" style="width:<?php echo esc_html( $content_col_width ); ?>%">
                            <?php if( $imgtxt_headline ) { 
                                if( $imgtxt_headline ) { ?>
                                    <h2><?php echo esc_html( $imgtxt_headline ); ?></h2>
                                <?php }
                            }
            
                            if( $imgtxt_text ) {
                                echo ACF_GSF('imgtxt_text');
                            }
            
                            if( ACF_HR('button_show') ) : ?>
                                <div class="section-content">

                                    <?php while ( ACF_HR('button_show') ) {
                                        get_template_part( 'inc/acf', 'buttons' );
                                    } ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        
					</div>
				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* CONTENT GRID SECTION */ 
        /**********************/
                                                 
        if( get_row_layout() == 'content_grid' ) { 
                        
            $content_grid_headline = ACF_GSF('content_grid_headline'); 
            $content_grid_text = ACF_GSF('content_grid_text'); ?>

			<section class="sec content-grid-sec text-center<?php if( $content_grid_headline || $content_grid_text ) { ?> padding-90<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">
					<div class="row">
					
						<?php if( $content_grid_headline || $content_grid_text ) { ?>
							<div class="col-md-8 col-md-offset-2">
								<?php if( $content_grid_headline ) { ?>
									<h2><?php echo esc_html( $content_grid_headline ); ?></h2>
								<?php }
                                                                        
                                if( $content_grid_text ) {
                                    echo ACF_GSF('content_grid_text'); // HTML output is escaped by acf_kses_post();
                                } ?>
							</div>
						<?php } ?>
					</div>
						
					<div class="content-grid section-content<?php if( ! $content_grid_headline && ! $content_grid_text ) { ?> mtop-null<?php } ?>">
                        <div class="row">
                            <?php include( locate_template( 'inc/acf-area-content-grid.php' ) ); ?>
                        </div>
					</div>
					
				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* NEWSLETTER SECTION */ 
        /**********************/
                                                 
        if( get_row_layout() == 'newsletter' ) { 
                        
            $newsletter_headline = ACF_GSF('newsletter_headline'); 
            $newsletter_text = ACF_GSF('newsletter_text'); ?>

			<section class="sec newsletter text-center<?php if( $newsletter_headline || $newsletter_text ) { ?> padding-90<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">
					<div class="row">
					
						<?php if( $newsletter_headline || $newsletter_text ) { ?>
							<div class="col-md-8 col-md-offset-2">
								<?php if( $newsletter_headline ) { ?>
									<h2><?php echo esc_html( $newsletter_headline ); ?></h2>
								<?php }
                                                                        
                                if( $newsletter_text ) {
                                    echo ACF_GSF('newsletter_text'); // HTML output is escaped by acf_kses_post();
                                } ?>
							</div>
						<?php } ?>
					</div>
						
					<div class="section-content<?php if( ! $newsletter_headline && ! $newsletter_text ) { ?> mtop-null<?php } ?>">
						<?php if( ACF_HR('newsletter_form_show') ) : 
							while ( ACF_HR('newsletter_form_show') ) { 
                                
								get_template_part( 'inc/acf', 'newsletter' );

							}
						endif; ?>
					</div>
					
				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* ANIMATED IMAGE SECTION */ 
        /**********************/
                                                 
        if( get_row_layout() == 'animated_image' ) { 
                        
            $animated_image_headline = ACF_GSF('animated_image_headline'); 
            $animated_image_text = ACF_GSF('animated_image_text');
            $image = ACF_GSF('animated_image'); ?>

			<section class="sec animated-image text-center<?php if( $animated_image_headline || $animated_image_text ) { ?> padding-90<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">

					<?php if( $animated_image_headline || $animated_image_text ) { ?>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<?php if( $animated_image_headline ) { ?>
									<h2><?php echo esc_html( $animated_image_headline ); ?></h2>
								<?php }
                                                                            
                                if( $animated_image_text ) {
                                    echo ACF_GSF('animated_image_text'); // HTML output is escaped by acf_kses_post();
                                } ?>
							</div>
						</div>
					<?php }
                                                    
                    if( $image ) {
                        $myeffect = ACF_GSF('animated_image_effect');
                        $myeffectduration = ACF_GSF('animated_image_effect_duration'); ?>
                    
						<div class="section-content<?php if( ! $animated_image_headline && ! $animated_image_text ) { ?> mtop-null<?php } ?>">
							<div class="row">
								<div class="image-animation<?php if( $myeffect ){ ?> wow <?php echo esc_attr( $myeffect ); ?><?php } ?>" data-wow-duration="<?php if( $myeffectduration ) { ?><?php echo esc_attr( $myeffectduration ); ?><?php } ?>s">
									<img class="img-responsive" src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
								</div>
							</div>
						</div>
                    
					<?php } ?>
				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* CUSTOM TEASER SECTION */ 
        /**********************/ 
                                                 
        if( get_row_layout() == 'post_teaser' ) { 
                        
            $post_teaser_headline = ACF_GSF('post_teaser_headline'); 
            $post_teaser_text = ACF_GSF('post_teaser_text'); 
            $post_teaser_column = ACF_GSF('post_teaser_column'); ?>

			<section class="sec post-teaser text-center<?php if( $post_teaser_headline || $post_teaser_text ) { ?> padding-90<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">

					<?php // get column
                    if( $post_teaser_column == 'col_1' ) {
                        $column = 'col-md-12';
                    } elseif( $post_teaser_column == 'col_2' ) { 
                        $column = 'col-md-6';
                    } elseif( $post_teaser_column == 'col_3' ) { 
                        $column = 'col-md-4';
                    } elseif( $post_teaser_column == 'col_4' ) { 
                        $column = 'col-md-3';
                    } 
                                                 
                    if( $post_teaser_headline || $post_teaser_text ) { ?>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<?php if( $post_teaser_headline ) { ?>
									<h2><?php echo esc_html( $post_teaser_headline ); ?></h2>
								<?php }
                                                                      
                                if( $post_teaser_text ) {
                                    echo ACF_GSF('post_teaser_text'); // HTML output is escaped by acf_kses_post();
                                } ?>
							</div>
						</div>
					<?php } ?>

					<div class="section-content<?php if( ! $post_teaser_headline && ! $post_teaser_text ) { ?> mtop-null<?php } ?>">
						
						<?php $row_counter = 1; // start counter
                        $item_count = count( ACF_GSF('post_teaser_show') );
                        if( ACF_HR('post_teaser_show') ) : ?>
                           <div class="post-teaser-wrapper">
                                <div class="row">

                                    <?php while ( ACF_HR('post_teaser_show') ) { the_row();
                                                                                
                                        $get_the_ids = ACF_GSF('post_teaser_box_url') . ',';

                                        $args = array(
                                            'post_type'	=> array( 'any' ),
                                            'post__in' => array( $get_the_ids ),
                                            'ignore_sticky_posts' => 1,
                                        );
                                                                                
                                        $teaser_query = new WP_Query( $args );

                                        if ( $teaser_query->have_posts() ) {                                             
                                            while ( $teaser_query->have_posts() ) : $teaser_query->the_post();

                                                $thumb_id = get_post_thumbnail_id();
                                                $thumb_url = wp_get_attachment_image_src( $thumb_id, 'large', true );

                                                $post_teaser_box_headline = ACF_GSF('post_teaser_box_headline');
                                                $post_teaser_box_text = ACF_GSF('post_teaser_box_text');
                                                $image = ACF_GSF('post_teaser_box_bg');
                                                if (!is_array($image)) { $image = acf_get_attachment($image); }

                                                echo '<div class="post-teaser-box ' . esc_html( $column ) . '">'; 

                                                    echo '<a class="post-teaser-img hover-box" title="' . get_the_title() . '" href="' . get_the_permalink() . '"'; 
                                                        if( $image['url'] ) {
                                                            echo ' style="background-image:url(' . esc_url( $image['url'] ) . ')"';
                                                        } else {
                                                            if( $thumb_id ) {
                                                                echo ' style="background-image:url(' . esc_url( $thumb_url[0] ) . ')"';
                                                            } 
                                                        } 
                                                        echo '>';
                                                        if( ! $image['url'] && ! $thumb_id ) {
                                                            echo '<div class="letter"><span>' . mb_strimwidth( esc_html( $post_teaser_box_headline ) , 0, 1 ) . '</span></div>';
                                                        }
                                                        echo '<div class="hover"></div>';
                                                    echo '</a>';
                                                    echo '<div class="post-teaser-content">'; 
                                                        if ( $post_teaser_box_headline ) { 
                                                            echo '<a href="' . get_the_permalink() .'"><h3>' . esc_html( $post_teaser_box_headline ) . '</h3></a>';
                                                        }
                                                        if( $post_teaser_box_text ) {
                                                            echo '<p>' . hannah_cd_kses( $post_teaser_box_text ) . '</p>';
                                                        }
                                                    echo '</div>';
                                                echo '</div>';                                               

                                            endwhile;
                                            
                                        }
                                                                          
                                        global $wp_query;
                                        wp_reset_postdata();
                                        $temp_query = $wp_query;
                                        $wp_query = $teaser_query;
                                        $wp_query = $temp_query;                                                                  

                                        if( $post_teaser_column == 'col_2' ) {
                                            // add row after every 2 items
                                            if( $row_counter % 2 == 0 && $item_count > 2 ) {
                                                echo '</div><div class="row">';
                                            }
                                        } elseif( $post_teaser_column == 'col_3' ) {
                                            // add row after every 3 items
                                            if( $row_counter % 3 == 0 && $item_count > 3 ) {
                                                echo '</div><div class="row">';
                                            }
                                        } elseif( $post_teaser_column == 'col_4' ) {
                                            // add row after every 4 items
                                            if( $row_counter % 4 == 0 && $item_count > 4 ) {
                                                echo '</div><div class="row">';
                                            }
                                        } else {
                                            // add row after each item
                                            if( $row_counter % 1 == 0 && $item_count >= 1 ) {
                                                echo '</div><div class="row">';
                                            } 
                                        }       
                                                                                
                                        $row_counter ++; // end counter                                             
                                                                                
                                    }   ?>

                                </div>
                            </div>
                        <?php endif; ?>

					</div>

				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* POST TEASER SECTION */ 
        /**********************/
                                                 
        if( get_row_layout() == 'custom_post_teaser' ) { 
                        
            $custom_post_teaser_headline = ACF_GSF('custom_post_teaser_headline'); 
            $custom_post_teaser_text = ACF_GSF('custom_post_teaser_text'); ?>

			<section class="sec custom-post-teaser text-center<?php if( $custom_post_teaser_headline || $custom_post_teaser_text ) { ?> padding-90<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">

					<?php if( $custom_post_teaser_headline || $custom_post_teaser_text ) { ?>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<?php if( $custom_post_teaser_headline ) { ?>
									<h2><?php echo esc_html( $custom_post_teaser_headline ); ?></h2>
								<?php }
                                                                                    
                                if( $custom_post_teaser_text ) {
                                    echo ACF_GSF('custom_post_teaser_text'); // HTML output is escaped by acf_kses_post();
                                } ?>
							</div>
						</div>
					<?php } ?>

					<div class="section-content<?php if( ! $custom_post_teaser_headline && ! $custom_post_teaser_text ) { ?> mtop-null<?php } ?>">
						
						<div class="post-teaser-wrapper">
							<div class="row">
							
								<?php $teaser_type_post = ACF_GSF('custom_post_teaser_types'); 
                                $teaser_type_post_selected = ACF_GSF('custom_post_teaser_selected');                                                        
                                                        
                                $get_postformat = ACF_GSF('custom_post_teaser_postformat_exclude'); 
                                $teaser_post_column = ACF_GSF('custom_post_teaser_column'); 
                                $teaser_post_amount = ACF_GSF('custom_post_teaser_amount');	
                                $teaser_post_category = ACF_GSF('custom_post_teaser_category');                   
                                                        
                                // postformat exclude
                                $postformat_exclude = array();
                                if ( is_array( $get_postformat ) || is_object( $get_postformat ) ) {
                                    foreach( $get_postformat as $postformat ) {
                                        array_push( $postformat_exclude, $postformat['value'] );
                                    }
                                }
                                                        
                                // POPULAR POSTS
                                if( $teaser_type_post == 'custom_post_teaser_show_popular' ) {
                                                                        
                                    $args = array(
                                        'post_type' => 'post',
                                        'meta_key' => 'post_views_count', // by views count
                                        'posts_per_page' => $teaser_post_amount,
                                        'orderby' => 'meta_value_num', // order by views
                                        'order' => 'DESC',
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' 	=> 'post_format',
                                                'field' 	=> 'slug',
                                                'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
                                                'operator' 	=> 'NOT IN'
                                            )
                                        ),
                                    );

                                // LIKED POSTS
                                } elseif( $teaser_type_post == 'custom_post_teaser_show_liked' ) {
                                    $args = array(
                                        'post_type' => 'post',
                                        'meta_key' => '_like_btn', // by likes count
                                        'posts_per_page' => $teaser_post_amount,
                                        'orderby' => 'meta_value_num', // order by likes count
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' 	=> 'post_format',
                                                'field' 	=> 'slug',
                                                'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
                                                'operator' 	=> 'NOT IN'
                                            )
                                        ),
                                    );

                                // RATED POSTS
                                } elseif( $teaser_type_post == 'custom_post_teaser_show_rated' ) {
                                    
                                    $args = array(
                                        'post_type' => 'post',
                                        'meta_key' => 'post_rating', // by post rating (rating / votes count = post rating)
                                        'posts_per_page' => $teaser_post_amount,
                                        'orderby' => 'meta_value_num', // order by likes count
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' 	=> 'post_format',
                                                'field' 	=> 'slug',
                                                'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
                                                'operator' 	=> 'NOT IN'
                                            )
                                        ),
                                    );

                                // COMMENTED POSTS
                                } elseif( $teaser_type_post == 'custom_post_teaser_show_commented' ) {
                                    $args = array(
                                        'post_type' => 'post',
                                        'posts_per_page' => $teaser_post_amount,
                                        'orderby' => 'comment_count', // order by comment count
                                        'order' => 'DESC',
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' 	=> 'post_format',
                                                'field' 	=> 'slug',
                                                'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
                                                'operator' 	=> 'NOT IN'
                                            )
                                        ),
                                    );

                                // RECENT POSTS
                                } elseif( $teaser_type_post == 'custom_post_teaser_show_recent' ) {
                                    $args = array(
                                        'post_type' => 'post',
                                        'posts_per_page' => $teaser_post_amount,
                                        'orderby' => 'date', 
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' 	=> 'post_format',
                                                'field' 	=> 'slug',
                                                'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
                                                'operator' 	=> 'NOT IN'
                                            )
                                        ),
                                    );

                                // SELECTED POSTS
                                } elseif( $teaser_type_post == 'custom_post_teaser_show_selected' ) {
                                    $args = array(
                                        'post_type' => 'post',
                                        'post__in' => $teaser_type_post_selected, // post id, like (1,22,50)
                                        'posts_per_page' => $teaser_post_amount,
                                        'orderby' => 'post__in', // order by user
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' 	=> 'post_format',
                                                'field' 	=> 'slug',
                                                'terms' 	=> $postformat_exclude, // postformat exclude, like ('post-format-link', 'post-format-quote')
                                                'operator' 	=> 'NOT IN'
                                            )
                                        ),
                                    );
                                }

                                // filter posts by category or tag				  

                                if( empty( $teaser_type_post == 'custom_post_teaser_show_selected' ) ) {

                                    if( ACF_GSF('custom_post_teaser_category_filter') ) 
                                    $args['category__in'] = ACF_GSF('custom_post_teaser_category_filter');

                                    if( ACF_GSF('custom_post_teaser_tag_filter') ) 
                                    $args['tag__in'] = ACF_GSF('custom_post_teaser_tag_filter');		
                                }					  

                                $my_posts_query = new WP_Query( $args );

                                if ( $my_posts_query->have_posts() ) :
                                    while ( $my_posts_query->have_posts() ) : $my_posts_query->the_post(); 

                                        // get post thumbnail
                                        $thumb_id = get_post_thumbnail_id();
                                        $thumb_url = wp_get_attachment_image_src( $thumb_id, 'large', true );

                                        if( has_post_thumbnail() ) { 
                                            $bgimage = $thumb_url[0]; 
                                        } 

                                        // get column
                                        if( $teaser_post_column == 'col_1' ) {
                                            $teaser_column = 'col-md-12';
                                        } elseif( $teaser_post_column == 'col_2' ) { 
                                            $teaser_column = 'col-md-6';
                                        } elseif( $teaser_post_column == 'col_3' ) { 
                                            $teaser_column = 'col-md-4';
                                        } elseif( $teaser_post_column == 'col_4' ) { 
                                            $teaser_column = 'col-md-3';
                                        } 
                                
                                        $teaser_post_headline = get_the_title(); ?>
											
                                        <div class="custom-post-teaser-box <?php echo esc_html( $teaser_column ); ?>">
                                            <a class="custom-post-teaser-box-bg hover-box" href="<?php the_permalink(); ?>" <?php if( has_post_thumbnail() ) { ?>style="background-image: url(<?php echo esc_url( $bgimage ); ?>)"<?php } ?>>
                                                <div class="custom-post-content">
                                                    <div class="custom-post-content-inner">
                                                        <div>
                                                            <?php if( ! $teaser_post_category ) { ?>
                                                                <span class="custom-post-teaser-category">
                                                                    <?php 
                                                                        $categories = get_the_category(); 
                                                                        if ( ! empty( $categories ) ) {
                                                                            echo esc_html( $categories[0]->name ); 
                                                                        }
                                                                    ?>
                                                                </span>
                                                            <?php } ?>
                                                            <span class="custom-post-teaser-title h3-title">
                                                                <?php the_title(); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if( ! has_post_thumbnail() && ! $thumb_id ) {
                                                    echo '<div class="letter"><span>' . mb_strimwidth( esc_html( $teaser_post_headline ) , 0, 1 ) . '</span></div>';
                                                } ?>
                                                <div class="hover"></div>
                                            </a>
                                        </div>
												
                                    <?php endwhile;
                                endif;

                                wp_reset_postdata(); ?>
								
							</div>
						</div>

					</div>

				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* PAGE TEASER SECTION */ 
        /**********************/
                                                 
        if( get_row_layout() == 'custom_page_teaser' ) { 
                        
            $custom_page_teaser_headline = ACF_GSF('custom_page_teaser_headline'); 
            $custom_page_teaser_text = ACF_GSF('custom_page_teaser_text'); ?>

			<section class="sec post-teaser text-center<?php if( $custom_page_teaser_headline || $custom_page_teaser_text ) { ?> padding-90<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">

					<?php if( $custom_page_teaser_headline || $custom_page_teaser_text ) { ?>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<?php if( $custom_page_teaser_headline ) { ?>
									<h2><?php echo esc_html( $custom_page_teaser_headline ); ?></h2>
								<?php }
                                                                                    
                                if( $custom_page_teaser_text ) {
                                    echo ACF_GSF('custom_page_teaser_text'); // HTML output is escaped by acf_kses_post();
                                } ?>
							</div>
						</div>
					<?php } ?>

					<div class="section-content<?php if( ! $custom_page_teaser_headline && ! $custom_page_teaser_text ) { ?> mtop-null<?php } ?>">
						
						<div class="post-teaser-wrapper">
							<div class="row">
							
								<?php $teaser_type_page = ACF_GSF('custom_page_teaser_types'); 
                                $teaser_type_page_selected = ACF_GSF('custom_page_teaser_selected');        
                                                        
                                $teaser_page_column = ACF_GSF('custom_page_teaser_column'); 
                                $teaser_page_amount = ACF_GSF('custom_page_teaser_amount'); 
                                $teaser_page_excerpt = ACF_GSF('custom_page_teaser_excerpt');  
                                       
                                // check if amount of posts exists
                                if ( $teaser_type_page_selected ) {
                                    $teaser_page_amount = count( $teaser_type_page_selected );
                                }                         
                                                        
                                // POPULAR PAGES
                                if( $teaser_type_page == 'custom_page_teaser_show_popular' ) {
                                                                        
                                    $args = array(
                                        'post_type' => 'page',
                                        'meta_key' => 'post_views_count', // by views count
                                        'posts_per_page' => $teaser_page_amount,
                                        'orderby' => 'meta_value_num', // order by views
                                        'order' => 'DESC',
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(),
                                    );

                                // COMMENTED PAGES
                                } elseif( $teaser_type_page == 'custom_page_teaser_show_commented' ) {
                                    $args = array(
                                        'post_type' => 'page',
                                        'posts_per_page' => $teaser_page_amount,
                                        'orderby' => 'comment_count', // order by comment count
                                        'order' => 'DESC',
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(),
                                    );

                                // RECENT PAGES
                                } elseif( $teaser_type_page == 'custom_page_teaser_show_recent' ) {
                                    $args = array(
                                        'post_type' => 'page',
                                        'posts_per_page' => $teaser_page_amount,
                                        'orderby' => 'date', 
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(),
                                    );

                                // SELECTED PAGES
                                } elseif( $teaser_type_page == 'custom_page_teaser_show_selected' ) {
                                    $args = array(
                                        'post_type' => 'page',
                                        'post__in' => $teaser_type_page_selected, // post id, like (1,22,50)
                                        'posts_per_page' => $teaser_page_amount,
                                        'orderby' => 'post__in', // order by user
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(),
                                    );
                                }				  

                                $my_pages_query = new WP_Query( $args );

                                if ( $my_pages_query->have_posts() ) :
                                                        
                                    $row_counter = 1; // start counter
                                    $item_count = $my_pages_query->found_posts;
                                                        
                                    while ( $my_pages_query->have_posts() ) : $my_pages_query->the_post(); 

                                        // get post thumbnail
                                        $thumb_id = get_post_thumbnail_id();
                                        $thumb_url = wp_get_attachment_image_src( $thumb_id, 'large', true );

                                        if( has_post_thumbnail() ) { 
                                            $bgimage = $thumb_url[0]; 
                                        } 
                                                        
                                        // get the title                
                                        $get_the_title = get_the_title();
                                                        
                                        // get the excerpt                
                                        $get_the_excerpt = get_the_excerpt();
                                                        
                                        // get column
                                        if( $teaser_page_column == 'col_1' ) {
                                            $teaser_column = 'col-md-12';
                                        } elseif( $teaser_page_column == 'col_2' ) { 
                                            $teaser_column = 'col-md-6';
                                        } elseif( $teaser_page_column == 'col_3' ) { 
                                            $teaser_column = 'col-md-4';
                                        } elseif( $teaser_page_column == 'col_4' ) { 
                                            $teaser_column = 'col-md-3';
                                        } ?>
											
                                        <div class="post-teaser-box <?php echo esc_html( $teaser_column ); ?>">
                                            <a class="post-teaser-img hover-box" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" <?php if( has_post_thumbnail() ) { ?>style="background-image: url(<?php echo esc_url( $bgimage ); ?>)"<?php } ?>>                                                       
                                                <?php if( ! has_post_thumbnail() ) {
                                                    echo '<div class="letter"><span>' . mb_strimwidth( esc_html( $get_the_title ), 0, 1 ) . '</span></div>';
                                                } ?>
                                                <div class="hover"></div>
                                            </a>
                                            <div class="post-teaser-content">
                                                <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                                                <?php if( ! $teaser_page_excerpt ) {
                                                    echo '<p>' . mb_strimwidth( $get_the_excerpt, 0, 100, '...' ) . '</p>';
                                                } ?>
                                            </div>
                                        </div>                                
												
                                        <?php if( $teaser_page_column == 'col_2' ) {
                                            // add row after every 2 items
                                            if( $row_counter % 2 == 0 && $item_count > 2 ) {
                                                echo '</div><div class="row">';
                                            }
                                        } elseif( $teaser_page_column == 'col_3' ) {
                                            // add row after every 3 items
                                            if( $row_counter % 3 == 0 && $item_count > 3 ) {
                                                echo '</div><div class="row">';
                                            }
                                        } elseif( $teaser_page_column == 'col_4' ) {
                                            // add row after every 4 items
                                            if( $row_counter % 4 == 0 && $item_count > 4 ) {
                                                echo '</div><div class="row">';
                                            }
                                        } else {
                                            // add row after each item
                                            if( $row_counter % 1 == 0 && $item_count >= 1 ) {
                                                echo '</div><div class="row">';
                                            } 
                                        }                                  

                                        $row_counter ++; // end counter
                                                        
                                    endwhile;
                                endif;

                                wp_reset_postdata(); ?>
								
							</div>
						</div>

					</div>

				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* PRODUCT TEASER SECTION */ 
        /**********************/
                                                 
        if( get_row_layout() == 'custom_product_teaser' ) { 
                        
            $custom_product_teaser_headline = ACF_GSF('custom_product_teaser_headline'); 
            $custom_product_teaser_text = ACF_GSF('custom_product_teaser_text'); ?>

			<section class="sec post-teaser text-center<?php if( $custom_product_teaser_headline || $custom_product_teaser_text ) { ?> padding-90<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">

					<?php if( $custom_product_teaser_headline || $custom_product_teaser_text ) { ?>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<?php if( $custom_product_teaser_headline ) { ?>
									<h2><?php echo esc_html( $custom_product_teaser_headline ); ?></h2>
								<?php }
                                                                                    
                                if( $custom_product_teaser_text ) {
                                    echo ACF_GSF('custom_product_teaser_text'); // HTML output is escaped by acf_kses_post();
                                } ?>
							</div>
						</div>
					<?php } ?>

					<div class="section-content<?php if( ! $custom_product_teaser_headline && ! $custom_product_teaser_text ) { ?> mtop-null<?php } ?>">
						
						<div class="post-teaser-wrapper">
							<div class="row">
							
								<?php $teaser_type_product = ACF_GSF('custom_product_teaser_types');  
                                $teaser_type_product_selected = ACF_GSF('custom_product_teaser_selected');     
                                                        
                                $teaser_product_column = ACF_GSF('custom_product_teaser_column'); 
                                $teaser_product_amount = ACF_GSF('custom_product_teaser_amount');
                                $teaser_product_excerpt = ACF_GSF('custom_product_teaser_excerpt'); 
                                                      
                                // check if amount of posts exists
                                if ( $teaser_type_product_selected ) {
                                    $teaser_product_amount = count( $teaser_type_product_selected );
                                }                           
                                                           
                                // POPULAR PRODUCTS
                                if( $teaser_type_product == 'custom_product_teaser_show_popular' ) {
                                                                        
                                    $args = array(
                                        'post_type' => 'product',
                                        'meta_key' => 'post_views_count', // by views count
                                        'posts_per_page' => $teaser_product_amount,
                                        'orderby' => 'meta_value_num', // order by views
                                        'order' => 'DESC',
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(),
                                    );

                                // RATED PRODUCTS
                                } elseif( $teaser_type_product == 'custom_product_teaser_show_rated' ) {
                                    
                                    $args = array(
                                        'post_type' => 'product',
                                        'meta_key' => '_wc_average_rating', // by post rating (rating / votes count = post rating)
                                        'posts_per_page' => $teaser_product_amount,
                                        'orderby' => 'meta_value_num', // order by likes count
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(),
                                    );

                                // RECENT PRODUCTS
                                } elseif( $teaser_type_product == 'custom_product_teaser_show_recent' ) {
                                    $args = array(
                                        'post_type' => 'product',
                                        'posts_per_page' => $teaser_product_amount,
                                        'orderby' => 'date', 
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(),
                                    );

                                // SELECTED PRODUCTS
                                } elseif( $teaser_type_product == 'custom_product_teaser_show_selected' ) {
                                    $args = array(
                                        'post_type' => 'product',
                                        'post__in' => $teaser_type_product_selected, // post id, like (1,22,50)
                                        'posts_per_page' => $teaser_product_amount,
                                        'orderby' => 'post__in', // order by user
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(),
                                    );
                                    
                                // MOST PRODUCTS SALES
                                } elseif( $teaser_type_product == 'custom_product_teaser_show_sales' ) {
                                    $args = array(
                                        'post_type' => 'product',
                                        'meta_key' => 'total_sales', // by most saled products
                                        'posts_per_page' => $teaser_product_amount,
                                        'orderby' => 'meta_value_num', // order by likes count
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(),
                                    );

                                // REDUCED PRODUCTS
                                } elseif( $teaser_type_product == 'custom_product_teaser_show_reduced' ) {
                                    $args = array(
                                        'post_type' => 'product',
                                        'meta_key' => '_sale_price', // by products in sale
                                        'posts_per_page' => $teaser_product_amount,
                                        'orderby' => 'meta_value_num', // order by likes count
                                        'ignore_sticky_posts' => 1,
                                        'tax_query' => array(),
                                    );
                                }

                                // filter products by category or tag			  

                                if( empty( $teaser_type_product == 'custom_product_teaser_show_selected' ) ) {

                                    // selected product categories
								
                                    if( ACF_GSF('custom_product_teaser_category_filter') ) {
                                        array_push($args['tax_query'], array(
                                            'taxonomy' => 'product_cat',
                                            'field' => 'term_id',
                                            'terms' => ACF_GSF('custom_product_teaser_category_filter')
                                        ));
                                    }

                                    // selected product tags

                                    if( ACF_GSF('custom_product_teaser_tag_filter') ) {
                                        array_push($args['tax_query'], array(
                                            'taxonomy' => 'product_tag',
                                            'field' => 'term_id',
                                            'terms' => ACF_GSF('custom_product_teaser_tag_filter')
                                        ));
                                    }	
                                    
                                }
                                                           
                                if( ! class_exists( 'WooCommerce' ) ) {

                                    echo '<div class="alert alert-warning">' . esc_html__( 'You have to activate the WooCommerce plugin to show products here.', 'hannah-cd' ) . '.</div>';              

                                } else {
                                    
                                    $my_products_query = new WP_Query( $args );
                                                           
                                    if( $my_products_query->have_posts() ) :
                                        while( $my_products_query->have_posts() ) : $my_products_query->the_post(); 

                                            // get post thumbnail
                                            $thumb_id = get_post_thumbnail_id();
                                            $thumb_url = wp_get_attachment_image_src( $thumb_id, 'large', true );

                                            if( has_post_thumbnail() ) { 
                                                $bgimage = $thumb_url[0]; 
                                            }
                                                        
                                            // get the title                
                                            $get_the_title = get_the_title();

                                            // get the excerpt                
                                            $get_the_excerpt = get_the_excerpt();
                                    
                                            global $product;
                                            $product = new WC_Product( get_the_ID() ); 

                                            // get product price
                                            $price_html = $product->get_price_html();

                                            // get product sale status
                                            if ( $product->is_on_sale() ) {
                                                $product_in_sale = true;
                                            } else {
                                                $product_in_sale = false;
                                            }

                                            // get column
                                            if( $teaser_product_column == 'col_1' ) {
                                                $teaser_column_product = 'col-md-12';
                                            } elseif( $teaser_product_column == 'col_2' ) { 
                                                $teaser_column = 'col-md-6';
                                            } elseif( $teaser_product_column == 'col_3' ) { 
                                                $teaser_column = 'col-md-4';
                                            } elseif( $teaser_product_column == 'col_4' ) { 
                                                $teaser_column = 'col-md-3';
                                            } ?>

                                            <div class="post-teaser-box <?php echo esc_html( $teaser_column ); ?>">
                                                <a class="post-teaser-img hover-box" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" <?php if( has_post_thumbnail() ) { ?>style="background-image: url(<?php echo esc_url( $bgimage ); ?>)"<?php } ?>>                                                       
                                                    <?php if( ! has_post_thumbnail() ) {
                                                        echo '<div class="letter"><span>' . mb_strimwidth( esc_html( $get_the_title ), 0, 1 ) . '</span></div>';
                                                    } ?>
                                                    <div class="hover"></div>
                                                    <?php if( $product_in_sale ) { 
														echo '<span class="onsale">' . esc_html__( 'Sale', 'hannah-cd' ) . '!</span>'; 
													} ?>
                                                </a>
                                                <div class="post-teaser-content">
                                                    <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                                                    <?php if( $price_html ) { 
														echo '<span class="woo-price">' . $price_html . '</span>'; 
													} ?>
                                                    <?php if( ! $teaser_product_excerpt ) {
                                                        echo '<p>' . mb_strimwidth( $get_the_excerpt, 0, 100, '...' ) . '</p>';
                                                    } ?>
                                                </div>
                                            </div>

                                        <?php endwhile;
                                    endif;

                                    wp_reset_postdata();
                                    
                                } ?>
								
							</div>
						</div>

					</div>

				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }

        /**********************/ 
        /* CATEGORY / TAG TEASER SECTION */ 
        /**********************/
                                                 
        if( get_row_layout() == 'category_tag_teaser' ) { 
                        
            $category_tag_teaser_headline = ACF_GSF('category_tag_teaser_headline'); 
            $category_tag_teaser_text = ACF_GSF('category_tag_teaser_text'); ?>

			<section class="sec category-tag-teaser text-center<?php if( $category_tag_teaser_headline || $category_tag_teaser_text ) { ?> padding-90<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">

					<?php if( $category_tag_teaser_headline || $category_tag_teaser_text ) { ?>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<?php if( $category_tag_teaser_headline ) {
                                    echo '<h2>' . esc_html( $category_tag_teaser_headline ) . '</h2>'; 
                                }
                                                                                      
                                if( $category_tag_teaser_text ) {
                                    echo ACF_GSF('category_tag_teaser_text'); // HTML output is escaped by acf_kses_post();
                                } ?>
							</div>
						</div>
					<?php } ?>

					<div class="section-content<?php if( ! $category_tag_teaser_headline && ! $category_tag_teaser_text ) { ?> mtop-null<?php } ?>">
						
						<div class="post-teaser-wrapper">
							<div class="row">
							
								<?php $category_tag_teaser_column = ACF_GSF('category_tag_teaser_column'); 
                                $category_tag_teaser_output = ACF_GSF('category_tag_teaser_output');
                                $category_tag_teaser_post_count = ACF_GSF('category_tag_teaser_post_count');
                                $category_tag_teaser_hide_empty = ACF_GSF('category_tag_teaser_hide_empty');
                                if( $category_tag_teaser_hide_empty ) { $hide_empty = 1; } else { $hide_empty = 0; }						   

                                // category teaser
                                if( $category_tag_teaser_output == 'cats' ) {

                                    $args = array(
                                        'hierarchical'	=> 1,
                                        'orderby'		=> 'include', // order by user
                                        'order'			=> 'ASC',
                                        'hide_empty'	=> $hide_empty,
                                    );

                                    // filter categories by id
                                    if( ACF_GSF('category_tag_teaser_cat_filter') ) 
                                    $args['include'] = ACF_GSF('category_tag_teaser_cat_filter');

                                    $ct_teaser = get_categories( $args );										

                                // tag teaser
                                } elseif( $category_tag_teaser_output == 'tags' ) {										

                                    $args = array(
                                        'hierarchical'	=> 1,
                                        'orderby'		=> 'include', // order by user
                                        'order'			=> 'ASC',
                                        'hide_empty'	=> $hide_empty,
                                    );

                                    // filter tags by id
                                    if( ACF_GSF('category_tag_teaser_tag_filter') ) 
                                    $args['include'] = ACF_GSF('category_tag_teaser_tag_filter');	

                                    $ct_teaser = get_tags( $args );	

                                } 				  

                                // get column
                                if( $category_tag_teaser_column == 'col_1' ) {
                                    $teaser_column = 'col-md-12';
                                } elseif( $category_tag_teaser_column == 'col_2' ) { 
                                    $teaser_column = 'col-md-6';
                                } elseif( $category_tag_teaser_column == 'col_3' ) { 
                                    $teaser_column = 'col-md-4';
                                } elseif( $category_tag_teaser_column == 'col_4' ) { 
                                    $teaser_column = 'col-md-3';
                                }										

                                foreach ( $ct_teaser as $teaser ) {

                                    // get term fields
                                    if( $category_tag_teaser_output == 'cats' ) {
                                        $taxonomy_image = ACF_GF('taxonomy_image', "category_{$teaser->cat_ID}");
                                        $bg_image = wp_get_attachment_image_src( $taxonomy_image, 'large', false, '' ); 
                                        $get_the_link = get_category_link( $teaser->term_id );	
                                    } else {
                                        $tag_taxonomy = $teaser->taxonomy;
                                        $tag_term_id = $teaser->term_id;
                                        $taxonomy_image = ACF_GF('taxonomy_image', $tag_taxonomy . '_' . $tag_term_id);
                                        $bg_image = wp_get_attachment_image_src( $taxonomy_image, 'large', false, '' );
                                        $get_the_link = get_tag_link( $teaser->term_id );	
                                    } ?>
										    
                                    <div class="custom-post-teaser-box <?php echo esc_html( $teaser_column ); ?>">
                                        <a class="custom-post-teaser-box-bg hover-box" href="<?php echo esc_url( $get_the_link ); ?>" <?php if ( $bg_image ) { ?>style="background-image: url(<?php echo esc_url( $bg_image[0] ); ?>)"<?php } ?>>
                                            <div class="custom-post-content">
                                                <div class="custom-post-content-inner">
                                                    <div>
                                                        <span class="custom-post-teaser-title h3-title"><?php echo esc_html( $teaser->name ); ?></span>
                                                        <?php if( $category_tag_teaser_post_count ) { ?>
                                                            <span class="custom-post-teaser-category">
                                                                <?php 
                                                                    echo esc_html( $teaser->count );
                                                                    echo ' ' . esc_html__('Posts', 'hannah-cd');
                                                                ?>
                                                            </span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if( ! $bg_image ) {
                                                echo '<div class="letter"><span>' . mb_strimwidth( esc_html( $teaser->name ) , 0, 1 ) . '</span></div>';
                                            } ?>
                                            <div class="hover"></div>
                                        </a>
                                    </div>

                                <?php } ?>
								
							</div>
						</div>

					</div>

				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
                                                 
        /**********************/ 
        /* WP CONTENT SECTION */ 
        /* if active, shows the default page content as a part of the sections */
        /**********************/
                                                 
        if( get_row_layout() == 'wp_content_section' && ACF_GSF('show_wp_content_here') && ! ACF_GSF('hide_wp_content') ) { ?>
		
			<section class="sec wp-content-section padding-90" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
                <div class="container">

                    <article id="page-<?php the_ID(); ?>">
                        
                        <div class="page-content <?php if( ! get_the_post_thumbnail() || $thumb_hide ) { ?>p-full<?php } ?><?php if( $thumb_right ) { ?> right<?php } ?>">

                            <?php // TITLE
                
                            if( ! ACF_GF('page_title') ) { ?>
                                <header class="page-header">
                                    <?php if( $hannah_cd_header && $hannah_cd_header_default ) { ?>
                                        <h2><?php the_title(); ?></h2>
                                    <?php } else { ?>
                                        <h1><?php the_title(); ?></h1>
                                    <?php } ?>
                                </header>
                            <?php }
                
                            // CONTENT  
						
                            if( ! ACF_GF('main_content') && ! empty( get_the_content() ) ) { ?>

                                <div class="wpcontent showtop">
                                    <?php the_content(); ?>
                                </div>

                            <?php } 
                
                            // COMMENTS

                            if ( comments_open() || get_comments_number() ) {
                                comments_template();
                            } ?>
                            
                        </div>
                        
                        <?php // THUMBNAIL
                
                        if( get_the_post_thumbnail() ) { 
                            if( ! $thumb_hide ) { ?>
                                <div class="page-thumbnail<?php if( $thumb_right ) { ?> right<?php } ?>">
                                    <?php echo get_the_post_thumbnail( $post->ID, 'large' ); 
                                    
                                    // CONTENT BELOW SIDE
						
                                    if( ACF_GF('content_below') ) { ?>

                                        <div class="wpcontent showbottom">
                                            <?php echo ACF_GF('content_below');	?>
                                        </div>

                                    <?php } ?>
                                </div>
                            <?php }
                        } 
                        
                        // THUMBNAIL DISABLED
                
                        if( ! get_the_post_thumbnail() || $thumb_hide ) { 
                            
                            // CONTENT BELOW FULL
						
                            if( ACF_GF('content_below') ) { ?>

                                <div class="wpcontent showbottom">
                                    <?php echo ACF_GF('content_below');	?>
                                </div>

                            <?php }
                            
                        } ?>
                        
                    </article>

                </div>
                <?php hannah_cd_section_end(); ?>
            </section>
			
		<?php }
                                                 
        /**********************/ 
        /* CUSTOM HTML SECTION */
        /**********************/
                                                 
        if( get_row_layout() == 'custom_html' ) { 
                        
            $custom_html_headline = ACF_GSF('custom_html_headline'); 
            $custom_html_text = ACF_GSF('custom_html_text');  
            $my_custom_html = ACF_GSF('my_custom_html'); ?>

			<section class="sec custom-html text-center<?php if( $custom_html_headline || $custom_html_text ) { ?> padding-90<?php } else { ?> no-heading<?php } ?>" id="section_<?php echo esc_html( $lp_menu_item_count ); ?>">
				<div class="container">

					<?php if( $custom_html_headline || $custom_html_text ) { ?>
						<div class="row">
							<div class="col-md-8 col-md-offset-2">
								<?php if( $custom_html_headline ) {
                                    echo '<h2>' . esc_html( $custom_html_headline ) . '</h2>';
                                }
                                                                      
                                if( $custom_html_text) {
                                    echo ACF_GSF('custom_html_text'); // HTML output is escaped by acf_kses_post();
                                } ?>
							</div>
						</div>
					<?php } ?>

					<?php if( $my_custom_html ) { ?>
						<div class="section-content<?php if( ! $custom_html_headline && ! $custom_html_text ) { ?> mtop-null<?php } ?>">
				            <?php echo ACF_GSF('my_custom_html'); // HTML output is escaped by acf_kses_post(); ?>
						</div>
					<?php } ?>
				</div>
                <?php hannah_cd_section_end(); ?>
			</section>

		<?php }
        
        $lp_menu_item_count ++; // end counter
                                                
    }

} ?>