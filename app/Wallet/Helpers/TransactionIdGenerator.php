<?php

namespace App\Wallet\Helpers;

use App\Models\TransactionId;
use Illuminate\Support\Facades\Log;

class TransactionIdGenerator
{
    /**
     * Generate a numeric random digit
     *
     * @param integer $digits
     * @return int
     */
    public static function generate($digits = 19)
    {
        $transaction = new TransactionId();
        $number = "";
        for ($i = 0; $i < $digits; $i++) {
            $min = ($i == 0) ? 1 : 0;
            $number .= mt_rand($min, 9);
        }
        if ($transaction->createTransaction($number)) {
            return $number;
        }
        self::generate($digits);
    }

    /**
     * Generate alphanumeric random string
     *
     * @param integer $digits
     * @return string
     */
    public static function generateAlphaNumeric($digits = 7)
    {
        $transaction = new TransactionId();
        $value = [];
        $chars = explode(" ", "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z 0 1 2 3 4 5 6 7 8 9");
        $totalChars = count($chars) - 1;
        foreach (range(1, $digits) as $r) {
            array_push($value, $chars[floor(rand(0, $totalChars))]);
        }
        $transactionID = implode('', $value);

        if ($transaction->createTransaction($transactionID)) {
            return $transactionID;
        }
        self::generateAlphaNumeric($digits);
    }


    public static function generateBFIId($firstAlphabet = "BFI", $digits = 5){
        $transaction = new TransactionId();
        $BFIId = [];
        $chars = explode(" ","A B C D E F G H I J K L M N O P Q R S T U V W X Y Z 0 1 2 3 4 5 6 7 8 9");
        $totalNoChars = count($chars) - 1;
        foreach(range(0,$digits) as $r){
            array_push($BFIId,$chars[rand(0,$totalNoChars)]);
        }
        $bfiBackNumber = implode('',$BFIId);
        $bfiNumber = $firstAlphabet.$bfiBackNumber;

        $transactionId = $transaction->createTransaction($bfiNumber);
        Log::info($bfiNumber." has been saved as transaction_id in transaction_ids table in BFI database");
        if($transactionId){
            return $bfiNumber;
        }
        self::generateBFIId($digits);
    }

    public static function generateReferral($firstAlphabet = "D", $digits = 6)
    {
        $transaction = new TransactionId();
        $value = [];
        $chars = explode(" ", "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z");
        $totalChars = count($chars) - 1;
        $alpha = $chars[floor(rand(0, $totalChars))];

        $number = "";
        for ($i = 0; $i < $digits; $i++) {
            $min = ($i == 0) ? 1 : 0;
            $number .= mt_rand($min, 9);
        }

        $transactionID = $firstAlphabet.$alpha.$number;

        if ($transaction->createTransaction($transactionID)) {
            return $transactionID;
        }
        self::generateReferral($transactionID);
    }
}
