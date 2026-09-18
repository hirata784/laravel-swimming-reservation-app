<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Support\Carbon;

class TimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 予約一覧に表示してる日付がtime_slotsテーブルに存在していない場合、データ追加
        for ($i = 0; $i < 7; $i++) {
            // 日付を取得
            $targetDate = Carbon::today()->addDays($i);
            // 日付が存在しているかチェック
            $exist = TimeSlot::whereDate('date',  $targetDate)->exists();
            // もし存在していなければデータ追加
            if (!$exist) {
                for ($j = 9; $j <= 18; $j++) {
                    TimeSlot::create([
                        'date' => $targetDate->toDateString(),
                        'start_time' => $j . ':00:00',
                        'capacity' => 7,
                    ]);
                    TimeSlot::create([
                        'date' => $targetDate->toDateString(),
                        'start_time' => $j . ':30:00',
                        'capacity' => 7,
                    ]);
                }
            }
        }

        // 全データ取得
        $items = TimeSlot::all();

        return response()->json([
            'data' => $items
        ], 200);
    }
}
