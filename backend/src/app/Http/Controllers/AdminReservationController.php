<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TimeSlot;
use App\Models\Reservation;
use App\Models\User;
use App\Models\RewardTicket;
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
        $reservations = Reservation::all();
        // 現在時刻から15分前を取得（判定基準となる日時）
        $threshold = Carbon::now()->subMinutes(15);
        // 年月日を取得
        $targetDate = $threshold->toDateString();
        // 時刻を取得
        $targetTime = $threshold->format('H:i');

        // 指定した日時以前のデータをすべて取得（指定日を含まない）
        $past = TimeSlot::where('date', '<', $targetDate)->get();
        // 当日かつ現在時刻から15分前を取得
        $fifteenMinutesAgo =  TimeSlot::where('date', '=', $targetDate)->where('start_time', '<=', $targetTime)->get();
        // merge()で1つに合体し、idのみ抽出
        $target = $past->merge($fifteenMinutesAgo)->pluck('id');
        // 変更内容を取得
        $update = [
            'status' => "no_show",
        ];
        // 過去日時で利用状況がreserved(利用前)になっている場合、no_show(来店なし)に変更
        foreach ($reservations as $reservation) {
            // 利用状況がreservedのとき処理
            if ($reservation->status === "reserved") {
                // $targetにtime_slot_idが含まれているとき処理
                if ($target->contains($reservation->time_slot_id)) {
                    $reservation->update($update);
                }
            }
        }
        // 利用状況更新後の予約データを再取得
        $reservations = Reservation::all();

        // パスの年月日を初日に設定
        $firstDate = $request->firstDate;
        // 一週間後を最終日に設定
        $lastDate = Carbon::parse($firstDate)->addDays(6)->toDateString();

        // 指定した日から一週間分のデータを取得
        $timeSlots = TimeSlot::whereBetween('date', [$firstDate, $lastDate])->get();

        $item = [];
        // 全てのid, 日時, 予約人数, 定員を取得
        foreach ($timeSlots as $index => $timeSlot) {
            // id
            $item[$index]['id'] = $timeSlot->id;
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
        $reservation = Reservation::find($id);
        // 予約データが存在しない場合は処理しない
        if (!$reservation) {
            return response()->json([
                'message' => 'Not reservation'
            ], 404);
        }

        // 利用状況を変更するユーザーidを取得
        $user_id = $reservation->user_id;
        // 変更内容を取得
        $update = [
            'status' => $request->status
        ];
        // 変更前の利用状況を取得
        $beforeStatus = $reservation->status;
        // 利用状況を更新
        $reservation->update($update);
        // 更新したユーザーの「used」の合計数を取得
        $earned_at_uses = Reservation::where('user_id', $user_id)->where('status', '=', 'used')->count();
        // 「used」の合計数が、5で割り切れるかつ5以上
        if ($earned_at_uses % 5 === 0 && $earned_at_uses >= 5) {
            // かつ変更前の利用状況が「used」ではない
            if ($beforeStatus !== 'used') {
                // かつ$user_id(利用状況を変更したユーザー)の$earned_at_uses(特典獲得時の利用済み回数)がreward_ticketsテーブルにない
                $exist = RewardTicket::where('user_id', $user_id)->where('earned_at_uses', $earned_at_uses)->exists();
                if (!$exist) {
                    // 特典を追加
                    RewardTicket::create(
                        [
                            'user_id' => $user_id,
                            'earned_at_uses' => $earned_at_uses,
                        ]
                    );
                }
            }
        }
        return response()->json([
            'message' => 'Updated successfully',
        ], 200);
    }
}
