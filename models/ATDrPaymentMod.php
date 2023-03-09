<?php

/**
 * модель для работы с таблицей Регионы (tblDrRegions)
 *
 * @author Andrey
 */
class ATDrPaymentMod extends Model{
    
    public function getPaymentList1(){
        $Sql='SELECT * FROM tbl5DRPayTypes ORDER BY ID';        
        return $this->data=db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function getPaymentList2(){
        $Sql="SELECT * FROM tbl5DRPayRepTypes ORDER BY ID";
        return $this->data=db2::getInstance()->FetchAll($Sql,[]);
    }
    
}