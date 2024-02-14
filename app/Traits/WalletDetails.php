<?php

namespace App\Traits;


use Illuminate\Support\Facades\Log;

/**
 * Relation for the user
 */
trait WalletDetails
{
    public function addBalance($userId, $amount)
    {
        return $this->where('user_id', $userId)->increment('balance', $amount);
    }

    public function subtractBalance($userId, $amount)
    {
        return $this->where('user_id', $userId)->decrement('balance', $amount);
    }

    public function addBonusBalance($userId, $amount)
    {
        Log::info("increment bonus balance", ["amount" => $amount]);
        return $this->where('user_id',$userId)->increment('bonus_balance', $amount);
    }

    public function subtractBonusBalance($userId, $amount)
    {
        Log::info("deduct bonus balance", ["amount" => $amount]);
        return $this->where('user_id', $userId)->decrement('bonus_balance', $amount);
    }
}
