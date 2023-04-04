function ajaxPaypal() {
    var data = {
        'action': 'paypal',
        'amount': jQuery('#amount').val(),
        'currency': jQuery('#currency').val()
    };
    jQuery.post(ajaxurl, data, function(response) {
        jQuery('#paypal').html(response);
    });
}