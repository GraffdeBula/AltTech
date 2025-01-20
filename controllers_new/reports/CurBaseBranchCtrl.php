<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class CurBaseBranchCtrl extends ControllerMain{
    protected $ContList=[];
    protected $JurList=[];
    protected $ArchList=[];
    protected $StopList=[];
    protected $BranchList=[];
    
    public function __construct(){
        $this->BranchList=(new Branch())->getBranchList();
    }
    
    public function actionIndex(){
        
        $this->ViewName='Отчёт по действующей базе';
        $Args=[
            'BranchList'=>$this->BranchList,
            'ContList'=>$this->ContList,
            'JurList'=>$this->JurList,
            'StopList'=>$this->StopList,            
            'ArchList'=>$this->ArchList,       
        ];
        $this->render('reports/CurBaseBranchRep',$Args);
    }
    
    public function actionUpdate(){
        
        
        $this->render('reports/CurBaseBranchRep',$Args);
    }
    
    public function actionShowBrBase(){
        if ((!isset($_GET['Branch']))OR($_GET['Branch']=='')){
            $this->actionIndex();            
        }
        $this->ViewName='Действующая база клиентов - '.$_GET['Branch'];
        $this->ContList=(new ReportsMod())->getCurrentBaseBranch($_GET['Branch']);
        $this->JurList=(new ReportsMod())->getCurrentBaseJurBranch($_GET['Branch']);
        $this->StopList=(new ReportsMod())->getCurrentBasePayStopBranch($_GET['Branch']);
        $this->ArchList=(new ReportsMod())->getArchBaseArchBranch($_GET['Branch']);
                
        $RepCols=[
            'A2'=>'ClCode',
            'B2'=>'ContCode',
            'C2'=>'ФИО',
            'D2'=>'Подразделение',
            'E2'=>'Менеджер',
            'F2'=>'Дата дог.',
            'G2'=>'Тариф',
            'H2'=>'Сумма договора',
            'I2'=>'Внесено по договору',
            'J2'=>'Статус',
            
        ];
        (new RepToExcel())->exportReport($this->ContList,$RepCols,'Действующие','Действующая база '.$_GET['Branch']);
        
        $RepCols=[
            'A2'=>'ClCode',
            'B2'=>'ContCode',
            'C2'=>'ФИО',
            'D2'=>'Дата договора',
            'E2'=>'Статус',
            'F2'=>'Юрист',
            'G2'=>'Номер дела',
            'H2'=>'АУ',
            'I2'=>'Дата подготовки',
            'J2'=>'Дата подачи иска',
            'K2'=>'Дата введения реструктуризации',
            'L2'=>'Дата завершения реструктуризации',
            'M2'=>'Дата введения реализации',
            'N2'=>'Дата завершения реализации',
            'O2'=>'Дата мирового',
            'P2'=>'Дата списания долга',
            
        ];
        (new RepToExcel())->exportReport($this->JurList,$RepCols,'ДД юрстадия ','ДД юрстадия '.$_GET['Branch']);
        
        $RepCols=[
            'A2'=>'ClCode',
            'B2'=>'ContCode',
            'C2'=>'ФИО',
            'D2'=>'Филиал',
            'E2'=>'Статус',
            'F2'=>'Дата договора',
            'G2'=>'Тариф',
            'H2'=>'Сумма договора',
            'I2'=>'Выплачено',       
        ];
        (new RepToExcel())->exportReport($this->StopList,$RepCols,'ДД приостановлены','ДД приостановлены '.$_GET['Branch']);
        
        $RepCols=[
            'A2'=>'ClCode',
            'B2'=>'ContCode',
            'C2'=>'ФИО',
            'D2'=>'Филиал',
            'E2'=>'Статус',
            'F2'=>'Дата договора',
            'G2'=>'Тариф',
            'H2'=>'Сумма договора',
            'I2'=>'Выплачено',
            'J2'=>'Дата банкротства',
            'K2'=>'Дата завершения работы',
            'L2'=>'Комментарий',
        ];
        (new RepToExcel())->exportReport($this->ArchList,$RepCols,'Архивные договоры','Архивные договоры '.$_GET['Branch']);
        
        $Args=[
            'BranchList'=>$this->BranchList,
            'ContList'=>$this->ContList,
            'JurList'=>$this->JurList,
            'StopList'=>$this->StopList,            
            'ArchList'=>$this->ArchList,            
        ];
        
        $this->render('reports/CurBaseBranchRep',$Args);
    }
                              
}
