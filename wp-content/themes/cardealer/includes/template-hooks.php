<?php
/**
 * Vehicle detail page sidebar hooks.
 */
add_action( 'cardealer_single_vehicle_sidebar', 'cardealer_single_vehicle_sidebar_trade_in_appraisal', 10 );
add_action( 'cardealer_single_vehicle_sidebar', 'cardealer_single_vehicle_sidebar_buy_online_btn', 20 );
add_action( 'cardealer_single_vehicle_sidebar', 'cardealer_single_vehicle_sidebar_review_stamps', 30 );
add_action( 'cardealer_single_vehicle_sidebar', 'cardealer_single_vehicle_sidebar_attributes', 40 );

/**
 * Vehicle detail page tabs hooks.
 */
add_filter( 'cardealer_vehicle_tabs', 'cardealer_default_vehicle_tabs' );
add_filter( 'cardealer_vehicle_tabs', 'cardealer_sort_vehicle_tabs', 9999 );

/**
 * Vehicle detail page sections hooks.
 */
add_filter( 'cardealer_vehicle_detail_page_section_enabled', 'cardealer_vehicle_detail_page_section_enabled', 10, 3 );

/**
 * Vehicle listing page hooks.
 */
add_action( 'cardealer/vehicle_listing/mobile/before_listing', 'cardealer_vehicle_listing_page_mobile_filters' );
add_action( 'cardealer_offcanvas', 'cardealer_widget_area__listing_cars' );

/**
 * Mobile item layout
 */
add_filter( 'cardealer_vehicle_list_view_type', 'cardealer_vehicle_list_mobile_view_type' );
