<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Requests\SubsriptionCancelationRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    private $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService) {
        $this->subscriptionService = $subscriptionService;    
    }

    public function cancel()
    {
        $this->subscriptionService->cancel(auth()->user());
    }
}