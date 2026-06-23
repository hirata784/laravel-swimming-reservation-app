<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;

class TimeSlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // time_slotsテーブルとreservationsテーブルの情報を一緒に取得(予約数がreservations_countとして追加される)
        $items = TimeSlot::withCount('reservations')->get()
            // フロント用にレスポンス形式を整形
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'date' => $item->date,
                    'start_time' => $item->start_time,
                    'capacity' => $item->capacity,
                    'reserved_count' => $item->reservations_count,  // 予約人数（reservationsテーブルの件数）
                    // 予約人数が定員未満なら予約可能（true）、満席ならfalse
                    'is_available' => $item->reservations_count < $item->capacity
                ];
            });

        return response()->json([
            'data' => $items
        ], 200);
    }
}
