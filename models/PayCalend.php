<?php

/**
 * Description of PayCalend2
 *
 * @author Andrey
 */
class PayCalend{
    protected $Data=[];
    
    public function getPayCalend($ContCode){ //метод возвращает график платежей БФЛ
        return $this->Data=db2::getInstance()->FetchAll("SELECT * FROM tblP1PayCalend WHERE ContCode={$ContCode} ORDER BY ID");        
    }
    
    public function addPlanPay($ContCode,$PayNum,$PaySum,$PayDate){
        $Sql="INSERT INTO tblP1PayCalend (ContCode,PayNum,PaySum,PayDate) VALUES (?,?,?,?)";
        $Params=[$ContCode,$PayNum,$PaySum,$PayDate];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function delPlanPay($ContCode,$ID){
        $Sql="DELETE FROM tblP1PayCalend WHERE ContCode=? AND ID=?";
        $Params=[$ContCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function delAllPlanPays($ContCode){
        $Sql="DELETE FROM tblP1PayCalend WHERE ContCode=?";
        $Params=[$ContCode];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    
}
