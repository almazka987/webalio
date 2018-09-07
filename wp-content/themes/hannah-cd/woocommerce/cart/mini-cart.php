<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.3.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_mini_cart' ); ?>

<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>" data-shop-url="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" data-shop-button="<?php _e( 'Return To Shop', 'hannah-cd' ) ?>">

	<?php if ( ! WC()->cart->is_empty() ) : ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				
				$variation_id_class = '';

				if ( $cart_item['variation_id'] > 0 )
                        $variation_id_class = ' product-var-id-' .  $cart_item['variation_id'];				

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>

					<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?> product-id-<?php echo $cart_item['product_id']; ?><?php echo esc_attr($variation_id_class); ?>">

						<a href="<?php echo esc_url( WC()->cart->get_remove_url( $cart_item_key ) ); ?>" class="remove-product remove" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>" data-product-id="<?php echo $cart_item['product_id'];?>"   data-variation-id="<?php echo $cart_item['variation_id'];?>" data-product-qty="<?php echo $cart_item['quantity'];?>" data-product_sku="<?php echo esc_attr( $_product->get_sku() );?>" title="<?php echo esc_html__( 'Remove this item', 'hannah-cd' ); ?>">&times;</a>
					
						<?php if ( ! $_product->is_visible() ) : ?>
							<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name . '&nbsp;'; ?>
						<?php else : ?>
							<a href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name . '&nbsp;'; ?>
							</a>
						<?php endif; ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
						
						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
					</li>
					<?php
				}
			}
		?>

	<?php else : ?>

		<li class="empty">

			<h3><?php _e( 'No products in the cart.', 'hannah-cd' ); ?></h3>

			<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
				<p class="return-to-shop">
					<a class="button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
						<i class="fa fa-chevron-left"></i> 
						<span><?php _e( 'Return To Shop', 'hannah-cd' ) ?></span>
					</a>
				</p>
			<?php endif; ?>

		</li>

	<?php endif; ?>

</ul><!-- end product list -->

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<p class="total">
		<strong><?php _e( 'Subtotal', 'hannah-cd' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?>
	</p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="buttons">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button btn1 wc-forward cart-but">
			<i class="fa fa-shopping-basket"></i> 
			<span><?php _e( 'View Cart', 'hannah-cd' ); ?></span>
		</a>
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button btn1 checkout wc-forward bshadow">
			<i class="fa fa-credit-card"></i> 
			<span><?php _e( 'Checkout', 'hannah-cd' ); ?></span>
		</a>
	</p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
