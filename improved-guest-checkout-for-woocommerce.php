<?php
/**
 * @package improved-guest-checkout-for-woocommerce
 * @version 1.5
 *
 * Plugin Name:	Improved Guest checkout for WooCommerce
 * Description: This plugin extends WooCommerce and require the guest confirm their email and combine orders when using the same email
 * Author: 		Dragonet
 * Version: 	1.5
 * Author URI: 	http://www.dragonet.nl/
 * Text Domain: improved-guest-checkout-for-woocommerce
 * Domain Path: /languages
*/
namespace guestCheckout;

use guestCheckout\Admin\Columns;
use guestCheckout\Frontend\Checkout;
use guestCheckout\Frontend\Enqueue;
use guestCheckout\Frontend\Session;

if ( ! defined('ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/*
 * Implement autoload
 */
spl_autoload_register(
    function ($class) {
        $path = trailingslashit(__DIR__) . str_replace('\\', '/', $class);

        if (file_exists($path . '.php')) {
            require_once($path . '.php');
        }
    }
);

define( 'WCIGC_VERSION', '1.5');

new Checkout();
new Columns();
new Enqueue();
new Session();
