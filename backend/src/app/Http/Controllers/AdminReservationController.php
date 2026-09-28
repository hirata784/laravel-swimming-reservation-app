<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSlot;
use App\Models\Reservation;

class AdminReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::all();
        $timeSlots = TimeSlot::all();

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
