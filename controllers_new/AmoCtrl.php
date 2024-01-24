<?php
/**
 * контроллер для работы с вьюшкой Амо
 *
 * @author Andrey
 */
class AmoCtrl extends ControllerMain{
    public $LeadList=[];
    public $AmoResult=[];
    
    public function actionIndex(){
        $this->ViewName='Amo View';
        $this->render('Amo',['AmoResult'=>$this->AmoResult]);
    }
    
    public function actionGetAuth(){
        $this->AmoResult=(new AmoMethods())->getAuth('');
        $this->actionIndex();
    }
    
    public function actionGetPipelineList(){
        $Model=new AmoMethods();
        $this->AmoResult=$Model->getPipelineList();
        $this->actionIndex();        
    }
    
    public function actionGetLead(){
        $Model=new AmoMethods();
        $LeadId=$_GET['leadid'];
        $this->AmoResult=$Model->getLeadById($LeadId);
        $this->actionIndex();
    }
    
    public function actionGetContact(){
        $Model=new AmoMethods();
        $this->AmoResult=$Model->getContact($_GET['contactid']);
        $this->actionIndex();
    }
        
    public function actionGetLeadList(){
        $repdf=substr($_GET['datef'],8,2); //день начала периода
        $repmf=substr($_GET['datef'],5,2); //месяц начала периода
        $repyf=substr($_GET['datef'],0,4); //год начала периода
        
        $repdl=substr($_GET['datel'],8,2); //день начала периода
        $repml=substr($_GET['datel'],5,2); //месяц начала периода
        $repyl=substr($_GET['datel'],0,4); //год начала периода
        
        $dtf=mktime(0,0,0,$repmf,$repdf,$repyf);
	$dtl=mktime(23,59,59,$repml,$repdl,$repyl);
        $strParam0='https://fpcalternative.amocrm.ru/api/v2/leads/';
        $strParam=$strParam0.'?limit_rows=500&&limit_offset=1&filter[date_create][from]='.$dtf.'&filter[date_create][to]='.$dtl; 
        
        $this->AmoResult=(new AmoMethods())->getLeadList($strParam);  
        $this->ResToExcel($this->AmoResult, 'Leads.xlsx');
        $this->actionIndex();
        
    } 
    
    public function ResToExcel($Leads,$File){
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle('Сделки из амо');
        $sheet->setCellValue("A1", "Сделки из амо");
        $sheet->setCellValue("A2", "ID");
        $sheet->setCellValue("B2", "дата создания");
        $sheet->setCellValue("C2", "статус");
        $sheet->setCellValue("D2", "воронка");
     
        $i=3;
        foreach ($Leads as $reprow){
            $sheet->setCellValueByColumnAndRow(1,$i,$reprow['id']);
            $sheet->setCellValueByColumnAndRow(2,$i,$reprow['created_at']);
            $sheet->setCellValueByColumnAndRow(3,$i,$reprow['status_id']);
            $sheet->setCellValueByColumnAndRow(4,$i,$reprow['pipeline_id']);           
            $i++;
        }
        //create file name  
        $FileName="{$_SERVER['DOCUMENT_ROOT']}/AltTech/downloads/{$File}.xlsx";
        //вывод в файл и сохранение
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $objWriter->save($FileName);
    }
}
