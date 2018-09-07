<?php 
/*
*************************************** 
Displaying for default sidebar
***************************************
*/ 

if ( class_exists( 'WooCommerce' ) ) {
	$is_woocommerce = is_woocommerce();
} else {
	$is_woocommerce = false;
}

// WOOCOMMERCE SIDEBAR

if ( $is_woocommerce ) :

	if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar('sidebar-shop') ) :
		if( is_active_sidebar( 'sidebar-shop' ) ) :
			echo '<div class="widget-area">';
				dynamic_sidebar( 'sidebar-shop' );
			echo '</div>';
		endif;
	endif;

// DEFAULT SIDEBAR

else :

	if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar('sidebar-1') ) :
		if( is_active_sidebar( 'sidebar-1' ) ) :
			echo '<div class="widget-area">';
				dynamic_sidebar( 'sidebar-1' );
			echo '</div>';
		endif;
	endif;

endif;

?>