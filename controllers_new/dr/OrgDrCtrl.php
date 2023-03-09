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
        (new OrgRecMod)->UpdOrg([$_GET['ORGPREF'],$_GET['ORGNAME'],$_GET['ORGFNAME'],
            $_GET['ORGOGRN'],$_GET['ORGINN'],$_GET['ORGKPP'],$_GET['ORGOFADR'],$_GET['ORGEMAIL'],$_GET['ORGDIRNAME'],
            $_GET['ORGBANKNAME'],$_GET['ORGBANKACC'],$_GET['ORGBANKBIK'],$_GET['ORGBANKCORR'],$_GET['OrgID']]);
        header("Location: index_admin.php?controller=OrgDrCtrl&OrgID={$_GET['OrgID']}");
    }
    
    
}
