<?php

namespace App\Traits;

trait CreateLoadTestFund{
    public function creatLoadTestFund($preTransaction,$user,$request,$currentBalance,$currentBonusBalance,$for_pre_transaction){
        $data = [
            'pre_transaction_id' => $preTransaction->pre_transaction_id,
            'admin_id' => auth()->user()->id,
            'user_id' => $user->id,
            'description' => $request['description'] ?? 'Refund for ' . $request->pre_transaction_id,
            'before_amount' => $currentBalance,
            'after_amount' => $currentBalance + ($request['amount'] * 100),
            //'after_amount' => $currentBalance + ($preTransaction->getOriginal('amount')),
            'before_bonus_balance' => $currentBonusBalance,
            'after_bonus_balance' => $currentBonusBalance + ($request['bonus_amount'] * 100),
            'self_pre_transaction_id' => $for_pre_transaction['pre_transaction_id'],
        ];
        return $data;
    }
}
