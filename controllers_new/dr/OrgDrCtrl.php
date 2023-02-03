<?php
/**
 * контроллер управления справочниками
 *
 * функции
 * 1. открыть карточку организации
 * 2. обновить данные
 *
 *
 */
class OrgDrCtrl extends ControllerMain {
    protected $Org;
    
    public function actionIndex(){
        $this->Org=(new OrgRecMod)->getOrgById($_GET['OrgID']);
        $Args=['Org'=>$this->Org];
        $this->render('dr/ATDrOrgFile',$Args);
    } 
    
    public function actionOrgUpd(){
        (new OrgRecMod)->UpdEmp([$_GET['EMNAME'],$_GET['EMLOGIN'],$_GET['EMSEX'],$_GET['EMBRANCH'],$_GET['EMPOS'],$_GET['EMROLE'],$_GET['EmpID']]);
        header("Location: index_admin.php?controller=ATEmpCtrl&EmpID={$_GET['EmpID']}");
    }
    
    
}
