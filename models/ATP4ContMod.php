<?php

/**
 * модель получения данных по договору БФЛ
 * Анкета
 * Фронт
 * Экспертиза
 *
 * @author andrey
 */
class ATP4ContMod extends Model{
    public $ClCode;
    protected $Data=[];
    
    public function GetContList($ClCode){
        $Sql="SELECT * FROM vwP4ContList WHERE ClCode=?;";                
        $Params=[$ClCode];
        return $this->Data=db2::getInstance()->FetchAll($Sql,$Params);    
    }
    
    public function getAnketaByCode($ContCode){ //метод возвращает строку из таблицы p4Anketa
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblP4Anketa WHERE contCode='{$ContCode}';");        
    }
    
    public function getFrontByCode($ContCode){ //метод возвращает строку из таблицы p4Front
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblP4Front WHERE ContCode='{$ContCode}';");        
    }
    
    public function getCont($ContCode){ 
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM vwP4ContList WHERE contCode='{$ContCode}';");        
    }
    
    public function InsP4Anketa($ClCode=0,$Branch='не указан',$Emp='не указан'){
        $Sql="INSERT INTO tblP4Anketa (ClCode,AkBranch,lgEmp) values (?,?,?)";
        $Params=[$ClCode,$Branch,$Emp];
        db2::getInstance()->Query($Sql,$Params); 
    }
    
    public function updP4Cons($FrOffice,$FrPersManager,$FrConsDate,$Emp,$ContCode){
        $Sql="UPDATE tblP4Front SET FrOffice=?,FrPersManager=?,FrConsDate=?,lgEmp=? WHERE ContCode=?";
        $Params=[$FrOffice,$FrPersManager,$FrConsDate,$Emp,$ContCode];
        db2::getInstance()->Query($Sql,$Params); 
    }
    
    public function updP4Cont($FrOffice,$FrPersManager,$FrContDate,$FrContSum,$Emp,$ContCode){
        $Sql="UPDATE tblP4Front SET FrOffice=?,FrPersManager=?,FrContDate=?,FrContSum=?,lgEmp=? WHERE ContCode=?";
        $Params=[$FrOffice,$FrPersManager,$FrContDate,$FrContSum,$Emp,$ContCode];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function updP4Dov($FrOffice,$FrPersManager,$FrDovDate,$Emp,$ContCode){
        $Sql="UPDATE tblP4Front SET FrOffice=?,FrPersManager=?,FrDovDate=?,lgEmp=? WHERE ContCode=?";
        $Params=[$FrOffice,$FrPersManager,$FrDovDate,$Emp,$ContCode];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function updP4Jurist($Jurist,$JurDovDate,$Emp,$ContCode){
        $Sql="UPDATE tblP4Front SET FrJurist=?,FrJurDovDate=?,lgEmp=? WHERE ContCode=?";
        $Params=[$Jurist,$JurDovDate,$Emp,$ContCode];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function updP4Office($FrOffice,$Emp,$ContCode){
        $Sql="UPDATE tblP4Front SET FrOffice=?,lgEmp=? WHERE ContCode=?";
        $Params=[$FrOffice,$Emp,$ContCode];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function updP4FinWork($Emp,$ContCode){
        $Sql="UPDATE tblP4Front SET FrArchDate=current_date,lgEmp=? WHERE ContCode=?";
        $Params=[$Emp,$ContCode];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function updP4FrontService($ContDate,$FrContService,$FrJurBranch,$FrAttrChannel,$FrContResult,$FrJurist,$FrFineWorkDate){
        $Sql="UPDATE tblP4Front SET FrContService=?,FrJurBranch=?,FrAttrChannel=?,FrContResult=?,FrJurist=?,FrFinWorkDate=? WHERE ContCode=?";
        $Params=[$FrContService,$FrJurBranch,$FrAttrChannel,$FrContResult,$FrJurist,$FrFineWorkDate,$ContDate];
        db2::getInstance()->Query($Sql,$Params); 
    }
    
    //Формирование отчёта по новой БД
    public function getP4RepNew($DateF,$DateL) {
        $Sql="SELECT tblClients.ClCode,tblP4Anketa.ContCode,ClFName||' '||cl1Name||' '||cl2Name AS ClName,frOffice,frPersManager,frContSum,frContDate,frJurist,frJurBranch,frContService,frContResult "
                . "FROM tblClients INNER JOIN tblP4Anketa ON tblClients.ClCode=tblP4Anketa.ClCode "
                . "INNER JOIN tblP4Front ON tblP4Anketa.ContCode=tblP4Front.ContCode WHERE frContDate BETWEEN ? and ? ORDER BY tblP4Anketa.ContCode";
        $Params=[$DateF,$DateL];  
        return db2::getInstance()->FetchAll($Sql,$Params); 
    }

    //Работа со старой БД 
    //Формирование отчёта
    public function GetP4Rep($DateF,$DateL) {
        $Sql="SELECT tblClients.ClCode,tblP4Anketa.ContCode,ClFName||' '||cl1Name||' '||cl2Name AS ClName,frContOffice,frContEmp,frContPay1Sum,frContDat,frJurist,frJurBranch,frContUsluga,frContResult "
                . "FROM tblClients INNER JOIN tblP4Anketa ON tblClients.ClCode=tblP4Anketa.ClCode "
                . "INNER JOIN tblP4Front ON tblP4Anketa.ContCode=tblP4Front.ContCode WHERE akDat BETWEEN ? and ? ORDER BY tblP4Anketa.ContCode";
        $Params=[$DateF,$DateL];        
        
        return db::getInstance()->fetch_all2($Sql,$Params); 
    }

}
