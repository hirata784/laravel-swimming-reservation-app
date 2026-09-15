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
        // 全データ取得
        $items = TimeSlot::all();

        return response()->json([
            'data' => $items
        ], 200);
    }
}
