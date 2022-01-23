<button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Add New Card
</button>
<div class="collapse mt-3" id="collapseExample">
    <form id="registration-form" action="{{ route('customer.payment-method.add') }}" method="POST">
        @csrf

        <input type="hidden" id="payment-method" name="payment_method">

        <label class="my-1 small" for="username">Card Holder Name</label>
        <input id="card-holder-name" class="form-control form-control-sm border" placeholder="John Smith" id="username" name="name" value="{{ auth()->user()->name }}">
        <div class="mt-3 form-control border" id="card-element"></div>

        <button id="loginButton" class="btn btn-primary btn-sm mt-3" type="button" data-secret="{{ auth()->user()->createSetupIntent()->client_secret }}">
            Submit
        </button>
    </form>
</div>