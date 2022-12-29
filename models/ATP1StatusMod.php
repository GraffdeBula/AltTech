<?php

/**
 * модель получения данных по договору БФЛ
 * Анкета
 * Фронт
 * Экспертиза
 *
 * @author andrey
 */
class ATP1StatusMod extends Model{
    public $ClCode;
    protected $Data=[];
    
    public function UpdP1Status($NewStatus,$ContCode){
        $Sql="UPDATE tblP1Anketa SET Status=? WHERE ContCode=?;";                        
        return $this->Data=db2::getInstance()->Query($Sql,[$NewStatus,$ContCode]);    
    }
        
}
