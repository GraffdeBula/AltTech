<?php
/**
 * контроллер для работы с вьюшкой Амо
 *
 * @author Andrey
 */
class AmoCtrl extends ControllerMain{
    public $LeadList=[];
    public $Pipelines=[];
    public $Users=[];
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
    
    public function actionGetUser(){
        $Model=new AmoMethods();
        $this->AmoResult=$Model->getUser();
        $this->actionIndex();
    }
            
    public function actionGetLeadList(){
        $this->getPipelines(); //формируем массив воронок
        $this->getUsers();
        
        $repdf=substr($_GET['datef'],8,2); //день начала периода
        $repmf=substr($_GET['datef'],5,2); //месяц начала периода
        $repyf=substr($_GET['datef'],0,4); //год начала периода
        
        $repdl=substr($_GET['datel'],8,2); //день начала периода
        $repml=substr($_GET['datel'],5,2); //месяц начала периода
        $repyl=substr($_GET['datel'],0,4); //год начала периода
        
        $dtf=mktime(0,0,0,$repmf,$repdf,$repyf);
	$dtl=mktime(23,59,59,$repml,$repdl,$repyl);
        $strParam0='https://fpcalternative.amocrm.ru/api/v2/leads/';
        
        $i=0;
        $leadnum=500;
        $this->LeadList=[];
        while($leadnum==500){
            $skip=$i*500;
            $strParam=$strParam0.'?limit_rows=500&&limit_offset='.$skip.'&filter[date_create][from]='.$dtf.'&filter[date_create][to]='.$dtl;
            $LeadPart=(new AmoMethods())->getLeadList($strParam);
            $this->LeadList= array_merge($this->LeadList,$LeadPart);
            $i++;
            $leadnum=count($LeadPart);
        }
                         
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
        $sheet->setCellValue("A2", "Дата");
        $sheet->setCellValue("B2", "ID");
        $sheet->setCellValue("C2", "Сделка");
        $sheet->setCellValue("D2", "Клиент");
        $sheet->setCellValue("E2", "Телефон");
        $sheet->setCellValue("F2", "Воронка");
        $sheet->setCellValue("G2", "Ответственный");
        $sheet->setCellValue("H2", "Источник");
        $sheet->setCellValue("I2", "Город");
        $sheet->setCellValue("J2", "Тип");
     
        $i=3;
        foreach ($Leads as $reprow){
            $j=1;
            foreach($reprow as $key=>$repfield){
                $sheet->setCellValueByColumnAndRow($key+1,$i,$reprow[$key]);
            }            
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
            if(in_array($Lead['pipeline_id'],[532060,4998399])){
                continue;
            }
            $Model=new AmoMethods();
            if(isset($Lead['main_contact']['id'])){
                $Contact=$Model->getContact($Lead['main_contact']['id']);
            }else{
                $Contact=['id'=>0,'name'=>''];
            }
            
            $CustField=$this->getCustomFields($Lead,$Contact);
            $Type=$this->getTag($Lead);
            $this->AmoResult[]=[
                date('d.m.Y',$Lead['created_at']),
                $Lead['id'],
                $Lead['name'],
                $Contact['name'],
                $CustField[2],
                $this->Pipelines[$Lead['pipeline_id']],
                $this->Users[$Lead['responsible_user_id']],
                $CustField[0],
                $CustField[1],
                $Type,
            ];                
        }
    }
    
    protected function getCustomFields($Lead,$Contact){
        $CustField=['','',''];
        if(isset($Lead['custom_fields'])){
            foreach ($Lead['custom_fields'] as $Ord=>$Field){
                if($Field['id']==1680596){
                    $CustField[0]=$Field['values'][0]['value'];
                }
                if($Field['id']==1672870){
                    $CustField[1]=$Field['values'][0]['value'];
                }
            }
        }
        if(isset($Contact['custom_fields'])){
            foreach ($Contact['custom_fields'] as $Ord=>$Field){
                if($Field['id']==646794){
                    $CustField[2]=$Field['values'][0]['value'];
                }            
            }
        }
        
        return $CustField;
    }
    
    protected function getTag($Lead){
        $Type='Заявка';
        foreach($Lead['tags'] as $Ord=>$Tag){
            if(in_array($Tag['name'], ['tg','wa','#VK','входящий звонок','пропущенный звонок'])){
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
    
    protected function getUsers(){
        $this->Users=[];
        $Model=new AmoMethods();        
        $Result=$Model->getUsers();
        foreach ($Result as $key=>$User){
            $this->Users[$User['id']]=$User['name'];
        }
    }
}
