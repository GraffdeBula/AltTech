<?php
/**
 * модель для работы с закладками
 * в старой базе (подключение черед db::getInstance()
 * в новой базе (подключение черед db2::getInstance()
 *
 * @author Andrey
 */
class Bookmarks extends Model{
    protected $TableName;
    protected $Data;
    //работа 
    public function getBookmarksList($TableName){
        return $this->Data=db::getInstance()->fetch_all("SELECT * FROM {$TableName};"); //таблица закладок возвращается как массив объектов
    }
    
    /**методы для новой БД
    * 
    */
    public function GetBMListForPrinter($DocName){
        return $this->Data=db2::getInstance()->FetchAll("SELECT * FROM tblDocBookMarks WHERE BmDocName=? ORDER BY ID",[$DocName]); //таблица закладок
    }
    
    public function GetBMList(){
        return $this->Data=db2::getInstance()->FetchAll("SELECT * FROM tblDocBookMarks ORDER BY ID DESC",[]); //таблица закладок
    }
    
    public function GetFilterList($Filter){
        return $this->Data=db2::getInstance()->FetchAll("SELECT * FROM tblDocBookMarks WHERE BmDocName=? ORDER BY ID DESC",[$Filter]); //таблица закладок
    }
    
    public function GetDocList(){
        return $this->Data=db2::getInstance()->FetchAll("SELECT BmDocName FROM tblDocBookMarks GROUP BY BmDocName",[]); //таблица документов для фильтра
    }
    
    public function InsBm($Params){
        db2::getInstance()->Query("INSERT INTO tblDocBookMarks (bmDocName,bmName,bmTable,bmField,bmType,bmChange,bmCheckData,bmInsData) VALUES (?,?,?,?,?,?,?,?)",
            $Params);
    }
    
    public function DelBm($Id){
        db2::getInstance()->Query("DELETE FROM tblDocBookMarks WHERE Id=?",[$Id]);
    }
    
    /*временные методы
     * трансфер закладок из старой базы
     */
    public function CopyBm(){
        #return $this->Data=db::getInstance()->fetch_all("SELECT * FROM tblContBookMarksPac31 ORDER BY Id");   
        return $this->Data=db2::getInstance()->FetchAll("SELECT * FROM tblDocBookMarks WHERE BmDocName=? ORDER BY ID",['Anketa']);
    }
    
    
}
