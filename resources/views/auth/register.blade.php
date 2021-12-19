@extends('auth.templates.main')

@section('main')

<form id="registration-form" method="POST" action="{{ route('customer.register.request') }}">
    @csrf

    <input type="hidden" id="payment-method" name="payment_method">

    <div class="form-group first">
        <label for="username">Full Name</label>
        <input type="text" class="form-control border" placeholder="John Smith" id="username" name="name">
    </div>

    <div class="form-group mt-3">
        <label for="username">Email</label>
        @error('email')
            <div>{{ $message }}</div>
        @enderror
        <input type="text" class="form-control border" placeholder="your-email@gmail.com" id="username" name="email">
    </div>

    <div class="form-group mt-3">
        <label for="password">Password</label>
        @error('password')
            <div>{{ $message }}</div>
        @enderror
        <input type="password" class="form-control border" placeholder="Your Password" id="password" name="password">
    </div>

    <div class="form-group mt-3">
        <label for="username">Card Holder Name</label>
        <input type="text" id="card-holder-name" class="form-control border" placeholder="John Smith" id="username" name="name">
    </div>

    <div class="form-group mb-3 mt-3 last">
        <div id="card-element"></div>
    </div>

    <input type="text" name="recurring_type" value="monthly">

    <input type="text" name="wordCount" value="4000">

    <div class="d-flex mb-5 align-items-center">
        <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
        <input type="checkbox" checked="checked"/>
        <div class="control__indicator"></div>
        </label>
        <span class="ms-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> 
    </div>

    <div class="d-grid">
        <button type="button" id="loginButton" class="btn btn-block btn-primary" data-secret="{{ $intent->client_secret }}">
            Register
        </button>
    </div>
</form>

@endsection

@section('js')
<script src="https://js.stripe.com/v3/"></script>

<script>
    const stripe = Stripe('pk_test_51K6PGJGAA2s7aUvAg2WBlwfxk4MSo9bWpJxTmkbnJDD7N5jTyGXQW6rEncqTvaog2Sz5MtCQiJdlnphoDyOLVraD00PzPtG1Vt');

    const elements = stripe.elements();
    const cardElement = elements.create('card');

    cardElement.mount('#card-element');

    const cardHolderName = document.getElementById('card-holder-name');
    const cardButton = document.getElementById('loginButton');
    const clientSecret = cardButton.dataset.secret;

cardButton.addEventListener('click', async (e) => {
    const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret, {
            payment_method: {
                card: cardElement,
                billing_details: { name: cardHolderName.value }
            }
        }
    );

    if (error) {
        console.log('error');
        
    } else {
        document.getElementById('payment-method').value = setupIntent.payment_method;

        document.getElementById('registration-form').submit();
    }
});
</script>
@endsection