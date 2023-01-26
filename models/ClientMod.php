<?php

class ClientMod extends Model{
    protected $clCode=10000;
    protected $name='Ivan Ivanov';
    protected $Data=[];
    
    public function getClientById($clCode){ //метод возвращает строку из таблицы Clients
        return $this->Data=db::getInstance()->fetch_one("SELECT * FROM tblClients WHERE clCode='{$clCode}';");        
    }
    
    public function getClientList(){
        return $this->Data=db::getInstance()->fetch_all("SELECT FIRST 50 * FROM tblClients INNER JOIN tblP1Anketa ON tblClients.clCode=tblP1Anketa.clCode;");
    }
}
