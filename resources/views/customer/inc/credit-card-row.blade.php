<div>
    <span>
        <td>
            @switch($paymentMethod['brand'])
                @case('visa')
                    <img class="card-icon" src="/svg/visa.svg"></i>
                    @break
                @case('mastercard')
                    <img class="card-icon" src="/svg/mastercard.svg"></i>
                    @break
            @endswitch

        </td>

        <td>
            <span class="cc-numbers">**** **** **** </span> {{ $paymentMethod['last4'] }}
        </td>
        <td>
            Expires {{ $paymentMethod['exp_month'] }}/{{ $paymentMethod['exp_year'] }}
        </td>
        <td>
            @if(!$paymentMethod['default'])
                <form id="set-default-pm-form" action="{{ route('customer.payment-method.set-default') }}" method="POST" style="display: none;">
                    <input type="hidden" name="payment_method" value="{{ $paymentMethod['id'] }}">
                    @csrf
                </form>

                <a href="{{ route('customer.payment-method.set-default') }}" onclick="event.preventDefault();document.getElementById('set-default-pm-form').submit();">Set as default</a>
            @else
                Default
            @endif
        </td>
    </span>
</div>