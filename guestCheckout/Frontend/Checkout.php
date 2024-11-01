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
class Checkout
{
    public function __construct()
    {
        add_filter('woocommerce_add_error', [$this, 'wooCommerceErrors']);
        add_filter('woocommerce_checkout_fields', [$this, 'addConfirmEmail']);
        add_action('woocommerce_checkout_process', [$this, 'matchingEmailAddresses']);
        add_action('woocommerce_checkout_order_created', [$this, 'registerGuest'], 10, 1);
    }

    /**
     * Added to remove the prefix Facturering voor de error messages in the checkout.
     *
     * @param $error
     * @return string|string[]
     */
    function wooCommerceErrors($error)
    {
        $removeString = __('Billing ', 'improved-guest-checkout-for-woocommerce');

        if (strpos($error, $removeString) !== false) {
            $error = str_replace($removeString, '', $error);
        }

        return $error;
    }

    /**
     * Validate the email fields.
     *
     * Generate error message if field values are different.
     */
    public function addConfirmEmail(array $address_fields): array
    {
        if (is_user_logged_in()) {
            return $address_fields;
        }

        $priority = (int)$address_fields['billing']['billing_email']['priority'];
        $priority++;

        $address_fields['billing']['billing_email']['class'][] = 'form-row-first';
        $address_fields['billing']['billing_email_2']          = Field::confirmEmailField($priority);

        return $address_fields;
    }

    /**
     * Validate the email fields.
     *
     * Generate error message if field values are different.
     */
    public function matchingEmailAddresses()
    {
        if (is_user_logged_in()) {
            return;
        }

        $email1 = $email2 = '';
        if (!empty($_POST['billing_email'])) {
            $email1 = sanitize_email($_POST['billing_email']);
        }
        if (!empty($_POST['billing_email_2'])) {
            $email2 = sanitize_email($_POST['billing_email_2']);
        }

        if ($email2 !== $email1) {
            wc_add_notice(
                __('The two e-mail addresses you entered are not the same.', 'improved-guest-checkout-for-woocommerce'),
                'error'
            );
        }
    }

    /**
     * Register a user and link the orders to this new 'guest' user
     * Only when the user does not exists
     *
     * @param \WC_Order|int $order Order ID or instance.
     *
     * @return bool
     */
    public function registerGuest($order): bool
    {
        $order       = $order instanceof \WC_Order ? $order : wc_get_order($order);
        $order_email = $order->billing_email;

        // if the UID is null, then it's a guest checkout
        $userId = username_exists($order_email);
        if (!empty($userId)) {
            wc_update_new_customer_past_orders($userId);
            $this->updateUserData($userId, $order);
            return true;
        }
        $userId = email_exists($order_email);
        if (!empty($userId)) {
            wc_update_new_customer_past_orders($userId);
            $this->updateUserData($userId, $order);
            return true;
        }

        /*
         * Store the guest user
         */
        $display_name = $order->billing_first_name . ' ' . $order->billing_last_name;

        $userId = wp_insert_user(
            [
                'ID'                   => $userId,
                'user_login'           => $order_email,
                'user_email'           => $order_email,
                'nickname'             => $display_name,
                'user_pass'            => wp_generate_password(),
                'first_name'           => $order->billing_first_name,
                'last_name'            => $order->billing_last_name,
                'display_name'         => $display_name,
                'show_admin_bar_front' => 'false',
            ]
        );

        update_user_meta($userId, 'created_by_webshop', true);

        $this->updateUserData($userId, $order);

        wc_update_new_customer_past_orders($userId);

        return false;
    }

    /**
     * Update the customer address with the latest information
     *
     * @param int       $userId
     * @param \WC_Order $order
     */
    private function updateUserData(int $userId, \WC_Order $order)
    {
        // user's billing data
        update_user_meta($userId, 'billing_address_1', $order->billing_address_1);
        update_user_meta($userId, 'billing_address_2', $order->billing_address_2);
        update_user_meta($userId, 'billing_city', $order->billing_city);
        update_user_meta($userId, 'billing_company', $order->billing_company);
        update_user_meta($userId, 'billing_country', $order->billing_country);
        update_user_meta($userId, 'billing_email', $order->billing_email);
        update_user_meta($userId, 'billing_first_name', $order->billing_first_name);
        update_user_meta($userId, 'billing_last_name', $order->billing_last_name);
        update_user_meta($userId, 'billing_phone', $order->billing_phone);
        update_user_meta($userId, 'billing_postcode', $order->billing_postcode);
        update_user_meta($userId, 'billing_state', $order->billing_state);

        // user's shipping data
        update_user_meta($userId, 'shipping_address_1', $order->shipping_address_1);
        update_user_meta($userId, 'shipping_address_2', $order->shipping_address_2);
        update_user_meta($userId, 'shipping_city', $order->shipping_city);
        update_user_meta($userId, 'shipping_company', $order->shipping_company);
        update_user_meta($userId, 'shipping_country', $order->shipping_country);
        update_user_meta($userId, 'shipping_first_name', $order->shipping_first_name);
        update_user_meta($userId, 'shipping_last_name', $order->shipping_last_name);
        update_user_meta($userId, 'shipping_method', $order->shipping_method);
        update_user_meta($userId, 'shipping_postcode', $order->shipping_postcode);
        update_user_meta($userId, 'shipping_state', $order->shipping_state);

        if ( ! empty( $order->billing_vat_number ) ) {
            update_user_meta($userId, 'vat_number', $order->billing_vat_number);
        }

        // link past orders to this newly created customer
        wc_update_new_customer_past_orders($userId);
    }
}
