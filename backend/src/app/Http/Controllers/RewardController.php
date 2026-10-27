<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\RewardTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function count()
    {
        // 認証中のユーザーidを取得
        $user_id = Auth::id();
        // 本日日付
        $targetDate = Carbon::now()->toDateString();
        // 現在時刻
        $targetTime = Carbon::now()->format('H:i');

        // 累計利用回数
        // reservationsとtime_slotsテーブルを結合
        $item['used_sum'] = Reservation::join('time_slots', 'reservations.time_slot_id', '=', 'time_slots.id')
            // ログインユーザー
            ->where('reservations.user_id', $user_id)
            ->where(function ($query) use ($targetDate, $targetTime) {
                // 予約日が今日より前
                $query->whereDate('time_slots.date', '<', $targetDate)
                    ->orWhere(function ($query) use ($targetDate, $targetTime) {
                        // 予約日が今日
                        $query->whereDate('time_slots.date', $targetDate)
                            // 開始時刻が現在時刻より前
                            ->whereTime('time_slots.start_time', '<', $targetTime);
                    });
            })->count();

        // 特典所持数
        $item['ticket'] = RewardTicket::where('user_id', $user_id)->whereNull('used_at')->count();

        return response()->json([
            'data' => $item
        ], 200);
    }
}
