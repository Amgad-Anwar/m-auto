<?php
/**
 * Create product for add to cart
 *
 * @author  TeamWP @Potenza Global Solutions
 * @package CarDealer/Functions
 * @version 1.0.0
 */

/**
 * WC_Product_Data_Store_CPT class extends
 *
 * @package cardealer
 */
class CarDealer_Data_Store_CPT extends WC_Product_Data_Store_CPT {

	/**
	 * Method to read a product from the database.
	 *
	 * @param WC_Product $product Product object.
	 * @throws Exception If invalid product.
	 */
	public function read( &$product ) {

		add_filter( 'woocommerce_is_purchasable', '__return_true', 10, 1 );

		$product->set_defaults();
		$post_object = get_post( $product->get_id() );

		if ( ! $product->get_id() || ! ( $post_object ) || ! ( ( 'product' === $post_object->post_type ) || ( 'cars' === $post_object->post_type ) ) ) {
			throw new Exception( __( 'Invalid product.', 'cardealer' ) );
		}

		$product->set_props(
			array(
				'name'              => $post_object->post_title,
				'slug'              => $post_object->post_name,
				'date_created'      => 0 < $post_object->post_date_gmt ? wc_string_to_timestamp( $post_object->post_date_gmt ) : null,
				'date_modified'     => 0 < $post_object->post_modified_gmt ? wc_string_to_timestamp( $post_object->post_modified_gmt ) : null,
				'status'            => $post_object->post_status,
				'description'       => $post_object->post_content,
				'short_description' => $post_object->post_excerpt,
				'parent_id'         => $post_object->post_parent,
				'menu_order'        => $post_object->menu_order,
				'reviews_allowed'   => 'open' === $post_object->comment_status,
			)
		);

		$this->read_attributes( $product );
		$this->read_downloads( $product );
		$this->read_visibility( $product );
		$this->read_product_data( $product );
		$this->read_extra_data( $product );
		$product->set_object_read( true );

	}

	/**
	 * Make sure we store the product type and version (to track data changes).
	 *
	 * @param int $product_id Product id.
	 * @since 3.0.0
	 */
	public function get_product_type( $product_id ) {
		$post_type = get_post_type( $product_id );
		if ( 'product_variation' === $post_type ) {
			return 'variation';
		} elseif ( ( 'product' === $post_type ) || ( 'cars' === $post_type ) ) {
			$terms = get_the_terms( $product_id, 'product_type' );
			return ! empty( $terms ) ? sanitize_title( current( $terms )->name ) : 'simple';
		} else {
			return false;
		}
	}
}
