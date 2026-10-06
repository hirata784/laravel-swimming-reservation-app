<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 検索ワード
        $search = $request->search;
        // ユーザー検索
        $users = User::where('name', 'LIKE', "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%")->get();
        $reservations = Reservation::all();

        $item = [];
        // 全てのid, 名前, メールアドレス, 予約数を取得
        foreach ($users as $index => $user) {
            // id
            $item[$index]['id'] = $user->id;
            // 名前
            $item[$index]['name'] = $user->name;
            // メールアドレス
            $item[$index]['email'] = $user->email;
            // 予約数
            $item[$index]['total_reservation'] = $reservations->where('user_id', $user->id)->count();
        }

        return response()->json([
            'data' => $item
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
