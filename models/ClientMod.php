<?php

class ClientMod extends Model{
    protected $clCode=10000;
    protected $name='Ivan Ivanov';
    protected $Data=[];
    
    public function getClientById($clCode){ //метод возвращает строку из таблицы Clients
        return $this->Data=db::getInstance()->fetch_one("SELECT * FROM tblClients WHERE clCode='{$clCode}';");        
    }
    
    public function getClProperty($ClCode){ //метод возвращает строку из таблицы СОБСТВЕННОСТЬ КЛИЕНТА
        return $this->Data=db::getInstance()->fetch_one2("SELECT * FROM tblClProperty WHERE clpCode=?;",[$ClCode]);        
    }
    
    public function getPartProperty($ClCode){ //метод возвращает строку из таблицы СОБСТВЕННОСТЬ СУПРУГА
        return $this->Data=db::getInstance()->fetch_one2("SELECT * FROM tblClPartnerProperty WHERE clpCode=?;",[$ClCode]);        
    }
    
    public function getClientList(){
        return $this->Data=db::getInstance()->fetch_all("SELECT FIRST 50 * FROM tblClients INNER JOIN tblP1Anketa ON tblClients.clCode=tblP1Anketa.clCode;");
    }
}
