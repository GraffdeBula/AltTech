<?php

#namespace AltTech\Domain;
/**
 *для создания объекта "сотрудник" и его использования в других классах
 *
 * @author Andrey
 */
class Employee {
    protected $Emp;
    protected $EmpDov;
    
    public function __construct($EmpName){
        $this->Emp=(new ATEmployeeMod())->getEmpName($EmpName);
        $this->EmpDov=(new ATEmployeeMod())->getEmpDovName($EmpName);
    }
    
    public function getEmp(){
        return $this->Emp;
    }
    
    public function getEmpDov(){
        return $this->EmpDov;
    }
    
}
