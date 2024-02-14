<?php


namespace App\Wallet;


use Carbon\Carbon;

class DateConverterHelper
{
    public static function convertToYMD($date)
    {
        return date('Y-m-d', strtotime(str_replace(',', ' ', $date))) ?? null;
    }

    public static function convertToYMDWithTime($date)
    {
        return date('Y-m-d H:i', strtotime(str_replace(',', ' ', $date))) ?? null;
    }

    public static function convertToYMDRange($date)
    {

        try {
            $date = explode(' - ', $date);
            $convertedFrom = Carbon::parse($date[0]);
            $convertedTo = Carbon::parse($date[1]);
            return [
                'from' => date($convertedFrom->format('Y-m-d')) ?? null,
                'to' => date($convertedTo->format('Y-m-d')) ?? null
            ];
        } catch (\Exception $e) {
            dd('Invalid date format');
        }
    }

}
