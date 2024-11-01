<?php
/**
 * Improved Guest Checkout Admin Columns
 *
 * @class    Improved Guest Checkout Admin Columns
 * @package  guestCheckout\Admin
 */

namespace guestCheckout\Admin;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Improved_Guest_Checkout_Admin_Columns Class.
 */
class Columns
{
    public function __construct()
    {
        add_filter('manage_users_custom_column', [$this, 'manageUsersCustomColumn'], 10, 3);
        add_filter('manage_users_columns', [$this, 'manageUsersColumn'], 10, 1);
    }

    /**
     * @param string $output
     * @param string $column_key
     * @param int    $user_id
     *
     * @return mixed|string
     */
    public function manageUsersCustomColumn(string $output, string $column_key, int $user_id)
    {
        if ('created_by_webshop' !== $column_key) {
            return $output;
        }

        return (true == get_user_meta($user_id, 'created_by_webshop', true)) ? 'yes' : 'no';
    }

    /**
     * @param array $columns
     *
     * @return array
     */
    public function manageUsersColumn(array $columns): array
    {
        $columns['created_by_webshop'] = __('Created by webshop', 'improved-guest-checkout-for-woocommerce');

        return $columns;
    }
}
