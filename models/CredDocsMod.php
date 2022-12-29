<?php
/**
 * Модель для работы со списком документов
 *
 * @author Andrey
 */
class CredDocsMod {
    protected $Data;
       
    public function GetDocList($ContCode){
        return $this->Data=db::getInstance()->fetch_all("SELECT * FROM vwIskCredDocs WHERE contCode={$ContCode};");
    }
    
    public function UpdDocID($params){
        $sql="UPDATE tblP1CrDocs SET ID=? WHERE CONTCODE=? and CRCODE=? and DOCNAME=?;";
        db::getInstance()->query_update($sql,$params); //params - массив параметров
    }
    
    public function UpdDoc($params){
        $sql="UPDATE tblP1CrDocs SET DOCNUM=?,DOCDATE=?,DOCPAGES=?,DOCTOISK=? WHERE ID=?;";
        db::getInstance()->query_update($sql,$params); //params - массив параметров
    }
}