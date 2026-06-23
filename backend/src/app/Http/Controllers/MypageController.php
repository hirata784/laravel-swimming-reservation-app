<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 認証中のユーザーidを取得
        $id = Auth::id();
        $item = Reservation::where('user_id', $id)->get();
        return response()->json([
            'data' => $item
        ], 200);
    }
}
