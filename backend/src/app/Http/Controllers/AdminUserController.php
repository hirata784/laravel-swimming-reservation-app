<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use App\Models\TimeSlot;
use App\Models\RewardTicket;

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
        $users = User::where('name', 'LIKE', "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%")->paginate(7);
        $reservations = Reservation::all();

        $item = [];
        $item['user'] = [];
        // 全てのid, 名前, メールアドレス, 予約数を取得
        foreach ($users as $index => $user) {
            // id
            $item['user'][$index]['id'] = $user->id;
            // 名前
            $item['user'][$index]['name'] = $user->name;
            // メールアドレス
            $item['user'][$index]['email'] = $user->email;
            // 予約数
            $item['user'][$index]['total_reservation'] = $reservations->where('user_id', $user->id)->count();
        }

        // ユーザーの全体数を取得
        $item['total_user'] = User::count();

        return response()->json([
            'data' => $item,
            'meta' => [
                // 現在のページ番号
                'current_page' => $users->currentPage(),
                // 最後のページ番号
                'last_page' => $users->lastPage(),
                // 1ページあたりの件数
                'per_page' => $users->perPage(),
                // 検索条件に一致する会員の総件数
                'total' => $users->total(),
            ],
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
        // reservationsとtime_slotsテーブルを結合して、日時が早い順に並び替える
        $reservations = Reservation::join('time_slots', 'reservations.time_slot_id', '=', 'time_slots.id')
            ->where('reservations.user_id', $id)
            ->orderBy('time_slots.date', 'asc')
            ->orderBy('time_slots.start_time', 'asc')
            ->get();
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

        // 特典情報
        // 未使用特典
        $item['rewards'] = RewardTicket::where('user_id', $id)->whereNull('used_at')->count();

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
    public function showRewards($id)
    {
        $user = User::find($id);
        // 会員が存在しない場合は処理しない
        if (!$user) {
            return response()->json([
                'message' => 'Not user'
            ], 404);
        }

        // id
        $item['user']['id'] = $id;
        // 名前
        $item['user']['name'] = $user->name;
        // 未使用特典数
        $item['rewards'] = RewardTicket::where('user_id', $id)->whereNull('used_at')->count();

        return response()->json([
            'data' => $item
        ], 200);
    }
}
