<?php
/**
 * контроллер управления справочниками
 *
 * функции
 * 1. открыть справочник (по имени), показать вьюшку с таблицей
 * 2. добавить значение в справочник
 * 3. удалить значение из справочника
 * опционально 4. исправить значение в справочнике
 */
class ATDRCtrl extends ControllerMain {
    
    public function actionIndex(){ //если действие не передано, то уходим в главное меню
        header("Location: index_admin.php?controller=AdminMainController");
    }            
    //Справочник регионов
    public function actionShowDRRegions(){
        $Args=['RegList'=>(new ATDrRegionsMod)->GetRegList()];
        $this->render('dr/ATDrRegions',$Args);
    }
    
    public function actionRegionAdd(){
        (new ATDrRegionsMod)->RegIns($_GET['REGNAME']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRRegions");
    }
    
    public function actionRegionDel(){
        (new ATDrRegionsMod)->RegDel($_GET['RegID']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRRegions");
    }    
    //справочник рисков по экспертизе
    public function actionShowDRExpRisks(){
        $this->ViewName='Справочник рисков по ЭПЭ';
        $Args=['RiskList'=>(new ExpertMod)->GetRiskDr(['Risk'])];
        $this->render('dr/ATDrRisks',$Args);
    }
    
    public function actionExpRiskAdd(){
        (new ExpertMod)->AddRiskDr($_GET['ExpRisk']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRExpRisks");
    }
    
    public function actionExpRiskDel(){
        (new ExpertMod)->DelRiskDr($_GET['ExpRiskID']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRExpRisks");
    }
    
    //справочник полей для анкеты кредита
    public function actionShowDRCredit(){
        $this->ViewName='Справочник анкеты кредита';
        $Args=['AnketaList'=>(new ATP1CredMod)->GetAnketaDr()];
        $this->render('dr/ATDrCredit',$Args);
    }
    
    public function actionCreditDrAdd(){
        (new ATP1CredMod)->AddAnketaDr($_GET['DrName'],$_GET['DrValue']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRCredit");
    }
    
    public function actionCreditDrDel(){
        (new ATP1CredMod)->DelAnketaDr($_GET['DrID']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRCredit");
    }
    
    //справочник сотрудников
    public function actionShowDREmployee(){
        $this->ViewName='Справочник сотрудников';
        $Args=['EmpList'=>(new ATEmployeeMod)->GetEmpList(),'BrList'=>(new ATDrBranchMod)->GetBrList()];
        $this->render('dr/ATDrEmployee',$Args);
    }
    
    public function actionEmpAdd(){
        (new ATEmployeeMod)->AddEmpDr($_GET['EmpName'],$_GET['EmpBranch']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDREmployee");
    }
    
    public function actionEmpDel(){
        (new ATEmployeeMod)->DelEmpDr($_GET['EmpID']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDREmployee");
    }
    //справочник организаций
    public function actionShowDROrg(){
        $this->ViewName='Справочник организаций';
        $Args=['OrgList'=>(new OrgRecMod)->getOrgList()];
        $this->render('dr/ATDrOrg',$Args);
    }
    
    public function actionOrgAdd(){
        (new OrgRecMod)->InsOrg($_GET['ORGNAME']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDROrg");
    }
    
    public function actionOrgDel(){
        (new OrgRecMod)->DelOrg($_GET['OrgID']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDROrg");
    }
    //справочник филиалов
    public function actionShowDRBranch(){
        $this->ViewName='Справочник филиалов';
        $Args=['BrList'=>(new ATDrBranchMod)->GetBrList()];
        $this->render('dr/ATDrBranch',$Args);
    }
    
    public function actionBranchAdd(){
        (new ATDrBranchMod)->InsBranch($_GET['BRNAME']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRBranch");
    }
    
    public function actionBranchDel(){
        (new ATDrBranchMod)->DelBranch($_GET['BranchID']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRBranch");
    }
    
    //справочник банков
    public function actionShowDRBanks(){
        $this->ViewName='Справочник банков';
        $Args=['BankList'=>(new AT8BanksMod)->GetBanksList()];
        $this->render('dr/ATDrBanks',$Args);
    }
    
    public function actionBanksAdd(){        
        if ((isset($_GET['BNINN']))&&($_GET['BNINN']!='')&&(isset($_GET['BNNAME']))&&($_GET['BNNAME']!='')){
            (new AT8BanksMod)->AddBank([$_GET['BNINN'],$_GET['BNOGRN'],$_GET['BNNAME'],$_GET['BNFULLNAME'],$_GET['BNADRREG'],$_GET['BNADRDOP'],
                $_GET['BNEMAIL'],$_GET['BNCOMMENT'],$_GET['BNTYPE']]);
        }
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRBanks");
    }
    
    public function actionBanksUpd(){
        (new AT8BanksMod)->InsBranch($_GET['BRNAME']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRBanks");
    }
    
    public function actionBanksDel(){
        (new AT8BanksMod)->DelBank($_GET['BnID']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRBanks");
    }
    //BOOKMARKS справочник закладок для документов
    public function actionShowDRBookmarks(){
        $this->ViewName='Справочник закладок для документов';
        $Args=['BmList'=>(new Bookmarks)->GetBMList()];
        $this->render('dr/ATDrBookmarks',$Args);
    }
    
    public function actionBookmarkAdd(){
        (new Bookmarks)->InsBm([
            $_GET['BMDOCNAME'],
            $_GET['BMNAME'],
            $_GET['BMTABLE'],
            $_GET['BMFIELD'],
            $_GET['BMTYPE'],
            $_GET['BMCHANGE'],
            $_GET['BMCHECKDATA'],
            $_GET['BMINSDATA']            
        ]);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRBookmarks");
    }
    
    public function actionBookmarkDel(){
        (new Bookmarks)->DelBm($_GET['BmID']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRBookmarks");
    }
    
    public function actionCopyBM(){
        /*
        $List=(new Bookmarks)->CopyBm();
        foreach($List as $Key => $Bm){
            (new Bookmarks)->InsBm([
                'ContNewType1',
                $Bm->BMNAME,
                $Bm->BMTABLE,
                $Bm->BMFIELD,
                $Bm->BMTYPE,
                $Bm->BMCHANGE,
                $Bm->BMCHECKDATA,
                $Bm->BMINSDATA
            ]);
        }
        */
        /*
        $List=(new Pacs)->CopyTarif();
        
        foreach($List as $Key => $Tarif){
            (new Pacs)->InsTarif([
                $Tarif->TRSTATUS,
                $Tarif->TRNAME,
                $Tarif->TRCOMMENT,
                $Tarif->TRPAC,
                $Tarif->TRSUMMIN,
                $Tarif->TRSUMMAX,
                $Tarif->TRTYPE,
                $Tarif->TRSUMFIX,
                $Tarif->TRSUMANN
            ]);
        }    
        */
        $List=(new Pacs)->CopyPac();
        
        foreach($List as $Key => $Tarif){
            (new Pacs)->InsPac([
                $Tarif->PCPROG,
                $Tarif->PCPAC,
                $Tarif->PCACT,
                $Tarif->PCTEMPLATEROOT,
                $Tarif->PCBOOKMARKSLIST,
                $Tarif->PCPERIOD,
            ]);
        }
        
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRBookmarks");
    }
    
}
