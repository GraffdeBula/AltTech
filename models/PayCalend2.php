<?php

/**
 * Description of PayCalend2
 *
 * @author Andrey
 */
class PayCalend2 {
    protected $Data=[];
    
    public function getData($ContCode){ //метод возвращает график платежей БФЛ
        return $this->Data=db::getInstance()->fetch_all("SELECT paySum,payDat FROM tblP2PayCalend WHERE payContCode={$ContCode} ORDER BY payNum");        
    }
    
    public function GetCalendZOK($ContCode){ //метод возвращает график платежей ЗОК
        return $this->Data=db::getInstance()->fetch_all("SELECT paySum,payDat FROM tblP1PayCalend WHERE payContCode={$ContCode} ORDER BY payNum");        
    }
}
