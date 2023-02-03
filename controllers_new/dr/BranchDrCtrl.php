<?php
/**
 * контроллер управления справочниками
 *
 * функции
 * 1. открыть карточку филиала
 * 2. 
 * 3. удалить значение из справочника
 
 */
class BranchDrCtrl extends ControllerMain {
    protected $Branch;
    
    public function actionIndex(){
        $this->Branch=(new BranchRecMod)->getBranchById($_GET['BranchID']);
        $Args=['Branch'=>$this->Branch];
        $this->render('dr/ATDrBranchFile',$Args);
    } 
    
    public function actionBranchUpd(){
        $ToQuery='';
        $Params=[];
        $Params[0]=$_GET['ID'];
        foreach($_GET as $Key => $Value){
            if(($Key!='controller')&&($Key!='action')&&($Key!='ID')){
                $Params[$Key]=$Value;
                $ToQuery=$ToQuery.",{$Key}=?";
            }            
        }
        $Params['ID']=$_GET['ID'];
        (new BranchRecMod())->updBranch($Params, $ToQuery);
        header("Location: index_admin.php?controller=BranchDrCtrl&BranchID={$_GET['ID']}");
    }
    
    
}
