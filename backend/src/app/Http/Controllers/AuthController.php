<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(RegisterRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Successfully user created']);
    }

    public function login(LoginRequest $request)
    {
        $token = $request->input('_api_token');

        /** @var User $user */
        $user = auth()->user();

        // リフレッシュトークンを作成
        $refreshToken = Str::random(60);
        $user->update([
            'refresh_token' => $refreshToken,
        ]);

        return response()->json([
            'access_token' => $token,
            'refresh_token' => $refreshToken,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }

    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function logout()
    {
        /** @var User $user */
        $user = auth()->user();

        // データベースのリフレッシュトークンを削除
        if ($user) {
            $user->update([
                'refresh_token' => null,
            ]);
        }

        Auth::guard('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(Request $request)
    {
        $refreshToken = $request->input('refresh_token');
        // データベースでリフレッシュトークンを検索
        $user = User::where('refresh_token', $refreshToken)->first();

        if (!$user) {
            return response()->json([
                'error' => 'Invalid refresh token'
            ], 401);
        }

        // 新しいaccess_tokenを発行
        $newAccessToken = auth()->login($user);

        return response()->json([
            'access_token' => $newAccessToken,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ]);
    }
}
