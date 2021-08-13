@props(['order'])
<div
  x-data="{
    edit: true,
    paymentMethod: null,
  }"
  x-on:step-updated.window="edit = $event.detail.step == 2 ? true : false"
  x-on:payment-method-updated.window="paymentMethod = $event.detail.paymentMethod"
>
  <div x-show="edit || !paymentMethod">
    <div id="payment-request-button"></div>

    <form id="payment-form" class="mb-6">
      <p class="instruction hidden text-sm text-center text-gray-600 my-6">@lang('Or enter your payment details below')</p>

      <label class="block mb-4">
        <span class="block text-sm mb-1">@lang('Card number')</span>
        <div id="cardNumber-element"></div>
      </label>

      <div class="flex space-x-4">
        <label class="w-1/2">
          <span class="block text-sm mb-1">@lang('Expiry')</span>
          <div id="cardExpiry-element"></div>
        </label>

        <label class="w-1/2">
          <span class="block text-sm mb-1">CVC</span>
          <div id="cardCvc-element"></div>
        </label>
      </div>

      <p id="card-error" role="alert" class="mt-2 text-red-600 text-sm"></p>
    </form>
  </div>

  <div x-show="!edit && paymentMethod">
    <div class="mb-6">
      <div class="font-semibold text-xs text-jade uppercase mb-2">@lang('Payment details')</div>

      <div class="">
        <span x-text="paymentMethod?.card?.brand" class="capitalize"></span>
        <span>@lang('ending in')</span>
        <span x-text="paymentMethod?.card?.last4"></span>
      </div>
      <div>
        <span>@lang('Expires on')</span>
        <span x-text="paymentMethod?.card?.exp_month.toString().padStart(2,'0')"></span>
        <span>/</span>
        <span x-text="paymentMethod?.card?.exp_year"></span>
      </div>
    </div>
  </div>
</div>

@push('scripts')

<script src="https://js.stripe.com/v3/"></script>

<script>
var stripe = Stripe('{{ config('ecommerce.key') }}');

// Payment Request Button

// TODO: parameter values
var paymentRequest = stripe.paymentRequest({
  country: 'ES',
  currency: 'eur',
  total: {
    label: '{{ config('app.name') }}',
    amount: {{ $order->total }},
  },
  // requestPayerEmail: true,
});

var elements = stripe.elements();

var prButton = elements.create('paymentRequestButton', {
  paymentRequest: paymentRequest,
});

// Check the availability of the Payment Request API first.
paymentRequest.canMakePayment().then(function(result) {
  if (result) {
    prButton.mount('#payment-request-button');
    document.querySelector('.instruction').classList.remove('hidden');
  } else {
    document.getElementById('payment-request-button').style.display = 'none';
  }
});

var paymentMethodId = null;

// Payment Method Set
paymentRequest.on('paymentmethod', function(ev) {
  ev.complete('success');

  paymentMethodId = ev.paymentMethod.id;

  window.dispatchEvent(new CustomEvent('payment-method-updated', {
    detail: { paymentMethod: ev.paymentMethod }
  }))

  window.dispatchEvent(new CustomEvent('step-updated', {
    detail: { step: 3 }
  }))
});

// Create Card Elements
const style = {
  base: {
    fontSize: '16px',
    lineHeight: '24px',
  }
};

const classes = {
  base: 'StripeElementInput',
  focus: 'StripeElementInput--focus',
  invalid: 'StripeElementInput--invalid',
}

var cardNumber = elements.create('cardNumber', { style, classes, showIcon: true });
var cardExpiry = elements.create('cardExpiry', { style, classes });
var cardCvc = elements.create('cardCvc', { style, classes });

cardNumber.mount("#cardNumber-element");
cardExpiry.mount("#cardExpiry-element");
cardCvc.mount("#cardCvc-element");

var cardError = document.querySelector("#card-error");

cardNumber.on("change", function (event) {
  // Disable the Pay button if there are no card details in the Element
  cardError.textContent = event.error ? event.error.message : "";
});

// Validate card
var validateCardBtn = document.getElementById("validate-card");

validateCardBtn.addEventListener("click", function () {
  stripe
    .createPaymentMethod({
      type: 'card',
      card: cardNumber,
      billing_details: {
        name: document.getElementById("customerName").innerText,
        email: document.getElementById("customerEmail").innerText,
      },
    })
    .then(function(result) {
      if (result.error) {
        cardError.textContent = result.error.message;
      } else {
        paymentMethodId = result.paymentMethod.id;

        window.dispatchEvent(new CustomEvent('payment-method-updated', {
          detail: { paymentMethod: result.paymentMethod }
        }))

        window.dispatchEvent(new CustomEvent('step-updated', {
          detail: { step: 3 }
        }))
      }
    });
})

// Place order
var placeOrderBtn = document.getElementById("place-order")

placeOrderBtn.addEventListener("click", function () {
  placeOrderBtn.disabled = true
  placeOrderBtn.classList.add('opacity-50')

  var clientSecret = document.getElementById("clientSecret");

  stripe
    .confirmCardPayment(clientSecret.value, {
      payment_method: paymentMethodId
    })
    .then(function(result) {
      if (result.error) {
        cardError.textContent = result.error ? result.error.message : "";

        window.dispatchEvent(new CustomEvent('step-updated', {
          detail: { step: 2 }
        }));
      } else {
        window.dispatchEvent(new CustomEvent('step-updated', {
          detail: { step: 4 }
        }));
      }
    })
    .finally(() => {
      placeOrderBtn.disabled = false;
      placeOrderBtn.classList.remove('opacity-50')
    });
})
</script>

@endpush
