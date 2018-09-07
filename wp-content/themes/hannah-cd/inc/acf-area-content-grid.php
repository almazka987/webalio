<?php // CONTENT GRID 

if( ACF_HR('content_grid_rows', $field_id) ) :        
                                                  
    while( ACF_HR('content_grid_rows', $field_id) ) : the_row();

        $content_grid_layout = ACF_GSF('content_grid_layout'); 

        // 1 column
        if( $content_grid_layout == 'col_1' ) {
            $grid_col = 'col-md-12';

        // 2 columns
        } elseif( $content_grid_layout == 'col_2' ) {
            $grid_col = 'col-md-6';

        // 3 columns
        } elseif( $content_grid_layout == 'col_3' ) {
            $grid_col = 'col-md-4';

        // 4 columns
        } elseif( $content_grid_layout == 'col_4' ) {
            $grid_col = 'col-md-3';

        // 5 columns
        } elseif( $content_grid_layout == 'col_5' ) {
            $grid_col = 'col-md-2-4';

        // 6 columns
        } elseif( $content_grid_layout == 'col_6' ) {
            $grid_col = 'col-md-2';
        } 

        // special widths = 1 : 5 columns | 2 : 4 columns | 4 : 2 columns | 5 : 1 columns
        $content_grid_extra_width = $content_grid_layout == 'col_1_5' || $content_grid_layout == 'col_2_4' || $content_grid_layout == 'col_4_2' || $content_grid_layout == 'col_5_1'; ?>

        <div class="content-grid-wrapper<?php if( $content_grid_extra_width ) { ?> cg-extra-widht<?php } ?>">
            <div class="row">
                
                <?php $col_item_count = count( ACF_GSF('content_grid_rows_columns') );
                if( ACF_HR('content_grid_rows_columns') ) : 
                    $row_grid_counter = 0;      
                    $row_counter = 1;
                    while( ACF_HR('content_grid_rows_columns') ) : the_row();

                        // 1 : 5 columns
                        if( $content_grid_layout == 'col_1_5' ) { 
                            if( $row_grid_counter % 2 == 0 ) {
                                // width 16.666 %
                                $grid_col = 'col-md-2';
                            } else {
                                // width 83.333 %
                                $grid_col = 'col-md-10';
                            }

                        // 2 : 4 columns
                        } elseif( $content_grid_layout == 'col_2_4' ) {
                            if( $row_grid_counter % 2 == 0 ) {
                                // width 33.333 %
                                $grid_col = 'col-md-4';
                            } else {
                                // width 66.666 %
                                $grid_col = 'col-md-8';
                            } 

                        // 1 : 1 columns
                        } elseif( $content_grid_layout == 'col_3_3' ) {
                            // width 50 %
                            $grid_col = 'col-md-6';

                        // 4 : 2 columns
                        } elseif( $content_grid_layout == 'col_4_2' ) {
                            if( $row_grid_counter % 2 == 0 ) {
                                // width 66.666 %
                                $grid_col = 'col-md-8';
                            } else {
                                // width 33.333 %
                                $grid_col = 'col-md-4';
                            }

                        // 5 : 1 columns
                        } elseif( $content_grid_layout == 'col_5_1' ) {
                            if( $row_grid_counter % 2 == 0 ) {
                                // width 83.333 %
                                $grid_col = 'col-md-10';
                            } else {
                                // width 16.666 %
                                $grid_col = 'col-md-2';
                            } 
                        }

                        $horizontal_alignment = ACF_GSF('content_grid_horizontal_alignment');
                        $vertical_alignment = ACF_GSF('content_grid_vertical_alignment');                                                                                   

                        $col_content = ACF_GSF('content_grid_column_content');                                                                                           
                        $content_grid_content = ACF_GSF('content_grid_rows_columns_content'); 
                        $content_grid_bg_image = ACF_GSF('content_grid_column_bg_image');
                        $content_grid_icon = ACF_GSF('content_grid_column_icon');
                        $content_grid_icon_size = ACF_GSF('content_grid_column_icon_size');

                        $content_grid_image_style = ACF_GSF('content_grid_column_image_style');
                        $content_grid_image = ACF_GSF('content_grid_column_image');
                        if( ! is_array( $content_grid_image ) ) { 
                            $content_grid_image = acf_get_attachment( $content_grid_image ); 
                        }                                           

                        // alignment horizontal  
                        if( $horizontal_alignment == 'right' ) {
                            $h_align = 'hright';
                        } elseif( $horizontal_alignment == 'center' ) {
                            $h_align = 'hcenter';
                        } else { 
                            $h_align = 'hleft';
                        }

                        // alignment vertical
                        if( $vertical_alignment == 'middle' ) {
                            $v_align = 'vmiddle';
                        } elseif( $vertical_alignment == 'bottom' ) {
                            $v_align = 'vbottom';
                        } else { 
                            $v_align = 'vtop';
                        }

                        // icon sizes
                        if( $content_grid_icon_size == 'size_5' ) {
                            $ico_size = 'fa-5x';
                        } elseif( $content_grid_icon_size == 'size_4' ) {
                            $ico_size = 'fa-4x';
                        } elseif( $content_grid_icon_size == 'size_3' ) {
                            $ico_size = 'fa-3x';
                        } elseif( $content_grid_icon_size == 'size_2' ) {
                            $ico_size = 'fa-2x';
                        } else { 
                            $ico_size = false;
                        }

                        // image shape
                        if( $content_grid_image_style == 'rounded' ) {
                            $img_style = 'rounded';
                        } elseif( $content_grid_image_style == 'square' ) {
                            $img_style = 'square';
                        } else { 
                            $img_style = false;
                        } ?>

                            <div class="content-grid-gutter <?php echo esc_html( $grid_col ); ?> <?php echo esc_html( $v_align ); ?> <?php echo esc_html( $h_align ); ?>">

                                <?php if( $col_content == 'background' ) { ?>
                                    <div class="content-grid-gutter-bg" style="background-image:url(<?php echo esc_html( $content_grid_bg_image ); ?>)">
                                <?php } ?>

                                    <?php if( $col_content == 'html' || $col_content == 'background' ) { 

                                        echo '<div class="content-grid-gutter-txt">' . ACF_GSF('content_grid_rows_columns_content') . '</div>';  

                                    } elseif( $col_content == 'image' ) { 

                                        if( $content_grid_image_style == 'rounded' || $content_grid_image_style == 'square' ) { ?>

                                            <div class="content-grid-img <?php echo esc_html( $img_style ); ?>" style="background-image:url(<?php echo esc_html( $content_grid_image['url'] ); ?>);"></div>

                                        <?php } else { ?>

                                            <img class="img-responsive" src="<?php echo esc_url( $content_grid_image['url'] ); ?>" alt="<?php echo esc_attr( $content_grid_image['alt'] ); ?>" />

                                        <?php }

                                    } elseif( $col_content == 'icon' ) { ?>

                                        <i class="fa <?php echo esc_html( $content_grid_icon ); ?> <?php echo esc_html( $ico_size ); ?>"></i>

                                    <?php } 

                                    if( ACF_HR('button_show') ) :
                                        while ( ACF_HR('button_show') ) {
                                            get_template_part( 'inc/acf', 'buttons' );
                                        }
                                    endif; ?>

                                <?php if( $col_content == 'background' ) { ?>
                                    </div>
                                <?php } ?>        

                            </div>

                        <?php // add row after every 2 items
                        if( $content_grid_layout == 'col_2' || $content_grid_extra_width || $content_grid_layout == 'col_3_3' ) {                                                   
                            if( $row_counter % 2 == 0 && $col_item_count > 2 ) {
                                echo '</div><div class="row">';
                            }

                        // add row after every 3 items    
                        } elseif( $content_grid_layout == 'col_3' ) {                                                    
                            if( $row_counter % 3 == 0 && $col_item_count > 3 ) {
                                echo '</div><div class="row">';
                            }

                        // add row after every 4 items    
                        } elseif( $content_grid_layout == 'col_4' ) {                                                    
                            if( $row_counter % 4 == 0 && $col_item_count > 4 ) {
                                echo '</div><div class="row">';
                            }

                        // add row after every 5 items    
                        } elseif( $content_grid_layout == 'col_5' ) {                                                    
                            if( $row_counter % 5 == 0 && $col_item_count > 5 ) {
                                echo '</div><div class="row">';
                            }

                        // add row after every 6 items    
                        } elseif( $content_grid_layout == 'col_6' ) {                                                    
                            if( $row_counter % 6 == 0 && $col_item_count > 6 ) {
                                echo '</div><div class="row">';
                            }

                        // add row after each item    
                        } else {
                            if( $row_counter % 1 == 0 && $col_item_count > 1 ) {
                                echo '</div><div class="row">';
                            }
                        } 

                        $row_counter++;   
                        $row_grid_counter++;  

                    endwhile;
                endif; ?>
                
            </div>
        </div>

    <?php endwhile;
endif; ?>            