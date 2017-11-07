<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255',
            'oldPassword' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => '邮箱是必须的',
            'oldPassword.required' => '旧密码是必须的',
            'oldPassword.min' => '密码长度不能低于6位',
            'password.required' => '密码是必须的',
            'password.min' => '密码不能低于6位',
            'password.confirm' => '两次密码需要一致'
        ];
    }
}
