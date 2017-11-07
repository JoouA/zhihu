<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Auth;

class PasswordController extends Controller
{
    public function password()
    {
        return view('users.password');
    }

    public function update(PasswordRequest $request)
    {
        $email = request('email');

        $user =  User::where('email',$email)->first();
       /* $user->password = bcrypt(request('password'));
        $user->save();*/
        // 验证旧的密码是否正确
        if (Hash::check(request('oldPassword'),$user->password))
        {

            $user->password = bcrypt(request('password'));
            $user->save();
            Auth::login($user);
            flash('密码修改成功!')->success()->important();
            return redirect('/');
        }

        flash('密码修改失败!')->error()->important();
        return back();
    }
}
