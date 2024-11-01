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
class Field
{
    /**
     * @return array
     */
    public static function confirmEmailField(int$priority=115)
    {
        return [
            'label'        => __('Confirm Email', 'improved-guest-checkout-for-woocommerce'),
            'required'     => 1,
            'type'         => 'email',
            'class'        => ['form-row-last'],
            'validate'     => ['email'],
            'autocomplete' => 'email',
            'priority'     => $priority,
        ];
    }
}
