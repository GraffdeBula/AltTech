<?php

class Contract extends Model{
    public function get_frontp1p2($contCode){ //метод возвращает строку из таблицы Clients
        return $this->Data=db::getInstance()->fetch_one("SELECT * FROM tblP1P2Front WHERE contCode={$contCode}");        
    }
    
    public function get_frontp1($contCode){ //метод возвращает строку из таблицы p1front (старая таблица)
        return $this->Data=db::getInstance()->fetch_one("SELECT * FROM tblP1P2Front WHERE contCode={$contCode}");
    }
    
    public function getFrontPN1($contCode){ //метод возвращает строку из таблицы pn1front (старая таблица)
        return $this->Data=db::getInstance()->fetch_one("SELECT * FROM tblPN1Front WHERE contCode='{$contCode}'");
    }
    
    public function getPayCalend2($ContCode){ //метод возвращает строку из таблицы Clients
        return $this->Data=db::getInstance()->fetch_all("SELECT paySum,payDat FROM tblP2PayCalend WHERE payContCode={$ContCode} ORDER BY payNum");        
    }
    
    public function getPayCalend1($ContCode){ //метод возвращает строку из таблицы Clients
        return $this->Data=db::getInstance()->fetch_all("SELECT paySum,payDat FROM tblP1PayCalend WHERE payContCode={$ContCode} ORDER BY payNum");        
    }
    
    public function getCredList($ContCode){ //метод возвращает строку из таблицы Clients
        return $this->Data=db::getInstance()->fetch_all("SELECT * FROM vwContCredList WHERE ContCode={$ContCode}");        
    }
    
    public function getDocList($ContCode){ //метод возвращает строку из таблицы Clients
        return $this->Data=db::getInstance()->fetch_all("SELECT * FROM vwContDocList WHERE ContCode={$ContCode}");        
    }
}
