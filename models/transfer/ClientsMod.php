<?php

class ClientsMod extends Model{    
    protected $Data=[];
        
    public function getClientsList(){
        return $this->Data=db::getInstance()->fetch_all("SELECT ClCode,clFNAme,cl1Name,cl2Name,clPasSer,clPasNum FROM tblClients");
    }
    
    public function insClient($ClCode,$ClFName,$Cl1Name,$Cl2Name){
        db2::getInstance()->Query("INSERT INTO tblClients (ClCode,ClFName,Cl1Name,Cl2Name) VALUES (?,?,?,?)",[$ClCode,$ClFName,$Cl1Name,$Cl2Name]);
    }
    
    public function insClientPassport($ClCode,$ClPasSer,$ClPasNum){
        db2::getInstance()->Query("INSERT INTO tblClDocuments (ClCOde,ClDocName,ClDocSer,ClDocNum) VALUES (?,?,?,?)",[$ClCode,'паспорт',$ClPasSer,$ClPasNum]);
    }
    
}
