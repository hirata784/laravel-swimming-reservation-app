<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\MypageRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(ProfileRequest $request)
    {
        // 認証中のユーザーidを取得
        $user_id = Auth::id();
        // 変更内容を取得
        $store = [
            'gender' => $request->gender,
            'address' => $request->address,
            'phone' => $request->phone
        ];
        // ユーザーの情報を更新
        User::where('id', $user_id)->update($store);
        return response()->json([
            'message' => 'Updated successfully',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(MypageRequest $request)
    {
        // 認証中のユーザーidを取得
        $user_id = Auth::id();
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
