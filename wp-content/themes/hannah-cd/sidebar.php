<?php 
/*
*************************************** 
Displaying for custom and default sidebar
***************************************
*/ 

// OUTPUT THE CUSTOM SIDEBARDS

if( ACF_HR('add_sidebars', 'option') ) { 
	
	$id_count = 1;
	$custom_sb_current = false;
	
	while ( ACF_HR('add_sidebars', 'option') ) { the_row();													

		hannah_cd_content_visibility( get_the_ID() );
                                                 
        global $hannah_cd_visibility, $hannah_cd_visibility_cases; 

		if( ! empty( $hannah_cd_visibility ) ) {
            foreach( $hannah_cd_visibility as $display ) :
                if( $hannah_cd_visibility_cases[ $display ] ) :

                    $custom_sb_current = true;

                    // CUSTOM SIDEBAR

                    echo '<div class="widget-area">';
                        dynamic_sidebar( 'custom-sb-' . $id_count );		
                    echo '</div>';	

                endif; 
            endforeach;
        } 

		$id_count++;

	}

	if( $custom_sb_current == false ) {

		// DEFAULT SIDEBAR

		get_template_part( 'sidebar-default' );

	}

} else {

	// DEFAULT SIDEBAR

	get_template_part( 'sidebar-default' );

}

?>