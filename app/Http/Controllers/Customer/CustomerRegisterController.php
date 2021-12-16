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

        return $user;
    }

    public function show()
    {
        $user = new User;

        return view('customer-register/register', [
            'intent' => $user->createSetupIntent()
        ]);
    }
}


        // $user = User::create([
        //     'name' => 'Czeslaw Niemen2',
        //     'email' => 'CzeslawJestem2@gmail.com',
        //     'account_type' => 'CUSTOMER',
        //     'password' => bcrypt('Drzewo'),
        //     'trial_ends_at' => now()->addDays(14),
        // ]);

        // $user->createAsStripeCustomer();
        // $user->addPaymentMethod( $request->payment_method );
        // $user->updateDefaultPaymentMethod( $request->payment_method );

        // $user->newSubscription('product_writing_service', 'price_writing_service_monthly')
        //     ->quantity(4000)
        //     ->create($request->payment_method);