<?php
/**
 * модель для работы с реферальной программой
 * получение списка агентов
 * инсерт нового агента
 * получение ID для формирования промокода
 * апдейт для сохранения кода и ссылки
 */
class AT7ReferProg extends Model{
    public function GetAgentList(){
        $Sql="SELECT * FROM tbl7ReferProg ORDER BY ID DESC";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function GetAgentListDate($DateF,$DateL){
        $Sql="SELECT * FROM tbl7ReferProg WHERE lgDate BETWEEN ? AND ? ORDER BY ID DESC";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[$DateF,$DateL]);
    }
    
    public function InsAgent($Name,$Phone,$EmName){
        $Sql="INSERT INTO tbl7ReferProg (Name,Phone,lgEmp) VALUES (?,?,?)";        
        return $this->Data=db2::getInstance()->Query($Sql,[$Name,$Phone,$EmName]);
    }
    
    public function GetAgent($Name){
        $Sql="SELECT * FROM tbl7ReferProg WHERE Name=?";
        return $this->Data=db2::getInstance()->FetchOne($Sql,[$Name]);
    }
    
    public function UpdAgent($ID,$Name,$Code,$Refer){
        $Sql="UPDATE tbl7ReferProg SET Name=?,Code=?,Refer=? WHERE ID=?";
        db2::getInstance()->FetchOne($Sql,[$Name,$Code,$Refer,$ID]);
    }
    
    public function DelAgent($ID){
        
    }
            
            
}
