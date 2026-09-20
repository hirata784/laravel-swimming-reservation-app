<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $item[$index]['user_id'] = $reservation->user_id;
            $item[$index]['date'] = TimeSlot::find($id)->date;
            $item[$index]['start_time'] = TimeSlot::find($id)->start_time;
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
        // 認証中のユーザーidを取得
        $user_id = Auth::id();
        // 予約枠idを検索してから取得
        $time_slot = TimeSlot::where('date', $request->date)->where('start_time', $request->start_time)->first();

        // 予約日時の不適切チェック
        // 1. 予約枠データの有無
        if ($time_slot === null) {
            return response()->json([
                'message' => 'invalid_slot'
            ], 404);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // 認証中のユーザーidを取得
        $user_id = Auth::id();
        // 予約枠idを検索してから取得
        $time_slot = TimeSlot::where('date', $request->date)->where('start_time', $request->start_time)->first();
        $time_slot_id = $time_slot->id;
        // 予約idを取得
        $reservation = Reservation::where('user_id', $user_id)->where('time_slot_id', $time_slot_id)->first();
        $reservation_id = $reservation->id;

        // 予約データを削除
        $item = Reservation::where('id', $reservation_id)->delete();

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
