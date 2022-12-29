<?php

/**
 * модель получения данных из таблицы anketa1
 *
 * @author andrey
 */
class ATOldClientsMod extends Model{
    public $ClCode;
    protected $Data=[];
    
    public function SearchClient($ClFName,$Cl1Name,$Cl2Name){
        $sql="SELECT tblClients.ClCode AS ClCode,tblP1Anketa.ContCode As ContCode, ClFName||' '||Cl1Name||' '||Cl2Name AS ClName,tblP1Status.Status,exTotDebtSum FROM tblClients "
                . "INNER JOIN tblP1Anketa on tblClients.ClCode=tblP1Anketa.ClCode "
                . "INNER JOIN tblP1Expert on tblP1Expert.ContCode=tblP1Anketa.ContCode "
                . "INNER JOIN tblP1Status on tblP1Anketa.Status=tblP1Status.StatNum "
                . "WHERE ClFName=? AND Cl1Name=? AND Cl2Name=?";        
        return $this->Data=db::getInstance()->fetch_all2($sql,[$ClFName,$Cl1Name,$Cl2Name]);
    }
    
    public function UpdStatus($StatNum,$ContCode){
        $sql="UPDATE tblP1Anketa SET Status=? WHERE COntCode=?";
        db::getInstance()->query_update($sql,[$StatNum,$ContCode]);
    }
    
    public function UpdDebt($DebtSum,$ContCode){
        $sql="UPDATE tblP1Expert SET exTotDebtSum=? WHERE COntCode=?";
        db::getInstance()->query_update($sql,[$DebtSum,$ContCode]);
    }
            
            
            
}
