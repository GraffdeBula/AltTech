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
        return  db2::getInstance()->FetchAll('SELECT * from tblP1ExpList WHERE ContCode=? AND ExListName=?',[$ContCode,'Risk']);
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
    //сохранение информации
    public function UpdExp($ExTotDebtSum,$ExMainDebtSum,$ExAnnTotPay,$ExAnnTotInc,$ContCode){//удалить запись из справочника
        return db2::getInstance()->Query('UPDATE tblP1Expert SET ExTotDebtSum=?,ExMainDebtSum=?,ExAnnTotPay=?,ExAnnTotInc=?,$ContCode WHERE ContCode=?',[$ExTotDebtSum,$ExMainDebtSum,$ExAnnTotPay,$ExAnnTotInc,$ContCode]);
    }
    
}
