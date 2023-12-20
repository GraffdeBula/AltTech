<?php

/**
 * модель получения данных по договору БФЛ
 * Анкета
 * Фронт
 * Экспертиза
 *
 * @author andrey
 */
class ATP1ContMod extends Model{
    public $ClCode;
    protected $Data=[];
    
    public function GetP1ContList($ClCode){
        $Sql="SELECT * FROM vwP1ContList WHERE ClCode=?;";                
        $Params=[$ClCode];
        return $this->Data=db2::getInstance()->FetchAll($Sql,$Params);    
    }
    
    public function GetAnketa($ContCode){ //метод возвращает строку из таблицы p1Anketa
        $Sql="SELECT * FROM tblP1Anketa WHERE ContCode=?";
        $Params=[$ContCode];
        return $this->Data=db2::getInstance()->FetchOne($Sql,$Params);       
    }

    public function GetFront($ContCode){ //метод возвращает строку из таблицы p1Front
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblP1Front WHERE contCode='{$ContCode}';");        
    }

    public function GetExpert($ContCode){ //метод возвращает строку из таблицы p1Expert
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblP1Expert WHERE contCode='{$ContCode}';");        
    }
    
    public function GetBackOf($ContCode){ //метод возвращает строку из таблицы p1Expert
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblP1BackOf WHERE contCode='{$ContCode}';");        
    }
    
    public function GetCont($ContCode){ 
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM vwP1ContList WHERE contCode='{$ContCode}';");        
    }
    
    public function InsP1Anketa($ClCode,$Branch,$Emp){
        $Sql="INSERT INTO tblP1Anketa (ClCode,AkBranch,lgEmp) VALUES (?,?,?)";
        $Params=[$ClCode,$Branch,$Emp];
        db2::getInstance()->Query($Sql,$Params); 
    }
    
    public function CopyP1Anketa($ContCode,$LgEmp){
        $Sql="INSERT INTO tblP1Anketa (lgEmp,ClCode,AkDat,AkBranch,AkLeadId,AkCredNum,AkCredTotSum,AkCredMainSum,AkComment,Status,AkType)"
            . "SELECT ?,ClCode,current_date,AkBranch,AkLeadId,AkCredNum,AkCredTotSum,AkCredMainSum,AkComment,1,AkType FROM tblP1Anketa WHERE ContCode=?";
        $Params=[$LgEmp,$ContCode];
        db2::getInstance()->Query($Sql,$Params);        
    }
    
    public function GetLastAnketa($ClCode){ //метод возвращает строку из таблицы p1Anketa
        $Sql="SELECT FIRST 1 * FROM tblP1Anketa WHERE ClCode=? ORDER BY ContCode DESC";
        $Params=[$ClCode];
        return $this->Data=db2::getInstance()->FetchOne($Sql,$Params);       
    }
    
    public function UpdP1Anketa($Param=[],$ContCode){
        $Sql="UPDATE tblP1Anketa SET lgdat=current_timestamp";
        $Params=[];
        foreach($Param as $Key=>$Value){
            $Sql=$Sql.", {$Key}=?";
            $Params[]=$Value;
            
        }
        $Sql=$Sql." WHERE ContCode=?";
        $Params[]=$ContCode;
        db2::getInstance()->Query($Sql,$Params); 
    }

    public function UpdP1Status($StatNum,$ContCode){
        $Sql="UPDATE tblP1Anketa SET Status=? WHERE ContCode=?";
        db2::getInstance()->Query($Sql,[$StatNum,$ContCode]);
    }
    
    public function UpdP1Expert($Params=[]){
        $Sql="UPDATE tblP1Expert SET EXTOTDEBTSUM=?, EXMAINDEBTSUM=?, EXANNTOTPAY=?,EXANNTOTINC=?, EXPRODREC=?, EXRES=?  WHERE ContCode=?";
        db2::getInstance()->Query($Sql,$Params); 
    }
    public function UpdP1Expert1($Params=[]){
        $Sql="UPDATE tblP1Expert SET EXTOTDEBTSUM=?, EXMAINDEBTSUM=?,EXANNTOTPAY=? WHERE ContCode=?";
        db2::getInstance()->Query($Sql,$Params); 
    }
    
    public function UpdP1Front($Param=[],$ContCode){                        
        $Sql="UPDATE tblP1Front SET lgEmp='{$_SESSION['EmName']}', lgDat=current_timestamp";
        $Params=[];
        foreach($Param as $Key=>$Value){
            $Sql=$Sql.", {$Key}=?";
            $Params[]=$Value;
            
        }
        $Sql=$Sql." WHERE ContCode=?";
        $Params[]=$ContCode;
        
        return $this->Data=db2::getInstance()->Query($Sql,$Params);
    }
        
    public function DelP1Anketa($ContCode){
        $Sql="DELETE FROM tblP1Anketa WHERE contCode=?";
        $Params=[$ContCode];
        db2::getInstance()->Query($Sql,$Params);  
    }
    
    public function updP1Front1($Key=['lgDat','lgEmp','ContCode'],$Params=['current_timeset','admin',0]) {
        $i=0;
        $Sql="UPDATE tblP1Anketa SET ";
        $Len=count($Key);
        echo($Len."<br>===<br>");
        foreach($Key as $Field){
            if ($i<=$Len-3){
                $Sql=$Sql.$Field."=?,";
            } elseif ($i==$Len-2){
                $Sql=$Sql.$Field."=?";
            } else {
                $Sql=$Sql." WHERE ".$Field."=?";
            }            
            $i++;
        }
        var_dump($Sql);
        exit();
        db2::getInstance()->Query($Sql,$Params);  
        
    }
    
    public function updP1BackOf($Key=['lgDat','lgEmp','ContCode'],$Params=['current_timestamp','admin',0]) {
        $i=0;
        $Sql="UPDATE tblP1BackOf SET lgdat=current_timestamp,";
        $Len=count($Key);        
        foreach($Key as $Field){
            if ($i<=$Len-3){
                $Sql=$Sql.$Field."=?,";
            } elseif ($i==$Len-2){
                $Sql=$Sql.$Field."=?";
            } else {
                $Sql=$Sql." WHERE ".$Field."=?";
            }            
            $i++;
        }        
        db2::getInstance()->Query($Sql,$Params);  
        
    }
    /*методы для согласования скидок (P1)
     */
    public function getContApproveList(){
        $Sql="SELECT tblClients.ClCode,tblp1anketa.contcode,ClFIO,"
                . "frDiscSum,frDiscComment,frOffice "
                . "FROM tblClients INNER JOIN tblp1Anketa ON tblClients.ClCode=tblp1anketa.ClCode "
                . "INNER JOIN tblp1front ON tblp1anketa.contcode=tblp1front.contcode "
                . "WHERE frDiscApproveDate is null AND frDiscQueryDate is not null";
        
        return db2::getInstance()->FetchAll($Sql,[]);
    }
            
    /*методы для построения отчёта по Действующей базе (P1)
     * 
     */
    
    public function getPaysByBranch($Branch,$DateF,$DateL){
        $Sql="SELECT tblClients.ClCode,tblp1Anketa.ContCode,ClFIO,FrContDate,FrContProg,FrContTarif,FrContSum,PaySum,PayDate,frOffice,PayLastDate,PayTotSum,DiscSum"
                ." FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblp1Anketa.ClCode"
                ." INNER JOIN tblP1Front ON tblp1Anketa.ContCode=tblP1Front.ContCode"
                ." INNER JOIN tblP1PayCalend on tblp1Anketa.ContCode=tblP1PayCalend.ContCode"
                ." INNER JOIN VWCONTP1TOTALPAY on tblp1Anketa.ContCode=VWCONTP1TOTALPAY.ContCode"
                ." INNER JOIN vwDiscountTotal on tblp1Anketa.ContCode=vwDiscountTotal.ContCode"
                ." WHERE FrOffice=? AND (PayDate BETWEEN ? AND ?) AND Status<90 AND (PayTotSum+DiscSum)<FrContSum AND FrContDate<?"
                ." AND frContPac NOT IN ('pac24','pac33','pac38','pac39','pac40','pac57') AND FrContTarif NOT LIKE ? ORDER BY ClFIO";                
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
                ." WHERE FrOffice=? AND (PayDate BETWEEN ? AND ?) AND Status<90 AND FrContDate<?"
                ." AND frContPac IN ('pac24','pac33','pac38','pac39','pac40','pac57') ORDER BY ClFIO ";
        return db2::getInstance()->FetchAll($Sql,[$Branch,$DateF,$DateL,$DateF]);
    }
    
    
}
