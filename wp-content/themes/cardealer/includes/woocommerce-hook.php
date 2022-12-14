<?php
/**
 * Woocommerce hook file
 *
 * @package Cardealer
 */

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/**
 * Minicart on header via Ajax
 */
if ( cardealer_woocommerce_version_check( '2.7.0' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'cardealer_add_to_cart_fragment', 100 );
} else {
	add_filter( 'add_to_cart_fragments', 'cardealer_add_to_cart_fragment', 100 );
}

if ( ! function_exists( 'cardealer_add_to_cart_fragment' ) ) {
	/**
	 * Add to cart fragment
	 *
	 * @param array $fragments array variable.
	 */
	function cardealer_add_to_cart_fragment( $fragments ) {
		// Menu Cart.
		ob_start();
		?>
		<div class="menu-item-woocommerce-cart-wrapper">
			<?php
			get_template_part( 'woocommerce/minicart-ajax' );
			?>
		</div>
		<?php
		$menu_cart = ob_get_clean();

		// Mobile Cart.
		ob_start();
		?>
		<div class="mobile-cart-wrapper">
			<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
		</div>
		<?php
		$mobile_cart                                      = ob_get_clean();
		$fragments['.menu-item-woocommerce-cart-wrapper'] = $menu_cart;
		$fragments['.mobile-cart-wrapper']                = $mobile_cart;

		return $fragments;
	}
}

/**
 * Remove default woocommerce_before_main_content
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

if ( ! function_exists( 'cardealer_show_related_products' ) ) {
	/**
	 * Cardealer show related products
	 */
	function cardealer_show_related_products() {
		global $car_dealer_options;
		if ( isset( $car_dealer_options['show_related_products'] ) && 'no' === $car_dealer_options['show_related_products'] ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
		}
	}
}
add_action( 'init', 'cardealer_show_related_products' );

add_filter( 'woocommerce_cart_item_permalink', 'cardealer_add_custom_link_to_car_page', 10, 3 );
if ( ! function_exists( 'cardealer_add_custom_link_to_car_page' ) ) {
	/**
	 * Update cart page product page link to car details page link
	 *
	 * @param string $permalink store permalink.
	 * @param array  $cart_item store cart item.
	 * @param string $cart_item_key store key.
	 */
	function cardealer_add_custom_link_to_car_page( $permalink, $cart_item, $cart_item_key ) {
		global $wpdb;

		$results = $wpdb->get_results(
			$wpdb->prepare(
				'
				SELECT * FROM ' . $wpdb->postmeta . '
				WHERE meta_key = "car_to_woo_product_id" AND meta_value = %d
				',
				$cart_item['product_id']
			),
			OBJECT
		);
		if ( isset( $results ) && ! empty( $results ) ) {
			$car_id = $results[0]->post_id;
			if ( isset( $car_id ) ) {
				$permalink = get_the_permalink( $car_id );
			}
		}
		return $permalink;
	}
}

/**
 * Sell vehicle custom call
 */
function cardealer_woocommerce_data_stores ( $stores ) {
	$stores['product'] = 'CarDealer_Data_Store_CPT';
	return $stores;
}

add_filter( 'woocommerce_data_stores', 'cardealer_woocommerce_data_stores' );

/**
 * Add custom meta to order for vehicle sell
 */
function cardealer_before_checkout_update_order_meta( $order_id, $data ) {
	$cart_item_data = WC()->cart->get_cart();

    foreach ( $cart_item_data as $item ) {
        $id          = $item['product_id'];
		$post_object = get_post($item['product_id']);

		if ( 'cars' !== $post_object->post_type ) {
			continue;
		}

		$sell_vehicle_status = get_post_meta( $id, 'sell_vehicle_status', true );
        if ( 'enable' === $sell_vehicle_status ) {
			$vehicle_old_ids = get_post_meta( $order_id, 'vehicle_ids', true );
			if ( ! empty( $vehicle_old_ids ) ) {
				$vehicle_ids   = $vehicle_old_ids;
				$vehicle_ids[] = $id;
			} else {
				$vehicle_ids[] = $id;
			}

			update_post_meta( $order_id, 'vehicle_ids', $vehicle_ids );
        }
    }

    return true;
}

add_action( 'woocommerce_checkout_update_order_meta', 'cardealer_before_checkout_update_order_meta', 10, 2 );

/**
 * Prevent vehicle out stock being added to the cart.
 *
 * @param  bool $passed     Validation.
 * @param  int  $product_id Product ID.
 * @return bool
 */
function cardealer_check_vehicle_in_stock_validation( $passed, $product_id, $quantity ) {
	if ( 'cars' === get_post_type( $product_id ) ) {
		$vehicle_in_stock = (int) get_post_meta( $product_id, 'total_vehicle_in_stock', true );

		if ( $vehicle_in_stock < 1 ) {
			$passed = false;
			wc_add_notice( esc_html__( 'Sorry, the item is out of stock and cannot be added to the cart.', 'cardealer' ), 'error' );
		}

		$cart_item_data = WC()->cart->get_cart();
		foreach ( $cart_item_data as $item ) {
			$id          = $item['product_id'];
			if ( $product_id == $id && $item['quantity'] > 0 ) {
				$passed = false;
			}
		}
	}

    return $passed;
}

add_filter( 'woocommerce_add_to_cart_validation', 'cardealer_check_vehicle_in_stock_validation', 10, 3 );

/**
 * Prevent vehicle out stock being Update cart.
 *
 * @param  bool $passed     Validation.
 * @param  int  $product_id Product ID.
 * @return bool
 */
function cardealer_update_cart_check_vehicle_in_stock_validation( $passed, $product_id, $values, $quantity ) {

	if ( 'cars' === get_post_type( $values['product_id'] ) ) {
		$vehicle_in_stock = (int) get_post_meta( $values['product_id'], 'total_vehicle_in_stock', true );
		if ( $vehicle_in_stock < 1 ) {
			$passed = false;
			wc_add_notice( esc_html__( 'Sorry, the item is out of stock and cannot be added to the cart.', 'cardealer' ), 'error' );
		} else if ( (int) $quantity > 1 ) {
			$passed = false;
			wc_add_notice( esc_html__( 'Sorry, only one copy of this product is allowed to be added to the cart.', 'cardealer' ), 'error' );
		}
	}

    return $passed;
}

add_filter( 'woocommerce_update_cart_validation', 'cardealer_update_cart_check_vehicle_in_stock_validation', 10, 4 );

/**
 * Update vehicle stock once order status get completed
 */
function cardealer_update_vehicle_stock_with_processing( $order_id ) {
    $vehicle_ids = get_post_meta( $order_id, 'vehicle_ids', true );

	if ( $vehicle_ids ) {
		foreach ( $vehicle_ids as $vehicle_id ) {
			$vehicle_in_stock = (int) get_post_meta( $vehicle_id, 'total_vehicle_in_stock', true );

			if ( $vehicle_in_stock > 0 ) {

				if ( 1 === $vehicle_in_stock ) {
					update_post_meta( $vehicle_id, 'car_status', 'sold' );
				}

				update_post_meta( $vehicle_id, 'total_vehicle_in_stock', $vehicle_in_stock - 1 );
			}
		}
	}
}
add_action( 'woocommerce_order_status_processing', 'cardealer_update_vehicle_stock_with_processing' );

/**
 * Update vehicle stock once order status get canceled refunded and failed
 */
function cardealer_update_vehicle_stock_on_order_status_changed( $order_id ) {
    $vehicle_ids = get_post_meta( $order_id, 'vehicle_ids', true );

	if ( $vehicle_ids ) {
		foreach ( $vehicle_ids as $vehicle_id ) {
			$vehicle_in_stock = (int) get_post_meta( $vehicle_id, 'total_vehicle_in_stock', true );

			if ( is_numeric($vehicle_in_stock) ){
				update_post_meta( $vehicle_id, 'car_status', 'unsold' );
				update_post_meta( $vehicle_id, 'total_vehicle_in_stock', $vehicle_in_stock + 1 );
			}
		}
	}
}

add_action( 'woocommerce_order_status_failed', 'cardealer_update_vehicle_stock_on_order_status_changed' );
add_action( 'woocommerce_order_status_refunded', 'cardealer_update_vehicle_stock_on_order_status_changed' );
add_action( 'woocommerce_order_status_cancelled', 'cardealer_update_vehicle_stock_on_order_status_changed' );
