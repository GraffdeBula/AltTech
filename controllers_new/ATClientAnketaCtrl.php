<?php
/**
 * контроллер управления анкетой клиента
 *
 * функции
 * показать анкету клиента
 * сохранить информацию в основной таблице (по блокам)
 * сохранить информацию в связанной таблице "документы"
 * сохранить информацию в связанной таблице "телефоны"
 * сохранить информацию в связанной таблице "доходы"
 * сохранить информацию в связанной таблице "собственность"
 * сохранить информацию в связанной таблице "родственники"
 */
class ATClientAnketaCtrl extends ControllerMain {
    protected $Params=[];    
    protected $Client;
    protected $ClPhoneList;
    
    public function actionIndex(){        
        $this->ShowAnketa();
    }
    
    //сохранение информации (по блокам) в основную таблицу
    //*сохранение блока "Общая информация"
    public function actionSaveClient(){
        $Model=new ATClientMod();
        $Model->updClient(['CLFNAME'=>$_GET['CLFNAME'],'CL1NAME'=>$_GET['CL1NAME'],'CL2NAME'=>$_GET['CL2NAME'],'CLSEX'=>$_GET['CLSEX'],'CLBIRTHPLACE'=>$_GET['CLBIRTHPLACE'],'CLBIRTHDATE'=>$_GET['CLBIRTHDATE']],$_GET['ClCode']);
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    //*сохранение блока "адреса и контакты"
    public function actionSaveClEmail(){
        $Model=new ATClientMod();
        $Model->updClient(['CLEMAIL'=>$_GET['CLEMAIL']],$_GET['ClCode']);
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionSaveClAdrR(){
        $Model=new ATClientMod();
        $Model->updClient(['CLADRRZIP'=>$_GET['CLADRRZIP'],'CLADRRREG'=>$_GET['CLADRRREG'],'CLADRRDIST'=>$_GET['CLADRRDIST'],
            'CLADRRCITY'=>$_GET['CLADRRCITY'],'CLADRRSTR'=>$_GET['CLADRRSTR'],'CLADRRHOUSE'=>$_GET['CLADRRHOUSE'],'CLADRRCORP'=>$_GET['CLADRRCORP'],'CLADRRAPP'=>$_GET['CLADRRAPP'],
            'CLADRRPROPYN'=>$_GET['CLADRRPROPYN'],'CLADRRCOMMENT'=>$_GET['CLADRRCOMMENT'] ],$_GET['ClCode']);
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionSaveClAdrF(){
        $Model=new ATClientMod();
        $Model->updClient(['CLADRFZIP'=>$_GET['CLADRFZIP'],'CLADRFREG'=>$_GET['CLADRFREG'],'CLADRFDIST'=>$_GET['CLADRFDIST'],
            'CLADRFCITY'=>$_GET['CLADRFCITY'],'CLADRFSTR'=>$_GET['CLADRFSTR'],'CLADRFHOUSE'=>$_GET['CLADRFHOUSE'],'CLADRFCORP'=>$_GET['CLADRFCORP'],'CLADRFAPP'=>$_GET['CLADRFAPP'],
            'CLADRFPROPYN'=>$_GET['CLADRFPROPYN'],'CLADRFCOMMENT'=>$_GET['CLADRFCOMMENT'] ],$_GET['ClCode']);
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    public function actionCopyAdr(){        
        $Model=new ATClientMod();
        $Client=$Model->GetClientById($_GET['ClCode']);
        $Model->updClient(['CLADRFZIP'=>$Client->CLADRRZIP,'CLADRFREG'=>$Client->CLADRRREG,'CLADRFDIST'=>$Client->CLADRRDIST,
            'CLADRFCITY'=>$Client->CLADRRCITY,'CLADRFSTR'=>$Client->CLADRRSTR,'CLADRFHOUSE'=>$Client->CLADRRHOUSE,'CLADRFCORP'=>$Client->CLADRRCORP,'CLADRFAPP'=>$Client->CLADRRAPP,
            'CLADRFPROPYN'=>$Client->CLADRRPROPYN,'CLADRFCOMMENT'=>$Client->CLADRRCOMMENT],$_GET['ClCode']);
        #var_dump($Client);    
        #exit();
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    //*сохранение блока "семья"
    public function actionSaveClFamily(){
        $Model=new ATClientMod();
        $Model->updClient(['CLFAMSTATUS'=>$_GET['CLFAMSTATUS'],'CLFAMPARTNAME'=>$_GET['CLFAMPARTNAME'],'CLCHILDNUM'=>$_GET['CLCHILDNUM'],
            'CLMARRIAGEDATE'=>$_GET['CLMARRIAGEDATE'],'CLDIVORCEDATE'=>$_GET['CLDIVORCEDATE'],'CLALIMENTYN'=>$_GET['CLALIMENTYN'],
            'CLALIMENTSUM'=>$_GET['CLALIMENTSUM']],$_GET['ClCode']);
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    //*сохранение блока "ЮрСтатус"
    public function actionSaveClForDocs(){
        $Model=new ATClientMod();
        $Model->updClient(['ClNameRP'=>$_GET['ClNameRP'],'ClNameDP'=>$_GET['ClNameDP'],'ClNameTP'=>$_GET['ClNameTP'],
            'CLADMRESPYN'=>$_GET['CLADMRESPYN'],'CLCRIMINALRESPYN'=>$_GET['CLCRIMINALRESPYN']],$_GET['ClCode']);
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionSaveClIpoteka(){
        $Model=new ATClientMod();
        $Model->updClient(['ClIpotekaYN'=>$_GET['ClIpotekaYN'],'ClIpotekaStatus'=>$_GET['ClIpotekaStatus'],'ClIpotekaBank'=>$_GET['ClIpotekaBank'],
            'ClIpotekaType'=>$_GET['ClIpotekaType'],'ClIpotekaAdr'=>$_GET['ClIpotekaAdr'],'ClIpotekaCost'=>$_GET['ClIpotekaCost'],
                'ClIpotekaCurSum'=>$_GET['ClIpotekaCurSum']],$_GET['ClCode']);
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionSaveClBusiness(){
        $Model=new ATClientMod();
        $Model->updClient(['CLINDENTRYN'=>$_GET['CLINDENTRYN'],'CLINDENTRACT'=>$_GET['CLINDENTRACT'],'CLINDENTROPENDATE'=>$_GET['CLINDENTROPENDATE'],
            'CLINDENTRCLOSEDATE'=>$_GET['CLINDENTRCLOSEDATE'],'CLLTDYN'=>$_GET['CLLTDYN'],'CLLTDACT'=>$_GET['CLLTDACT'],
                'CLLTDOPENDATE'=>$_GET['CLLTDOPENDATE'],'CLLTDCLOSEDATE'=>$_GET['CLLTDCLOSEDATE']],$_GET['ClCode']);
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionSaveClWork(){
        $Model=new ATClientMod();
        $Model->updClient(['CLWORKSTATUS'=>$_GET['CLWORKSTATUS'],'CLWORKORG'=>$_GET['CLWORKORG'],'CLWORKPOS'=>$_GET['CLWORKPOS'],
            'CLWORKPERIOD'=>$_GET['CLWORKPERIOD'],'CLWORKORGADR'=>$_GET['CLWORKORGADR'],'CLWORKORGINN'=>$_GET['CLWORKORGINN'],
                'CLWORKPARTSTATUS'=>$_GET['CLWORKPARTSTATUS'],'CLWORKPARTORG'=>$_GET['CLWORKPARTORG'],'CLWORKPARTPOS'=>$_GET['CLWORKPARTPOS']],$_GET['ClCode']);
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    
                
    //добавдение записей в связанные таблицы, удаление записей
    public function actionAddPhone(){
        if ((isset($_GET['ClPhone']))&&($_GET['ClPhone']!='')){
            $Model=new ATClientMod();
            $Model->InsPhone($_GET['ClCode'],$_GET['ClPhone'],$_GET['ClPhText'],$_GET['ClPhComment']);        
        }
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionDelPhone(){        
        $Model=new ATClientMod();
        $Model->DelPhone($_GET['ClCode'],$_GET['ClPhID']);
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionAddRelative(){
        if ((isset($_GET['ClRelName']))&&($_GET['ClRelName']!='')){
            $Model=new ATClientMod();
            $Model->InsRelative($_GET['ClCode'],$_GET['ClRelStatus'],$_GET['ClRelName'],$_GET['ClRelBirthDate'],$_GET['ClRelDocSer'],$_GET['ClRelDocNum'],$_GET['ClRelDocDate']);        
        }
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionDelRelative(){        
        $Model=new ATClientMod();
        $Model->DelRelative($_GET['ClCode'],$_GET['ClRelID']);
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionAddDocument(){
        if ((isset($_GET['ClDocName']))&&($_GET['ClDocName']!='')){
            $Model=new ATClientMod();
            $Model->InsDoc($_GET['ClCode'],$_GET['ClDocName'],$_GET['ClDocSer'],$_GET['ClDocNum'],$_GET['ClDocComment'],
                    $_GET['ClDocOrg'],$_GET['ClDocDate'],$_GET['ClDocAttr1'],$_GET['ClDocAttr2'],$_GET['ClDocAttr3']);        
        }
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionUpdDocument(){        
        $Model=new ATClientMod();
        $Model->UpdDocument($_GET['ClCode'],$_GET['ClDocID'],$_GET['ClDocName'],$_GET['ClDocSer'],$_GET['ClDocNum'],$_GET['ClDocComment'],
                    $_GET['ClDocOrg'],$_GET['ClDocDate'],$_GET['ClDocAttr1']);        
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionDelDocument(){        
        $Model=new ATClientMod();
        $Model->DelDocument($_GET['ClCode'],$_GET['ClDocID']);        
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionAddIncome(){
        if ((isset($_GET['ClIncName']))&&($_GET['ClIncName']!='')){
            $Model=new ATClientMod();
            $Model->InsIncome($_GET['ClCode'],$_GET['ClIncName'],$_GET['ClIncSum'],$_GET['ClIncSumOf'],$_GET['ClIncCardYN'],$_GET['ClIncBank'],$_GET['ClIncDeduct'],
                $_GET['ClIncSumReal'],$_GET['ClIncComment'],$_GET['ClIncPensDate']);        
        }
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");   
    }
    
    public function actionDelIncome(){        
        $Model=new ATClientMod();
        $Model->DelIncome($_GET['ClCode'],$_GET['ClIncID']);        
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionAddProperty(){
        if ((isset($_GET['ClPropType']))&&($_GET['ClPropType']!='')){
            $Model=new ATClientMod();
            $Model->InsProperty($_GET['ClCode'],$_GET['ClPropType'],$_GET['ClPropOwner'],$_GET['ClPropDesc'],$_GET['ClPropCost'],$_GET['ClPropDate'],
                    $_GET['ClPropComment'],$_GET['ClPropDocumentsYN']);        
        }
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionDelProp(){        
        $Model=new ATClientMod();
        $Model->DelProperty($_GET['ClCode'],$_GET['ClPropID']);        
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionAddDeal(){
        if ((isset($_GET['ClDlObj']))&&($_GET['ClDlObj']!='')){
            $Model=new ATClientMod();
            $Model->InsDeal($_GET['ClCode'],$_GET['ClDlType'],$_GET['ClDlObj'],$_GET['ClDlSum'],$_GET['ClDlDate'],$_GET['ClDlComment'],$_GET['ClDlDocumentsYN'],$_GET['ClDlOwner']);        
        }
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionDelDeal(){        
        $Model=new ATClientMod();
        $Model->DelDeal($_GET['ClCode'],$_GET['ClDlID']);        
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }
    
    public function actionAddBankAcc(){
        if ((isset($_GET['ClBnAcc']))&&($_GET['ClBnAcc']!='')){
            $Model=new ATClientMod();
            $Model->InsBankAcc($_GET['ClCode'],$_GET['ClBnAcc'],$_GET['ClBnName'],$_GET['ClBnComment'],$_GET['ClBnSum'],$_GET['ClBnOpenDate'],$_GET['ClBnCloseDate']);        
        }
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");        
    }
    
    public function actionDelBankAcc(){        
        $Model=new ATClientMod();
        $Model->DelBankAcc($_GET['ClCode'],$_GET['ClAccID']);        
        header("Location: index_admin.php?controller=ATClientAnketaCtrl&ClCode={$_GET['ClCode']}");
    }

    protected function ShowAnketa(){
        $Model=new ATClientMod();
        $this->Client=$Model->GetClientById($_GET['ClCode']);        
        $this->ViewName='Анкета клиента '.$this->Client->CLFNAME;
        $args=['Client'=>$this->Client,
            'ClPhoneList'=>$Model->GetClPhoneList($_GET['ClCode']),            
            'ClRelativesList'=>$Model->GetClRelativesList($_GET['ClCode']),
            'ClDocumentsList'=>$Model->GetClDocumentsList($_GET['ClCode']),
            'ClIncomesList'=>$Model->GetClIncomesList($_GET['ClCode']),
            'ClPropertyList'=>$Model->GetClPropertyList($_GET['ClCode']),
            'ClDealsList'=>$Model->GetClDealsList($_GET['ClCode']),
            'ClBankAccsList'=>$Model->GetClBankAccsList($_GET['ClCode'])
        ];
        $this->render('ATClientAnketa',$args);
    }
}
