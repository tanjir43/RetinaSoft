<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request):RedirectResponse
    {
        $user = User::find($request->route('id')); ////takes user ID from verification link. Even if somebody would hijack the URL, signature will be fail the request
        if($user->hasVerifiedEmail()) {
            return redirect()->intended(config('fortify.home')). '?verfied=1';
        }
        if($user->markEmailAsVerifed()) {
            event(new Verified($user));
        }
        $message = __('Your email has been verified');

        return redirect('login')->with('status',$message);
    }
}
