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
            'currentPassword' => ['required', 'current_password'],
            'newPassword' => ['required', 'min:6'],
            'confirmPassword' => ['required', 'same:newPassword'],
        ];
    }

    public function messages()
    {
        return [
            'currentPassword.required' => '現在のパスワードを入力してください',
            'currentPassword.current_password' => '現在のパスワードが正しくありません',
            'newPassword.required' => '新しいパスワードを入力してください',
            'newPassword.min' =>  '6文字以上で入力してください',
            'confirmPassword.required' => '新しいパスワード(確認)を入力してください',
            'confirmPassword.same' => 'パスワードが一致しません',
        ];
    }
}
