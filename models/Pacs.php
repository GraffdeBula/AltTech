<?php

/**
 * модель для работы с пакетами и тарифами
 *
 * @author Andrey
 */
class Pacs extends Model{
    protected $Data=[]; //для полученных данных
    
    public function getFullList(){ //получение всего списка пакетов
        return $this->Data=db::getInstance()->fetch_all("SELECT * FROM tblp1p2Pacs");
    }
    
    public function getPacByName($PacName){ //получение пакета по имени
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblp1Pacs WHERE pcPac='{$PacName}'");
    }
    
//    ###на удаление  24/04/2023
//    public function getPacByName($PacName){ //получение пакета по имени
//        return $this->Data=db::getInstance()->fetch_one("SELECT * FROM tblp1p2Pacs WHERE pcPac='{$PacName}'");
//    }
        
    public function saveNewPac($pacParams){
        $strSql="INSERT INTO tblP1P2Pacs (pcprog,pcPac,pcAct,pcTemplateRoot,pcBookmarkList) VALUES (?,?,?,?,?')";
        //$strSql="INSERT INTO tblP1P2Pacs VALUES (0,'1','2',1,'3','4');";
        //db::getInstance()->query_insert($strSql,$pacParams);
        var_dump($pacParams);
    }
    
    public function getTarifByName($TrPac,$CredSum){
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblP1Tarif WHERE TrPac=? AND TrSumMin<=? AND TrSumMax>=?",[$TrPac,$CredSum,$CredSum]);
    }
    
    public function getTarifByPeriod($TrComment,$CredSum,$Period){
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblP1Tarif INNER JOIN tblP1Pacs on tblP1Tarif.trPac=tblP1Pacs.pcPac "
                . "WHERE TrComment=? AND TrSumMin<=? AND TrSumMax>=? AND PCPERIOD=?",[$TrComment,$CredSum,$CredSum,$Period]);
    }
//копирование из старой БД
    public function CopyTarif(){
        $sql="SELECT * FROM tblP1P2Tarif WHERE trPac IN ('pac59','pac60','pac61','pac62') ORDER BY trCode";
        return $this->Data=db::getInstance()->fetch_all($sql);
    }

    public function InsTarif($Params){
        $Sql="INSERT INTO tblP1Tarif (trStatus,trName,trComment,trPac,trSumMin,trSumMax,trType,trSumFix,trSumAnn) 
            VALUES (?,?,?,?,?,?,?,?,?)";
        db2::getInstance()->Query($Sql,$Params);
    }

    public function CopyPac(){
        $sql="SELECT * FROM tblP1P2pacs WHERE pcID>=528 ORDER BY pcPac";
        return $this->Data=db::getInstance()->fetch_all($sql);
    }

    public function InsPac($Params){
        $Sql="INSERT INTO tblP1pacs (pcProg,pcPac,pcAct,pcTemplateRoot,pcBookmarksList,pcPeriod) 
            VALUES (?,?,?,?,?,?)";
        db2::getInstance()->Query($Sql,$Params);
    }
       
    
}
