<div>
    <span>
        <td>
            @if($paymentMethod['brand'] == 'visa')
                <i class="fab fa-cc-visa" style="color: #007eff;"></i>
            @endif
        </td>

        <td>
            **** **** **** {{ $paymentMethod['last4'] }}
        </td>
    </span>
</div>