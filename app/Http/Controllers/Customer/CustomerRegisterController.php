<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerRegisterRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CustomerService;

class CustomerRegisterController extends Controller
{
    private $customerService;

    public function __construct(CustomerService $customerService) {
        $this->customerService = $customerService;    
    }

    public function register(CustomerRegisterRequest $request)
    {
        $user = $this->customerService->register(
            customerData: $request->getDto(),
            trialDays: 14
        );

        auth()->login($user);

        return redirect()->route('customer.dashboard.view');
    }

    public function show()
    {
        $user = new User;

        return view('auth/register', [
            'intent' => $user->createSetupIntent()
        ]);
    }
}