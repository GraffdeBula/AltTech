<?php
/**
 * Description of ReportsMod
 *
 * @author Andrey
 */
class ReportsMod extends Model {
    public function getContP1(){
        
        $Sql="SELECT tblClients.ClCode AS ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,FrOffice,FrPersManager,FrContDate,PayLastDate as PayDate,FrContProg,FrContTarif,FrContSum,ExTotDebtSum,DiscountSum"
                . " FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1anketa.ClCode INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode"
                . " INNER JOIN tblP1Expert ON tblP1Anketa.ContCode=tblP1Expert.ContCode"
                . " INNER JOIN vwDiscountNewTotal ON tblP1Anketa.ContCode=vwDiscountNewTotal.ContCode"
                . " INNER JOIN VWCONTP1TOTALPAY ON tblP1Anketa.ContCode=VWCONTP1TOTALPAY.ContCode"
                . " WHERE FrContDate>=? ORDER BY FrContDate DESC";
        return db2::getInstance()->FetchAll($Sql,['01.03.2023']);
    }
    
    public function getContExp(){
        $Sql="SELECT FIRST 150 tblClients.ClCode AS ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,FrOffice,FrPersManager,"
            . " FrExpDate,PayDate,frExpSum,PaySum"
            . " FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1anketa.ClCode"
            . " INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode"
            . " INNER JOIN ExpP1FirstPay ON tblP1Anketa.ContCode=ExpP1FirstPay.ContCode"
            . " WHERE PayDate>=? ORDER BY PayDate DESC";
        
        return db2::getInstance()->FetchAll($Sql,['01.03.2023']);
    }
}
