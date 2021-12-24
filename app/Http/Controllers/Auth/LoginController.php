<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return $this->redirectToHome();
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectToHome()
    {
        switch($accountType = Auth::user()->account_type) {
            case 'CUSTOMER':
                $redirectViewName = 'customer.dashboard.view';
                break;
            case 'ADMIN':
                $redirectViewName = 'admin.dashboard.view';
                break;
        }

        return redirect()->intended(route($redirectViewName));
    }
}