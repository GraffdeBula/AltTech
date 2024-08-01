<?php

/**
 * функеции для нестандартного вывода данных
 *
 * @author Andrey
 */
class ConvertFunctions {       
    public function DateToStr($Date){
        return substr($Date,8,2).".".substr($Date,5,2).".".substr($Date,0,4);
    }
    
    public function AddMonth($Date){
        $NewDate=$Date;
        $PayMonth=substr($NewDate->format('d.m.Y'),3,2);
        if(substr($PayMonth,0,1)==0){
            $PayMonth=substr($PayMonth,1,1);
        } 

        $NewDate->modify("+1 month");

        $PayMonthNew=substr($NewDate->format('d.m.Y'),3,2);
        if(substr($PayMonthNew,0,1)==0){
            $PayMonthNew=substr($PayMonthNew,1,1);
        }

        while ($PayMonthNew-1>$PayMonth){
            $NewDate->modify("-1 day");
            $PayMonthNew=substr($NewDate->format('d.m.Y'),3,2);
            if(substr($PayMonthNew,0,1)==0){
                $PayMonthNew=substr($PayMonthNew,1,1);
            }
        }
        
        return $NewDate;
    }
    
}    