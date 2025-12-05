<?php
/**
 * контроллер для работы с вьюшкой Амо
 *
 * @author Andrey
 */
class OutcomesCtrl extends ControllerMain{
    protected $OutcomesList=[];  
    protected $TotalOutcomes=0;
    protected $TotalIncomes=0;
    protected $OutcomeDr;
    protected $DateF='';
    protected $DateL='';
    
    public function actionIndex(){
        $this->ViewName='Учёт расходов';
        $_SESSION['DateF']='';
        $_SESSION['DateL']='';
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
        
        $this->getOutcomes();
        
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
        $this->getOutcomes();
        
        $this->render('Outcomes',
            ['OutcomeList'=>$this->OutcomesList,
                'TotalOutcomes'=>$this->TotalOutcomes,
                'TotalIncomes'=>$this->TotalIncomes,
                'OutcomeDr'=>$this->OutcomeDr,
                'Dates'=>[$this->DateF,$this->DateL],                
            ]
        );
    }
    
    public function actionAddOutcome(){        
        (new OutcomesMod())->addOutcome($_GET['OutBranch'],$_GET['OutDate'],$_GET['OutSum'],$_GET['Outcome'],$_GET['Comment'],$_GET['OutcomeType']);
        header("Location: index_admin.php?controller=OutcomesCtrl");
    }
    
    protected function getOutcomes(){        
        $this->OutcomeDr=(new OutcomesMod())->getOutcomesDr();
        $this->OutcomesList=(new OutcomesMod())->getOutcomes($_SESSION['OutcomesBranch'],$this->DateF,$this->DateL);
                
        $Sql='SELECT SUM(OutSum) AS TotSum FROM tbl6Outcomes WHERE OutBranch=? AND (OutDate BETWEEN ? AND ?)';
        $this->TotalOutcomes=0;
        if (isset(db2::getInstance()->FetchOne($Sql,[$_SESSION['OutcomesBranch'],$this->DateF,$this->DateL])->TOTSUM)){
            $this->TotalOutcomes=db2::getInstance()->FetchOne($Sql,[$_SESSION['OutcomesBranch'],$this->DateF,$this->DateL])->TOTSUM;
        }
        $Sql='SELECT SUM(PaySUM) AS TotSum FROM tbl5Payments WHERE ContBranch=? AND (PayDate BETWEEN ? AND ?) AND PayType>?';
        $this->TotalIncomes=0;
        if (isset(db2::getInstance()->FetchOne($Sql,[$_SESSION['OutcomesBranch'],$this->DateF,$this->DateL,10])->TOTSUM)){
            $this->TotalIncomes=db2::getInstance()->FetchOne($Sql,[$_SESSION['OutcomesBranch'],$this->DateF,$this->DateL,10])->TOTSUM;
        }
    }
    
    
}
