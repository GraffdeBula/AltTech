<?php
/**
 * Description of ExpertMod
 *
 * @author Andrey
 */
class ExpertMod extends Model{
    protected $Data=[];

    //сохранение и получение данных из tblP1Expert
    public function GetExp($ContCode){
        return db2::getInstance()->FetchOne('SELECT * from tblP1Expert WHERE ContCode=?',[$ContCode]);
    }
    //получение списка рисков
    public function GetExpRiskList($ContCode){
        return  db2::getInstance()->FetchAll('SELECT tblP1ExpList.Id AS ID,ContCode,ExListValue,ExListValue2,ExListValue3,DrValueType 
            FROM tblP1ExpList INNER JOIN tbl1DrExpList ON tblP1ExpList.ExListValue=tbl1DrExpList.DrValue 
            WHERE ContCode=? AND ExListName=?',[$ContCode,'Risk']);
    }    
    public function GetExpRiskList2($ContCode){
        return  db2::getInstance()->FetchAll('SELECT tblP1ExpList.Id AS ID,ContCode,ExListValue,ExListValue2,ExListValue3 
            FROM tblP1ExpList WHERE ContCode=? AND ExListName=?',[$ContCode,'Risk2']);
    }
    //добавление нового риска
    public function InsExpRisk($param){
        db2::getInstance()->Query('INSERT INTO tblP1ExpList (ContCode,exListName,exListValue,exListValue2) VALUES (?,?,?,?)',$param); //должен получить массив из одного строкового элемента
    }
    //обновление инф по работе с риском
    public function updExpRisk($ExListValue2,$ExListValue3,$Id){
        db2::getInstance()->Query('UPDATE tblP1ExpList SET ExListValue2=?,ExListValue3=? WHERE ID=?',[$ExListValue2,$ExListValue3,$Id]);
    }
    //удаление лишнего риска
    public function DelExpRisk($param){        
        db2::getInstance()->Query('DELETE FROM tblP1ExpList WHERE ID=?',$param);
    }
    //получение справочника рисков
    public function GetRiskDr($param){        
        return db2::getInstance()->FetchAll('SELECT * FROM tbl1DrExpList WHERE DrName=?',$param);
    }
    //добавление риска в справочник
    public function AddRiskDr($DrValue){        
        return db2::getInstance()->Query('INSERT INTO tbl1DrExpList (DrName,DrValue) VALUES (?,?)',['Risk',$DrValue]);
    }
    //удаление риска из справочника
    public function DelRiskDr($DrID){//удалить запись из справочника
        return db2::getInstance()->Query('DELETE FROM tbl1DrExpList WHERE id=?',[$DrID]);
    }
    //сохранение инф о прожиточном минимуме
    public function addExpMinInc($ContCode,$Value,$Value2){
        $Params=[$ContCode,'MinInc',$Value,$Value2];
        db2::getInstance()->Query('INSERT INTO tblP1ExpList (ContCode,ExListName,ExListValue,ExListValue2) VALUES (?,?,?,?)',$Params);
    }
    //получение инф о прожиточном минимуме
    public function getExpMinInc($ContCode){
        return db2::getInstance()->FetchAll('SELECT * FROM tblP1ExpList WHERE ExListName=? AND ContCode=?',['MinInc',$ContCode]);
    }
    //удаление инф о прожиточном минимуме
    public function delExpMinInc($ContCode){
        return db2::getInstance()->Query('DELETE FROM tblP1ExpList WHERE ExListName=? AND ContCode=?',['MinInc',$ContCode]);
    }
    //сохранение результатов ЭПЭ
    public function UpdExp($ExTotDebtSum,$ExMainDebtSum,$ExAnnTotPay,$ExAnnTotInc,$ContCode){
        return db2::getInstance()->Query('UPDATE tblP1Expert SET ExTotDebtSum=?,ExMainDebtSum=?,ExAnnTotPay=?,ExAnnTotInc=? WHERE ContCode=?',[$ExTotDebtSum,$ExMainDebtSum,$ExAnnTotPay,$ExAnnTotInc,$ContCode]);
    }
    //согласование андеррайтера
    public function UpdSoglExp($ExResName,$ExResDate,$ContCode){
        return db2::getInstance()->Query('UPDATE tblP1Expert SET ExResEmp=?,ExResDat=? WHERE ContCode=?',[$ExResName,$ExResDate,$ContCode]);
    }
    //согласование юриста
    public function UpdSoglJur($ExJurName,$ExJurDate,$ContCode){
        return db2::getInstance()->Query('UPDATE tblP1Expert SET ExJurSoglName=?,ExJurSoglDate=?,ExResDat=? WHERE ContCode=?',[$ExJurName,$ExJurDate,$ExJurDate,$ContCode]);
    }
    //согласование руководителя
    public function UpdSoglDir($ExDirName,$ExDirDate,$ContCode){
        return db2::getInstance()->Query('UPDATE tblP1Expert SET ExDirSoglName=?,ExDirSoglDate=? WHERE ContCode=?',[$ExDirName,$ExDirDate,$ContCode]);
    }
    //общий коммент для юриста
    public function AddToJurist($ExComment,$ContCode){
        db2::getInstance()->Query('UPDATE tblP1Expert SET ExComment=? WHERE ContCode=?',[$ExComment,$ContCode]);
    }
    public function AddFromJurist($ExComment,$ContCode){
        db2::getInstance()->Query('UPDATE tblP1Expert SET ExJurComment=? WHERE ContCode=?',[$ExComment,$ContCode]);
    }
    
    //***НОВЫЕ списки договоров на ЭПЭ
    //*договоры на правовой анализ
    public function getContJurList(){
        return db2::getInstance()->fetchAll("SELECT tblClients.ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,frOffice,frContdate "
                . "FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1Anketa.ClCode "
                . "INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode "                
                . "WHERE tblP1Anketa.Status=? ORDER BY tblP1Anketa.ContCode DESC",[16]);
    }
    //*проведён правовой анализ (договоры для постконтроля)
    public function getContJurSogl(){
        return db2::getInstance()->fetchAll("SELECT tblClients.ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,frOffice,frContdate,exresdat "
                . "FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1Anketa.ClCode "
                . "INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode "
                . "INNER JOIN tblP1Expert ON tblP1Anketa.ContCode=tblP1Expert.ContCode "
                . "WHERE tblP1Anketa.Status=? AND expunderdate is null ORDER BY exresdat,tblP1Anketa.ContCode",[17]);
    }
    
    //*проведён постконтроль
    public function getContAfterUnder(){
        return db2::getInstance()->fetchAll("SELECT tblClients.ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,frOffice,frContdate,exresdat,expunderdate,expunderres "
                . "FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1Anketa.ClCode "
                . "INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode "                
                . "INNER JOIN tblP1Expert ON tblP1Anketa.ContCode=tblP1Expert.ContCode "
                . "WHERE expunderdate>=? ORDER BY tblP1Anketa.ContCode DESC",['01.08.2024']);
    }
    
    //*проведён постконтроль, выявлены ошибки
    public function getContAfterUnderErr(){
        return db2::getInstance()->fetchAll("SELECT tblClients.ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,frOffice,frContdate,exresdat,expunderdate,expunderres "
                . "FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1Anketa.ClCode "
                . "INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode "                
                . "INNER JOIN tblP1Expert ON tblP1Anketa.ContCode=tblP1Expert.ContCode "
                . "WHERE expunderdate>=? ORDER BY tblP1Anketa.ContCode DESC",['01.08.2024']);
    }
    
}
