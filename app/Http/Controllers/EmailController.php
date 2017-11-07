<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    public function verify($token){
        $user = User::where('confirmation_token',$token)->first();

        if (is_null($user)){
            flash('邮箱验证失败')->danger();
            return redirect('/');
        }

        $user->is_active = 1;
        $user->confirmation_token = str_random(40);
        $user->save();
        Auth::login($user);
        flash('邮箱验证成功')->success();
        return redirect('/home');

        // 当你的route带有{param}的时候的话，当你使用route()的时候就会报错，你要将{param}这个参数写入route中
//        echo route('verify',$token);
    }
}
