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
        $Sql="SELECT FIRST 200 * FROM tbl7ReferProg WHERE Status=1 ORDER BY ID DESC";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function GetAgentFullList(){
        $Sql="SELECT * FROM tbl7ReferProg WHERE Status=1 ORDER BY ID DESC";
        return $this->Data=db2::getInstance()->FetchAll($Sql,[]);
    }
    
    public function GetAgentListDate($DateF,$DateL){
        $Sql="SELECT * FROM tbl7ReferProg WHERE Status=1 AND lgDate BETWEEN ? AND ? ORDER BY ID DESC";
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
    
    public function GetAgentByName($Name){
        $Sql="SELECT * FROM tbl7ReferProg WHERE Status=1 AND Name LIKE ?";
        return $this->Data=db2::getInstance()->FetchAll($Sql,["%".$Name."%"]);
    }
    
    public function GetAgentByCode($Code){
        $Sql="SELECT * FROM tbl7ReferProg WHERE Status=1 AND ((Code LIKE ?) OR (Code=?))";
        return $this->Data=db2::getInstance()->FetchAll($Sql,["%".$Code."%",$Code]);
    }
    
    public function GetAgentByFullCode($Code){
        $Sql="SELECT * FROM tbl7ReferProg WHERE Status=1 AND Code=?";
        return $this->Data=db2::getInstance()->FetchAll($Sql,["%".$Code."%"]);
    }
    
    public function GetAgentByPhone($Phone){
        $Sql="SELECT * FROM tbl7ReferProg WHERE Status=1 AND Phone LIKE ?";
        return $this->Data=db2::getInstance()->FetchAll($Sql,["%".$Phone."%"]);
    }
    
    public function UpdAgent($ID,$Name,$Code,$Refer,$Phone){
        $Sql="UPDATE tbl7ReferProg SET Name=?,Code=?,Refer=?,Phone=? WHERE ID=?";
        db2::getInstance()->FetchOne($Sql,[$Name,$Code,$Refer,$Phone,$ID]);
    }
    
    public function DelAgent($ID,$Comment){
        $Sql="UPDATE tbl7ReferProg SET Status=?,DelComment=? WHERE ID=?";
        db2::getInstance()->FetchOne($Sql,[2,$Comment,$ID]);
    }
            
            
}
