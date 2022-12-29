<?php

class ContP1Mod extends Model{    
    protected $Data=[];
        
    public function getP1AnketaList(){
        return $this->Data=db::getInstance()->fetch_all("SELECT ClCode,ContCode,AkDat,AkBranch,AkLeadID,Status,AkCredNum,AkCredTotSum,AkCredMainSum,AkType FROM tblP1Anketa");
    }
    
    public function getP1FrontList(){
        return $this->Data=db::getInstance()->fetch_all("SELECT ContCode,frContDat,frPersManager,frOffice,frTarPac,frTarProg,frTarif,frContSum  FROM tblPN1Front WHERE frContDat>='01.07.2019'");
    }
    
    public function getP1Calend1List(){
        return $this->Data=db::getInstance()->fetch_all("SELECT * FROM tblP1PayCalend");
    }
    
    public function getP1Calend2List(){
        return $this->Data=db::getInstance()->fetch_all("SELECT * FROM tblP2PayCalend");
    }
    
    public function getP1Calend3List(){
        return $this->Data=db::getInstance()->fetch_all("SELECT * FROM tblP2PayCalendCred");
    }
        
    public function insP1Anketa($ClCode,$ContCode,$AkDat,$AkBranch,$AkLeadID,$Status,$AkCredNum,$AkCredTotSum,$AkCredMainSum,$AkType){
        db2::getInstance()->Query("INSERT INTO tblp1Anketa (ClCode,ContCode,AkDat,AkBranch,AkLeadID,Status,AkCredNum,AkCredTotSum,AkCredMainSum,AkType) VALUES (?,?,?,?,?,?,?,?,?,?)",
            [$ClCode,$ContCode,$AkDat,$AkBranch,$AkLeadID,$Status,$AkCredNum,$AkCredTotSum,$AkCredMainSum,$AkType]);
    }
    
    public function insP1Front($ContCode,$FrContDate,$FrPersManager,$FrOffice,$frContPac,$frContProg,$frContTarif,$frContSum){
        db2::getInstance()->Query("INSERT INTO tblP1Front (ContCode,FrContDate,FrPersManager,FrOffice,frContPac,frContProg,frContTarif,frContSum) VALUES (?,?,?,?,?,?,?,?)",
                [$ContCode,$FrContDate,$FrPersManager,$FrOffice,$frContPac,$frContProg,$frContTarif,$frContSum]);
    }
    
    public function insP1PayCalend($ContCode,$PayNum,$PayDate,$PaySum=0,$PayPercSum=0,$PayMainSum=0,$PayDebtSum=0){
        db2::getInstance()->Query("INSERT INTO tblP1PayCalend (ContCode,PayNum,PayDate,PaySum,PayPercSum,PayMainSum,PayDebtSum) VALUES (?,?,?,?,?,?,?)",
                [$ContCode,$PayNum,$PayDate,$PaySum,$PayPercSum,$PayMainSum,$PayDebtSum]);
    }
    
    public function getPays(){
        return $this->Data=db::getInstance()->fetch_all("SELECT * FROM tblPKO");
    }
    
    public function insPays($ContCode,$PkoCode,$PkoSum,$PkoDat){
        db2::getInstance()->Query($Sql,$Params);
    }
        
}
