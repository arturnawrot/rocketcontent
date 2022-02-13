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
            **** **** **** {{ $paymentMethod['last4'] }}
        </td>
        @if($paymentMethod['default'] == true)
            <td>Default</td>
        @endif
    </span>
</div>