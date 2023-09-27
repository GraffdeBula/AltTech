<?php
/**
 * Description of ReportsMod
 *
 * @author Andrey
 */
class ReportsMod extends Model {
    public function getContP1(){
        
        $Sql="SELECT FIRST 100 tblClients.ClCode AS ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,FrOffice,FrPersManager,FrContDate,FrContProg,FrContTarif,FrContSum,ExTotDebtSum,DiscountSum"
                . " FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1anketa.ClCode INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode"
                . " INNER JOIN tblP1Expert ON tblP1Anketa.ContCode=tblP1Expert.ContCode"
                . " INNER JOIN vwDiscountNewTotal ON tblP1Anketa.ContCode=vwDiscountNewTotal.ContCode"
                . " WHERE FrContDate>=? ORDER BY FrContDate DESC";
        return db2::getInstance()->FetchAll($Sql,['01.03.2023']);
    }

            
}
