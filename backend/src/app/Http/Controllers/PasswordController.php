<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\PasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(PasswordRequest $request)
    {
        // 認証中のユーザーidを取得
        $user_id = Auth::id();

        // 変更内容を取得
        $update = [
            'password' => Hash::make($request->newPassword),
        ];
        // パスワードを更新
        User::where('id', $user_id)->update($update);

        return response()->json([
            'message' => 'Updated successfully',
        ], 200);
    }
}
