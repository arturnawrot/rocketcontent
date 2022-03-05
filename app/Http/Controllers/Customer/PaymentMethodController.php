<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Requests\ContentListingRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPaymentMethodRequest;
use App\Http\Requests\DeletePaymentMethodRequest;
use App\Http\Requests\SetDefaultPaymentMethodRequest;
use App\Services\PaymentService;
use App\Models\User;

class PaymentMethodController extends Controller
{
    private $paymentService;

    public function __construct(PaymentService $paymentService) {
        $this->paymentService = $paymentService;
    }

    public function addPaymentMethod(AddPaymentMethodRequest $request)
    {
        $this->paymentService->addPaymentMethod(
            auth()->user(), $request->getDto()
        );

        return redirect()->back()->withSuccess('The payment method has been successfully added.');
    }

    public function setDefaultPaymentMethod(SetDefaultPaymentMethodRequest $request)
    {
        $this->paymentService->setDefaultPaymentMethod(
            auth()->user(), $request->getDto()
        );

        return redirect()->back()->withSuccess('The default payment method has been successfully updated.');
    }

    public function deletePaymentMethod(DeletePaymentMethodRequest $request)
    {
        $this->paymentService->deletePaymentMethod(
            auth()->user(), $request->getDto()
        );

        return redirect()->back()->withSuccess('The payment method has been succesfuly deleted.');
    }
}
