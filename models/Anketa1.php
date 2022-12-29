<?php

/**
 * модель получения данных из таблицы anketa1
 *
 * @author andrey
 */
class Anketa1 extends Model{
    public $ClCode;
    protected $Data=[];
    
    public function getAnketaByCode($contCode){ //метод возвращает строку из таблицы Clients
        return $this->Data=db::getInstance()->fetch_one("SELECT * FROM tblP1Anketa WHERE contCode='{$contCode}';");        
    }
}
