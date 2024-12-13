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
    ##отчёт по первым платежам
    public function getContNewPays($DateF,$DateL){
        $Sql="SELECT tblClients.ClCode AS ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,FrOffice,FrPersManager,"
            . " FrContDate,PayDate,PaySum"
            . " FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1anketa.ClCode"
            . " INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode"
            . " INNER JOIN tblp1PayCalend ON tblP1Anketa.ContCode=tblp1PayCalend.ContCode"
            . " WHERE PayNum=1 AND (PayDate BETWEEN ? AND ?)  AND (tblP1Anketa.status between 15 AND 80) ORDER BY PayDate DESC";
        
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL]);
    }
    
    public function getContNewPaysBranch($DateF,$DateL,$Branch){
        $Sql="SELECT tblClients.ClCode AS ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,FrOffice,FrPersManager,"
            . " FrContDate,PayDate,PaySum"
            . " FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1anketa.ClCode"
            . " INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode"
            . " INNER JOIN tblp1PayCalend ON tblP1Anketa.ContCode=tblp1PayCalend.ContCode"
            . " WHERE PayNum=1 AND (PayDate BETWEEN ? AND ?) AND  FROFFICE=? AND (tblP1Anketa.status between 15 AND 80) ORDER BY PayDate DESC";
        
        return db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$Branch]);
    }
    ##отчёт по действующей базе
       
    public function getCurrentBaseBranch($Branch){
        $Sql="SELECT tblClients.ClCode AS ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,FrOffice,FrPersManager,"
            . " FrContDate,frContTarif,frContSum,tblp1Status.status as Status "
            . " FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1anketa.ClCode"
            . " INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode"
            . " INNER JOIN tblp1Status ON tblP1Anketa.Status=tblp1Status.Statnum"
            . " WHERE (tblP1Anketa.status BETWEEN 15 AND 90) AND  FROFFICE=? ORDER BY frContDate DESC";
        
        return db2::getInstance()->FetchAll($Sql,[$Branch]);
    }
    ##плановые платежи по действующей базе
     public function getPaysByBranch($Branch,$DateF,$DateL){
        $Sql="SELECT tblClients.ClCode,tblp1Anketa.ContCode,ClFIO,FrContDate,FrContProg,FrContTarif,FrContSum,PaySum,PayDate,frOffice,PayLastDate,PayTotSum,DiscSum"
                ." FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblp1Anketa.ClCode"
                ." INNER JOIN tblP1Front ON tblp1Anketa.ContCode=tblP1Front.ContCode"
                ." INNER JOIN tblP1PayCalend on tblp1Anketa.ContCode=tblP1PayCalend.ContCode"
                ." INNER JOIN VWCONTP1TOTALPAY on tblp1Anketa.ContCode=VWCONTP1TOTALPAY.ContCode"
                ." INNER JOIN vwDiscountTotal on tblp1Anketa.ContCode=vwDiscountTotal.ContCode"
                ." WHERE FrOffice=? AND (PayDate BETWEEN ? AND ?) AND (Status BETWEEN 15 AND 80) AND (PayTotSum+DiscSum)<FrContSum AND FrContDate<? AND PayNum>1"
                ." AND frContPac NOT IN ('pac24','pac33','pac38','pac39','pac40','pac57') AND FrContTarif NOT LIKE ? ORDER BY PayDate";                
        #new MyCheck($Sql,0);    
        return db2::getInstance()->FetchAll($Sql,[$Branch,$DateF,$DateL,$DateF,"%сразу%"]);
    }
    
    public function getPaysByBranchCred($Branch,$DateF,$DateL){
        $Sql="SELECT tblClients.ClCode,tblp1Anketa.ContCode,ClFIO,FrContDate,FrContProg,FrContTarif,FrContSum,PaySum,PayDate,frOffice,PayLastDate,PayTotSum,DiscSum"
                ." FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblp1Anketa.ClCode"
                ." INNER JOIN tblP1Front ON tblp1Anketa.ContCode=tblP1Front.ContCode"
                ." INNER JOIN tblP1PayCalend on tblp1Anketa.ContCode=tblP1PayCalend.ContCode"
                ." INNER JOIN VWCONTP1TOTALPAY on tblp1Anketa.ContCode=VWCONTP1TOTALPAY.ContCode"
                ." INNER JOIN vwDiscountTotal on tblp1Anketa.ContCode=vwDiscountTotal.ContCode"
                ." WHERE FrOffice=? AND (PayDate BETWEEN ? AND ?) AND (Status BETWEEN 15 AND 80) AND FrContDate<?"
                ." AND frContPac IN ('pac24','pac33','pac38','pac39','pac40','pac57') ORDER BY ClFIO ";
        return db2::getInstance()->FetchAll($Sql,[$Branch,$DateF,$DateL,$DateF]);
    }
    ## действующая база юрстадия
    public function getCurrentBaseJurBranch($Branch){
        $Sql="SELECT tblClients.ClCode AS ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,FrOffice,FrPersManager,"
            . " FrContDate,frContTarif,frContSum,tblp1Status.status as Status,"
            . " BoJurName,BoCourtFileNum,BoArbUprName,BoIskDate,BoIskSentDate,BoProcRestDate,BoProcRestFinDate,"
            . " BoProcRealDate,BoProcRealFinDate,BoBankrMirDate,BoBankrFinDate"                
            . " FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1anketa.ClCode"
            . " INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode"
            . " INNER JOIN tblP1BackOf ON tblP1Anketa.ContCode=tblP1Front.ContCode"
            . " INNER JOIN tblp1Status ON tblP1Anketa.Status=tblp1Status.Statnum"
            . " WHERE (tblP1Anketa.status BETWEEN 15 AND 90) AND  FROFFICE=? ORDER BY frContDate DESC";
        
        return db2::getInstance()->FetchAll($Sql,[$Branch]);
    }
    
    ##отчёт по должникам
    
    ##отчёт по экспертизам
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
