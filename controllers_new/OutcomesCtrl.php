<?php
/**
 * контроллер для работы с вьюшкой Амо
 *
 * @author Andrey
 */
class OutcomesCtrl extends ControllerMain{
    protected $OutcomesList=[];  
    protected $TotalOutcomes=[];
    protected $TotalIncomes=[];
    protected $OtherIncomes=[];
    protected $TotalIncomesDays=[];
    protected $OutcomeDr;
    protected $DateF='';
    protected $DateL='';
    
    public function actionIndex(){
        $this->ViewName='Учёт расходов';
        $this->DateF=date('Y-m-01');        
        $LastDay='31';
        if (in_array(date('m'),[4,6,9,11])){
            $LastDay='30';
        }elseif(in_array(date('m'),[2,])){
            $LastDay='28';
        }
        $this->DateL=date('Y-m-'.$LastDay);
        $_SESSION['DateF']=$this->DateF;
        $_SESSION['DateL']=$this->DateL;
        
        if (isset($_GET['BranchName'])) {
           $_SESSION['OutcomesBranch']=$_GET['BranchName'];
        }
        
        if (isset($_SESSION['OutcomesBranch'])){
            $_SESSION['OutcomesBranch']=$_SESSION['OutcomesBranch'];
        } else {
            if (in_array($_SESSION['EmRole'],['top','admin'])){
                $_SESSION['OutcomesBranch']='';
            } else {
                $_SESSION['OutcomesBranch']=$_SESSION['EmBranch'];
            }
        }
        
        if (isset($_GET['BranchName'])) {
            $Branch=$_GET['BranchName'];
        }else{
            $Branch=$_SESSION['OutcomesBranch'];
        }
        
        $this->getData();
        
        $this->actionShowOutcomes();
    }
    /*
     */
    public function actionFilterOutcomes(){
        if (isset($_GET['BranchName'])) {
           $_SESSION['OutcomesBranch']=$_GET['BranchName'];
        }
        if (isset($_GET['DateF'])) {
           $_SESSION['DateF']=$_GET['DateF'];
        }
        if (isset($_GET['DateL'])) {
           $_SESSION['DateL']=$_GET['DateL'];
        }
        
        if (isset($_GET['DateF'])){
            $this->DateF=$_GET['DateF'];
        }else{
            $this->DateF=date('Y-m-01');
        }
        if (isset($_GET['DateL'])){
            $this->DateL=$_GET['DateL'];
        }else{
            $LastDay='31';
            if (in_array(date('m'),[4,6,9,11])){
                $LastDay='30';
            }elseif(in_array(date('m'),[2,])){
                $LastDay='28';
            }
            $this->DateL=date('Y-m-'.$LastDay);
        }
        
        $this->actionShowOutcomes();
    }
    
    public function actionShowOutcomes(){
        $this->getData();
        
        $this->render('Outcomes',
            ['OutcomeList'=>$this->OutcomesList,
                'TotalOutcomes'=>$this->TotalOutcomes,
                'TotalIncomes'=>$this->TotalIncomes,
                'OtherIncomes'=>$this->OtherIncomes,
                'TotalIncomesDays'=>$this->TotalIncomesDays,
                'OutcomeDr'=>$this->OutcomeDr,
                'Dates'=>[$this->DateF,$this->DateL],                
            ]
        );
    }
    
    public function actionAddOutcome(){        
        (new OutcomesMod())->addOutcome($_GET['OutBranch'],$_GET['OutDate'],$_GET['OutSum'],$_GET['Outcome'],$_GET['Comment'],$_GET['OutcomeType']);
        $_SESSION['OutcomesBranch']=$_GET['BranchName'];
        $this->actionShowOutcomes();
    }
    
    protected function getData(){  
        $Model=new OutcomesMod();
        $this->OutcomeDr=$Model->getOutcomesDr();
        $this->OutcomesList=$Model->getOutcomes($_SESSION['OutcomesBranch'],$this->DateF,$this->DateL);
        $OutcomesArray=[];
        foreach($this->OutcomesList as $Outcome){
            $Date=(new DateTime($Outcome->OUTDATE))->format('d.m.Y');
            if ($Outcome->OUTCOMETYPE=='С расчётного счёта'){
                if (isset($OutcomesArray[$Date][0])){
                    $OutcomesArray[$Date][0]=$OutcomesArray[$Date][0]+$Outcome->OUTSUM;
                }else{
                    $OutcomesArray[$Date][0]=$Outcome->OUTSUM;
                }
            }
            if ($Outcome->OUTCOMETYPE=='Наличные Б'){ 
                if (isset($OutcomesArray[$Date][1])){
                    $OutcomesArray[$Date][1]=$OutcomesArray[$Date][1]+$Outcome->OUTSUM;
                }else{
                    $OutcomesArray[$Date][1]=$Outcome->OUTSUM;
                }
            }
            if ($Outcome->OUTCOMETYPE=='Наличные С'){
                if (isset($OutcomesArray[$Date][2])){
                    $OutcomesArray[$Date][2]=$OutcomesArray[$Date][2]+$Outcome->OUTSUM;
                }else{
                    $OutcomesArray[$Date][2]=$Outcome->OUTSUM;
                }
            }
            
        }
        
        $this->TotalIncomes=[
            $Model->getTotalPayments($_SESSION['OutcomesBranch'],$this->DateF,$this->DateL,2,'Безналичный')->PAYSUM,
            $Model->getTotalPayments($_SESSION['OutcomesBranch'],$this->DateF,$this->DateL,2,'Наличные')->PAYSUM,
            $Model->getTotalPayments($_SESSION['OutcomesBranch'],$this->DateF,$this->DateL,1,'Наличные')->PAYSUM,            
        ];
        $this->TotalIncomes[3]=$this->TotalIncomes[0]+$this->TotalIncomes[1]+$this->TotalIncomes[2];
        $this->TotalOutcomes=[
            $Model->getTotalOutcomes($_SESSION['OutcomesBranch'],$this->DateF,$this->DateL,'Безналичный расчёт')->PAYSUM,
            $Model->getTotalOutcomes($_SESSION['OutcomesBranch'],$this->DateF,$this->DateL,'Наличные по чеку')->PAYSUM,
            $Model->getTotalOutcomes($_SESSION['OutcomesBranch'],$this->DateF,$this->DateL,'Наличные по ПКО')->PAYSUM,            
        ];
        $this->TotalOutcomes[3]=$this->TotalOutcomes[0]+$this->TotalOutcomes[1]+$this->TotalOutcomes[2];
        $this->OtherIncomes=[
            $Model->getOtherIncomes($_SESSION['OutcomesBranch'],$this->DateF,$this->DateL,'Безналичный расчёт')->PAYSUM,
            $Model->getOtherIncomes($_SESSION['OutcomesBranch'],$this->DateF,$this->DateL,'Наличные по чеку')->PAYSUM,
            $Model->getOtherIncomes($_SESSION['OutcomesBranch'],$this->DateF,$this->DateL,'Наличные по ПКО')->PAYSUM,            
        ];
        $this->OtherIncomes[3]=$this->OtherIncomes[0]+$this->OtherIncomes[1]+$this->OtherIncomes[2];
        
        $this->TotalIncomesDays=[];
        $Date1=new DateTime($this->DateF);
        $Datel=new DateTime($this->DateL);
        while($Date1->getTimestamp()<=$Datel->getTimestamp()){
            
            $this->TotalIncomesDays[$Date1->format('d.m.Y')]=[];
            if (isset($OutcomesArray[$Date1->format('d.m.Y')][0])){
                $this->TotalIncomesDays[$Date1->format('d.m.Y')][0]=$OutcomesArray[$Date1->format('d.m.Y')][0];                 
            }else{
                $this->TotalIncomesDays[$Date1->format('d.m.Y')][0]=0; 
            }
            if (isset($OutcomesArray[$Date1->format('d.m.Y')][1])){
                $this->TotalIncomesDays[$Date1->format('d.m.Y')][1]=$OutcomesArray[$Date1->format('d.m.Y')][1];                 
            }else{
                $this->TotalIncomesDays[$Date1->format('d.m.Y')][1]=0; 
            }
            if (isset($OutcomesArray[$Date1->format('d.m.Y')][2])){
                $this->TotalIncomesDays[$Date1->format('d.m.Y')][2]=$OutcomesArray[$Date1->format('d.m.Y')][2];                 
            }else{
                $this->TotalIncomesDays[$Date1->format('d.m.Y')][2]=0; 
            }

            $Date1->add(new DateInterval('P1D'));
        }
   
    }
  
    
}
