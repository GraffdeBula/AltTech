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
    
    public function GetP1ContList($ClCode){
        $Sql="SELECT * FROM vwP4ContList WHERE ClCode=?;";                
        $Params=[$ClCode];
        return $this->Data=db2::getInstance()->FetchAll($Sql,$Params);    
    }
    
    public function GetAnketaByCode($ContCode){ //метод возвращает строку из таблицы p4Anketa
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblP4Anketa WHERE contCode='{$ContCode}';");        
    }
    
    public function GetCont($ContCode){ 
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM vwP4ContList WHERE contCode='{$ContCode}';");        
    }
    
    public function InsP1Anketa($ClCode){
        $Sql="INSERT INTO tblP4Anketa (ClCode,AkBranch,lgEmp) values (?,?,?)";
        $Params=[$ClCode,'ГО','admin'];
        db2::getInstance()->Query($Sql,$Params); 
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
