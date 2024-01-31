<?php
/**
 * контроллер для работы с вьюшкой Амо
 *
 * @author Andrey
 */
class AmoCtrl extends ControllerMain{
    public $LeadList=[];
    public $Pipelines=[];
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
        $Result=$Model->getPipelineList();
        foreach ($Result as $key=>$Pipeline){
            $this->AmoResult[$Pipeline['id']]=$Pipeline['name'];
        }
        $this->actionIndex();        
    }
    
    public function actionGetLead(){
        $Model=new AmoMethods();
        $LeadId=$_GET['leadid'];
        $this->AmoResult=$Model->getLeadById($LeadId);
        $this->actionIndex();
    }
    
    public function actionGetCustomFields(){
        $Model=new AmoMethods();
        $LeadId=$_GET['leadid'];
        $this->AmoResult=$Model->getLeadById($LeadId)['custom_fields'];
        $this->actionIndex();
    }
    
    public function actionGetTags(){
        $Model=new AmoMethods();
        $LeadId=$_GET['leadid'];
        $this->AmoResult=$Model->getLeadById($LeadId)['tags'];
        $this->actionIndex();
    }
    
    public function actionGetContact(){
        $Model=new AmoMethods();
        $this->AmoResult=$Model->getContact($_GET['contactid']);
        $this->actionIndex();
    }
    
    public function actionGetContactList(){
        $Model=new AmoMethods();
        $this->AmoResult=$Model->getContactList($_GET['contactid']);
        $this->actionIndex();
    }
    
    public function actionStrToLower(){
        #$word=mb_convert_case($_GET['mystring'],MB_CASE_LOWER, "UTF-8");
        $word=mb_convert_case($_GET['mystring'],MB_CASE_TITLE, "UTF-8");
        $this->AmoResult=[0=>$word];
        $this->actionIndex();
    }
        
    public function actionGetLeadList(){
        $this->getPipelines(); //формируем массив воронок
        
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
        
        $this->LeadList=(new AmoMethods())->getLeadList($strParam);
        $this->createLeadArr();
        
        $this->ResToExcel($this->AmoResult, 'Leads');
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
            $sheet->setCellValueByColumnAndRow(1,$i,$reprow[0]);
            $sheet->setCellValueByColumnAndRow(2,$i,$reprow[1]);
            $sheet->setCellValueByColumnAndRow(3,$i,$reprow[2]);
            $sheet->setCellValueByColumnAndRow(4,$i,$reprow[3]);           
            $sheet->setCellValueByColumnAndRow(5,$i,$reprow[4]);
            $sheet->setCellValueByColumnAndRow(6,$i,$reprow[5]);
            $sheet->setCellValueByColumnAndRow(7,$i,$reprow[6]);
            $sheet->setCellValueByColumnAndRow(8,$i,$reprow[7]);
            $i++;
        }
        //create file name  
        $FileName="{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/downloads/{$File}.xlsx";
        //вывод в файл и сохранение
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $objWriter->save($FileName);
    }
    
    public function createLeadArr(){
        $this->AmoResult=[];
        foreach ($this->LeadList as $Ord=>$Lead){
            $Model=new AmoMethods();
            if(isset($Lead['main_contact']['id'])){
                $Contact=$Model->getContact($Lead['main_contact']['id']);
            }else{
                $Contact=['id'=>0,'name'=>''];
            }
            $CustField=$this->getCustomFields($Lead);
            $Type=$this->getTag($Lead);
            $this->AmoResult[]=[
                date('d.m.Y',$Lead['created_at']),
                $Lead['id'],
                $Lead['name'],
                $Contact['name'],
                $this->Pipelines[$Lead['pipeline_id']],
                $CustField[0],
                $CustField[1],
                $Type,
            ];                
        }
    }
    
    protected function getCustomFields($Lead){
        $CustField=['',''];
        $CustomFields=$Lead['custom_fields'];
        foreach ($CustomFields as $Ord=>$Field){
            if($Field['id']==1680596){
                $CustField[0]=$Field['values'][0]['value'];
            }
            if($Field['id']==1672870){
                $CustField[1]=$Field['values'][0]['value'];
            }
        }
        
        return $CustField;
    }
    
    protected function getTag($Lead){
        $Type='Заявка';
        foreach($Lead['tags'] as $Ord=>$Tag){
            if(in_array($Tag['name'], ['tg','wa','#VK'])){
                $Type=$Tag['name'];
            }
        }
        return $Type;
    }
    
    protected function getPipelines(){
        $this->Pipelines=[];
        $Model=new AmoMethods();        
        $Result=$Model->getPipelineList();
        foreach ($Result as $key=>$Pipeline){
            $this->Pipelines[$Pipeline['id']]=$Pipeline['name'];
        }
    } 
}
