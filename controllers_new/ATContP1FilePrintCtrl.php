<?php
/**
 * контроллер для печати документов P1 (из разных вьюшек)
 *
 * функции
 * договор ЭПЭ
 * отчёт об ЭПЭ
 * договор услуг
 * отчёт о процедуре БФЛ
 * доверенность для нотариуса
 * доверенность - предоверие
 * 
 */
class ATContP1FilePrintCtrl extends ControllerMain {
    protected $Client; //клиент
    protected $ClientPas; //клиент
    protected $ClientPens; //клиент
    protected $ClientInn; //клиент
    protected $ClientAdr; //клиент
    protected $ClientRel; //клиент массив
    protected $Contract;
    protected $BackOf;
    protected $Court;
    protected $Nalog;
    protected $Creditors;
    protected $Documents;
    protected $IskPack;
    protected $IskNames;
    
    protected $Data; //данные для формирования иска
    protected $BookMarks;       
    protected $ClCode;
    protected $ContCode;
    
    public function actionIndex(){
        (new ATMainFormCtrl())->actionIndex();
    }
    
    public function actionTest(){     
        $Client=new Client($_GET['ClCode']);
        $TemplateName='test';
        $Printer=new PrintDoc('test_tmp','test',['Client'=>$Client->getClRec(),]);
        
        $DocName=$Printer->PrintDoc();
        header("Location: ".$DocName);
    }
    
    public function actionCredList(){ 
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        
        //заполнение таблицы кредиторов
        $CredList=[];
        $i=1;
        foreach($ContP1->getCredList() as $CredRow){
            
            $CredList[]=[
                
                'CREDNAME'=>$CredRow->CRBANKCONTNAME,
                'CREDPROG'=>$CredRow->CRPROG,
                'CREDNUM'=>$CredRow->CRCONTNUM,
                'CREDDATE'=>(new PrintFunctions())->DateToStr($CredRow->CROPENDAT),                
                'CREDSUM'=>$CredRow->CRSUM,                                
            ];
            $i++;
        }       
        
        $List=new \PhpOffice\PhpWord\TemplateProcessor("{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/templates/Список кредиторов.docx");
        
        $List->setValue('ID',$_GET['ContCode']);
        $List->setValue('NAME',$Client->getClRec()->CLFIO);
        
        $List->cloneRowAndSetValues('CREDNAME', $CredList); 
        
        //БЛОК 4
        $FileName="Список кредиторов {$Client->getClRec()->CLFIO}";
        $List->saveAs("{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/documents/{$FileName}.docx");
        
        header("Location: documents/{$FileName}.docx");
    }
    
    public function actionDopGaranty(){ 
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }                
        $Org=new Organization($Branch->getRec()->BRORGPREF);
        $Emp=new Employee($Branch->getRec()->BRDIR);        
        
        $TemplateName='Приложение Соглашение о гарантии';
        if (in_array($ContP1->getFront()->FRCONTPAC,['pac107','pac108'.'pac111','pac112'])){
            $TemplateName='Приложение Соглашение о гарантии ипотека';
        }
              
        
        $Printer=new PrintDoc('DopGarant','Приложение Соглашение о гарантии',[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),        
            'ClientAdr'=>$Client->getAdr(),   
            'Front'=>$ContP1->getFront(),
            'BranchRec'=>$Branch->getRec(),
            'OrgRec'=>$Org->getRec(),   
            'Emp'=>$Emp->getEmp(),
        ]
                
        );
        $DocName=$Printer->PrintDoc();
        header("Location: ".$DocName);
    }
    
    public function actionAnketa(){        
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }                
        $Org=new Organization($Branch->getRec()->BRORGPREF);
        $Emp=new Employee($Branch->getRec()->BRDIR);        
        
        if ($Client->getFamcont()==null){
            $FamCont=new ClientRec();
        }else{
            $FamCont=$Client->getFamcont();
        }
        
        $Printer=new PrintDoc('DopAnketa','Приложение №2 Анкета клиента',[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),
            'ClientINN'=>$Client->getINN(),
            'ClientPens'=>$Client->getPens(),
            'ClientFamcont'=>$FamCont,
            'ClientPhone'=>$Client->getContPhone(),
            'ClientAdr'=>$Client->getAdr(),
            'Anketa'=>$ContP1->getAnketa(),
            'Front'=>$ContP1->getFront(),
            'OrgRec'=>$Org->getRec(),
            'BranchRec'=>$Branch->getRec(),
            'Emp'=>$Emp->getEmp(),
            'EmpDov'=>$Emp->getEmpDov(),
            
            'ClProperty'=>$Client->getPropertyList(),
            'ClDeals'=>$Client->getDealList(),
            'ClIncome'=>$Client->getIncomeList(),
        ]
                
        );
        $DocName=$Printer->PrintDoc();
        header("Location: ".$DocName);
    }
    
    public function actionPersDataPermit(){        
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }                
        $Org=new Organization($Branch->getRec()->BRORGPREF);
        $Emp=new Employee($Branch->getRec()->BRDIR);        
        
        $Printer=new PrintDoc('PersDataPermit','Согласие на обработку ПД',[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),        
            'ClientAdr'=>$Client->getAdr(),            
            'Org'=>$Org->getRec(),            
        ]
                
        );
        $DocName=$Printer->PrintDoc();
        header("Location: ".$DocName);
    }

    public function actionExpCont(){        
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }                
        $Org=new Organization($Branch->getRec()->BRORGPREF);
        #if ($ContP1->getFront()->FRPERSMANAGER==""){
        #    $Emp=new Employee($_SESSION['EmName']);
        #} else
        #{
            $Emp=new Employee($Branch->getRec()->BRDIR);        
        #}
        #var_dump($Emp->getEmp());
        #exit();
        $Printer=new PrintDoc('Exp','Договор ЭПЭ',[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),
            'ClientPhone'=>$Client->getContPhone(),
            'ClientAdr'=>$Client->getAdr(),
            'Front'=>$ContP1->getFront(),
            'Org'=>$Org->getRec(),
            'Branch'=>$Branch->getRec(),
            'Emp'=>$Emp->getEmp(),
            'EmpDov'=>$Emp->getEmpDov()
        ]
                
        );
        $DocName=$Printer->PrintDoc();
        header("Location: ".$DocName);
    }
    
    public function actionExpAct(){
        /*схема печати акта
         * 1. загрузка необходимых данных
         * клиент, его имущество, его сделки, его кредиты, риски по экспертизе
         * для хранения данных сформировать нужные объекты
         * 2. создаём шаблон для заполнения 
         * 3. по блокам заполняем шаблон информацией. блоки с рисками заполняем по схеме есть риски/нет рисков
         * 4. сохраняем отчёт и выводим в файл и выводим в загрузку
         */
        //БЛОК 1
        $Client=new Client($_GET['ClCode']);             
        $Cont=new ContP1($_GET['ContCode']);     
        if ($Cont->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($Cont->getFront()->FROFFICE);        
        }                
        $Org=new Organization($Branch->getRec()->BRORGPREF);
        if ($Cont->getFront()->FRPERSMANAGER==""){
            $Emp=new Employee($_SESSION['EmName']);
        } else
        {
            $Emp=new Employee($Cont->getFront()->FRPERSMANAGER);        
        }
        
        //БЛОК 2 выбор шаблона
        $ExpRec=$Cont->getExpert()->EXPRODREC;
        switch($ExpRec){
            case "Банкротство физлиц":
            case "Защита от кредиторов":
                $Act=new \PhpOffice\PhpWord\TemplateProcessor("{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/templates/Отчёт ЭПЭ.docx");
                break;
            case "Банкротство физлиц с ипотекой":
                $Act=new \PhpOffice\PhpWord\TemplateProcessor("{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/templates/Отчёт ЭПЭ с ипотекой.docx");
                break;
            case "Внесудебное банкротство":
                $Act=new \PhpOffice\PhpWord\TemplateProcessor("{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/templates/Отчёт ЭПЭ ВБФЛ.docx");
                break;
            case "Не подходит внесудебное банкротство":
                $Act=new \PhpOffice\PhpWord\TemplateProcessor("{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/templates/Отчёт ЭПЭ ВБФЛ.docx");
                break;
            case "Судебное банкротство (внесудебное не подходит)":
                $Act=new \PhpOffice\PhpWord\TemplateProcessor("{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/templates/Отчёт ЭПЭ ВБФЛ.docx");
                break;
        }
                
        //БЛОК 3
        //заполнение шапки отчёта и первого абзаца
        $Act->setValue('ID',$_GET['ContCode']);
        $Act->setValue('EXPCONTDATE',(new PrintFunctions())->DateToStr($Cont->getFront()->FRCONTDATE));
        $Act->setValue('CITY',$Branch->getRec()->BRCITY);
        $Act->setValue('REPDATE',(new PrintFunctions())->DateToStr($Cont->getFront()->FREXPACTDATE));
        $Act->setValue('CLNAME',$Client->getClRec()->CLFIO);
        $Act->setValue('COMPNAME',$Org->getRec()->ORGNAME);
        $Act->setValue('TOTALDEBTSUM',$Cont->getExpert()->EXTOTDEBTSUM);
        $Act->setValue('TOTALPAYSUM',$Cont->getExpert()->EXANNTOTPAY);
        $Act->setValue('ALIMENTSUM',$Client->getClRec()->CLALIMENTSUM);
        //заполнение таблицы кредиторов
        $CredList=[];
        $i=1;
        foreach($Cont->getCredList() as $CredRow){
            
            $CredList[]=[
                'CREDID'=>$i,
                'CREDNAME'=>$CredRow->CRBANKCONTNAME,
                'CREDNUM'=>$CredRow->CRCONTNUM,
                'CREDDATE'=>(new PrintFunctions())->DateToStr($CredRow->CROPENDAT),
                'CREDCURNAME'=>$CredRow->CRBANKCURNAME,
                'DEBTSUM'=>$CredRow->CRSUMREST,
                'PAYSUM'=>$CredRow->CRPAYSUM,
                'DELAY'=>$CredRow->CRDELAYYN,
                'PAYNUM'=>$CredRow->CRPAYSNUM
            ];
            $i++;
        }       
        $Act->cloneRowAndSetValues('CREDID', $CredList);      
        //заполнение таблицы доходов
        $IncList=[];
        foreach($Client->getIncomeList() as $IncRow){
            $IncList[]=[                
                'INCNAME'=>$IncRow->CLINCNAME,
                'INCSUM'=>$IncRow->CLINCSUM
             ];
        }
        $Act->cloneRowAndSetValues('INCNAME', $IncList);
        //заполнение таблицы имущества
        $PropList=[];
        foreach($Client->getPropertyList() as $PropRow){
            $Owner=$PropRow->CLPROPOWNER;
            if ($PropRow->CLPROPOWNER=='клиент'){
                $Owner='Заказчик';
            } 
            $PropList[]=[                
                'PROPTYPE'=>$PropRow->CLPROPTYPE,
                'PROPDESC'=>$PropRow->CLPROPDESC,
                'PROPCOST'=>$PropRow->CLPROPCOST,
                'PROPOWNER'=>$Owner    
             ];
        }
        if ($PropList==[]){
            $PropList[]=[                
                'PROPTYPE'=>'---',
                'PROPDESC'=>'---',
                'PROPCOST'=>'---',
                'PROPOWNER'=>'---'    
             ];
        }
        $Act->cloneRowAndSetValues('PROPTYPE', $PropList);
        //заполнение таблицы Риски1
        switch($ExpRec){
            case "Банкротство физлиц":
            case "Банкротство физлиц с ипотекой":
            case "Защита от кредиторов":
                $Risk1List=[];
                $Risk1=0;
                foreach($Cont->getRiskList() as $Risk){
                    if ($Risk->DRVALUETYPE==1){
                        $Risk1List[]=['RISK1NAME'=>$Risk->EXLISTVALUE];
                        $Risk1++;
                    }
                }
                if ($Risk1>0){
                    $Act->cloneBlock('RISK1', 0, true, false, $Risk1List);
                } else {
                    $Act->cloneBlock('RISK1', 1, true, false,[['RISK1NAME'=>'Рисков при анализе предоставленных данных не обнаружено']]);
                }
                break;
            //заполнение таблицы Риски1-ВБФЛ
            case "Внесудебное банкротство":                
                $Risk2_1='Заказчик соответствует условиям для подачи заявления о признании гражданина банкротом во внесудебном порядке';
                foreach($Cont->getRiskList2() as $Risk){
                    if ($Risk->EXLISTVALUE2==1){
                        $Risk2_1=$Risk->EXLISTVALUE;
                    }
                }
                $Act->setValue('RISK2_1',$Risk2_1);
                break;
            case "Не подходит внесудебное банкротство":                
                $Risk2_1='Заказчик соответствует условиям для подачи заявления о признании гражданина банкротом во внесудебном порядке';
                foreach($Cont->getRiskList2() as $Risk){
                    if ($Risk->EXLISTVALUE2==1){
                        $Risk2_1=$Risk->EXLISTVALUE;
                    }
                }
                $Act->setValue('RISK2_1',$Risk2_1);
                break;
            case "Судебное банкротство (внесудебное не подходит)":
                $Risk2_1='Заказчик соответствует условиям для подачи заявления о признании гражданина банкротом во внесудебном порядке';
                foreach($Cont->getRiskList2() as $Risk){
                    if ($Risk->EXLISTVALUE2==1){
                        $Risk2_1=$Risk->EXLISTVALUE;
                    }
                }
                $Act->setValue('RISK2_1',$Risk2_1);
                break;
        }
                                        
        //заполнение таблицы Сделок
        $DealList=[];
        foreach($Client->getDealList() as $DealRow){
            $Owner=$DealRow->CLDLOWNER;
            if ($DealRow->CLDLOWNER=='клиент'){
                $Owner='заказчик';
            }
            $DealList[]=[                
                'DLOBJ'=>$DealRow->CLDLOBJ,
                'DLCOMMENT'=>$DealRow->CLDLCOMMENT,
                'DLSUM'=>$DealRow->CLDLSUM,
                'DLOWNER'=>$Owner    
             ];
        }
        if ($DealList==[]){
            $DealList[]=[                
                'DLOBJ'=>'---',
                'DLCOMMENT'=>'---',
                'DLSUM'=>'---',
                'DLOWNER'=>'---'    
             ];
        }
        
        $Act->cloneRowAndSetValues('DLOBJ', $DealList);
        
        //заполнение таблицы Риски2        
        switch($ExpRec){
            case "Банкротство физлиц":
            case "Банкротство физлиц с ипотекой":
            case "Защита от кредиторов":
                $Risk2List=[];
                $Risk2=0;
                foreach($Cont->getRiskList() as $Risk){
                    if ($Risk->DRVALUETYPE==2){
                        $Risk2List[]=['RISK2NAME'=>$Risk->EXLISTVALUE];
                        $Risk2++;
                    }
                }
                if ($Risk2>0){
                    $Act->cloneBlock('RISK2', 0, true, false, $Risk2List);
                } else {
                    $Act->cloneBlock('RISK2', 1, true, false,[['RISK2NAME'=>'Рисков при анализе предоставленных данных не обнаружено']]);
                }
                break;
            case "Внесудебное банкротство":                
                //заполнение таблицы Риски2_2
                $Risk2_2='Рисков при анализе предоставленных данных не обнаружено';
                foreach($Cont->getRiskList2() as $Risk){
                    if ($Risk->EXLISTVALUE2==2){
                        $Risk2_2=$Risk->EXLISTVALUE;
                    }
                }
                $Act->setValue('RISK2_2',$Risk2_2);
                break;
            case "Не подходит внесудебное банкротство": 
                $Risk2_2='Рисков при анализе предоставленных данных не обнаружено';
                foreach($Cont->getRiskList2() as $Risk){
                    if ($Risk->EXLISTVALUE2==2){
                        $Risk2_2=$Risk->EXLISTVALUE;
                    }
                }
                $Act->setValue('RISK2_2',$Risk2_2);
                break;
            case "Судебное банкротство (внесудебное не подходит)":
                $Risk2_2='Рисков при анализе предоставленных данных не обнаружено';
                foreach($Cont->getRiskList2() as $Risk){
                    if ($Risk->EXLISTVALUE2==2){
                        $Risk2_2=$Risk->EXLISTVALUE;
                    }
                }
                $Act->setValue('RISK2_2',$Risk2_2);
                break;
        }
                
        //заполнение раздела 1.5 Общие сведения
        $Act->setValue('FAMSTATUS',$Client->getClRec()->CLFAMSTATUS);
        $Act->setValue('CHILDNUM',$Client->getClRec()->CLCHILDNUM);
        $Act->setValue('CRIMINALRESP',$Client->getClRec()->CLCRIMINALRESPYN);
        $Act->setValue('ADMRESP',$Client->getClRec()->CLADMRESPYN);
        $Act->setValue('INDENTRYN',$Client->getClRec()->CLINDENTRYN);
        //заполнение таблицы по прожиточному минимуму
        $Act->setValue('MININCAVG',$Cont->getMinIncList()['Avg']);
        $Act->setValue('MININCWORK',$Cont->getMinIncList()['Work']);
        $Act->setValue('MININCPENS',$Cont->getMinIncList()['Pens']);
        $Act->setValue('MININCCHILD',$Cont->getMinIncList()['Child']);
        $Act->setValue('MININCRESULT',$Cont->getMinIncList()['Result']);
        
        //заполнение таблицы Риски3
        switch($ExpRec){
            case "Банкротство физлиц":                
            case "Банкротство физлиц с ипотекой":
            case "Защита от кредиторов":
                $Risk3List=[];
                $Risk3=0;
                foreach($Cont->getRiskList() as $Risk){
                    if ($Risk->DRVALUETYPE==3){
                        $Risk3List[]=['RISK3NAME'=>$Risk->EXLISTVALUE];
                        $Risk3++;
                    }
                }
                if ($Risk3>0){
                    $Act->cloneBlock('RISK3', 0, true, false, $Risk3List);
                } else {
                    $Act->cloneBlock('RISK3', 1, true, false,[['RISK3NAME'=>'Рисков при анализе предоставленных данных не обнаружено']]);
                }
                break;
            case "Внесудебное банкротство":                
                //заполнение таблицы Риски2_3
                $Risk2_3='Заказчик соответствует условиям для подачи заявления о признании гражданина банкротом во внесудебном порядке';
                foreach($Cont->getRiskList2() as $Risk){
                    if ($Risk->EXLISTVALUE2==3){
                        $Risk2_3=$Risk->EXLISTVALUE;
                    }
                }
                $Act->setValue('RISK2_3',$Risk2_3);
                break;
            case "Не подходит внесудебное банкротство": 
                $Risk2_3='Заказчик соответствует условиям для подачи заявления о признании гражданина банкротом во внесудебном порядке';
                foreach($Cont->getRiskList2() as $Risk){
                    if ($Risk->EXLISTVALUE2==3){
                        $Risk2_3=$Risk->EXLISTVALUE;
                    }
                }
                $Act->setValue('RISK2_3',$Risk2_3);
                break;
            case "Судебное банкротство (внесудебное не подходит)":
                $Risk2_3='Заказчик соответствует условиям для подачи заявления о признании гражданина банкротом во внесудебном порядке';
                foreach($Cont->getRiskList2() as $Risk){
                    if ($Risk->EXLISTVALUE2==3){
                        $Risk2_3=$Risk->EXLISTVALUE;
                    }
                }
                $Act->setValue('RISK2_3',$Risk2_3);
                break;
        }               
        
        //заполнение таблицы Риски4
        switch($ExpRec){
            case "Банкротство физлиц":  
            case "Банкротство физлиц с ипотекой":
            case "Защита от кредиторов":
                $Risk4List=[];
                $Risk4=0;
                foreach($Cont->getRiskList() as $Risk){
                    if ($Risk->DRVALUETYPE==4){
                        $Risk4List[]=['RISK4NAME'=>$Risk->EXLISTVALUE];
                        $Risk4++;
                    }
                }
                if ($Risk4>0){
                    $Act->cloneBlock('RISK4', 0, true, false, $Risk4List);
                } else {
                    $Act->cloneBlock('RISK4', 1, true, false,[['RISK4NAME'=>'Рисков при анализе предоставленных данных не обнаружено']]);
                }
                break;        
        }
        //заполнение итоговой таблицы Риски
        $RiskFList=[];
        $RiskRecList=[];
        $RiskF=0;
        foreach($Cont->getRiskList2() as $Risk){            
            $RiskFList[]=[
                'RISKFIN'=>$Risk->EXLISTVALUE,
                'RISKJURWORK'=>'',
                'RISKPROPERTY'=>$Risk->EXLISTVALUE3
            ];
            $RiskF++;            
        }
        foreach($Cont->getRiskList() as $Risk){            
            $RiskFList[]=[
                'RISKFIN'=>$Risk->EXLISTVALUE,
                'RISKJURWORK'=>$Risk->EXLISTVALUE2,
                'RISKPROPERTY'=>$Risk->EXLISTVALUE3
            ];
            
            if ($Risk->DRRECOMEND!=''){
                $RiskRecList[]=                    
                    $Risk->DRRECOMEND
                ;
            }
            $RiskF++;            
        }
        
        if ($RiskF==0){    
            $RiskFList[]=[
                'RISKFIN'=>'Риски проведения процедуры банкротства не выявлены',
                'RISKJURWORK'=>'',
                'RISKPROPERTY'=>''
            ];
        }      
        
        
        
        #$RiskRecListPr=array_map("unserialize", array_unique(array_map("serialize", $RiskRecList)));
        $RiskRecListPr=array_unique($RiskRecList);
        $RiskRecListPr2=[];
        foreach($RiskRecListPr as $Risk){
            $RiskRecListPr2[]=[
                'RECOMEND'=>$Risk,
            ];
        }
        
        #new MyCheck($RiskRecListPr2,0);
        
        $Act->cloneRowAndSetValues('RISKFIN', $RiskFList);          
        //заполнение таблицы рекомендаций
        switch($ExpRec){
            case "Банкротство физлиц":  
            case "Банкротство физлиц с ипотекой":
            case "Защита от кредиторов":
                $Act->cloneRowAndSetValues('RECOMEND', $RiskRecListPr2);
                break;  
        }
        
        //заполнение резюме
        switch($Cont->getExpert()->EXPRODREC){            
            case "Внесудебное банкротство":
                $Act->setValue('EXPRES','Процедура банкротства гражданина во внесудебном порядке рекомендована.');
                break;
            case "Судебное банкротство (внесудебное не подходит)":
                $Act->setValue('EXPRES','Рекомендована процедура банкротства в судебном порядке.');
                break;
            case "Не подходит внесудебное банкротство":
                $Act->setValue('EXPRES','Процедура банкротства гражданина во внесудебном порядке не рекомендована.');
                break;
        }
        
        if ($Cont->getExpert()->EXJURCOMMENT==''){            
            $Act->setValue('WHATTODO',"Рекомендовано заключение договора по программе ".$Cont->getExpert()->EXPRODREC);
        } else {
            $Act->setValue('WHATTODO',$Cont->getExpert()->EXJURCOMMENT);
        }
        //заполнение стоимости услуг
        $Act->setValue('CONTSUM',9000);
        $Act->setValue('CONTSUMSTR','девять тысяч');
        //БЛОК 4
        $FileName="Отчёт ЭПЭ {$Client->getClRec()->CLFIO}";
        $Act->saveAs("{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/documents/{$FileName}.docx");
        
        header("Location: documents/{$FileName}.docx");
    }
    
    public function actionMainCont(){
        /*печатьдоговора услуг
         * 
         */
        
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }                
        $Org=new Organization($Branch->getRec()->BRORGPREF);        
        $Emp=new Employee($Branch->getRec()->BRDIR);        
        
        if ($Client->getFamcont()==null){
            $FamCont=new ClientRec();
        }else{
            $FamCont=$Client->getFamcont();
        }
        
        $Printer=new PrintDoc('ContNewType3',$ContP1->getPac()->PCTEMPLATEROOT,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),
            'ClientINN'=>$Client->getINN(),
            'ClientPens'=>$Client->getPens(),
            'ClientFamcont'=>$FamCont,
            'ClientPhone'=>$Client->getContPhone(),
            'ClientAdr'=>$Client->getAdr(),
            'Anketa'=>$ContP1->getAnketa(),
            'Front'=>$ContP1->getFront(),
            'OrgRec'=>$Org->getRec(),
            'BranchRec'=>$Branch->getRec(),
            'Emp'=>$Emp->getEmp(),
            'EmpDov'=>$Emp->getEmpDov(),
            'Pac'=>$ContP1->getPac(),
            'PayCalend'=>$ContP1->getPayCalend(),
            'ClProperty'=>$Client->getPropertyList(),
            'ClDeals'=>$Client->getDealList(),
            'ClIncome'=>$Client->getIncomeList(),
        ]
                
        );
        $DocName=$Printer->PrintDoc();
        header("Location: ".$DocName);        
    }
    
    public function actionDopCont(){
        /*печатьдоговора услуг
         * 
         */
        
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }                
        $Org=new Organization($Branch->getRec()->BRORGPREF);        
        $Emp=new Employee($Branch->getRec()->BRDIR);        
        
        if ($Client->getFamcont()==null){
            $FamCont=new ClientRec();
        }else{
            $FamCont=$Client->getFamcont();
        }
        
        $Printer=new PrintDoc('ContDop','Допсоглашение БФЛ',[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),
            'ClientINN'=>$Client->getINN(),
            'ClientPens'=>$Client->getPens(),
            'ClientFamcont'=>$FamCont,
            'ClientPhone'=>$Client->getContPhone(),
            'ClientAdr'=>$Client->getAdr(),
            'Anketa'=>$ContP1->getAnketa(),
            'Front'=>$ContP1->getFront(),
            'OrgRec'=>$Org->getRec(),
            'BranchRec'=>$Branch->getRec(),
            'Emp'=>$Emp->getEmp(),
            'EmpDov'=>$Emp->getEmpDov(),
            'Pac'=>$ContP1->getPac(),
            'PayCalend'=>$ContP1->getPayCalend(),
            'ClProperty'=>$Client->getPropertyList(),
            'ClDeals'=>$Client->getDealList(),
            'ClIncome'=>$Client->getIncomeList(),
        ]);
        
        $DocName=$Printer->PrintDoc();
        header("Location: ".$DocName);        
    }
    
    public function actionDovTemplate(){
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }                
        $Org=new Organization($Branch->getRec()->BRORGPREF);        
        $Emp=new Employee($Org->getRec()->ORGDIRNAME);        
        
        if ($Client->getFamcont()==null){
            $FamCont=new ClientRec();
        }else{
            $FamCont=$Client->getFamcont();
        }
        
        $Printer=new PrintDoc('DovNot','Доверенность БФЛ',[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(), 
            'ClientINN'=>$Client->getINN(),
            'ClientPens'=>$Client->getPens(),
            'ClientAdr'=>$Client->getAdr(),
            'Anketa'=>$ContP1->getAnketa(),
            'Front'=>$ContP1->getFront(),
            'OrgRec'=>$Org->getRec(),
            'BranchRec'=>$Branch->getRec(),
            'Employee'=>$Emp->getEmp()
            ]
                
        );
                     
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    
    public function actionDovCompJur(){
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }                
        $Org=new Organization($Branch->getRec()->BRORGPREF);        
        $Emp1=new Employee($Org->getRec()->ORGDIRNAME);        
        $Emp2=new Employee($ContP1->getBackOf()->BOJURNAME);
        
        if ($Client->getFamcont()==null){
            $FamCont=new ClientRec();
        }else{
            $FamCont=$Client->getFamcont();
        }
        
        $DovName='Доверенность БФЛ передоверие';
        if ($ContP1->getFront()->FRCONTPROG=='Защита от кредиторов'){
            $DovName='Доверенность ЗОК передоверие';
        }
        
        $Printer=new PrintDoc('DovCompJur',$DovName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(), 
            'ClientINN'=>$Client->getINN(),
            'ClientPens'=>$Client->getPens(),
            'ClientAdr'=>$Client->getAdr(),
            'Anketa'=>$ContP1->getAnketa(),
            'Front'=>$ContP1->getFront(),
            'BackOf'=>$ContP1->getBackOf(),
            'OrgRec'=>$Org->getRec(),
            'BranchRec'=>$Branch->getRec(),
            'Director'=>$Emp1->getEmp(),
            'Jurist'=>$Emp2->getEmp(),
            ]
                
        );
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    
    public function actionPayBill(){
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']); 
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }  
        $PayList=$ContP1->getPayList();
        $PayedSum=0;
        foreach($PayList as $Pay){
            $PayedSum=$PayedSum+$Pay->PAYSUM;
        }
        $CurSum=$ContP1->getFront()->FRCONTSUM-$PayedSum;
                
        $DocName='Выписка о платежах';
        
        $Printer=new PrintDoc('PayBillP1',$DocName,[
            'Client'=>$Client->getClRec(),            
            'Front'=>$ContP1->getFront(),            
            'Branch'=>$Branch->getRec(),
            'CurDate'=>new ContP1CurSum(date('d.m.Y'),$CurSum,$PayedSum),
            'PayList'=>$PayList,
        ]);
                                
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    
    public function actionContDopWorkBrakeAfterExp(){
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }                
        $Org=new Organization($Branch->getRec()->BRORGPREF);        
        $Emp=new Employee($Branch->getRec()->BRDIR);        
        
        if ($Client->getFamcont()==null){
            $FamCont=new ClientRec();
        }else{
            $FamCont=$Client->getFamcont();
        }
        
        $ContProg=$ContP1->getFront()->FRCONTPROG;
        if ($ContProg=='Внесудебное банкротство') {
            $DocName='Доп соглашение Расторжение договора услуг 2';
        } else {
            $DocName='Доп соглашение Расторжение договора услуг 1';
        }
                
        $Printer=new PrintDoc('ContDopWorkBrake',$DocName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),             
            'ClientAdr'=>$Client->getAdr(),
            'ClientPhone'=>$Client->getContPhone(),
            'Anketa'=>$ContP1->getAnketa(),
            'Front'=>$ContP1->getFront(),
            'OrgRec'=>$Org->getRec(),
            'Branch'=>$Branch->getRec(),
            'Emp'=>$Emp->getEmp(),
            'EmpDov'=>$Emp->getEmpDov()
            ]
                
        );
        
        $DocName=$Printer->PrintDoc();      
        header("Location: ".$DocName);
    }
    
    public function actionContDopWorkBrake(){
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }                
        $Org=new Organization($Branch->getRec()->BRORGPREF);        
        $Emp=new Employee($Branch->getRec()->BRDIR);        
        
        if ($Client->getFamcont()==null){
            $FamCont=new ClientRec();
        }else{
            $FamCont=$Client->getFamcont();
        }
        
        $PacNum= substr($ContP1->getFront()->FRCONTPAC,-2);        
        if ($PacNum>45) {
            $DocName='Доп соглашение Расторжение договора поручения';
        } else {
            $DocName='Доп соглашение Расторжение договора услуг';
        }
                
        $Printer=new PrintDoc('ContDopWorkBrake',$DocName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),             
            'ClientAdr'=>$Client->getAdr(),
            'ClientPhone'=>$Client->getContPhone(),
            'Anketa'=>$ContP1->getAnketa(),
            'Front'=>$ContP1->getFront(),
            'OrgRec'=>$Org->getRec(),
            'Branch'=>$Branch->getRec(),
            'Emp'=>$Emp->getEmp(),
            'EmpDov'=>$Emp->getEmpDov()
            ]
                
        );
        
        $DocName=$Printer->PrintDoc();      
        header("Location: ".$DocName);
    }
    
    public function actionWorkFinalAct(){
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }                
        $Org=new Organization($Branch->getRec()->BRORGPREF);        
        $Emp=new Employee($Branch->getRec()->BRDIR);        
        
        if ($Client->getFamcont()==null){
            $FamCont=new ClientRec();
        }else{
            $FamCont=$Client->getFamcont();
        }
        
        $PacNum= substr($ContP1->getFront()->FRCONTPAC,-2);        
        if ($PacNum>45) {
            $DocName='Отчёт об исполнении БФЛ 2';
        } else {
            $DocName='Отчёт об исполнении БФЛ 1';
        }
                
        $Printer=new PrintDoc('WorkFinalAct',$DocName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(), 
            'ClientINN'=>$Client->getINN(),
            'ClientPens'=>$Client->getPens(),
            'ClientAdr'=>$Client->getAdr(),
            'Anketa'=>$ContP1->getAnketa(),
            'Front'=>$ContP1->getFront(),
            'OrgRec'=>$Org->getRec(),
            'BranchRec'=>$Branch->getRec(),
            'Employee'=>$Emp->getEmp(),
            'EmpDov'=>$Emp->getEmpDov()
            ]
                
        );
        
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    
    public function actionReqCompP1(){
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        $Credit=new CreditP1($_GET['CrCode']);
        if ($Credit->getCrRec()->CRBANKCONTTYPE=='Банк'){
            $DocTmpName='Запрос в банк юрист';
        } else {
            $DocTmpName='Запрос в МФО юрист';
        }
        
        $Printer=new PrintDoc('ReqComp1P1',$DocTmpName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),             
            'ClientAdr'=>$Client->getAdr(),       
            'ClientPhone'=>$Client->getContPhone(),
            'Jurist'=>(new Employee($ContP1->getBackOf()->BOJURNAME))->getEmp(),
            'Creditor'=>$Credit->getBnContRec(), //здесь должны быть наименование и адрес организации
            'CreditorContList'=>(new ATP1CredMod())->getP1CredContList($_GET['ContCode'],$Credit->getCrRec()->CRBANKCONTNAME),
            
            ]
                
        );
        
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    
    public function actionReqCurrCompP1(){
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        $Credit=new CreditP1($_GET['CrCode']);
        $DocTmpName='Запрос переуступка юрист';
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }
        
        $Printer=new PrintDoc('ReqCurrCompP1',$DocTmpName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),             
            'ClientAdr'=>$Client->getAdr(),       
            'ClientPhone'=>$Client->getContPhone(),
            'Jurist'=>(new Employee($ContP1->getBackOf()->BOJURNAME))->getEmp(),
            'Creditor'=>$Credit->getBnContRec(), //здесь должны быть наименование и адрес организации
            'CreditorCurr'=>$Credit->getBnContRec(), //здесь должны быть наименование и адрес организации
            'CreditorContList'=>(new ATP1CredMod())->getP1CredContList($_GET['ContCode'],$Credit->getCrRec()->CRBANKCONTNAME),
            'Branch'=>$Branch->getRec(),            ]
                
        );
        
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    
    public function actionReqClientP1(){
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        $Credit=new CreditP1($_GET['CrCode']);
        if ($Credit->getCrRec()->CRBANKCONTTYPE=='Банк'){
            $DocTmpName='Запрос в банк клиент';
        } else {
            $DocTmpName='Запрос в МФО клиент';
        }
        
        $Printer=new PrintDoc('ReqComp1P1',$DocTmpName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),             
            'ClientAdr'=>$Client->getAdr(),            
            'ClientPhone'=>$Client->getContPhone(),
            'Jurist'=>(new Employee($ContP1->getBackOf()->BOJURNAME))->getEmp(),
            'Creditor'=>$Credit->getBnContRec(), //здесь должны быть наименование и адрес организации
            #'CreditorCurr'=>$Credit->getBnContRec(), //здесь должны быть наименование и адрес организации
            'CreditorContList'=>(new ATP1CredMod())->getP1CredContList($_GET['ContCode'],$Credit->getCrRec()->CRBANKCONTNAME),
            
            ]
                
        );
        
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    
    public function actionReqCurrClientP1(){
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        $Credit=new CreditP1($_GET['CrCode']);        
        $DocTmpName='Запрос переуступка клиент';
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }
        
                
        $Printer=new PrintDoc('ReqCurrClientP1',$DocTmpName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),             
            'ClientAdr'=>$Client->getAdr(),            
            'ClientPhone'=>$Client->getContPhone(),
            'Jurist'=>(new Employee($ContP1->getBackOf()->BOJURNAME))->getEmp(),
            'Creditor'=>$Credit->getBnContRec(), //здесь должны быть наименование и адрес организации
            'CreditorCurr'=>$Credit->getBnContRec(), //здесь должны быть наименование и адрес организации
            'CreditorContList'=>(new ATP1CredMod())->getP1CredContList($_GET['ContCode'],$Credit->getCrRec()->CRBANKCONTNAME),
            'Branch'=>$Branch->getRec(),
            ]
                
        );
        
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    
    public function actionReqEntStatus(){//запрос о статусе индивидуального предпринимателя
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        #$Credit=new CreditP1($_GET['CrCode']);        
        $DocTmpName='Запрос статус ИП';
                
        $Printer=new PrintDoc('ReqEntStatus',$DocTmpName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),             
            'ClientINN'=>$Client->getINN(),             
            'ClientAdr'=>$Client->getAdr(),            
            'ClientPhone'=>$Client->getContPhone(),
            'Jurist'=>(new Employee($ContP1->getBackOf()->BOJURNAME))->getEmp(),            
            
            ]
                
        );
        
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    /* документы по внесудебному БФЛ
     */
    public function actionPrintMFO1(){
        $Client=new Client($_GET['ClCode']);    
        $DocTmpName='Заявление внесуд Ф1';
        $Printer=new PrintDoc('MfcForm',$DocTmpName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),             
            'ClientINN'=>$Client->getINN(),        
            'ClientPens'=>$Client->getPens(),
            'ClientAdr'=>$Client->getAdr(),            
            'ClientPhone'=>$Client->getContPhone()
            ]
        );
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    public function actionPrintMFO2(){
        $Client=new Client($_GET['ClCode']);  
        $DocTmpName='Заявление внесуд Ф2';
        $Printer=new PrintDoc('MfcForm',$DocTmpName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),             
            'ClientINN'=>$Client->getINN(),       
            'ClientPens'=>$Client->getPens(),
            'ClientAdr'=>$Client->getAdr(),            
            'ClientPhone'=>$Client->getContPhone()
            ]
        );
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    public function actionPrintMFO3(){
        $Client=new Client($_GET['ClCode']);             
        $DocTmpName='Заявление внесуд Ф3';
        $Printer=new PrintDoc('MfcForm',$DocTmpName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),             
            'ClientINN'=>$Client->getINN(),           
            'ClientPens'=>$Client->getPens(),
            'ClientAdr'=>$Client->getAdr(),            
            'ClientPhone'=>$Client->getContPhone()
            ]
        );
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    public function actionPrintMFO4(){
        $Client=new Client($_GET['ClCode']);             
        $DocTmpName='Заявление внесуд Ф4';
        $Printer=new PrintDoc('MfcForm',$DocTmpName,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),             
            'ClientINN'=>$Client->getINN(),         
            'ClientPens'=>$Client->getPens(),
            'ClientAdr'=>$Client->getAdr(),            
            'ClientPhone'=>$Client->getContPhone()
            ]
        );
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
            
}
