jQuery(document).ready(function () {

    jQuery('input[name="billing_email_2"]')
        .bind('copy cut paste drop', function (event) {
            event.preventDefault();
        })
        .bind('blur change', function () {
            var wrapper = jQuery(this).closest('.form-row');

            if (jQuery(this).val() !== jQuery('input[name="billing_email"]').val()) {
                wrapper.addClass('woocommerce-invalid');
                return;
            }

            wrapper.addClass('woocommerce-validated');
        });
});
