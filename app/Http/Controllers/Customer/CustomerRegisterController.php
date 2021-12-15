<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerRegisterController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => 'Arturek Nawrot',
            'email' => 'artur.programista2@gmail.com',
            'customer' => 'CUSTOMER',
            'password' => bcrypt('Drzewo'),
            'trial_ends_at' => now()->addDays(14),
        ]);

        $user->createAsStripeCustomer();
        $user->addPaymentMethod( $request->payment_method );
        $user->updateDefaultPaymentMethod( $request->payment_method );

        $user->newSubscription('product_writing_service', 'price_writing_service_monthly')
            ->quantity(4000)
            ->create($request->payment_method);

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
