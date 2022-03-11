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
            @if($paymentMethod['default'])
                <b>Default</b> 
            @else
                Backup
            @endif
        </td>
        <td>

            <div class="dropdown" id="cc-actions-menu">
                <span id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-h"></i>
                </span>
                <ul class="dropdown-menu dropdown-menu-center text-center" aria-labelledby="dropdownMenuButton1">
                    <li>
                        <a class="dropdown-item text-muted" role="button" href="" data-bs-toggle="modal" data-bs-target="#{{ $paymentMethod['id'] }}-update">
                            Update Card
                        </a>
                    </li>

                    @if(!$paymentMethod['default'])
                        <form id="set-default-pm-form" action="{{ route('customer.payment-method.set-default') }}" method="POST" style="display: none;">
                            <input type="hidden" name="payment_method" value="{{ $paymentMethod['id'] }}">
                            @csrf
                        </form>

                        <li>
                            <a href="{{ route('customer.payment-method.set-default') }}" class="dropdown-item text-muted" onclick="event.preventDefault();document.getElementById('set-default-pm-form').submit();">Make Default</a>
                        </li>
                    @endif


                    @if(!$paymentMethod['default'])
                        <li>
                            <a class="dropdown-item" id="delete-action-link" role="button" href="" data-bs-toggle="modal" data-bs-target="#{{ $paymentMethod['id'] }}-delete">
                                Delete
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
                 
        </td>
    </span>
</div>