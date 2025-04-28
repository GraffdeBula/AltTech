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
    
    public function actionIndex(){
        $this->ViewName='Учёт расходов';
        
        $this->getOutcomes();
        
        $this->render('Outcomes',['OutcomeList'=>$this->OutcomesList,'TotalOutcomes'=>$this->TotalOutcomes,'TotalIncomes'=>$this->TotalIncomes]);
    }
    
    public function actionAddOutcome(){
        $Sql='INSERT INTO tbl6Outcomes (OutDate,OutSum,Outcome) VALUES (?,?,?)';
        db2::getInstance()->Query($Sql,[$_GET['OutDate'],$_GET['OutSum'],$_GET['Outcome']]);
        header("Location: index_admin.php?controller=OutcomesCtrl");
    }
    
    protected function getOutcomes(){
        $Sql='SELECT ID,OutDate,OutSum,Outcome FROM tbl6Outcomes ORDER BY Id DESC';
        $this->OutcomesList=db2::getInstance()->FetchAll($Sql,[]);
        
        $Sql='SELECT SUM(OutSum) AS TotSum FROM tbl6Outcomes WHERE OutDate BETWEEN ? AND ?';
        $this->TotalOutcomes=db2::getInstance()->FetchOne($Sql,['01.04.2025','30.04.2025'])->TOTSUM;
        
        $Sql='SELECT SUM(PaySUM) AS TotSum FROM tbl5Payments WHERE (PayDate BETWEEN ? AND ?) AND ContBranch=? AND PayType<?';
        $this->TotalIncomes=db2::getInstance()->FetchOne($Sql,['01.04.2025','30.04.2025','ОП Томск',10])->TOTSUM;
    }
}
