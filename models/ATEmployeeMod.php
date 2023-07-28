<?php

class ATEmployeeMod extends Model{
    protected $Data;    
    public function GetEmpWorkData(){ //метод возвращает строку из таблицы Employee по логину и паролю (при авторизации) для помещения в сессию. переименовать метод
        return $this->Data=db2::getInstance()->FetchOne("SELECT * FROM tbl9DrEmployee WHERE emLogin=? and emPass=?;",[$_SESSION['login'],md5($_SESSION['pass'])]);
    }
    
    public function GetEmpList(){//возвращает список сотрудников ВСЕХ
        return db2::getInstance()->FetchAll("SELECT * FROM tbl9DrEmployee ",[]);
    }
    
    public function GetEmpListAct(){//возвращает список сотрудников только тех, кто работает
        return db2::getInstance()->FetchAll("SELECT * FROM tbl9DrEmployee WHERE EmStatus=? ORDER BY EmBranch,EmName",['работает']);
    }
    
    public function getEmpSearchAct($Branch='',$Role=''){//возвращает список сотрудников только тех, кто работает
        if (($Branch=='') && ($Role=='')){
            return db2::getInstance()->FetchAll("SELECT * FROM tbl9DrEmployee WHERE EmStatus=? ORDER BY EmBranch,EmName",['работает']);
        }            
        if (($Branch=='') && ($Role!='')){
            return db2::getInstance()->FetchAll("SELECT * FROM tbl9DrEmployee WHERE EmStatus=? AND EmRole=? ORDER BY EmBranch,EmName",['работает',$Role]);
        }            
        if (($Branch!='') && ($Role=='')){
            return db2::getInstance()->FetchAll("SELECT * FROM tbl9DrEmployee WHERE EmStatus=? AND EmBranch=? ORDER BY EmBranch,EmName",['работает',$Branch]);
        }            
        if (($Branch!='') && ($Role!='')){
            return db2::getInstance()->FetchAll("SELECT * FROM tbl9DrEmployee WHERE EmStatus=? AND EmBranch=? AND EmRole=? ORDER BY EmBranch,EmName",['работает',$Branch,$Role]);
        }               
    }
   
    public function AddEmpDr($EmpName,$EmpBranch){//добавить сотрудника
       db2::getInstance()->Query("INSERT INTO tbl9DrEmployee (EmName,EmBranch,EmStatus) VALUES (?,?,?)",[$EmpName,$EmpBranch,'работает']);       
    }
   
    public function DelEmpDr($EmpID){//удалить сотрудника
       db2::getInstance()->Query("DELETE FROM tbl9DrEmployee WHERE ID=?",[$EmpID]);
    }

    public function UpdEmp($Param){//изменить информацию по сотруднику
       db2::getInstance()->Query("UPDATE tbl9DrEmployee SET EMNAME=?, EMLOGIN=?,EMSEX=?,EMBRANCH=?,EMPOS=?,EMROLE=?,EMFNAME1=?,EMFNAME2=?,EMFNAME3=? WHERE ID=?",$Param);
    }
    
    public function UpdEmpPass($Param){//изменение пароля
        db2::getInstance()->Query("UPDATE tbl9DrEmployee SET EMPASS=? WHERE ID=?",$Param);
    }
    
    public function UpdEmpPasport($Param){//изменить информацию по сотруднику
       db2::getInstance()->Query("UPDATE tbl9DrEmployee SET EMDATEBIRTH=?,EMPASSER=?,EMPASNUM=?,EMPASORG=?,EMPASDATE=?,EMPASCODE=?,EMADRREG=? WHERE ID=?",$Param);
    }
    
    public function GetEmp($EmpID){//выбирает сотрудника из таблицы по Id
       return db2::getInstance()->FetchOne("SELECT * FROM tbl9DrEmployee WHERE ID=?",[$EmpID]);
    }
    
    public function getEmpName($EmName){//выбирает сотрудника из таблицы по Имени
       return db2::getInstance()->FetchOne("SELECT * FROM tbl9DrEmployee WHERE EmName=?",[$EmName]);
    }
    
    public function getEmpDovName($EmName){//выбирает сотрудника из таблицы доверенностей по Имени
       return db2::getInstance()->FetchOne("SELECT * FROM tbl9DrEmpDov WHERE EmName=?",[$EmName]);
    }
                      
}
