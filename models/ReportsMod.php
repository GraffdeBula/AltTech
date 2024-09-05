<?php
/**
 * Description of ReportsMod
 *
 * @author Andrey
 */
class ReportsMod extends Model {
    public function getContP1($DateF,$DateL){
        
        $Sql="SELECT tblClients.ClCode AS ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,FrOffice,FrPersManager,FrContDate,PAYDATE,FrContProg,FrContTarif,FrContSum,ExTotDebtSum,DiscountSum"
                . " FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1anketa.ClCode INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode"
                . " INNER JOIN tblP1Expert ON tblP1Anketa.ContCode=tblP1Expert.ContCode"
                . " INNER JOIN vwDiscountNewTotal ON tblP1Anketa.ContCode=vwDiscountNewTotal.ContCode"
                . " INNER JOIN CONTP1FIRSTPAY ON tblP1Anketa.ContCode=CONTP1FIRSTPAY.ContCode"
                . " WHERE FrContDate BETWEEN ? AND ?  ORDER BY FrContDate DESC";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL]);
    }
    
    public function getContP1Branch($DateF,$DateL,$Branch){
        
        $Sql="SELECT tblClients.ClCode AS ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,FrOffice,FrPersManager,FrContDate,PAYDATE,FrContProg,FrContTarif,FrContSum,ExTotDebtSum,DiscountSum"
                . " FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1anketa.ClCode INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode"
                . " INNER JOIN tblP1Expert ON tblP1Anketa.ContCode=tblP1Expert.ContCode"
                . " INNER JOIN vwDiscountNewTotal ON tblP1Anketa.ContCode=vwDiscountNewTotal.ContCode"
                . " INNER JOIN CONTP1FIRSTPAY ON tblP1Anketa.ContCode=CONTP1FIRSTPAY.ContCode"
                . " WHERE (FrContDate BETWEEN ? AND ?) AND  FROFFICE=?  ORDER BY FrContDate DESC";
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$Branch]);
    }
    
    public function getContExp($DateF,$DateL){
        $Sql="SELECT tblClients.ClCode AS ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,FrOffice,FrPersManager,"
            . " FrExpDate,PayDate,frExpSum,PaySum"
            . " FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1anketa.ClCode"
            . " INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode"
            . " INNER JOIN ExpP1FirstPay ON tblP1Anketa.ContCode=ExpP1FirstPay.ContCode"
            . " WHERE PayDate BETWEEN ? AND ? ORDER BY PayDate DESC";
        
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL]);
    }
    
    public function getContExpBranch($DateF,$DateL,$Branch){
        $Sql="SELECT tblClients.ClCode AS ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,FrOffice,FrPersManager,"
            . " FrExpDate,PayDate,frExpSum,PaySum"
            . " FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1anketa.ClCode"
            . " INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode"
            . " INNER JOIN ExpP1FirstPay ON tblP1Anketa.ContCode=ExpP1FirstPay.ContCode"
            . " WHERE (PayDate BETWEEN ? AND ?) AND  FROFFICE=? ORDER BY PayDate DESC";
        
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$Branch]);
    }
}
