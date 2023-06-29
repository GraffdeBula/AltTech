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
        $Sql="SELECT * FROM tblP1Discounts WHERE ContCode=? ORDER BY ID DESC";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[$ContCode]);
    }

    public function delDiscount($Id){
        $Sql="DELETE FROM tblP1Discounts WHERE ID=?";                        
        db2::getInstance()->Query($Sql,[$Id]);
    }


}
    