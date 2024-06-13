

/**
 * Module pattern
 */
var StripeJava = (function () {
    "use strict";

    var pub;

    // Public interface
    pub = {};


    
 
    
    //callback to handle the response from stripe
    function stripeResponseHandler(status, response) {
        if (response.error) {
            console.log('error:');
            console.log(response.error.message);
            //enable the submit button
            $('#payBtn').removeAttr("disabled");
            //display the errors on the form
            //$(".payment-errors").html(response.error.message);
        } else {
            var form$ = $("#paymentFrm");
            //get token id
            var token = response['id'];
            //insert the token into the form
            form$.append("<input type='hidden' name='stripeToken' value='" 
    + token + "' />");
            //submit form to the servers
            //console.log(form$.get(0).submit());
            form$.get(0).submit();
        }
    } 
    
    /**
     * Setup function for the Checkout
     *
     */
    pub.setup = function () {
    //on form submit
    $("#paymentFrm").submit(function(event) {
        //disable the submit button to prevent repeated clicks
        $('#payBtn').attr("disabled", "disabled");
        
        //create single-use token to charge the user
        Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
        }, stripeResponseHandler);
        
        //submit from callback
        return false;
        });
    };

    // Expose public interface
    return pub;
}());
    
// The usual ready event handling to call Stripe.setup
$(document).ready(StripeJava.setup);

//set your publishable key
  Stripe.setPublishableKey('pk_test_51K3FIuE3QizePBpf0DwNYsjqAhY6Y2NvKLarC75WS3mzNU4rkpoFnMhzyEaFfCcAk31NIEFap3xBDCDX4rP9nU0P00dXSf5sb7');
