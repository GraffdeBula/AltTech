<?php

/**
 * функеции для нестандартного вывода данных
 *
 * @author Andrey
 */
class PrintFunctions {
    public function CredList($ContCode){
        $List=(new CreditorsMod)->getBankList($ContCode);
        $CredList='';
        foreach($List as $Key => $Name){
            if ($Key==0){
                $CredList=$Name->CRNAME;
            } else {
                $CredList=$CredList.', '.$Name->CRNAME;
            }
        }
        return $CredList;
    }
    
    public function Discounts($Bookmark,$CredSum,$TrPac,$Period,$ContSum){
        $Tarif=(new Pacs)->getTarifByName($TrPac, $CredSum);
       
        $TarSums=(new Pacs)->getTarifByPeriod($Tarif->TRCOMMENT, $CredSum, $Period);
                
        $qryPeriod=3;
        if ($Bookmark=='DISCOUNT18'){$qryPeriod=18;}
        if ($Bookmark=='DISCOUNT12'){$qryPeriod=12;}
        if ($Bookmark=='DISCOUNT6'){$qryPeriod=6;}
        if ($Bookmark=='DISCOUNT3'){$qryPeriod=3;}
        if ($Bookmark=='DISCOUNT1'){$qryPeriod=1;}
        
        $TarSums=(new Pacs)->getTarifByPeriod($Tarif->TRCOMMENT, $CredSum, $qryPeriod);
        (new logger)->logToFile($Bookmark.$CredSum.$TrPac.$Period.$ContSum);
        if (isset($TarSums->TRSUMFIX)){
            $DISCSUM=$ContSum-$TarSums->TRSUMFIX;
            $TOTSUM=$TarSums->TRSUMFIX;
            
            if ($qryPeriod==1){
                $Discount="Стороны согласовали, что если Заказчик оплачивает всю стоимость услуг Исполнителя в течение 30 дней с момента подписания Договора, "
                    . "то Заказчику предоставляется скидка на услуги Исполнителя в размере {$DISCSUM} руб. от стоимости услуг Исполнителя, указанной в п. 4.1 "
                    . "настоящего Договора, в этом случае стоимость услуг Исполнителя с учётом скидки составит {$TOTSUM} руб";                
            } else {
                $Discount="Стороны согласовали, что если Заказчик оплачивает всю стоимость услуг Исполнителя в течение {$qryPeriod} месяцев с момента подписания Договора, "
                    . "то Заказчику предоставляется скидка на услуги Исполнителя в размере {$DISCSUM} руб. от стоимости услуг Исполнителя, указанной в п. 4.1 "
                    . "настоящего Договора, в этом случае стоимость услуг Исполнителя с учётом скидки составит {$TOTSUM} руб";            
            }
            
            (new logger)->logToFile($Discount);
            if ($qryPeriod<$Period){
                return $Discount;
            } else {
                return ' ';
            }
        } else return ' ';
    }
}

