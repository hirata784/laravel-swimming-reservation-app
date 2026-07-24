<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::all();
        // 各予約日と時間を取得
        foreach ($reservations as $index => $reservation) {
            $id =  $reservation->time_slot_id;
            $item['date'][$index] = TimeSlot::find($id)->date;
            $item['start_time'][$index] = TimeSlot::find($id)->start_time;
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
        // ユーザーidを取得
        $user_id = $request->user_id;
        // 予約枠idを検索してから取得
        $time_slot = TimeSlot::where('date', $request->date)->where('start_time', $request->start_time)->first();

        // 予約枠テーブルに存在しない日時の場合、新たにデータを追加する
        if ($time_slot === null) {
            TimeSlot::create(
                [
                    'date' => $request->date,
                    'start_time' => $request->start_time,
                ]
            );
            // データ追加後、改めて予約枠idを検索してから取得
            $time_slot = TimeSlot::where('date', $request->date)->where('start_time', $request->start_time)->first();
        }

        $time_slot_id = $time_slot->id;
        // 予約データを作成
        $item = Reservation::create(
            [
                'user_id' => $user_id,
                'time_slot_id' => $time_slot_id,
            ]
        );

        return response()->json([
            'data' => $item
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $item = Reservation::where('id', $reservation->id)->delete();
        if ($item) {
            return response()->json([
                'message' => 'Deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found',
            ], 404);
        }
    }
}
