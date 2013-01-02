/**
 * WP-Stripe
 *
 * @since 1.4
 *
 */

// var wp-stripe-key declared in DOM from localized script

Stripe.setPublishableKey( wpstripekey );

// Stripe Token Creation & Event Handling

jQuery(document).ready(function($) {

    var resetStripeForm = function() {
        $("#wp-stripe-payment-form").get(0).reset();
        $('input').removeClass('stripe-valid stripe-invalid');
    }

    function stripeResponseHandler(status, response) {
        if (response.error) {

            $('.stripe-submit-button').prop("disabled", false).css("opacity","1.0");
            $(".payment-errors").show().html(response.error.message);

        } else {

            var form$ = $("#wp-stripe-payment-form");
            var token = response['id'];
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");

            var newStripeForm = form$.serialize();

            $.ajax({
                type : "post",
                dataType : "json",
                url : ajaxurl,
                data : newStripeForm,
                success: function(response) {

                    $('.wp-stripe-details').prepend(response);
                    $('.stripe-submit-button').prop("disabled", false).css("opacity","1.0");
                    resetStripeForm();

                }

            });

        }
    }

    $("#wp-stripe-payment-form").submit(function(event) {

        event.preventDefault();
        $(".wp-stripe-notification").hide();

        $('.stripe-submit-button').prop("disabled", true).css("opacity","0.4");

        var amount = $('.wp-stripe-card-amount').val() * 100; //amount you want to charge in cents

        Stripe.createToken({
            name: $('.wp-stripe-name').val(),
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $('.card-expiry-month').val(),
            exp_year: $('.card-expiry-year').val()
        }, stripeResponseHandler);

        // prevent the form from submitting with the default action

        return false;

    });
});

// Form Validation & Enhancement

jQuery(document).ready(function($) {

    $('.card-number').focusout( function() {

        var cardValid = Stripe.validateCardNumber( $(this).val() );
        var cardType = Stripe.cardType( $(this).val() );

        // Card Number Validation

        if ( cardValid ) {
            $(this).removeClass('stripe-invalid').addClass('stripe-valid');
        } else {
            $(this).removeClass('stripe-valid').addClass('stripe-invalid');
        }

        // Card Type Information

        /*
        if ( cardType && cardValid  ) {
            // Display Card Logo
        }
        */

    });

    // CVC Validation

    $('.card-cvc').focusout( function() {

        if ( Stripe.validateCVC( $(this).val() ) ) {
            $(this).removeClass('stripe-invalid').addClass('stripe-valid');
        } else {
            $(this).removeClass('stripe-valid').addClass('stripe-invalid');
        }

    });

});

//jQuery iframe resizer version 1.90 for the embedded iframe shortcode.
//https://github.com/house9/jquery-iframe-auto-height
  jQuery(document).ready(function () {
    jQuery('.wp-stripe-embedded-frame').iframeAutoHeight({
		heightOffset: 100
	});  
  });
/*
  Plugin: iframe autoheight jQuery Plugin
  Version: 1.9.0
  Description: when the page loads set the height of an iframe based on the height of its contents
  see README: http://github.com/house9/jquery-iframe-auto-height 
*/
(function(a){a.fn.iframeAutoHeight=function(b){function d(a){c.debug&&c.debug===!0&&window.console&&console.log(a)}function e(b,c){d("Diagnostics from '"+c+"'");try{d("  "+a(b,window.top.document).contents().find("body")[0].scrollHeight+" for ...find('body')[0].scrollHeight"),d("  "+a(b.contentWindow.document).height()+" for ...contentWindow.document).height()"),d("  "+a(b.contentWindow.document.body).height()+" for ...contentWindow.document.body).height()")}catch(e){d("  unable to check in this state")}d("End diagnostics -> results vary by browser and when diagnostics are requested")}var c=a.extend({heightOffset:0,minHeight:0,callback:function(a){},animate:!1,debug:!1,diagnostics:!1,resetToMinHeight:!1,triggerFunctions:[],heightCalculationOverrides:[]},b);return d(c),this.each(function(){function g(a){var c=null;return jQuery.each(b,function(b,d){if(a[d])return c=f[d],!1}),c===null&&(c=f["default"]),c}function i(b){c.diagnostics&&e(b,"resizeHeight"),c.resetToMinHeight&&c.resetToMinHeight===!0&&(b.style.height=c.minHeight+"px");var f=a(b,window.top.document).contents().find("body"),h=g(a.browser),i=h(b,f,c,a.browser);d(i),i<c.minHeight&&(d("new height is less than minHeight"),i=c.minHeight+c.heightOffset),d("New Height: "+i),c.animate?a(b).animate({height:i+"px"},{duration:500}):b.style.height=i+"px",c.callback.apply(a(b),[{newFrameHeight:i}])}var b=["webkit","mozilla","msie","opera"],f=[];f["default"]=function(a,b,c,d){return b[0].scrollHeight+c.heightOffset},jQuery.each(b,function(a,b){f[b]=f["default"]}),jQuery.each(c.heightCalculationOverrides,function(a,b){f[b.browser]=b.calculation});var h=0;d(this),c.diagnostics&&e(this,"each iframe");if(c.triggerFunctions.length>0){d(c.triggerFunctions.length+" trigger Functions");for(var j=0;j<c.triggerFunctions.length;j++)c.triggerFunctions[j](i,this)}if(a.browser.webkit||a.browser.opera){d("browser is webkit or opera"),a(this).load(function(){var a=0,b=this,e=function(){i(b)};h===0?a=500:b.style.height=c.minHeight+"px",d("load delay: "+a),setTimeout(e,a),h++});var k=a(this).attr("src");a(this).attr("src",""),a(this).attr("src",k)}else a(this).load(function(){i(this)})})}})(jQuery); 