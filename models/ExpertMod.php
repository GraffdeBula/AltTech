<?php
/**
 * Description of ExpertMod
 *
 * @author Andrey
 */
class ExpertMod extends Model{
    protected $Data=[];
    //работа со старым справочником 
    public function getExpListDr(){
        return $this->Data=db::getInstance()->fetch_all('SELECT * FROM tblP1ExpertListDr');
    }
    
    public function insExpListDr($param){
        db::getInstance()->queryInsertOne('INSERT INTO tblP1ExpertListDr (expDrValue) VALUES (?)',$param); //должен получить массив из одного строкового элемента
    }
    
    public function updExpListDr($param){
        db::getInstance()->query_update('UPDATE tblP1ExpertListDr SET expDrValue=? WHERE ID=?',$param);
    }
    
    public function delExpListDr($param){        
        db::getInstance()->query_delete2('DELETE FROM tblP1ExpertListDr WHERE ID=?',$param);
    }
    //работа с новой БД
    //сохранение и получение данных из tblP1Expert
    public function GetExp($ContCode){
        return db2::getInstance()->FetchOne('SELECT * from tblP1Expert WHERE ContCode=?',[$ContCode]);
    }
    //получение списка рисков
    public function GetExpRiskList($ContCode){
        return  db2::getInstance()->FetchAll('SELECT * from tblP1ExpList INNER JOIN tbl1DrExpList 
            ON tblP1ExpList.ExListValue=tbl1DrExpList.DrValue 
            WHERE ContCode=? AND ExListName=?',[$ContCode,'Risk']);
    }
    //добавление нового риска
    public function InsExpRisk($param){
        db2::getInstance()->Query('INSERT INTO tblP1ExpList (ContCode,exListName,exListValue) VALUES (?,?,?)',$param); //должен получить массив из одного строкового элемента
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
        return db2::getInstance()->Query('UPDATE tblP1Expert SET ExJurSoglName=?,ExJurSoglDate=? WHERE ContCode=?',[$ExJurName,$ExJurDate,$ContCode]);
    }
    //согласование руководителя
    public function UpdSoglDir($ExDirName,$ExDirDate,$ContCode){
        return db2::getInstance()->Query('UPDATE tblP1Expert SET ExDirSoglName=?,ExDirSoglDate=? WHERE ContCode=?',[$ExDirName,$ExDirDate,$ContCode]);
    }
    //общий коммент для юриста
    public function AddToJurist($ExComment,$ContCode){
        db2::getInstance()->Query('UPDATE tblP1Expert SET ExComment=? WHERE ContCode=?',[$ExComment,$ContCode]);
    }

    //***списки договоров на ЭПЭ
    //список для андеррайтера
    public function getExpList(){
        return db2::getInstance()->fetchAll("SELECT tblClients.ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,frOffice,frexpdate, exRes "
                . "FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1Anketa.ClCode "
                . "INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode "
                . "INNER JOIN tblP1Expert ON tblP1Anketa.ContCode=tblP1Expert.ContCode "
                . "WHERE tblP1Anketa.Status=? AND tblP1Expert.ExResDat IS NULL ORDER BY tblP1Anketa.ContCode DESC",[2]);
    }
    //список для юриста
    public function getExpJurList(){
        return db2::getInstance()->fetchAll("SELECT tblClients.ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,frOffice,exRes "
                . "FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1Anketa.ClCode "
                . "INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode "
                . "INNER JOIN tblP1Expert ON tblP1Anketa.ContCode=tblP1Expert.ContCode "
                . "WHERE tblP1Anketa.Status=? AND tblP1Expert.ExResDat IS NOT NULL AND tblP1Expert.ExJurSoglDate IS NULL ORDER BY tblP1Anketa.ContCode DESC",[2]);
    }
    //список для руководителя
    public function getExpDirList(){
        return db2::getInstance()->fetchAll("SELECT tblClients.ClCode,tblP1Anketa.ContCode AS ContCode,ClFIO,frOffice,exRes "
                . "FROM tblClients INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1Anketa.ClCode "
                . "INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode "
                . "INNER JOIN tblP1Expert ON tblP1Anketa.ContCode=tblP1Expert.ContCode "
                . "WHERE tblP1Anketa.Status=? AND tblP1Expert.ExResDat IS NOT NULL AND tblP1Expert.ExDirSoglDate IS NULL ORDER BY tblP1Anketa.ContCode DESC",[2]);
    }
    
}
