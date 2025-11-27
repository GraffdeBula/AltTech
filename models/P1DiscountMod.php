<?php
/* модель для работы со скидками
 */
class P1DiscountMod extends Model{
    public $ContCode;
    protected $Data=[];

    public function addDiscount($ContCode,$DsSum,$DsComment,$DsType,$LgEmp){
        $Sql="INSERT INTO tblP1Discounts (ContCode,DiscountSum,DiscountComment,DiscountType,lgEmp) VALUES (?,?,?,?,?)";        
        db2::getInstance()->Query($Sql,[$ContCode,$DsSum,$DsComment,$DsType,$LgEmp]);
    }
    
    public function getDiscount($ContCode){
        $Sql="SELECT * FROM tblP1Discounts WHERE ContCode=? AND DiscountSum>0 ORDER BY ID DESC";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[$ContCode]);
    }
    
    public function getDDiscount($ContCode){
        $Sql="SELECT Sum(DiscountSum) AS DiscountSum FROM tblP1Discounts WHERE ContCode=? AND DiscountType=?";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[$ContCode,'ДД']);
    }

    public function delDiscount($Id){
        $Sql="DELETE FROM tblP1Discounts WHERE ID=?";                        
        db2::getInstance()->Query($Sql,[$Id]);
    }
    
    public function delDiscountList($ContCode){
        $Sql="DELETE FROM tblP1Discounts WHERE ContCode=? AND DiscountSum>?";                        
        db2::getInstance()->Query($Sql,[$ContCode,0]);
    }
    
    public function delDiscountListFull($ContCode){
        $Sql="DELETE FROM tblP1Discounts WHERE ContCode=? ";                        
        db2::getInstance()->Query($Sql,[$ContCode]);
    }


}
    