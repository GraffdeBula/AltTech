<?php

/**
 * модель для работы с таблицей Регионы (tblDrRegions)
 *
 * @author Andrey
 */
class ATDrPaymentMod extends Model{
    
    public function getPaymentList1(){
        $Sql='SELECT * FROM tbl5DRPayTypes WHERE PAYPROD IN (0,1) ORDER BY ID';        
        return $this->data=db2::getInstance()->FetchAll($Sql,[]);
    }
            
    public function getPaymentList2(){
        $Sql='SELECT * FROM tbl5DRPayTypes WHERE PAYPROD IN (0,2) ORDER BY ID';        
        return $this->data=db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function getPaymentList4(){
        $Sql='SELECT * FROM tbl5DRPayTypes WHERE PAYPROD IN (0,4) ORDER BY ID';        
        return $this->data=db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function getPaymentMethod(){
        $Sql='SELECT * FROM tbl5DRPayMethods';        
        return $this->data=db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function getPaymentType($TypeName){
        $Sql='SELECT * FROM tbl5DRPayTypes WHERE Name=?';                
        return $this->data=db2::getInstance()->FetchOne($Sql,[$TypeName]);
    }
}