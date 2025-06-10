<?php
/**
 * контроллер управления главной формой
 *
 * функции
 * 
 */
class ATRefProgCtrl extends ControllerMain {
    protected $Params=[];    
    protected $Refers=[];    
    protected $FullRefers=[];    
    
    
    public function actionIndex(){        
        $this->GetRefers();    
        $this->ExportToExcel((new AT7ReferProg())->GetAgentFullList(), 'RefFullRefers');
        $this->ShowList();
    }   
            
    public function actionSaveAgent(){//реферальная программа
        $Model=new AT7ReferProg();
        $Model->InsAgent($_GET['AgName'],$_GET['AgPhone'],$_SESSION['EmName'],1);
        
        $NewAg=$Model->GetAgent($_GET['AgName']);
        $ID=2731+$NewAg->ID;
        $Code='AGENT'.$ID;
        $Branch='';
        switch ($_SESSION['EmBranch']) {
            case 'ОП Барнаул':
                $Branch='barnaul.';
                break;
            case 'ОП Томск':
                $Branch='tomsk.';
                break;            
        }
        $ReferLink="https://".$Branch."fpk-alternativa.ru/bankrotstvo?utm_term=promo&kod={$Code}";
        $Model->UpdAgent($NewAg->ID, $NewAg->NAME, $Code, $ReferLink, $_GET['AgPhone']);

        header("Location: index_admin.php?controller=ATRefProgCtrl");
    }
    public function actionSearchAgent(){
        #new MyCheck($_GET['AgCode'],0);
        $this->GetRefers();
        if ((isset($_GET['AgName']))&&($_GET['AgName']!='')){
            $this->Refers=(new AT7ReferProg())->GetAgentByName($_GET['AgName']);
        }
        if ((isset($_GET['AgCode']))&&($_GET['AgCode']!='')){
            $this->Refers=(new AT7ReferProg())->GetAgentByCode($_GET['AgCode']);
            #new MyCheck($_GET['AgCode'],0);
        }
        if ((isset($_GET['AgPhone']))&&($_GET['AgPhone']!='')){
            $this->Refers=(new AT7ReferProg())->GetAgentsByPhone($_GET['AgPhone']);
        }             
        $this->ShowList();
    }
    /* Изменение данных агента
     */
    public function actionUpdAgent(){        
        (new AT7ReferProg())->UpdAgent($_GET['Id'],$_GET['Name'],$_GET['Code'],$_GET['Refer'],$_GET['Phone']);
        header("Location: index_admin.php?controller=ATRefProgCtrl");
    }
    /* удаление агента из списка
     */
    public function actionDelAgent(){
        $DelComment="{'Date':'".Date('d.m.Y')."','Name':'".$_SESSION['EmName']."','Comment':'".$_GET['DelComment']."'}";
        (new AT7ReferProg())->DelAgent($_GET['RefId'], $DelComment);
        header("Location: index_admin.php?controller=ATRefProgCtrl");
    }
    
    protected function ShowList(){       
        $this->ViewName='Реферальная программа';
        $args=['Refers'=>$this->Refers];        
        $this->render('ATRefProg',$args);
    }
            
    /*получение списка реферальных ссылок
     */
    protected function GetRefers(){
        if ((isset($_GET['DateF']))&&($_GET['DateF']!='')&&(isset($_GET['DateL']))&&($_GET['DateL']!='')){            
            $this->Refers=(new AT7ReferProg())->GetAgentListDate($_GET['DateF'],$_GET['DateL']);        
        } else {
            $this->Refers=(new AT7ReferProg())->GetAgentList();
        }
        $this->ExportToExcel($this->Refers,'RefRefers');
    }
    
    /*формирование эксель файла с выгрузкой списка реферальнй программы
     * 
     */
    protected function ExportToExcel($Refers,$File){
        //вывод отчёта в EXCEL
        // Создаем объект класса PHPExcel
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // Устанавливаем индекс активного листа
        $xls->setActiveSheetIndex(0);
        // Получаем активный лист
        $sheet = $xls->getActiveSheet();
        // Подписываем лист
        $sheet->setTitle('Агенты по реферальной программе');
        // Вставляем заголовки таблицы
        $sheet->setCellValue("A1", "Агенты по реферальной программе");
        $sheet->setCellValue("A2", "ID");
        $sheet->setCellValue("B2", "ФИО");
        $sheet->setCellValue("C2", "Код");
        $sheet->setCellValue("D2", "Ссылка");
        $sheet->setCellValue("E2", "Телефон");
        $sheet->setCellValue("F2", "Кто внёс");
        $sheet->setCellValue("G2", "ДАТА");        
        $i=3;
        
        foreach ($Refers as $reprow){
            $sheet->setCellValueByColumnAndRow(1,$i,$reprow->ID);
            $sheet->setCellValueByColumnAndRow(2,$i,$reprow->NAME);
            $sheet->setCellValueByColumnAndRow(3,$i,$reprow->CODE);
            $sheet->setCellValueByColumnAndRow(4,$i,$reprow->REFER);
            $sheet->setCellValueByColumnAndRow(5,$i,$reprow->PHONE);
            $sheet->setCellValueByColumnAndRow(6,$i,$reprow->LGEMP);
            $sheet->setCellValueByColumnAndRow(7,$i,$reprow->LGDATE);            
            $i++;
        }
        //create file name  
        $FileName="{$_SERVER['DOCUMENT_ROOT']}/AltTech/downloads/{$File}.xlsx";
        //вывод в файл и сохранение
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $objWriter->save($FileName);
    }
}

