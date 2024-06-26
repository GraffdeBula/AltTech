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
    
    //справочник организаций
    public function actionShowDROrg(){
        $this->ViewName='Справочник организаций';
        $Args=['OrgList'=>(new OrgRecMod)->getOrgList()];
        $this->render('dr/ATDrOrg',$Args);
    }
    
    public function actionOrgAdd(){
        (new OrgRecMod)->addOrg($_GET['ORGNAME'],$_GET['ORGPREF']);
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
    //справочник регионов
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

    //справочник сотрудников
    public function actionShowDREmployee(){
        $this->ViewName='Справочник сотрудников';
        $Args=['EmpList'=>(new ATEmployeeMod)->GetEmpListAct(),'BrList'=>(new ATDrBranchMod)->GetBrList()];
        $this->render('dr/ATDrEmployee',$Args);
    }
    
    public function actionEmpSearch(){
        $this->ViewName='Справочник сотрудников';
        $Model=new ATEmployeeMod();                
        
        $EmpList=$Model->getEmpSearchAct($_GET['EmpBranch'],$_GET['EmpRole']);
        
        #new MyCheck($EmpList,0);
        
        $Args=['EmpList'=>$EmpList,'BrList'=>(new ATDrBranchMod)->GetBrList()];
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
    //справочник доверенностей сотрудников
    public function actionShowDREmpDov(){
        $this->ViewName='Справочник доверенностей';
        $Args=['DovList'=>(new ATEmployeeMod)->getEmpDovList()];
        $this->render('dr/ATDrEmpDov',$Args);
    }
    
    public function actionEmpDovAdd(){
        (new ATEmployeeMod)->addEmpDov($_GET['EmName'],$_GET['EmDov']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDREmpDov");
    }
    
    public function actionEmpDovUpd(){
        (new ATEmployeeMod)->updEmpDov($_GET['EmName'],$_GET['EmDov'],$_GET['EmDovDate'],$_GET['EmDovEndDate'],$_GET['EmDovComment'],$_GET['Id']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDREmpDov");
    }
    
    //### справочники вторая колонка
    //справочник пакетов тарифов
    public function actionShowDRPac(){
        $this->ViewName='Справочник пакетов';
        $Model=new TarifMod();
        $Args=['PacList'=>$Model->getPacFullList()];
        $this->render('dr/ATDrPac',$Args);
    }
    
    public function actionAddPac(){        
        $Model=new TarifMod();
        $Model->addPac($_GET['PCPROG'],$_GET['PCPAC'],$_GET['PCACT'],$_GET['PCTEMPLATEROOT'],$_GET['PCBOOKMARKSLIST'],$_GET['PCPERIOD']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRPac");
    }
    
    public function actionUpdPac(){        
        $Model=new TarifMod();
        #$Model->addPac();
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRPac");
    }
    
    public function actionDelPac(){        
        $Model=new TarifMod();
        $Model->delPac($_GET['Id']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRPac");
    }
    
    //справочник тарифов
    public function actionShowDRTarif(){
        $this->ViewName='Справочник тарифов';
        $Model=new TarifMod();
        $Args=['TarifList'=>$Model->getTarifFullList()];
        $this->render('dr/ATDrTarif',$Args);
    }
    
    public function actionAddTarif(){        
        $Model=new TarifMod();
        $Model->addTarif($_GET['TRSTATUS'],$_GET['TRDATE'],$_GET['TRNAME'],$_GET['TRCOMMENT'],$_GET['TRPAC'],$_GET['TRSUMMIN'],$_GET['TRSUMMAX'],
            $_GET['TRTYPE'],$_GET['TRSUMFIX'],$_GET['TRSUMANN'],$_GET['TRSUMPERC']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRTarif");
    }
    
    public function actionUpdTarif(){        
        $Model=new TarifMod();
        #$Model->addPac();
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRTarif");
    }
    
    public function actionDelTarif(){        
        $Model=new TarifMod();
        $Model->delTarif($_GET['Id']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRTarif");
    }
    
    //справочник единого тарифа
    public function actionShowDRTarif2(){
        $this->ViewName='Справочник единого тарифа';
        $Model=new TarifMod();
        $Args=['TarifList'=>$Model->getTarifElList()];
        $this->render('dr/ATDrTarifEl',$Args);
    }
    public function actionAddTarifEl(){
        $Model=new TarifMod();
        $Model->addTarifEl($_GET['ELTYPE'],$_GET['ELNAME'],$_GET['ELSUM']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRTarif2");
    }
    
    //справочник типов пакетов по филиалам
    public function actionShowDRPacBranch(){
        $this->ViewName='Справочник пакетов по филалам';
        $Model=new TarifMod();
        $Args=['PacList'=>$Model->getPacBranchList()];
        $this->render('dr/ATDrPacBranch',$Args);
    }
    
    public function actionUpdPacBr(){        
        (new TarifMod())->updPacBranch($_GET['PacId'],$_GET['PacContType']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRPacBranch");
    }
    
    //### справочники третья колонка
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
    //справочник прочих организаций
    public function actionShowDROrganizations(){
        $this->ViewName='Справочник прочих организаций';
        $Args=['OrgList'=>(new OrganizationsMod())->getOrgList(),'RegList'=>(new ATDrRegionsMod)->GetRegList()];        
        $this->render('dr/ATDrOrganizations',$Args);
    }
    
    public function actionOrganizationAdd(){      
        (new OrganizationsMod())->addOrganization($_GET['ORGNAME'],$_GET['ORGTYPE'],$_GET['ORGREGION'],$_GET['ORGADDRESS'],$_GET['ORGADRNAME'],$_GET['ORGPHONE']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDROrganizations");
    }
    
    public function actionOrganizationUpd(){        
        (new OrganizationsMod())->updOrganization($_GET['ID'],$_GET['ORGNAME'],$_GET['ORGTYPE'],$_GET['ORGREGION'],$_GET['ORGADDRESS'],$_GET['ORGADRNAME'],$_GET['ORGPHONE']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDROrganizations");
    }
    
    public function actionOrganizationDel(){   
        (new OrganizationsMod())->delOrganization($_GET['ID']);
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDROrganizations");
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
        header("Location: index_admin.php?controller=ATDRCtrl&action=ShowDRBookmarks&DocName={$_GET['BMDOCNAME']}&Model={$_GET['BMTABLE']}");
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

    //###########справочник рисков по экспертизе
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
    
    //###########справочник полей для анкеты кредита
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
    
    
}
