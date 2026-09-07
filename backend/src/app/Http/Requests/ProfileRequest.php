<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'address.max' =>  '255文字以下で入力してください',
            'phone.regex' => '正しい電話番号（10桁または11桁）を入力してください',
        ];
    }
}
