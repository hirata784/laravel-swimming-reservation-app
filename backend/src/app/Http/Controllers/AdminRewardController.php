<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RewardTicket;
use App\Models\RewardItem;
use App\Models\RewardRedemption;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminRewardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reward_items = RewardItem::all();
        foreach ($reward_items as $index => $reward_item) {
            // id
            $item['items'][$index]['id'] = $reward_item->id;
            // 商品名
            $item['items'][$index]['name'] = $reward_item->name;
            // 商品の交換回数
            $item['items'][$index]['exchange_count'] = RewardRedemption::where('reward_item_id', $reward_item->id)->count();
        }
        // 登録商品数
        $item['registered_count'] = $reward_items->count();
        // 累計交換数
        $item['total_exchange_count'] = RewardRedemption::count();

        return response()->json([
            'data' => $item
        ], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function availableItems()
    {
        $reward_items = RewardItem::where('is_active', true)->get();

        $item = [];
        $item['items'] = [];
        foreach ($reward_items as $index => $reward_item) {
            // id
            $item['items'][$index]['id'] = $reward_item->id;
            // 商品名
            $item['items'][$index]['name'] = $reward_item->name;
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
    public function exchange(Request $request, $id)
    {
        $user_id = $id;
        // 未使用の特典を1枚取得する
        $ticket = RewardTicket::where('user_id', $user_id)
            ->whereNull('used_at')
            ->orderBy('earned_at_uses')
            ->first();

        // 未使用の特典がない場合は処理しない
        if (!$ticket) {
            return response()->json([
                'message' => 'Not ticket'
            ], 404);
        }

        // 交換する商品を確認する
        $item = RewardItem::find($request->item_id);

        // 交換する商品がない場合は処理しない
        if (!$item) {
            return response()->json([
                'message' => 'Not item'
            ], 404);
        }

        // すでに取り扱いが終了した商品の場合は処理しない
        if (!$item->is_active) {
            return response()->json([
                'message' => 'Not available'
            ], 404);
        }

        // トランザクションを開始する
        DB::transaction(function () use ($ticket, $item) {
            // 特典を使用済みに更新する
            RewardTicket::where('id', $ticket->id)->update([
                'used_at' => Carbon::now(),
            ]);

            // 交換履歴を登録する
            RewardRedemption::create([
                'reward_ticket_id' => $ticket->id,
                'reward_item_id' => $item->id,
            ]);
        });

        return response()->json([
            'message' => 'Updated successfully',
        ], 200);
    }
}
