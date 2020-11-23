var stripeElement = document.getElementById('stripe');
var stripe = Stripe(stripeElement.getAttribute('data-key'));
$('#pay')
    .on('click', function (e) {
            stripe.redirectToCheckout({
                sessionId: stripeElement.getAttribute('data-session-id')
            });
        }
    );
