<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/admin';

    public function showResetForm($token)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => request()->email]
        );
    }
}
