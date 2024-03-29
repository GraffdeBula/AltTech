<?php
/**
 * контроллер управления справочниками
 *
 * функции
 * 1. открыть карточку сотрудника
 * 2. изменить данные сотрудника
 * 3. изменить пароль сотрудника
 * сделать 4. добавить доверенность сотрудника
 * сделать 
 */
class ATEmpCtrl extends ControllerMain {
    protected $Employee;
    
    public function actionIndex(){
        $this->Employee=(new ATEmployeeMod)->GetEmp($_GET['EmpID']);
        $Args=['Employee'=>$this->Employee];
        $this->render('dr/ATDrEmpFile',$Args);
    } 
    
    public function actionEmpUpd(){
        (new ATEmployeeMod)->UpdEmp([$_GET['EMNAME'],$_GET['EMLOGIN'],$_GET['EMSEX'],$_GET['EMBRANCH'],$_GET['EMPOS'],
            $_GET['EMROLE'],$_GET['EMFNAME1'],$_GET['EMFNAME2'],$_GET['EMFNAME3'],$_GET['EMSTATUS'],$_GET['EmpID']]);
        header("Location: index_admin.php?controller=ATEmpCtrl&EmpID={$_GET['EmpID']}");
    }
    
    public function actionEmpPassUpd(){
        (new ATEmployeeMod)->UpdEmpPass([md5($_GET['EMPASS']),$_GET['EmpID']]);
        header("Location: index_admin.php?controller=ATEmpCtrl&EmpID={$_GET['EmpID']}");
    }
    
    public function actionEmpPasportUpd(){
        (new ATEmployeeMod())->UpdEmpPasport([$_GET['EMDATEBIRTH'],$_GET['EMPASSER'],$_GET['EMPASNUM'],$_GET['EMPASORG'],
            $_GET['EMPASDATE'],$_GET['EMPASCODE'],$_GET['EMADRREG'],$_GET['EmpID']]);
        header("Location: index_admin.php?controller=ATEmpCtrl&EmpID={$_GET['EmpID']}");
    }
                
}
