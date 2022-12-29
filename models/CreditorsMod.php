<?php

class CreditorsMod extends Model{
    protected $Data=[];
    
    public function getCredList($contCode){ //метод возвращает список кредитов
        return $this->Data=db::getInstance()->fetch_all("SELECT * FROM vwIskCreditors WHERE contCode={$contCode};");        
    }
    
    public function getCredListFilt($contCode,$bnName){ //метод возвращает список кредитов
        return $this->Data=db::getInstance()->fetch_all2("SELECT * FROM vwIskCreditors WHERE contCode=? and crName=?;",[$contCode,$bnName]);        
    }

    public function updCredit($params){
        $sql="UPDATE tblP1Credits SET CRBANKCUR=?,CRBNCURINN=?,
            CRDEBTSUM=?,CRDEBTDELAYSUM=?,CRDEBTFEESUM=?
            WHERE crCode=?;";
        db::getInstance()->query_update($sql,$params); //params - массив параметров
    }
    
    public function UpdCredSum($contCode){ //метод считает сумму долга по всем кредитам и сохраняет в tblP2BackOf               
        $CrSum=db::getInstance()->fetch_one("SELECT SUM(crDebtSum) AS Sum1, SUM(crDebtDelaySum) AS Sum2, SUM(crDebtFeeSum) AS Sum3 FROM tblP1Credits WHERE contCode={$contCode};");        
        
        $sql="UPDATE tblP2BackOf SET boDebtSum=?,boDebtDelaySum=?,boDebtFeeSum=? WHERE ContCode=?";
        $params=[$CrSum->SUM1,$CrSum->SUM2,$CrSum->SUM3,$contCode];
        db::getInstance()->query_update($sql,$params); //params - массив параметров
    }
    
    public function getBankList($contCode){
        return $this->Data=db::getInstance()->fetch_all("SELECT crName FROM vwIskCreditors WHERE contCode={$contCode} GROUP BY crName;");
    }
     
}
