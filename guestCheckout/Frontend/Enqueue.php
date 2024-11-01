<?php
/**
 * Improved Guest Checkout Front Enqueue JavaScript
 *
 * @class    Improved Guest Checkout Front Enqueue
 * @package  guestCheckout\Checkout
 */

namespace guestCheckout\Frontend;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Improved_Guest_Checkout_Front_Enqueue Class.
 */
class Enqueue
{

    /**
     * @var float
     */
    protected $version = 1.0;

    public function __construct()
    {
        if (defined('WCIGC_VERSION')) {
            $this->version = WCIGC_VERSION;
        }

        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
        add_action('plugins_loaded', [$this, 'initTextdomain']);
    }

    /**
     * Init the translations
     */
    public function initTextdomain()
    {
        $plugin_dir = basename(dirname(dirname(dirname(__FILE__))));
        load_plugin_textdomain('improved-guest-checkout-for-woocommerce', false, $plugin_dir . '/languages');
    }


    /**
     * Adding extra javascript to prevent copy - paste
     */
    public function enqueueScripts()
    {
        wp_register_script(
            'guestCheckout',
            plugins_url('assets/js/guestCheckout.js', dirname(dirname(__FILE__))),
            ['jquery'],
            $this->version,
            true
        );

        wp_enqueue_script('guestCheckout');
    }
}
