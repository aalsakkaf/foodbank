$(function() {
  var $form         = $(".require-validation");
$('form.require-validation').bind('submit', function(e) {
  var $form         = $(".require-validation"),
      inputSelector = ['input[type=email]', 'input[type=password]',
                       'input[type=text]', 'input[type=file]',
                       'textarea'].join(', '),
      $inputs       = $form.find('.required').find(inputSelector),
      $errorMessage = $form.find('div.error'),
      valid         = true;
      $errorMessage.addClass('hide');

      $('.has-error').removeClass('has-error');
  $inputs.each(function(i, el) {
    var $input = $(el);
    if ($input.val() === '') {
      $input.parent().addClass('has-error');
      $errorMessage.css('display','block');
      e.preventDefault();
    }
  });

  if (!$form.data('cc-on-file')) {
    e.preventDefault();
    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
    Stripe.createToken({
      number: $('.card-number').val(),
      cvc: $('.card-cvc').val(),
      exp_month: $('.card-expiry-month').val(),
      exp_year: $('.card-expiry-year').val()
    }, stripeResponseHandler);
  }

});

function stripeResponseHandler(status, response) {
      if (response.error) {
          $('.error')
              .css('display','block')
              .find('.alert')
              .text(response.error.message);
      } else {
          // token contains id, last4, and card type
          var token = response['id'];
          // insert the token into the form so it gets submitted to the server
          $form.find('input[type=text]').empty();
          $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
          $form.get(0).submit();
      }
  }
//     $('#credit-card').on('keypress change', function () {
//   $(this).val(function (index, value) {
//     return value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
//   });
// });
$('#credit-card').mask("9999 9999 9999 9999");
});