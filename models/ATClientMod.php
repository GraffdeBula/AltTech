<?php
/*
 * МОДЕЛЬ для работы с таблицей tblClients
 * получить список
 * получить одного клиента 
 * сохранить инф в таблицу tblClients
 * РАБОТА со связанными таблицами (родственники, телефоны, документы, имущество, сделки, доходы, банковские счета...)
 * сохранение, удаление //изменение данных. Кто может удалять? думаю по аналогии с комментарием тот. кто внёс. тогда надо хранить кто внёс.
 */
class ATClientMod extends Model{
    protected $clCode=10000;
    protected $name='Ivan Ivanov';
    protected $Data=[];
    
    public function NewClient($ClFName,$Cl1Name,$Cl2Name,$ClPasSer,$ClPasNum,$Emp,$Branch){
        //добавить запись в таблицу клиентов
        $Sql="INSERT INTO tblClients (lgDat,lgEmp,clBranch,clFNAme,cl1Name,cl2Name) VALUES (current_timestamp,?,?,?,?,?)";
        $Params=[$Emp,$Branch,$ClFName,$Cl1Name,$Cl2Name];
        db2::getInstance()->Query($Sql,$Params);
        
        //получение кода клиента
        $Sql="SELECT MAX(ClCode) AS CLCODE FROM tblClients WHERE lgEmp=?";
        $Params=[$Emp];
        $ClCode=db2::getInstance()->FetchOne($Sql,$Params)->CLCODE;
        
        //добавить запись в таблицу документов
        $Sql="INSERT INTO tblClDocuments (clCode,clDocName,clDocSer,clDocNum) VALUES (?,?,?,?)";
        $Params=[$ClCode,'паспорт',$ClPasSer,$ClPasNum];
        db2::getInstance()->Query($Sql,$Params);        
    }        
    
    public function GetClientList(){
        $Sql="SELECT FIRST 50 tblClients.clCode AS CLCODE,clFName,cl1Name,cl2Name,clDocSer,clDocNum FROM tblClients INNER JOIN tblClDocuments ON tblClients.clCode=tblClDocuments.clCode "
                . "WHERE clDocName=? ORDER BY tblClients.clCode DESC";
        $Params=['паспорт'];
        return $this->Data=db2::getInstance()->FetchAll($Sql,$Params);
    }
    
    public function SearchClient($ClFName,$Cl1Name,$Cl2Name,$ClPasS,$ClPasN){
        $Sql="SELECT FIRST 50 tblClients.clCode AS CLCODE,clFName,cl1Name,cl2Name,clDocSer,clDocNum FROM tblClients INNER JOIN tblClDocuments ON tblClients.clCode=tblClDocuments.clCode WHERE clDocName=?";
        $Params=['паспорт'];
        if ($ClFName!=''){
            $Sql=$Sql." AND clFName=?";
            array_push($Params,$ClFName);
        }
        if ($Cl1Name!=''){
            $Sql=$Sql." AND cl1Name=?";
            array_push($Params,$Cl1Name);
        }
        if ($Cl2Name!=''){
            $Sql=$Sql." AND cl2Name=?";
            array_push($Params,$Cl2Name);
        }
        if ($ClPasS!=''){
            $Sql=$Sql." AND clDocSer=?";
            array_push($Params,$ClPasS);
        }
        if ($ClPasN!=''){
            $Sql=$Sql." AND clDocNum=?";
            array_push($Params,$ClPasN);
        }
        return $this->Data=db2::getInstance()->FetchAll($Sql,$Params);
    }
    
    public function GetClientById($ClCode){
        $Sql="SELECT * FROM tblClients WHERE ClCode=?";
        $Params=[$ClCode];
        return $this->Data=db2::getInstance()->FetchOne($Sql,$Params);
    }
                          
    public function updClient($Param=[],$ClCode){                
        $Sql="UPDATE tblClients SET lgEmp='{$_SESSION['EmName']} and lgDat=current_timestamp'";
        $Params=[];
        foreach($Param as $key=>$value){
            $Sql=$Sql.", {$key}=?";            
            array_push($Params,$value);
        }
        $Sql=$Sql." WHERE clCode=?";
        array_push($Params,$ClCode);
        
        return $this->Data=db2::getInstance()->Query($Sql,$Params);
    }
    
    public function delClient($ClCode){
        return $this->Data=db2::getInstance()->Query("DELETE FROM tblClients WHERE ClCode=?",[$ClCode]);
    }
    
    //работа со связанной таблицей телефоны    
    public function GetClPhoneList($ClCode){
        $Sql="SELECT * FROM tblClPhones WHERE ClCode=?";
        $Params=[$ClCode];
        return db2::getInstance()->FetchAll($Sql,$Params);
    }
    
    public function getPhone($ClCode,$Name){
        $Sql="SELECT * FROM tblClPhones WHERE ClCode=? AND ClPhText=?";
        return db2::getInstance()->FetchOne($Sql,[$ClCode,$Name]);
    }
    
    public function InsPhone($ClCode,$ClPhone,$ClPhText,$ClPhComment){
        $Sql="INSERT INTO tblClPhones (ClCode,ClPhone,ClPhText,clPhComment) VALUES (?,?,?,?)";
        $Params=[$ClCode,$ClPhone,$ClPhText,$ClPhComment];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function DelPhone($ClCode,$ID){
        $Sql="DELETE FROM tblClPhones WHERE ClCode=? AND ID=?";
        $Params=[$ClCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    //операции с таблицей Родственники
    public function GetClRelativesList($ClCode){
        $Sql="SELECT * FROM tblClRelatives WHERE ClCode=?";
        $Params=[$ClCode];
        return db2::getInstance()->FetchAll($Sql,$Params);
    }
            
    public function InsRelative($ClCode,$ClRelStatus,$ClRelName,$ClRelBirthDate,$ClRelDocSer,$ClRelDocNum,$ClRelDocDate){
        $Sql="INSERT INTO tblClRelatives (clCode,clRelStatus,ClRelName,ClRelBirthDate,ClRelDocSer,ClRelDocNum,ClRelDocDate) VALUES (?,?,?,?,?,?,?)";
        $Params=[$ClCode,$ClRelStatus,$ClRelName,$ClRelBirthDate,$ClRelDocSer,$ClRelDocNum,$ClRelDocDate];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function UpdRelative($ClCode,$ID,$ClRelStatus,$ClRelName,$ClRelBirthDate,$ClRelDocSer,$ClRelDocNum,$ClRelDocDate){
        $Sql="UPDATE tblClRelatives SET clRelStatus=?,ClRelName=?,ClRelBirthDate=?,ClRelDocSer=?,ClRelDocNum=?,ClRelDocDate=? WHERE ClCode=? AND ID=?";
        $Params=[$ClRelStatus,$ClRelName,$ClRelBirthDate,$ClRelDocSer,$ClRelDocNum,$ClRelDocDate,$ClCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function DelRelative($ClCode,$ID){
        $Sql="DELETE FROM tblClRelatives WHERE ClCode=? AND ID=?";
        $Params=[$ClCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    //операции с таблицей Документы
    public function GetClDocumentsList($ClCode){
        $Sql="SELECT * FROM tblClDocuments WHERE ClCode=?";
        $Params=[$ClCode];
        return db2::getInstance()->FetchAll($Sql,$Params);
    }
            
    public function InsDoc($ClCode,$ClDocName,$ClDocSer,$ClDocNum,$ClDocComment,$ClDocOrg,$ClDocDate,$ClDocAttr1,$ClDocAttr2,$ClDocAttr3){
        $Sql="INSERT INTO tblClDocuments (clCode,clDocName,clDocSer,clDocNum,clDocComment,clDocOrg,clDocDate,"
                . "clDocAttr1,clDocAttr2,clDocAttr3) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $Params=[$ClCode,$ClDocName,$ClDocSer,$ClDocNum,$ClDocComment,$ClDocOrg,$ClDocDate,$ClDocAttr1,$ClDocAttr2,$ClDocAttr3];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function updDocument($ClCode=0,$ID=0,$ClDocName,$ClDocSer,$ClDocNum,$ClDocComment,$ClDocOrg,$ClDocDate,$ClDocAttr1='',$ClDocAttr2='',$ClDocAttr3=''){
        $Sql="UPDATE tblClDocuments SET clDocName=?,clDocSer=?,clDocNum=?,clDocComment=?,clDocOrg=?,clDocDate=?,"
                . "clDocAttr1=?,clDocAttr2=?,clDocAttr3=? WHERE ID=? AND ClCode=?";
        $Params=[$ClDocName,$ClDocSer,$ClDocNum,$ClDocComment,$ClDocOrg,$ClDocDate,
            $ClDocAttr1,$ClDocAttr2,$ClDocAttr3,$ID,$ClCode];
        db2::getInstance()->Query($Sql,$Params);
    }
        
    public function DelDocument($ClCode,$ID){
        $Sql="DELETE FROM tblClDocuments WHERE ClCode=? AND ID=?";
        $Params=[$ClCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function getDocument($ClCode,$Name){
        $Sql="SELECT * FROM tblClDocuments WHERE ClCode=? AND ClDocName=?";
        return db2::getInstance()->FetchOne($Sql,[$ClCode,$Name]);
    }
    
    //операции с таблицей Доходы
    public function GetClIncomesList($ClCode){
        $Sql="SELECT * FROM tblClIncomes WHERE ClCode=?";
        $Params=[$ClCode];
        return db2::getInstance()->FetchAll($Sql,$Params);
    }
            
    public function InsIncome($ClCode,$ClIncName,$ClIncSum,$ClIncSumOf,$ClIncCardYN,$ClIncBank,$ClIncDeduct,$ClIncSumReal,$ClIncComment,$ClIncPensDate){
        $Sql="INSERT INTO tblClIncomes (ClCode,ClIncName,ClIncSum,ClIncSumOf,ClIncCardYN,ClIncBank,ClIncDeduct,ClIncSumReal,ClIncComment,ClIncPensDate) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $Params=[$ClCode,$ClIncName,$ClIncSum,$ClIncSumOf,$ClIncCardYN,$ClIncBank,$ClIncDeduct,$ClIncSumReal,$ClIncComment,$ClIncPensDate];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function DelIncome($ClCode,$ID){
        $Sql="DELETE FROM tblClIncomes WHERE ClCode=? AND ID=?";
        $Params=[$ClCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    //операции с таблицей Собственность
    public function GetClPropertyList($ClCode){
        $Sql="SELECT * FROM tblClProperty WHERE ClCode=?";
        $Params=[$ClCode];
        return db2::getInstance()->FetchAll($Sql,$Params);
    }
    
    public function GetClPropertyByDesc($ClCode,$Desc){
        $Sql="SELECT * FROM tblClProperty WHERE ClCode=? AND ClPropDesc=?";
        $Params=[$ClCode,$Desc];
        return db2::getInstance()->FetchAll($Sql,$Params);
    }
    
    public function InsProperty($ClCode,$ClPropType,$ClPropOwner,$ClPropDesc,$ClPropCost,$ClPropDate,$ClPropComment,$ClPropDocumentsYN){
        $Sql="INSERT INTO tblClProperty (ClCode,ClPropType,ClPropOwner,ClPropDesc,ClPropCost,ClPropDate,ClPropComment,ClPropDocumentsYN) VALUES (?,?,?,?,?,?,?,?)";
        $Params=[$ClCode,$ClPropType,$ClPropOwner,$ClPropDesc,$ClPropCost,$ClPropDate,$ClPropComment,$ClPropDocumentsYN];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function UpdProperty($ClCode,$ID,$ClPropType,$ClPropOwner,$ClPropDesc,$ClPropCost,$ClPropDate,$ClPropComment,$ClPropDocumentsYN){
        $Sql="UPDATE tblClProperty SET ClPropType=?,ClPropOwner=?,ClPropDesc=?,ClPropCost=?,ClPropDate=?,ClPropComment=?,ClPropDocumentsYN=? WHERE ClCode=? AND ID=?";
        $Params=[$ClPropType,$ClPropOwner,$ClPropDesc,$ClPropCost,$ClPropDate,$ClPropComment,$ClPropDocumentsYN,$ClCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function DelProperty($ClCode,$ID){
        $Sql="DELETE FROM tblClProperty WHERE ClCode=? AND ID=?";
        $Params=[$ClCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    //операции с таблицей Сделки
    public function GetClDealsList($ClCode){
        $Sql="SELECT * FROM tblClDeals WHERE ClCode=?";
        $Params=[$ClCode];
        return db2::getInstance()->FetchAll($Sql,$Params);
    }
    
    public function InsDeal($ClCode,$ClDlType,$ClDlObj,$ClDlSum,$ClDlDate,$ClDlComment,$ClDlDocumentsYN,$ClDlOwner){
        $Sql="INSERT INTO tblClDeals (ClCode,ClDlType,ClDlObj,ClDlSum,ClDlDate,ClDlComment,ClDlDocumentsYN,ClDlOwner) VALUES (?,?,?,?,?,?,?,?)";
        $Params=[$ClCode,$ClDlType,$ClDlObj,$ClDlSum,$ClDlDate,$ClDlComment,$ClDlDocumentsYN,$ClDlOwner];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function UpdDeal($ClCode,$ID,$ClDlType,$ClDlObj,$ClDlSum,$ClDlDate,$ClDlComment,$ClDlDocumentsYN,$ClDlOwner){
        $Sql="UPDATE tblClDeals SET ClDlType=?,ClDlObj=?,ClDlSum=?,ClDlDate=?,ClDlComment=?,ClDlDocumentsYN=?,ClDlOwner=? WHERE ClCode=? AND ID=?";
        $Params=[$ClDlType,$ClDlObj,$ClDlSum,$ClDlDate,$ClDlComment,$ClDlDocumentsYN,$ClDlOwner,$ClCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function DelDeal($ClCode,$ID){
        $Sql="DELETE FROM tblClDeals WHERE ClCode=? AND ID=?";
        $Params=[$ClCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    //операции с таблицей Банковские счета
    public function GetClBankAccsList($ClCode){
        $Sql="SELECT * FROM tblClBankAccs WHERE ClCode=?";
        $Params=[$ClCode];
        return db2::getInstance()->FetchAll($Sql,$Params);
    }
    
    public function InsBankAcc($ClCode,$ClBnAcc,$ClBnName,$ClBnComment,$ClBnSum,$ClBnOpenDat,$ClBnCloseDat){
        $Sql="INSERT INTO tblClBankAccs (ClCode,ClBnAcc,ClBnName,ClBnComment,ClBnSum,ClBnOpenDat,ClBnCloseDat) VALUES (?,?,?,?,?,?,?)";
        $Params=[$ClCode,$ClBnAcc,$ClBnName,$ClBnComment,$ClBnSum,$ClBnOpenDat,$ClBnCloseDat];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    public function DelBankAcc($ClCode,$ID){
        $Sql="DELETE FROM tblClBankAccs WHERE ClCode=? AND ID=?";
        $Params=[$ClCode,$ID];
        db2::getInstance()->Query($Sql,$Params);
    }
    
    //операции с таблицей История клиентов
    public function DelIncHist($ClCode){
        $Sql="DELETE FROM tblClIncomeHist WHERE ClCODE=?";
        db2::getInstance()->Query($Sql,[$ClCode]);
        
    }
    public function GetIncHist($ClCode){
        $Sql="SELECT * FROM tblClIncomeHist WHERE ClCODE=?";
        db2::getInstance()->Query($Sql,[$ClCode]);
        
    }
    public function InsIncHist($ClCode,$IncYear,$IncOfSum,$IncRealSum){
        $Sql="INSERT INTO tblClIncomeHist (ClCode,IncYear,IncOfSum,IncRealSum) VALUES (?,?,?,?)";
        $Params=[$ClCode,$IncYear,$IncOfSum,$IncRealSum];
        db2::getInstance()->Query($Sql,$Params);
        
    }
    
    
    
    
}
