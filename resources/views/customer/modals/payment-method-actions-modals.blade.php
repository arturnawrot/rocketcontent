@foreach($user->getPaymentMethods() as $paymentMethod)
    <!-- Update Modal Start -->
    <div class="modal fade show" id="{{ $paymentMethod['id'] }}-update">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Payment Method Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">



            @if(!$paymentMethod['default'])
                <form id="set-default-pm-form" action="{{ route('customer.payment-method.set-default') }}" method="POST" style="display: none;">
                    <input type="hidden" name="payment_method" value="{{ $paymentMethod['id'] }}">
                    @csrf
                </form>

                <a href="{{ route('customer.payment-method.set-default') }}" onclick="event.preventDefault();document.getElementById('set-default-pm-form').submit();">Set as default, </a>
            @endif




                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Submit</button>
            </div>
            </div>
        </div>
    </div>
    <!-- Update Modal End -->

    <!-- Delete Modal Start -->
    @if(!$paymentMethod['default'])
        <div class="modal fade show" id="{{ $paymentMethod['id'] }}-delete">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><strong>Delete Payment Method</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="delete-pm" action="{{ route('customer.payment-method.delete') }}" method="POST" style="display: none;">
                        <input type="hidden" name="payment_method" value="{{ $paymentMethod['id'] }}">
                        @csrf
                    </form>

                    <p>Are you sure you want to delete the following payment method:</p>
                    <p><b>{{ ucfirst($paymentMethod['brand']) }}</b> ending at <b>{{ $paymentMethod['last4'] }}</b> expiring at <b>{{ $paymentMethod['exp_month'] }}/{{ $paymentMethod['exp_year'] }}</b></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button href="{{ route('customer.payment-method.delete') }}" onclick="event.preventDefault();document.getElementById('delete-pm').submit();" class="btn btn-danger">Delete</button>
                </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Delete Modal End -->
@endforeach