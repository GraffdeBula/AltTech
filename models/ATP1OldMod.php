<?php

/**
 * модель для работы с действующими клиентами
 * Анкета
 * Фронт
 * Экспертиза
 *
 * @author andrey
 */
class ATP1OldMod extends Model{
    public $ClCode;
    protected $Data=[];
    
    public function getP1ContTomskList(){
        $Sql="SELECT tblClients.ClCode as ClCode,ContCode,ClFName,Cl1Name,Cl2Name,ContDat,ContOffice,ContProg,ContTarif,ContSum1 "
                . "FROM tblClients, tblP1P2ContReestr WHERE tblClients.ClCode=tblP1P2ContReestr.ClCode AND ContOffice=?";
        $Branch='Томск';
        return db::getInstance()->fetch_all2($Sql,[$Branch]);
    }
    
    public function getCalend1($ContCode){
        $Sql="SELECT * FROM tblP1PayCalend WHERE PayContCode=? AND (PayDat BETWEEN ? AND ?)";
        return db::getInstance()->fetch_all2($Sql,[$ContCode]);
    }
    
    public function getCalend2($ContCode){
        $Sql="SELECT * FROM tblP2PayCalend WHERE PayContCode=? AND (PayDat BETWEEN ? AND ?)";
        return db::getInstance()->fetch_all2($Sql,[$ContCode]);
    }
    
    public function getCalend3($ContCode){
        $Sql="SELECT * FROM tblP2PayCalendCred WHERE PayContCode=? AND (PayDat BETWEEN ? AND ?)";
        return db::getInstance()->fetch_all2($Sql,[$ContCode]);
    }
}
