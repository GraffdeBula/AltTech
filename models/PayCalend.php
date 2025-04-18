<?php

/**
 * Description of PayCalend2
 *
 * @author Andrey
 */
class PayCalend{
    protected $Data=[];
    
    public function getPayCalend($ContCode){ //метод возвращает график платежей БФЛ
        return $this->Data=db2::getInstance()->FetchAll("SELECT * FROM tblP1PayCalend WHERE ContCode={$ContCode} ORDER BY PayNum,PayDate");        
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
    
    public function updPlanPay($PayNum,$PayDate,$PaySum,$ContCode,$ID){
        $Sql="UPDATE tblP1PayCalend SET PayNum=?,PayDate=?,PaySum=? WHERE ContCode=? AND ID=?";
        $Params=[$PayNum,$PayDate,$PaySum,$ContCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function delAllPlanPays($ContCode){
        $Sql="DELETE FROM tblP1PayCalend WHERE ContCode=?";
        $Params=[$ContCode];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function getPayCalendP4($ContCode){ //метод возвращает график платежей по РУ
        return $this->Data=db2::getInstance()->FetchAll("SELECT * FROM tblP4PayCalend WHERE ContCode={$ContCode} ORDER BY PayNum,PayDate");        
    }
    
    public function addPlanPayP4($ContCode,$PayNum,$PayDate,$PaySum){
        $Sql="INSERT INTO tblP4PayCalend (ContCode,PayNum,PayDate,PaySum) VALUES (?,?,?,?)";
        $Params=[$ContCode,$PayNum,$PayDate,$PaySum];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function delPlanPayP4($ContCode,$ID){
        $Sql="DELETE FROM tblP4PayCalend WHERE ContCode=? AND ID=?";
        $Params=[$ContCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    
}
