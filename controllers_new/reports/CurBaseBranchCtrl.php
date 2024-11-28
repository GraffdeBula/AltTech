<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class CurBaseBranchCtrl extends ControllerMain{
    protected $ContList=[];
    protected $BranchList=[];
    
    public function __construct(){
        $this->BranchList=(new Branch())->getBranchList();
    }
    
    public function actionIndex(){
        
        $this->ViewName='Отчёт по действующей базе';
        $this->render('reports/CurBaseBranchRep',['BranchList'=>$this->BranchList,'ContList'=>$this->ContList]);
    }
    
    public function actionShowBrBase(){
        if ((!isset($_GET['Branch']))OR($_GET['Branch']=='')){
            $this->actionIndex();            
        }
        $this->ViewName='Действующая база клиентов - '.$_GET['Branch'];
        $this->ContList=(new ReportsMod())->getCurrentBaseBranch($_GET['Branch']);
        
        $RepCols=[
            'A2'=>'ClCode',
            'B2'=>'ContCode',
            'C2'=>'ФИО',
            'D2'=>'Подразделение',
            'E2'=>'Менеджер',
            'F2'=>'Дата дог.',
            'G2'=>'Тариф',
            'H2'=>'Сумма договора',
            'I2'=>'Статус',
            
        ];
        (new RepToExcel())->exportReport($this->ContList,$RepCols,'Действующая база '.$_GET['Branch'],'Действующая база '.$_GET['Branch']);
        
        $this->render('reports/CurBaseBranchRep',['ContList'=>$this->ContList,'BranchList'=>$this->BranchList]);
    }
                              
}
