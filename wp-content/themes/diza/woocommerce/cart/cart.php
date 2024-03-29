<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

defined( 'ABSPATH' ) || exit;

remove_action('woocommerce_cart_collaterals','woocommerce_cross_sell_display');
add_action('woocommerce_after_cart_contents','woocommerce_cross_sell_display');

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	<div class="row">
		<div class="col-lg-8 tb-cart-form">
			<div class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
				<div class="cart_item head">
					<span class="product-info"><?php esc_html_e( 'Product', 'diza' ); ?></span>
					<span class="product-price"><?php esc_html_e( 'Price', 'diza' ); ?></span>
					<span class="product-quantity"><?php esc_html_e( 'Qty', 'diza' ); ?></span>
					<span class="product-subtotal"><?php esc_html_e( 'Total', 'diza' ); ?></span>
					<span class="product-remove">&nbsp;</span>
				</div>
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>
				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
						<div class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

							<span class="product-info" data-title="<?php esc_attr_e( 'Product', 'diza' ); ?>">
								<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $product_permalink ) {
										echo trim($thumbnail);
									} else {
										printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
									}
								?>
								<span class="product-name">
									<?php
        						if ( ! $product_permalink ) {
        							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', esc_html($_product->get_name()), $cart_item, $cart_item_key ) . '&nbsp;' );
        						} else {
        							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), esc_html($_product->get_name()) ), $cart_item, $cart_item_key ) );
        						}

										do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
										// Meta data.
										echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

        						// Backorder notification.
        						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
        							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'diza' ) . '</p>', $product_id ) );
        						}
									?>
								</span>
								
							</span>

							<span class="product-price" data-title="<?php esc_attr_e( 'Price', 'diza' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?>
						</span>

						<span class="product-quantity" data-title="<?php esc_attr_e( 'Qty', 'diza' ); ?>">
							<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'    => "cart[{$cart_item_key}][qty]",
										'input_value'   => $cart_item['quantity'],
										'max_value'     => $_product->get_max_purchase_quantity(),
										'min_value'     => '0',
										'product_name'  => $_product->get_name(),
									), $_product, false );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
							?>
						</span>

						<span class="product-subtotal price" data-title="<?php esc_attr_e( 'Total', 'diza' ); ?>">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</span>
						<span class="product-remove">
							<?php
								// @codingStandardsIgnoreLine
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="tb-icon tb-icon-trash"></i></a>',
									esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
									esc_attr__( 'Remove this item', 'diza' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );
							?>
						</span>
					</div>
					<?php
				}
			}

			?>
			</div>
			<div class="cart-bottom clearfix" class="actions">
				<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
					<div class="continue-to-shop pull-left hidden-xs">
						<a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
							<i class="tb-icon tb-icon-arrow-left"></i><?php esc_html_e( 'Continue Shopping', 'diza' ) ?>
						</a>
					</div>
				<?php endif; ?>
				<div class="update-cart pull-right">
					<i class="tb-icon tb-icon-redo2"></i>
					<input type="submit" class="btn btn-default update" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'diza' ); ?>" />
				</div>

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

			</div>
			<?php if ( wc_coupons_enabled() ) { ?>
			<div class="coupon">
				<label for="coupon_code"><?php esc_html_e( 'Coupon apply', 'diza' ); ?></label>
				<div class="box"><input type="text" name="coupon_code" id="coupon_code" value="" class="text" placeholder="<?php esc_attr_e('Enter coupon code here...', 'diza'); ?>" /><input type="submit" class="btn btn-default" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'diza' ); ?>" /></div>
				<?php do_action('woocommerce_cart_coupon'); ?>
			</div>	
			<?php } ?>
			<?php do_action( 'woocommerce_cart_contents' ); ?>
		</div>
		<div class="col-lg-4 tb-cart-total">
			<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
			<div class="cart-collaterals">
				<?php
					/**
					 * Cart collaterals hook.
					 *
					 * @hooked woocommerce_cross_sell_display
					 * @hooked woocommerce_cart_totals - 10
					 */
					do_action( 'woocommerce_cart_collaterals' );
				?>
			</div>
			

		</div>
	</div>

	<?php do_action( 'woocommerce_after_cart_contents' ); ?>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<?php do_action( 'woocommerce_after_cart' ); ?>
