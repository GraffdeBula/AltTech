<?php
/* модель для работы с договорами в кредит
 */
class P1ContCredMod extends Model{
    public $ContCode;
    protected $Data=[];

    public function getContCred($ContCode){
        $Sql="SELECT * FROM tblP1ContCredit WHERE ContCode=?";
        return db2::getInstance()->FetchOne($Sql,[$ContCode]);        
    }
    
    public function getPayList($ContCode){
        $Sql="SELECT * FROM tbl5Payments WHERE ContCode=? AND PayType=?";
        return db2::getInstance()->FetchAll($Sql,[$ContCode,5]);        
    }
    
    public function getPayCredList($ContCode){
        $Sql="SELECT * FROM tblP1ContCreditPays WHERE ContCode=? ORDER BY PayNum";
        return db2::getInstance()->FetchAll($Sql,[$ContCode]);        
    }
    
    public function insPayCred($ContCode,$PayNum,$PayDate,$PayDays,$DebtSum,$PaySum,$PercSum,$MainSum,$DebtAfterSum){
        $Sql="INSERT INTO tblP1ContCreditPays (ContCode,PayNum,PayDate,PayDays,DebtSum,PaySum,PercSum,MainSum,DebtAfterSum) VALUES (?,?,?,?,?,?,?,?,?)";
        db2::getInstance()->Query($Sql,[$ContCode,$PayNum,$PayDate,$PayDays,$DebtSum,$PaySum,$PercSum,$MainSum,$DebtAfterSum]);        
    }
    
    public function delPayCredList(){
        $Sql="DELETE FROM tblP1ContCreditPays";
        return db2::getInstance()->Query($Sql,[]);        
    }
        

}
    