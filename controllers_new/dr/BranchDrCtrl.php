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
        $Params=[$_GET['BRNAME'],$_GET['BRREGION'],$_GET['BRCITY'],$_GET['BRNAMEOLD'],
            $_GET['BRDIR'],$_GET['BRADDRESSFACT'],$_GET['BRKPP'],$_GET['BRORGPREF'],
            $_GET['BRBUCH1'],$_GET['BRKASS1'],$_GET['BRBUCH2'],$_GET['BRKASS2'],$_GET['BranchID']
        ];
        (new BranchRecMod())->updBranch($Params);
        header("Location: index_admin.php?controller=BranchDrCtrl&BranchID={$_GET['BranchID']}");
    }
    
    
}
