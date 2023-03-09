<?php

/**
 * модель для работы с пакетами и тарифами
 *
 * @author Andrey
 */
class TarifMod extends Model{
    protected $Data=[]; //для полученных данных
        
    public function getTarifList(){
        $Sql="SELECT TrName FROM tblp1tarif WHERE TrStatus=? GROUP BY TrName";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[1]);
    }

    public function getTarifFullList(){
//        $Sql="INSERT INTO tblP1Tarif (trStatus,trName,trComment,trPac,trSumMin,trSumMax,trType,trSumFix,trSumAnn) 
//            VALUES (?,?,?,?,?,?,?,?,?)";
//        db2::getInstance()->Query($Sql,$Params);
        return [];
    }

    public function getPacList(){
//        $sql="SELECT * FROM tblP1P2pacs WHERE pcID>=528 ORDER BY pcPac";
//        return $this->Data=db::getInstance()->fetch_all($sql);
        return [];
    }
    
    public function getTarif($TrName,$DebtSum){
        $Sql="SELECT * FROM tblp1tarif WHERE TrName=? AND TrSumMin<=? AND TrSumMax>=?";
        return $this->Data=db2::getInstance()->FetchOne($Sql,[$TrName,$DebtSum,$DebtSum]);
    }
           
}
