<?php

class RepCurPaysMod extends Model{    
    protected $Data=[];
    
    public function getClList(){
        $sql="SELECT FIRST 25 clFNAme,cl1Name,cl2Name,ContDat,ContOffice,ContSum1,PkoSum "
                . "FROM tblClients INNER JOIN tblP1P2ContReestr ON tblClients.ClCode=tblP1P2ContReestr.ClCode "
                . "INNER JOIN vwPkoTotal ON tblP1P2ContReestr.ContCode=vwPkoTotal.ContCode ORDER BY tblP1P2ContReestr.ContCode DESC";
        return db::getInstance()->fetch_all($sql);
    }
        
    public function getP1AnketaList($Branch){
        $Sql=("SELECT tblClients.ClCode,ClFName,Cl1Name,Cl2Name,tblP1Anketa.ContCode,frContDate,frContSum,frContTarif,frOffice FROM tblClients "
                . "INNER JOIN tblP1Anketa ON tblClients.ClCode=tblP1Anketa.ClCode "
                . "INNER JOIN tblP1Front ON tblP1Anketa.ContCode=tblP1Front.ContCode WHERE frOffice=? AND frContDate>=?");
        return $this->Data=db2::getInstance()->FetchAll($Sql,[$Branch,'01.01.2000']);    
    }
    
    public function getP1Pays($DatF,$DatL){
        $Sql=("SELECT * FROM tblP1PayCalend WHERE PayDate BETWEEN ? AND ?");
        return $this->Data=db2::getInstance()->FetchAll($Sql,[$DatF,$DatL]);
    }
    
    public function getPaysCalend($ContCode){
        return $this->Data=db2::getInstance()->FetchAll("SELECT * FROM tblP1PayCalend WHERE ContCode=?");
    }

    
}
