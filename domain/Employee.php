<?php

#namespace AltTech\Domain;
/**
 *для создания объекта "сотрудник" и его использования в других классах
 *
 * @author Andrey
 */
class Employee {
    protected $Emp;
    protected $EmpList;
    protected $EmpDov;
    
    public function __construct($EmpName){
        $this->Emp=(new ATEmployeeMod())->getEmpName($EmpName);
        $this->EmpList=(new ATEmployeeMod())->GetEmpListAct();
        $this->EmpDov=(new ATEmployeeMod())->getEmpDovName($EmpName);
    }
    
    public function getEmp(){
        return $this->Emp;
    }
    
    public function getEmpList(){
        return $this->EmpList;
    }
    
    public function getEmpDov(){
        return $this->EmpDov;
    }
    
}
