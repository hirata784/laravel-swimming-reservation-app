<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use App\Models\TimeSlot;

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $reservations = Reservation::where('user_id', $id)->get();
        $timeSlots = TimeSlot::all();

        // 基本情報
        // id
        $item['user']['id'] = $id;
        // 名前
        $item['user']['name'] = $user->name;
        // メールアドレス
        $item['user']['email'] = $user->email;
        // 性別
        $item['user']['gender'] = $user->gender;
        // 電話番号
        $item['user']['phone'] = $user->phone;
        // 住所
        $item['user']['address'] = $user->address;
        // 登録日
        $item['user']['created_at'] = $user->created_at;

        // 利用状況
        // 予約回数
        $item['usage']['total_reservation'] = $reservations->count();
        // 利用済み
        $item['usage']['used'] = $reservations->where('status', 'used')->count();
        // 利用前
        $item['usage']['reserved'] = $reservations->where('status', 'reserved')->count();
        // 来店なし
        $item['usage']['no_show'] = $reservations->where('status', 'no_show')->count();

        // ユーザーが予約0の場合のエラー対策
        $item['reservations'] = [];
        // 予約履歴
        foreach ($reservations as $index => $reservation) {
            // 日付
            $item['reservations'][$index]['date'] =  $timeSlots->find($reservation->time_slot_id)->date;
            // 開始時間
            $item['reservations'][$index]['start_time'] =  $timeSlots->find($reservation->time_slot_id)->start_time;
            // ステータス
            $item['reservations'][$index]['status'] =  $reservation->status;
        }

        return response()->json([
            'data' => $item
        ], 200);
    }
}
