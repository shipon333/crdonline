<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\UserCode;
use App\Notifications\SendEmailNotification;
use App\Notifications\TwoFANotification;
use App\Providers\RouteServiceProvider;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        if($request->session()->regenerate()){
            $this->generateCode();
//            echo 'ok';
//            die;
//            return redirect()->intended(RouteServiceProvider::HOME);
            return redirect()->route('two-step-verification.index');
        }
        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
    }

    public function generateCode()
    {
        $code = rand(1000, 9999);

        $f_code = new UserCode();
        $f_code->user_id = auth()->user()->id ;
        $f_code->code = $code ;
        $f_code->save();

        $email = auth()->user()->email;
        $message = "Two Face Authentication login code is ". $code;

        try {
            $user = auth()->user();
            Notification::send($user, new TwoFANotification($message));
        } catch (Exception $e) {
            info("Error: ". $e->getMessage());
        }
    }
    public function resend()
    {
        $this->generateCode();

        return back()->with('success', 'We sent you code on your email.');
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
