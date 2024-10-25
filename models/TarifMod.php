<?php

/**
 * модель для работы с пакетами и тарифами
 * 
 * получение и изменение списка пакетов
 * получение и изменение списка тарифов
 * 
 * получение тарифа по имени и сумме долга для договора
 * @author Andrey
 */
class TarifMod extends Model{
    protected $Data=[]; //для полученных данных
    
    public function getPacFullList(){
        $Sql="SELECT * FROM tblP1Pacs ORDER BY PcAct,PcProg,PcTemplateRoot,PcPeriod";
        #$Sql="SELECT FIRST 100 * FROM tblP1Pacs ORDER BY ID DESC";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function addPac($PcProg,$PcPac,$PcAct,$PcTemplateRoot,$PcBookmarkList,$PcPeriod){
        $Sql="INSERT INTO tblP1Pacs (PcProg,PcPac,PcAct,PcTemplateRoot,PcBookmarksList,PcPeriod) VALUES (?,?,?,?,?,?)";
        db2::getInstance()->Query($Sql,[$PcProg,$PcPac,$PcAct,$PcTemplateRoot,$PcBookmarkList,$PcPeriod]);
    }
    
    public function updPac(){
        
    }
    
    public function delPac($Id){
        $Sql="DELETE FROM tblP1Pacs WHERE ID=?";
        db2::getInstance()->Query($Sql,[$Id]);
    }
    
    public function getPacBranchList(){
        $Sql="SELECT tblP1PacBranchTypes.ID as ID,pcTemplateRoot,pacName,pacBrName,pacContType,pcPeriod FROM tblP1PacBranchTypes INNER JOIN tblP1Pacs "
                . "ON tblP1PacBranchTypes.pacName=tblP1Pacs.pcPac WHERE pcAct=? ORDER BY pacBrName,pacName ";
        return db2::getInstance()->FetchAll($Sql,[1]);
    }
    
    public function getPacBranch($Pac,$Branch){
        $Sql="SELECT * FROM tblP1PacBranchTypes WHERE pacName=? AND pacBrName=?";
        return db2::getInstance()->FetchOne($Sql,[$Pac,$Branch]);
    }
    
    public function updPacBranch($Id,$PayType){
        $Sql="UPDATE tblP1PacBranchTypes SET pacContType=? WHERE Id=?";
        db2::getInstance()->Query($Sql,[$PayType,$Id]);
    }
    
    public function getTarifList(){
        $Sql="SELECT TrName FROM tblp1tarif WHERE TrStatus=? GROUP BY TrName";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[1]);
    }

    public function getTarifFullList(){
        #$Sql="SELECT * FROM tblP1Tarif ORDER BY TrName,TrSumMin";
        $Sql="SELECT FIRST 100 * FROM tblP1Tarif ORDER BY ID DESC";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function addTarif($TrStatus,$TrDate,$TrName,$TrComment,$TrPac,$TrSumMin,$TrSumMax,$TrType,$TrSumFix,$TrSumAnn,$TrSumPerc){
        $Sql="INSERT INTO tblP1Tarif (TrStatus,TrDate,TrName,TrComment,TrPac,TrSumMin,TrSumMax,TrType,TrSumFix,TrSumAnn,TrSumPerc) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        db2::getInstance()->Query($Sql,[$TrStatus,$TrDate,$TrName,$TrComment,$TrPac,$TrSumMin,$TrSumMax,$TrType,$TrSumFix,$TrSumAnn,$TrSumPerc]);
    }
    
    public function updTarif(){
        
    }
    
    public function delTarif($Id){
        $Sql="DELETE FROM tblP1Tarif WHERE ID=?";
        db2::getInstance()->Query($Sql,[$Id]);
    }

    public function getPacList(){
//        $sql="SELECT * FROM tblP1P2pacs WHERE pcID>=528 ORDER BY pcPac";
//        return $this->Data=db::getInstance()->fetch_all($sql);
        return [];
    }
    
    public function getTarif($TrName,$DebtSum,$Branch){
        $Sql="SELECT * FROM tblp1tarif WHERE TrName=? AND TrSumMin<=? AND TrSumMax>=? AND TrBranch=? AND TrStatus=1";
        return $this->Data=db2::getInstance()->FetchOne($Sql,[$TrName,$DebtSum,$DebtSum,$Branch]);
    }
    
    public function getTarifByPac($TrPac,$CredSum,$Branch){
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblP1Tarif WHERE TrPac=? AND TrSumMin<=? AND TrSumMax>=? AND TrBranch=? AND TrStatus=1",
            [$TrPac,$CredSum,$CredSum,$Branch]);
    }
    
    public function getTarifByPeriod($TrComment,$CredSum,$Period,$Branch){
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tblP1Tarif INNER JOIN tblP1Pacs on tblP1Tarif.trPac=tblP1Pacs.pcPac "
                . "WHERE TrComment=? AND TrSumMin<=? AND TrSumMax>=? AND PCPERIOD=? AND TrBranch=? AND TrStatus=1",
                [$TrComment,$CredSum,$CredSum,$Period,$Branch]);
    }
    
    public function getTarifElList(){
        $Sql="SELECT * FROM tblP1TarifElement";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function getTarifElListByType($ElType=''){
        $Sql="SELECT * FROM tblP1TarifElement WHERE TrElType=?";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[$ElType]);
    }
    
    public function addTarifEl($Type,$Name,$Sum){
        $Sql="INSERT INTO tblP1TarifElement (trElType,trElName,trElSum) VALUES (?,?,?)";
        db2::getInstance()->Query($Sql,[$Type,$Name,$Sum]);
    }
           
}
