<?php


class ReportExpFirstPay extends Model{
    protected $Data;    
    
    public function getRep($DateF,$DateL) {
        $Sql="SELECT tblP1Anketa.ContCode,tblClients.ClCode,clFio,frOffice,ExpP1FirstPay.PayDate FROM ExpP1FirstPay "
            ."INNER JOIN tblp1Anketa on ExpP1FirstPay.ContCode=tblP1Anketa.ContCode "
            . "INNER JOIN tblClients on tblP1Anketa.ClCode=tblClients.ClCode "    
            . "WHERE PayDate BETWEEN ? AND ?";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[$DateF,$DateL]); 
    }
             
}
