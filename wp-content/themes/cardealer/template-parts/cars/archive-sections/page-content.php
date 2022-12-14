<div class="listing-page--page-content">
	<?php
	if ( isset( $args['inv_page_content'] ) && ! empty( $args['inv_page_content'] ) ) {
		$content = $args['inv_page_content'];

		$content = apply_filters( 'cd_' . $args['layout'] . '_inv_style_content', $content, $args['inv_page_id'], $args['layout'] );
		$content = apply_filters( 'cardealer_listing_page__page_content', $content, $args['inv_page_id'], $args['layout'] );

		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		if ( ! empty( $content ) ) {
			echo do_shortcode( $content );
			$cd_inv_content = 'cd-content';
		} else {
			$cd_inv_content = 'cd-no-content';
		}
	}
	?>
</div>
