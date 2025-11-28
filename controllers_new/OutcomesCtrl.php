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
    
    
    public function actionIndex(){
        $this->ViewName='Учёт расходов';
        
        if (isset($_GET['BranchName'])) {
            $Branch=$_GET['BranchName'];
        }else{
            $Branch=$_SESSION['EmBranch'];
        }
        if (isset($_GET['DateF'])){
            $DateF=$_GET['DateF'];
        }else{
            $DateF=date('Y-m-01');
        }
        if (isset($_GET['DateL'])){
            $DateL=$_GET['DateL'];
        }else{
            $LastDay='31';
            if (in_array(date('m'),[4,6,9,11])){
                $LastDay='30';
            }elseif(in_array(date('m'),[2,])){
                $LastDay='28';
            }
            $DateL=date('Y-m-'.$LastDay);
        }
        $this->getOutcomes($Branch,$DateF,$DateL);
        
        $this->render('Outcomes',
            ['OutcomeList'=>$this->OutcomesList,
                'TotalOutcomes'=>$this->TotalOutcomes,
                'TotalIncomes'=>$this->TotalIncomes,
                'OutcomeDr'=>$this->OutcomeDr,
                'Dates'=>[$DateF,$DateL],
            ]);
    }
    /*
     */
    public function actionAddOutcome(){
        $Sql='INSERT INTO tbl6Outcomes (OutBranch,OutDate,OutSum,Outcome,Comment,OutcomeType) VALUES (?,?,?,?,?,?)';
        db2::getInstance()->Query($Sql,[$_GET['OutBranch'],$_GET['OutDate'],$_GET['OutSum'],$_GET['Outcome'],$_GET['Comment'],$_GET['OutcomeType']]);
        header("Location: index_admin.php?controller=OutcomesCtrl");
    }
    
    protected function getOutcomes($Branch,$DateF,$DateL){
        $Sql='SELECT * FROM tbl6DROutcomes ORDER BY Id DESC';
        $this->OutcomeDr=db2::getInstance()->FetchAll($Sql,[]);
        
        $Sql='SELECT * FROM tbl6Outcomes WHERE OutBranch=? AND (OutDate BETWEEN ? AND ?) ORDER BY Id DESC';
        $this->OutcomesList=db2::getInstance()->FetchAll($Sql,[$Branch,$DateF,$DateL]);
        
        $Sql='SELECT SUM(OutSum) AS TotSum FROM tbl6Outcomes WHERE OutBranch=? AND (OutDate BETWEEN ? AND ?)';
        $this->TotalOutcomes=0;
        if (isset(db2::getInstance()->FetchOne($Sql,[$Branch,$DateF,$DateL])->TOTSUM)){
            $this->TotalOutcomes=db2::getInstance()->FetchOne($Sql,[$Branch,$DateF,$DateL])->TOTSUM;
        }
        $Sql='SELECT SUM(PaySUM) AS TotSum FROM tbl5Payments WHERE ContBranch=? AND (PayDate BETWEEN ? AND ?) AND PayType>?';
        $this->TotalIncomes=0;
        if (isset(db2::getInstance()->FetchOne($Sql,[$Branch,$DateF,$DateL,10])->TOTSUM)){
            $this->TotalIncomes=db2::getInstance()->FetchOne($Sql,[$Branch,$DateF,$DateL,10])->TOTSUM;
        }
    }
    
    
}
