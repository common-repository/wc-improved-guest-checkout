<?php
/**
 * Improved Guest Checkout Front Checkout
 *
 * @class    Improved Guest Checkout Front Checkout
 * @package  guestCheckout\Checkout
 */

namespace guestCheckout\Frontend;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Improved_Guest_Checkout_Admin_Columns Class.
 */
class Session
{
    public function __construct()
    {
        add_action('woocommerce_after_checkout_validation', [$this, 'setPersitentCheckout']);
        add_filter('woocommerce_checkout_get_value', [$this, 'get_persistent_checkout'], 10, 2);
    }

    /**
     * @param array $postData
     * @return $this
     */
    public function setPersitentCheckout(array $postData): self
    {
        if (empty($postData['billing_email_2'])) {
            return $this;
        }

        WC()->session->set('billing_email_2', esc_attr($postData['billing_email_2']));
        return $this;
    }

    /**
     * Retrieve the billing email from the session
     *
     * @param $value
     * @param $index
     * @return array|string
     */
    public function get_persistent_checkout($value, $index)
    {
        if ('billing_email_2' !== $index) {
            return $value;
        }

        $data = WC()->session->get('billing_email_2');
        if (empty($data)) {
            return $value;
        }
        return $data;
    }
}
