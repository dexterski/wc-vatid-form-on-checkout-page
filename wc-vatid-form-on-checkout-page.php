<?php
/*
Plugin Name: WC VAT–ID form on checkout page
Plugin URI: https://bogaczek.com
Description: This plugin adds field for VAT–ID (NIP) on checkout, and save it to order. Custom field name: <code>[vat_number]</code> 
Version: 0.7
Author: Black Sun
Author URI: https://bogaczek.com
Text Domain: wc-vatid-form-on-checkout-page
*/
defined('ABSPATH') or die();


/**
* Display VAT Number field in WooCommerce Checkout
*/
function dexter_vat_field( $checkout ) {
    echo '<div id="dexter_vat_field"><h3>' . __('Numer NIP / EU-VAT') . '</h3>';
    
    woocommerce_form_field( 'vat_number', array(
        'type'          => 'text',
        'class'         => array( 'vat-number-field form-row-wide') ,
        'label'         => __( 'Aby otrzymać fakturę, podaj numer NIP / EU VAT' ),
        'placeholder'   => __( 'PL1234567890' ),
    ), $checkout->get_value( 'vat_number' ));
    
    echo '</div>';
}
add_action( 'woocommerce_after_checkout_billing_form', 'dexter_vat_field' );

/**
* Save VAT Number in the order meta
*/
function dexter_checkout_vat_number_update_order_meta( $order_id ) {
    if ( ! empty( $_POST['vat_number'] ) ) {
        update_post_meta( $order_id, '_vat_number', sanitize_text_field( $_POST['vat_number'] ) );
    }
}
add_action( 'woocommerce_checkout_update_order_meta', 'dexter_checkout_vat_number_update_order_meta' );

/**
 * Display VAT Number in order edit screen
 */
function dexter_vat_number_display_admin_order_meta( $order ) {
    echo '<p><strong>' . __( 'NIP / EU VAT', 'woocommerce' ) . ':</strong> ' . get_post_meta( $order->id, '_vat_number', true ) . '</p>';
}
add_action( 'woocommerce_admin_order_data_after_billing_address', 'dexter_vat_number_display_admin_order_meta', 10, 1 );


?>