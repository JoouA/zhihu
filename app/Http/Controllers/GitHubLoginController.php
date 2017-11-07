<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Overtrue\Socialite\SocialiteManager;
use Auth;

class GitHubLoginController extends Controller
{

    // 实现github登录
    public function github()
    {

        $socialite = new SocialiteManager(config('services'));

        return  $socialite->driver('github')->redirect();

    }

    public function githubLogin()
    {
        $socialite = new SocialiteManager(config('services'));

        $user = $socialite->driver('github')->user();
//        dd($user);
        $githubinfo = [
            'name' => $user->getUsername()?$user->getUsername():$user->getNickname(),
            'email' => $user->getEmail(),
            'password' => bcrypt(str_random(16)),
            'avatar' => $user->getAvatar(),
            'confirmation_token' => str_random(40),
            'api_token' => str_random(60),
            'settings' => ['city' => ''],
        ];

        $email = $user->getEmail();
        $emails = User::all()->pluck('email')->toArray();


        if (in_array($email,$emails)){
            $us = User::all()->where('email',$email)->first();
            Auth::login($us);
        }else{
            $us = User::create($githubinfo);
            Auth::login($us);
            return redirect('fy');
        }


        return redirect('/');
    }
}
