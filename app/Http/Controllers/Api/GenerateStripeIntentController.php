<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class GenerateStripeIntentController extends Controller
{
    public function generateIntentToken()
    {
        if(auth()->check()) {
            $user = auth()->user();
        } else {
            $user = new User;
        }

        return $user->createSetupIntent()->client_secret;
    }
}
