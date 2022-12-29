<?php

class IskMod extends Model{
    protected $Data=[];
    
    public function getClient($clCode){ //метод возвращает строку из таблицы view VWIskClient
        return $this->Data=db::getInstance()->fetch_one("SELECT * FROM vwIskClient WHERE clCode='{$clCode}';");        
    }

    public function getContract($contCode){
        return $this->Data=db::getInstance()->fetch_one("SELECT *  FROM vwIskCont WHERE contCode='{$contCode}';");
    }
    
    public function getCourt($contCode){
        return $this->Data=db::getInstance()->fetch_one("SELECT *  FROM vwIskCourt WHERE contCode='{$contCode}';");
    }

    public function getNalog($contCode){
        return $this->Data=db::getInstance()->fetch_one("SELECT *  FROM vwIskNalog WHERE contCode='{$contCode}';");
    }
  
    public function getAU($contCode){
    	return $this->Data=db::getInstance()->fetch_one("SELECT *  FROM vwIskAU WHERE contCode='{$contCode}';");
    }

    public function getCreditors($contCode){
    	return $this->Data=db::getInstance()->fetch_all("SELECT *  FROM vwIskCreditors WHERE contCode='{$contCode}';");
    }
    
    public function getDocuments($contCode){
    	return $this->Data=db::getInstance()->fetch_all("SELECT *  FROM vwIskCredDocs WHERE contCode='{$contCode}';");
    }

    //получение таблицы соответствия
    public function getBookMarks1(){
    	return $this->Data=db::getInstance()->fetch_all("SELECT *  FROM tblPrintIsk ORDER BY bmName;");
    }        
    public function getBookMarks2(){
    	return $this->Data=db::getInstance()->fetch_all("SELECT *  FROM tblPrintIsk2 ORDER BY bmName;");
    }
    public function getBookMarks3(){
    	return $this->Data=db::getInstance()->fetch_all("SELECT *  FROM tblPrintIsk3 ORDER BY bmName;");
    }
    //сохранение инф по договору для иска
    public function UpdIskDat($params){
        $sql="UPDATE tblP2BackOf SET boIskSignedDat=? WHERE contCode=?;";
        db::getInstance()->query_update($sql,$params); //params - массив параметров
    }
}
