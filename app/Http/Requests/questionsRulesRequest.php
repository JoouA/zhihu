<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class questionsRulesRequest extends FormRequest
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

    public function messages()
    {
        return [
            'title.required'  => '标题不能为空 ',
            'title.max' => '标题不能超过191个字符',
            'body.required' => '内容是必须的',
            'body.min' => '内容不能过短'
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:191',
            'body' => 'required|min:12',
        ];
    }
}
