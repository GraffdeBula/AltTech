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
        if(!$Client->getContPhone()){
            echo('111');
        }else{
            echo('sssss');
        }
        exit();
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
        //заполнение таблицы по прожиточному минимуму
        $Act->setValue('MININCAVG',$Cont->getMinIncList()['Avg']);
        $Act->setValue('MININCWORK',$Cont->getMinIncList()['Work']);
        $Act->setValue('MININCPENS',$Cont->getMinIncList()['Pens']);
        $Act->setValue('MININCCHILD',$Cont->getMinIncList()['Child']);
        $Act->setValue('MININCRESULT',$Cont->getMinIncList()['Result']);
        
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
            $RiskFList[]=[
                'RISKFIN'=>$Risk->EXLISTVALUE,
                'RISKJURWORK'=>$Risk->EXLISTVALUE2,
                'RISKPROPERTY'=>$Risk->EXLISTVALUE3
            ];
            $RiskF++;            
        }
        if ($RiskF>0){
            $Act->cloneRowAndSetValues('RISKFIN', $RiskFList);
        }         
        //заполнение резюме
        if ($Cont->getExpert()->EXJURCOMMENT==''){            
            $Act->setValue('WHATTODO',"Рекомендовано заключение договора по программе ".$Cont->getExpert()->EXPRODREC);
        } else {
            $Act->setValue('WHATTODO',$Cont->getExpert()->EXJURCOMMENT);
        }
        //заполнение стоимости услуг
        $Act->setValue('CONTSUM',$Cont->getFront()->FREXPSUM);
        $Act->setValue('CONTSUMSTR',(new PrintFunctions())->SumToStr($Cont->getFront()->FREXPSUM));
        //БЛОК 4
        $FileName="Отчёт ЭПЭ {$Client->getClRec()->CLFIO}";
        $Act->saveAs("{$_SERVER['DOCUMENT_ROOT']}/AltTech/documents/{$FileName}.docx");
        
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
        
        $Printer=new PrintDoc('ContNewType2',$ContP1->getPac()->PCTEMPLATEROOT,[
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
            'ClDeals'=>$Client->getDealList()
        ]
                
        );
        $DocName=$Printer->PrintDoc();
        header("Location: ".$DocName);        
    }
    
    public function actionMainAct(){
        echo('Основной акт');
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
        #var_dump($Emp->getEmp());
        #exit();
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
        
        $Printer=new PrintDoc('DovCompJur','Доверенность БФЛ передоверие',[
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
        
        $Printer=new PrintDoc('WorkFinalAct','Отчёт об исполнении БФЛ',[
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
            'CreditorContList'=>(new ATP1CredMod())->getP1CredContList($_GET['ContCode'],$Credit->getCrRec()->CRBANKCONTNAME),
            
            ]
                
        );
        
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    
    public function actionPrintIsk(){
        $this->ClCode=$_GET['ClCode'];
        $this->ContCode=$_GET['ContCode'];
        $this->IskPack=[
            1=>'7551B0D0-AE7C-402F-9850-35D4FF38FAED',
            2=>'7120A40A-1183-4F78-86B3-CD38C96E8AEA',            
            3=>'E8FED364-975F-41D5-996A-7EE756D18BBD'
            
        ];
        $this->IskNames=[
            1=>'Исковое заявление',
            2=>'Приложение 1 кредиторы',
            3=>'Приложение 2 имущество'            
        ];
        
        ####Формирование набора данных для иска
        $this->GetDataForIsk();
        
        foreach($this->IskPack as $i => $IskDoc){
            $Isk=new DZCtrl(); //создание нового объекта curl для формирования иска            
            $Isk->DocID=$IskDoc;
            $Isk->DocName=$this->Client->CLFIO.' '.$this->IskNames[$i];
            $Isk->Data=$this->CreateDataForIsk($i); 
            #new MyCheck($Isk->Data,0);
            #if ($i==1) {new MyCheck($Isk->Data,1);}
            $Isk->run();                        
        }
        
        header("Location: https://afpc24.doczilla.pro"); //пересылка на докзиллу для скачивания файла
    }
    
    protected function GetDataForIsk(){
        $IskData=new IskMod();
        $Client=new Client($this->ClCode);
        $this->Client=$Client->getClRec();
        $this->ClientPas=$Client->getPasport();
        $this->ClientPens=$Client->getPens();
        $this->ClientInn=$Client->getINN();
        $this->ClientAdr=$Client->getAdr();
        $this->ClientRel=$Client->getRelativeList();
        
        $Contract=new ContP1($this->ContCode);
        $this->Contract=$Contract->getAnketa();
        $this->BackOf=$Contract->getBackOf();
        $this->Creditors=$Contract->getCredList();                
        
        $this->Court=(new OrganizationOther('Арбитражный суд',$this->Client->CLADRRREG))->getRec();
        $this->Nalog=(new OrganizationOther('Налоговая',$this->Client->CLADRRREG))->getRec();
                        
        $this->BookMarks[1]=$IskData->getBookMarks2_1();
        $this->BookMarks[2]=$IskData->getBookMarks2_2();
        $this->BookMarks[3]=$IskData->getBookMarks2_3();    
    }
    
    protected function CreateDataForIsk($i){//
        $this->Data=[];

        foreach ($this->BookMarks[$i] as $BookMark) {                        
            if ($BookMark->BMARRKEY>=0){
                
                if (isset($this->{$BookMark->BMTABLE}[$BookMark->BMARRKEY]->{$BookMark->BMFIELD})){
                    
                    $this->Data[$BookMark->BMNAME]=$this->{$BookMark->BMTABLE}[$BookMark->BMARRKEY]->{$BookMark->BMFIELD};
                } else {
                    
                }
                       
            }
             
            else {
                if (isset($this->{$BookMark->BMTABLE}->{$BookMark->BMFIELD})){
                    $this->Data[$BookMark->BMNAME]=$this->{$BookMark->BMTABLE}->{$BookMark->BMFIELD};               
                }
            }
         
        }    
        
        return $this->Data;
    }
    
}
