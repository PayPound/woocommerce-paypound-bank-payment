<?php
/* @wordpress-plugin
 * Plugin Name:       WooCommerce paypound bank Payment Gateway
 * Plugin URI:        https://portal.paypound.ltd/
 * Description:       Paypound Bank Payment is help to do payment using third party payment getway.
 * Version:           1.3.4
 * WC requires at least: 3.0
 * WC tested up to: 5.3
 * Author:            Paypound
 * Author URI:        https://portal.paypound.ltd/
 * Text Domain:       woocommerce-paypoundbank-payment-gateway
 * Domain Path: /languages
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

$active_plugins = apply_filters('active_plugins', get_option('active_plugins'));
if(wpruby_custom_payment_paypoundbank_is_woocommerce_active()){
	add_filter('woocommerce_payment_gateways', 'add_paypoundbank_payment_gateway');
	function add_paypoundbank_payment_gateway( $gateways ){
		$gateways[] = 'WC_Paypoundbank_Payment_Gateway';
		return $gateways;
	}
	// add_action('woocommerce_before_thankyou', 'custome_message_payment_paypoundbank');
	// function custome_message_payment_paypoundbank(){
		// $order = new WC_Order($_GET['customer_order_id']);
		// if(!isset($_GET['status'])){
			// echo '<p> Payment Status : <strong>Success</strong> </p>';
		// }else{
			// if($_GET['status'] == 'success'){
				// $order->add_order_note(esc_html('Order Successfully Apporved, Payment Order id :'.$_GET['order_id']),1);
				// $order->update_status('Completed', '', true);
				// echo '<p> Payment Status : <strong>'.$_GET['status'].'</strong> || Message : <strong>'.$_GET['message'].'</strong> || Payment Order Id : <strong>'.$_GET['order_id'].'</p>';
			// }else{
				// $order->add_order_note(esc_html('Order Fail or Error : '.$_GET['message'].' , Payment Order id :'.$_GET['order_id']),1);
				// $order->update_status('Pending Payment', '', true);
				// echo '<p> Payment Status : <strong>'.$_GET['status'].'</strong> || Message : <strong>'.$_GET['message'].'</strong> || Payment Order Id : <strong>'.$_GET['order_id'].'</p>';
			// }
		// }
	// }
	add_action('plugins_loaded', 'init_paypoundbank_payment_gateway');
	function init_paypoundbank_payment_gateway(){
		require 'class-woocommerce-paypoundbank-payment-gateway.php';
	}

	add_action( 'plugins_loaded', 'paypound_paymentbank_load_plugin_textdomain' );
	function paypound_paymentbank_load_plugin_textdomain() {
	  load_plugin_textdomain( 'woocommerce-paypoundbank-payment-gateway', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}

}

/**
 * @return bool
 */
function wpruby_custom_payment_paypoundbank_is_woocommerce_active()
{
	$active_plugins = (array) get_option('active_plugins', array());

	if (is_multisite()) {
		$active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
	}

	return in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins);
}

