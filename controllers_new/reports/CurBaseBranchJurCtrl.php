<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class CurBaseBranchJurCtrl extends ControllerMain{
    protected $ContList=[];
    protected $JurList=[];
    protected $ArchList=[];
    protected $StopList=[];
    protected $BranchList=[];
    
    public function __construct(){
        $this->BranchList=(new Branch())->getBranchList();
    }
    
    public function actionIndex(){
        
        $this->ViewName='Судебная стадия';
        $Args=[
            'BranchList'=>$this->BranchList,
            'JurList'=>$this->JurList,
            
        ];
        $this->render('reports/CurBaseBranchJurRep',$Args);
    }
    
    public function actionUpdate(){
        
        
        $this->render('reports/CurBaseBranchJurRep',$Args);
    }
    
    public function actionShowBrBase(){
        if ((!isset($_GET['Branch']))OR($_GET['Branch']=='')){
            $this->actionIndex();            
        }
        $this->ViewName='Действующая база клиентов - '.$_GET['Branch'];        
        $this->JurList=(new ReportsMod())->getCurrentBaseJurBranch($_GET['Branch']);
                        
        $RepCols=[
            'A2'=>'ClCode',
            'B2'=>'ContCode',
            'C2'=>'ФИО',
            'D2'=>'Подразделение',            
            'E2'=>'Дата дог.',
            'F2'=>'Тариф',
            'G2'=>'Сумма договора',            
            'H2'=>'Статус',
            'I2'=>'Дата подготовки иска',
            'J2'=>'Дата списания долга',
            
        ];
        (new RepToExcel())->exportReport($this->JurList,$RepCols,$_GET['Branch'],'Действующая база ЮС '.$_GET['Branch']);
                      
        $Args=[
            'BranchList'=>$this->BranchList,
            'JurList'=>$this->JurList,            
        ];
        
        $this->render('reports/CurBaseBranchJurRep',$Args);
    }
                              
}
