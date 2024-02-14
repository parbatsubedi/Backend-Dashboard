<?php

namespace App\Traits;
use Fivedots\NepaliCalendar\Calendar;
use Fivedots\NepaliCalendar\NepaliDataProvider;
use mysql_xdevapi\Exception;

trait DateConverter
{

    public function ConvertNepaliDateFromRequest($requestData,$year,$month,$date){
        try {
            $date = $requestData[$year] . '-' . $requestData[$month] . '-' . $requestData[$date];    //converts date to yyyy-mm-dd format
            $dateAD = $this->NepaliToEnglish($date);
            return $dateAD['year'] . '-' . $dateAD['month'] . '-' . $dateAD['date'];  // returns date in yyyy-mm-dd format
        }
        catch (\Exception $e){
            return null;
        }
    }

    public function EnglishToNepali($date){
        try {
            $SplitDate = $this->SplitDate($date);
            $year = $SplitDate[0];
            $month = $SplitDate[1];
            $day = $SplitDate[2];
            $calendar = new Calendar(new NepaliDataProvider());
            $nepaliDate = $calendar->englishToNepali($year, $month,$day);
            return $nepaliDate;
        }catch (\Exception $e){
            return null;
        }

    }

    public function NepaliToEnglish($date){
        try {
            $SplitDate = $this->SplitDate($date);
            $year = $SplitDate[0];
            $month = $SplitDate[1];
            $day = $SplitDate[2];
            $calendar = new Calendar(new NepaliDataProvider());
            $nepaliDate = $calendar->nepaliToEnglish($year, $month,$day);
            return $nepaliDate;
        }catch (\Exception $e){
            return null;
        }

    }

    public function SplitDate($date){
        return preg_split("/[\s-]+/",$date,0);
    }


}
