<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // 把login的方法重写了，这个方法是在AuthenticatesUsers里面  因为我们User表里面多了和is_active的验证 所以我们要重写这方法
    public function login(Request $request)
    {
        // 对验证的进行验证
        if (request('valid') !== session('validTag'))
        {
            flash('验证码不正确')->warning()->important();
            return redirect()->refresh()->withInput();
        }

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // 这里调用attemplogin方法，在里面验证相关的信息
        if ($this->attemptLogin($request)) {
            flash('欢迎回来!')->success()->important();
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        // 返回错误的信息
        return $this->sendFailedLoginResponse($request);
    }

    // attemptLogin()也进行了重写了
    protected function attemptLogin(Request $request)
    {
        // $credentials 也进行重写了
        $credentials = array_merge($this->credentials($request), ['is_active' => 1]);
        return $this->guard()->attempt(
           $credentials, $request->has('remember')
        );
    }

}
