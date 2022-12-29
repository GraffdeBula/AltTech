<?php

class ATEmployeeMod extends Model{
    protected $Data;    
    public function GetEmpWorkData(){ //метод возвращает строку из таблицы Employee по логину и паролю (при авторизации) для помещения в сессию. переименовать метод
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tbl9DrEmployee WHERE emLogin=? and emPass=?;",[$_SESSION['login'],md5($_SESSION['pass'])]);
    }
    
    public function GetEmpList(){//возвращает список сотрудников
        return db2::getInstance()->FetchAll("SELECT * FROM tbl9DrEmployee ",[]);
    }
   
    public function AddEmpDr($EmpName,$EmpBranch){//добавить сотрудника
       db2::getInstance()->Query("INSERT INTO tbl9DrEmployee (EmName,EmBranch) VALUES (?,?)",[$EmpName,$EmpBranch]);       
    }
   
    public function DelEmpDr($EmpID){//удалить сотрудника
       db2::getInstance()->Query("DELETE FROM tbl9DrEmployee WHERE ID=?",[$EmpID]);
    }

    public function UpdEmp($Param){//изменить информацию по сотруднику
       db2::getInstance()->Query("UPDATE tbl9DrEmployee SET EMNAME=?, EMLOGIN=?,EMSEX=?,EMBRANCH=?,EMPOS=?,EMROLE=? WHERE ID=?",$Param);
    }
    
    public function UpdEmpPass($Param){//изменение пароля
        db2::getInstance()->Query("UPDATE tbl9DrEmployee SET EMPASS=? WHERE ID=?",$Param);
    }
    
    public function GetEmp($EmpID){//выбирает сотрудника из таблицы по Id
       return db2::getInstance()->FetchOne("SELECT * FROM tbl9DrEmployee WHERE ID=?",[$EmpID]);
    }
                      
}
