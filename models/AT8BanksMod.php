<?php

class AT8BanksMod extends Model{
    protected $Data;    
    
               
    public function GetBanksList($LsPart=0){//возвращает список банков
        return db2::getInstance()->FetchAll("SELECT FIRST 100 SKIP {$LsPart} * FROM tbl8DrBanks ",[]);
    }
   
    public function AddBank($Bank=[]){//добавить организацию (банк/мфо/коллектор)        
        db2::getInstance()->Query("INSERT INTO tbl8DrBanks (BnINN,BnOGRN,BnName,BnFullName,BnAdrReg,BnAdrDop,BnEmail,BnComment,BnType) VALUES (?,?,?,?,?,?,?,?,?)",$Bank);       
    }
    
    public function UpdBank($EmpName,$EmpBranch){//изменить организацию
       db2::getInstance()->Query("INSERT INTO tbl8DrBanks (EmName,EmBranch) VALUES (?,?)",[$EmpName,$EmpBranch]);       
    }
   
    public function DelBank($BankID){//удалить организацию
       db2::getInstance()->Query("DELETE FROM tbl8DrBanks WHERE ID=?",[$BankID]);
    }

    public function getBankByName($BnName){//возвращает список банков
        return db2::getInstance()->FetchOne("SELECT * FROM tbl8DrBanks WHERE BnName=?",[$BnName]);
    }
    
    public function getBankByINN($INN){
        return db2::getInstance()->FetchOne("SELECT * FROM tbl8DrBanks WHERE bnINN=?",[$INN]);
    }
                      
}
