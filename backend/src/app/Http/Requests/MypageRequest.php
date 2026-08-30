<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MypageRequest extends FormRequest
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
            'name' => ['required', 'max:20'],
            'email' => ['required', 'email', 'unique:users,email,' . auth()->user()->email . ',email'],
            'address' => ['nullable', 'max:255'],
            'phone' => [
                'nullable',
                // 0から始まる10桁または11桁の数字（ハイフンなし）
                'regex:/^0[0-9]{9,10}$/',
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.max' =>  '20文字以下で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式で入力してください',
            'email.unique' => 'そのアドレスは登録されています',
            'address.max' =>  '255文字以下で入力してください',
            'phone.regex' => '正しい電話番号（10桁または11桁）を入力してください。',
        ];
    }
}
