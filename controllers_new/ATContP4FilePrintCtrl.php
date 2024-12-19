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
class ATContP4FilePrintCtrl extends ControllerMain {
    
    protected $Data=[];
    
    public function actionIndex(){
        (new ATMainFormCtrl())->actionIndex();
    }
    
    public function actionPersDataPermit(){        
        $Client=new Client($_GET['ClCode']);             
        $ContP4=new ContP1($_GET['ContCode']);     
        if ($ContP4->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP4->getFront()->FROFFICE);        
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
       
    public function actionMainCont(){
        $this->getData();
        $Printer=new PrintDoc('NewContP4','Договор РУ',[
            'Client'=>$this->Data['Client']->getClRec(),
            'ClientPas'=>$this->Data['Client']->getPasport(),
            'ClientPhone'=>$this->Data['Client']->getContPhone(),
            'ClientAdr'=>$this->Data['Client']->getAdr(),
            'Front'=>$this->Data['ContP4']->getFront(),
            'Org'=>$this->Data['Org']->getRec(),
            'Branch'=>$this->Data['Branch']->getRec(),
            'Director'=>$this->Data['Director']->getEmp(),
            'DirectorDov'=>$this->Data['Director']->getEmpDov(),
            'PayCalend'=>$this->Data['ContP4']->getPayCalend(),
        ]);
        $DocName=$Printer->PrintDoc();
        header("Location: ".$DocName);        
    }
    
    public function actionDovComp(){
        $this->getData();

        $Printer=new PrintDoc('DovCompP4','Доверенность РУ',[
            'Client'=>$this->Data['Client']->getClRec(),
            'ClientPas'=>$this->Data['Client']->getPasport(),
            'ClientINN'=>$this->Data['Client']->getINN(),
            'ClientPens'=>$this->Data['Client']->getPens(),
            'ClientPhone'=>$this->Data['Client']->getContPhone(),
            'ClientAdr'=>$this->Data['Client']->getAdr(),
            'Front'=>$this->Data['ContP4']->getFront(),
            'Org'=>$this->Data['Org']->getRec(),
            'Branch'=>$this->Data['Branch']->getRec(),
            'Director'=>$this->Data['DirectorComp']->getEmp(),
            'DirectorDov'=>$this->Data['Director']->getEmpDov()            
        ]);
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    
    public function actionDovCompJur(){
        $this->getData();
        
        $Printer=new PrintDoc('DovCompJurP4','Доверенность РУ передоверие',[
            'Client'=>$this->Data['Client']->getClRec(),
            'ClientPas'=>$this->Data['Client']->getPasport(),
            'ClientINN'=>$this->Data['Client']->getINN(),
            'ClientPens'=>$this->Data['Client']->getPens(),
            'ClientPhone'=>$this->Data['Client']->getContPhone(),
            'ClientAdr'=>$this->Data['Client']->getAdr(),
            'Front'=>$this->Data['ContP4']->getFront(),
            'Org'=>$this->Data['Org']->getRec(),
            'Branch'=>$this->Data['Branch']->getRec(),
            'Director'=>$this->Data['DirectorComp']->getEmp(),
            'DirectorDov'=>$this->Data['Director']->getEmpDov(),
            'Jurist'=>$this->Data['Jurist']->getEmp(),
        ]);
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    
    
    
    public function actionWorkFinalAct(){
       
        
        $DocName=$Printer->PrintDoc();        
        header("Location: ".$DocName);
    }
    
    protected function getData(){
        $this->Data['Client']=new Client($_GET['ClCode']);             
        $this->Data['ContP4']=new ContP4($_GET['ContCode']);     
        if ($this->Data['ContP4']->getFront()->FROFFICE==""){
            $this->Data['Branch']=new Branch($_SESSION['EmBranch']);
        } else
        {
            $this->Data['Branch']=new Branch($this->Data['ContP4']->getFront()->FROFFICE);        
        }                
        $this->Data['Org']=new Organization($this->Data['Branch']->getRec()->BRORGPREF);        
        $this->Data['DirectorComp']=new Employee($this->Data['Org']->getRec()->ORGDIRNAME);        
        $this->Data['Director']=new Employee($this->Data['Branch']->getRec()->BRDIR);        
        $this->Data['Manager']=new Employee($this->Data['ContP4']->getFront()->FRPERSMANAGER);        
        $this->Data['Jurist']=new Employee($this->Data['ContP4']->getFront()->FRJURIST);        
    }
    
}
