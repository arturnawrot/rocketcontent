@extends('customer.templates.main')

@section('content')

@include('customer.modals.payment-method-actions-modals')

<div class="row">
  <div class="col-md-6 col-sm-12 mb-2">

    <div class="card">
      <div class="card-body">
          <h2 id="card-title">Account</h2>
          This is some text within a card body.
      </div>
    </div>

  </div>
  <div class="col-md-6 col-sm-12">

    @include('customer.cards.subscription')
    
  </div>
</div>

<div class="row mt-4">
  <div class="col-md-12 col-lg-6">
    <div class="card">
      <div class="card-body">
          <h2 id="card-title">Payment Methods</h2>
            <div class="table-responsive">
              <table class="table text-center cc-table">
                @foreach($user->getPaymentMethods() as $paymentMethod)
                  <tr class="mt-3">
                    @include('customer.inc.credit-card-row')
                  </tr>
                @endforeach
              </table>
            </div>
          <div class="mt-3">
            @include('customer.inc.add-payment-method')
          </div>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h2 id="card-title">Statistics</h2>
      </div>
    </div>
  </div>
</div>

<a href="{{ route('auth.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout
</a>

<form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
    @csrf
</form>

@endsection


@section('js')

@include('inc.stripe-js')

@endsection

<!-- <a href="{{ route('customer.content.request.view') }}">Request New Content</a> -->
