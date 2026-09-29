<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSlot;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;

class AdminReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // パスの年月日を初日に設定
        $firstDate = $request->firstDate;
        // 一週間後を最終日に設定
        $lastDate = Carbon::parse($firstDate)->addDays(6)->toDateString();

        $reservations = Reservation::all();
        // 指定した日から一週間分のデータを取得
        $timeSlots = TimeSlot::whereBetween('date', [$firstDate, $lastDate])->get();

        // 全ての日時, 予約人数, 定員を取得
        foreach ($timeSlots as $index => $timeSlot) {
            // 日にち
            $item[$index]['date'] = $timeSlot->date;
            // 時間
            $item[$index]['start_time'] = $timeSlot->start_time;
            // 予約人数
            $item[$index]['reserved_count'] = $reservations->where('time_slot_id', $timeSlot->id)->count();
            // 予約上限
            $item[$index]['capacity'] = $timeSlot->capacity;
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
        $reservations = Reservation::where('time_slot_id', $id)->get();
        $timeSlot = TimeSlot::find($id);

        // 日にち
        $item['date'] = $timeSlot->date;
        // 時間
        $item['start_time'] = $timeSlot->start_time;
        foreach ($reservations as $index => $reservation) {
            // ユーザー名
            $item['reservations'][$index]['name'] = User::find($reservation->user_id)->name;
            // 予約ID
            $item['reservations'][$index]['reservation_id'] = $reservation->id;
            // 利用状況
            $item['reservations'][$index]['status'] = $reservation->status;
        }

        return response()->json([
            'data' => $item
        ], 200);
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
