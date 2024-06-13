/**
 * var response = fetch('/secret').then(function(response) {
  return response.json();
}).then(function(responseJson) {
  var clientSecret = responseJson.client_secret;
  // Call stripe.confirmCardPayment() with the client secret.
  Stripe
  .confirmCardPayment(clientSecret, {
    payment_method: {
      card: cardElement,
      billing_details: {
        name: 'Jenny Rosen',
      },
    },
  })
  .then(function(result) {
    // Handle result.error or result.paymentIntent
  });
});
*/