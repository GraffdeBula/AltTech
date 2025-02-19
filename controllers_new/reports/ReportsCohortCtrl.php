<?php
/**
 * Контроллер для загрузки отчёта для когортного анализа по договорам
 *
 * @author Andrey
 */
class ReportsCohortCtrl extends ControllerMain{
        
    protected $Report=[];
    protected $ContArrStr='';
    
    public function actionCohortRepForm(){//Форма для отчёта
        $this->render('reports/CohortRep',['Contracts'=>[]]);    
    }
    
    public function actionCohortRep(){        
        $DateF1=new DateTime($_GET['DateF']);
        $DateL1=new DateTime($_GET['DateL']);
                                       
        $this->ContArrStr=$this->getContArrStr($DateF1->format('d.m.Y'),$DateL1->format('d.m.Y'));
        $Contracts=$this->getContList($DateF1->format('d.m.Y'),$DateL1->format('d.m.Y'));
        
        $Pays=[];
        for($i=1; $i<=6; $i++){ 

            (new ConvertFunctions())->AddMonth($DateF1);
            (new ConvertFunctions())->AddMonth($DateL1);

            $Pays[$i]=$this->getPays($DateF1->format('d.m.Y'),$DateL1->format('d.m.Y'));
        }
                                        
        $this->render('reports/CohortRep',['Contracts'=>$Contracts,'Pays'=>$Pays]);
            
    }
    
    protected function getContList($DateF,$DateL){
        
        $Sql='SELECT Count(ContCode),FrOffice,Sum(FrContSum),FrContPeriod FROM tblP1Front WHERE FrContDate BETWEEN ? AND ?  GROUP BY FrOffice,FrContPeriod ORDER BY FrOffice,FrContPeriod';
        
        $ContList=db2::getInstance()->FetchAll($Sql,[$DateF,$DateL]);
        
        $ContArr=[];
        
        foreach($ContList as $Cont){
            $ContArr[$Cont->FROFFICE]=[$Cont->COUNT,$Cont->SUM];
        }
        
        return $ContArr;
    }
    
    protected function getContArrStr($DateF,$DateL){
        
        $Sql='SELECT ContCode FROM tblP1Front WHERE FrContDate BETWEEN ? AND ?';
        
        $ContCode=db2::getInstance()->FetchAll($Sql,[$DateF,$DateL]);
        
        $ContArr='';
        foreach($ContCode as $Cont){
            if ($ContArr=='') {
                $ContArr=$ContArr.$Cont->CONTCODE;                        
            }else{
                $ContArr=$ContArr.','.$Cont->CONTCODE;
            }
        }
        
        return $ContArr;
    }
    
    protected function getPays($DateF,$DateL){
        $Sql='SELECT Count(Distinct ContCode),Sum(PaySum),ContBranch FROM tbl5payments WHERE (PayDate BETWEEN ? AND ?) AND ContCode IN ('.$this->ContArrStr.') GROUP BY ContBranch';
        $Pays=db2::getInstance()->FetchAll($Sql,[$DateF,$DateL]);
        $PayArr=[];
        foreach($Pays as $Pay){
            $PayArr[$Pay->CONTBRANCH]=[$Pay->COUNT,$Pay->SUM];
        }
        return $PayArr;
    }
}
