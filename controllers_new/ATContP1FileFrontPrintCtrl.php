<?php
/**
 * контроллер управления  формой досье договора P1
 *
 * функции
 * открыть досье договора - экшн
 * показать информацию по договору
 * сохранить информацию по договору - экшн
 * открыть анкету договора - переход по ссылке
 * распечатать договор ЭПЭ - экшн
 * ** запускается экшн печать договора ЭПЭ. он получаеткод клиента и код договора
 * ** экшн должен вызвать объект класса PrintDoc и передать ему всю необходимую информацию для печати договора
 * 
 */
class ATContP1FileFrontPrintCtrl extends ControllerMain {
    public function actionIndex(){
        (new ATMainFormCtrl())->actionIndex();
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
        /*схемапечати акта
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
        
        //БЛОК 2
        $Act=new \PhpOffice\PhpWord\TemplateProcessor("{$_SERVER['DOCUMENT_ROOT']}/AltTech/templates/Отчёт ЭПЭ.docx");
        
        //БЛОК 3
        //заполнение шапки отчёта и первого абзаца
        $Act->setValue('ID',$_GET['ContCode']);
        $Act->setValue('EXPCONTDATE',$Cont->getFront()->FREXPDATE);
        $Act->setValue('CITY',$Branch->getRec()->BRCITY);
        $Act->setValue('REPDATE',$Cont->getExpert()->EXRESDAT);
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
                'CREDDATE'=>$CredRow->CROPENDAT,
                'CREDCURNAME'=>$CredRow->CRBANKCURNAME,
                'DEBTSUM'=>$CredRow->CRSUMREST,
                'PAYSUM'=>$CredRow->CRPAYSUM,
                'DELAY'=>$CredRow->CRDELAYYN
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
                $Owner='заказчик';
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
        //заполнение раздела 1.5 Общие сведения
        $Act->setValue('FAMSTATUS',$Client->getClRec()->CLFAMSTATUS);
        $Act->setValue('CHILDNUM',$Client->getClRec()->CLCHILDNUM);
        $Act->setValue('CRIMINALRESP',$Client->getClRec()->CLCRIMINALRESPYN);
        $Act->setValue('ADMRESP',$Client->getClRec()->CLADMRESPYN);
        //заполнение таблицы Риски3
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
        //заполнение таблицы Риски4
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
        //заполнение итоговой таблицы Риски
        $RiskFList=[];
        $RiskF=0;
        foreach($Cont->getRiskList() as $Risk){            
            $RiskFList[]=['RISKFIN'=>$Risk->EXLISTVALUE];
            $RiskF++;            
        }
        if ($RiskF>0){
            $Act->cloneRowAndSetValues('RISKFIN', $RiskFList);
        }         
        //заполнение стоимости услуг
        $Act->setValue('CONTSUM',$Front->getFront()->FREXPSUM);
        $Act->setValue('CONTSUMSTR',$Front->getFront()->FREXPSUM);
        //БЛОК 4
        $FileName="Отчёт ЭПЭ {$Client->getClRec()->CLFIO}";
        $Act->saveAs("{$_SERVER['DOCUMENT_ROOT']}/AltTech/documents/{$FileName}.docx");
        
        header("Location: documents/{$FileName}.docx");
    }
    
    public function actionMainCont(){
        /*схемапечати акта
         * 1. загрузка необходимых данных
         * клиент, вся его анкета (родня, документы, доходы), его имущество, его сделки, его кредиты, реквизиты организации, 
         * для хранения данных сформировать нужные объекты
         * 2. выбираем шаблон ждя заполнения исходя из тарифа
         * 3. формируем массив данных для заполнения
         * 4. вызываем принтер, передавай в него все необходимые данные и открываем заполненный договор
         */
        //БЛОК 1
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
        
        #var_dump($Org);
        #echo("<br>===============<br>");
        #var_dump($Branch->getRec());
        #echo("<br>===============<br>");
        #var_dump($Client->getAdr());
        #exit();
        $Printer=new PrintDoc('ContNewType2',$ContP1->getPac()->PCTEMPLATEROOT,[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),
            'ClientPhone'=>$Client->getContPhone(),
            'ClientAdr'=>$Client->getAdr(),
            'Anketa'=>$ContP1->getAnketa(),
            'Front'=>$ContP1->getFront(),
            'OrgRec'=>$Org->getRec(),
            'BranchRec'=>$Branch->getRec(),
            'Emp'=>$Emp->getEmp(),
            'EmpDov'=>$Emp->getEmpDov(),
            'Pac'=>$ContP1->getPac()   
        ]
                
        );
        $DocName=$Printer->PrintDoc();
        header("Location: ".$DocName);        
    }
    
    public function actionMainAct(){
        echo('Основной акт');
    }
    
    public function actionDovTemplate(){
        echo('Шаблон доверки');
        header("Location: documents/{$FileName}.docx");
    }
    
}
