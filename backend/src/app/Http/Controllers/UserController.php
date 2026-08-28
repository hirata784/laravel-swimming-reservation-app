<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // ユーザーidを取得
        $user_id = $request->user_id;
        // 変更内容を取得
        $update = [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone
        ];
        // ユーザーの情報を更新
        User::where('id', $user_id)->update($update);

        return response()->json([
            'message' => 'Updated successfully',
        ], 200);
    }
}
