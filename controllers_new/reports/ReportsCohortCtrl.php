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
        $this->render('reports/CohortRep',['Contracts'=>[],'Pays'=>[]]);    
    }
    
    public function actionCohortRep(){        
        $DateF1=new DateTime($_GET['DateF']);
        $DateL1=new DateTime($_GET['DateL']);
                                               
        $RepContracts=$this->getRepContTab($DateF1->format('d.m.Y'),$DateL1->format('d.m.Y'));
                
        foreach($RepContracts as $key=>$RepStr){
            
            $RepContracts[$key][5]=$this->getPays($RepStr[4]);            
        }
                 
        $this->render('reports/CohortRep',['Contracts'=>$RepContracts]);
            
    }
    
    protected function getRepContTab($DateF,$DateL){
        
        $Sql='SELECT Count(ContCode),FrOffice,Sum(FrContSum),FrContPeriod FROM tblP1Front WHERE FrContDate BETWEEN ? AND ? GROUP BY FrOffice,FrContPeriod ORDER BY FrOffice,FrContPeriod';
        
        $ContList=db2::getInstance()->FetchAll($Sql,[$DateF,$DateL]);
        
        $ContArr=[];
        
        foreach($ContList as $Cont){
            $ContArr[]=[$Cont->FROFFICE,$Cont->FRCONTPERIOD,$Cont->COUNT,$Cont->SUM,$this->getContArrStr($DateF,$DateL,$Cont->FROFFICE,$Cont->FRCONTPERIOD)];
        }
        
        return $ContArr;
    }
    
    protected function getContArrStr($DateF,$DateL,$Branch,$Period){
        
        $Sql='SELECT ContCode FROM tblP1Front WHERE (FrContDate BETWEEN ? AND ?) AND FrOffice=? AND FrContPeriod=?';
        
        $ContCode=db2::getInstance()->FetchAll($Sql,[$DateF,$DateL,$Branch,$Period]);
        
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
    
    protected function getPays($ContList){
        $PaysArr=[];
        $DateF1=new DateTime($_GET['DateF']);
        $DateL1=new DateTime($_GET['DateL']);
        
        for($i=1; $i<=6; $i++){
            $PaysArr[$i]='-';
            (new ConvertFunctions())->AddMonth($DateF1);
            (new ConvertFunctions())->AddMonth($DateL1);
            
            $Sql='SELECT Count(Distinct ContCode) AS ContNum FROM tbl5payments WHERE (PayDate BETWEEN ? AND ?) AND ContCode IN ('.$ContList.')';
            $Pays=db2::getInstance()->FetchOne($Sql,[$DateF1->format('d.m.Y'),$DateL1->format('d.m.Y')]);
            if ($Pays==NULL){
                $PaysArr[$i]='-';
            } else {
                $PaysArr[$i]=$Pays->CONTNUM;
            }
        }
                       
        return $PaysArr;
    }
}
