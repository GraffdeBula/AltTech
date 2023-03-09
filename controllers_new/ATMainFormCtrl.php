<?php
/**
 * контроллер управления главной формой
 *
 * функции
 * 
 */
class ATMainFormCtrl extends ControllerMain {
    protected $Params=[];
    protected $ClList=[];
    protected $Refers=[];
    protected $ExpList=[];
    
    
    public function actionIndex(){
        $this->Params=[];
        $this->LoadList();                
        $this->GetEmpWorkData();
        $this->GetRefers();       
        $this->getExpList();
        $this->ShowList();
    }
    
    public function actionClSearch(){
        #var_dump($_GET);
        #echo(ucfirst($_GET['ClFName']));
        #exit();
        $this->Params=[ucfirst($_GET['ClFName']),ucfirst($_GET['Cl1Name']),ucfirst($_GET['Cl2Name'])];
        $this->LoadList();
        $this->GetEmpWorkData();
        $this->GetRefers();       
        $this->getExpList();
        $this->ShowList();
    }
    
    public function actionClIns(){
        $this->ClIns();        
        header("Location: index_admin.php?controller=ATMainFormCtrl&action=ClSearch&ClFName={$_GET['ClFName']}&Cl1Name={$_GET['Cl1Name']}&Cl2Name={$_GET['Cl2Name']}");
    }
            
    public function actionClDel(){
        $Model=new ATClientMod();
        $Model->delClient($_GET['ClCode']);
        header("Location: index_admin.php?controller=ATMainFormCtrl");
    }
    
    public function actionSaveAgent(){//реферальная программа
        $Model=new AT7ReferProg();
        $Model->InsAgent($_GET['AgName'],$_GET['AgPhone'],$_SESSION['EmName']);
        
        $NewAg=$Model->GetAgent($_GET['AgName']);
        $ID=2731+$NewAg->ID;
        $Code='AGENT'.$ID;
        $ReferLink="https://fpk-alternativa.ru/bankrotstvo?utm_term=promo&kod={$Code}";
        $Model->UpdAgent($NewAg->ID, $NewAg->NAME, $Code, $ReferLink);

        header("Location: index_admin.php?controller=ATMainFormCtrl");
    }
    /* удаление агента из списка
     */
    public function actionDelAgent(){
        $DelComment="{'Date':'".Date('d.m.Y')."','Name':'".$_SESSION['EmName']."','Comment':'".$_GET['DelComment']."'}";
        (new AT7ReferProg())->DelAgent($_GET['RefId'], $DelComment);
        header("Location: index_admin.php?controller=ATMainFormCtrl");
    }
    /* выход из системы
     */
    public function actionExit(){
        $sessName='PHPSESSID';
	setcookie($sessName,'',time()-1,'/');
        header('Location: index_admin.php');
    }
    /* сохранение нового клиента
     */    
    protected function ClIns(){
        $Model=new ATClientMod();        
        $Model->NewClient($_GET['ClFName'],$_GET['Cl1Name'],$_GET['Cl2Name'],$_GET['ClPasSer'],$_GET['ClPasNum'],$_SESSION['EmName'],$_SESSION['EmBranch']);
    }
            
    /* загрузка формы
     */   
    protected function ShowList(){       
        $this->ViewName='Главная форма';
        $args=['ClList'=>$this->ClList,'Refers'=>$this->Refers,'ExpList'=>$this->ExpList];        
        $this->render('ATMainForm',$args);
    }
    
    /*получение данных по пользователю и запись их в сессию для отображения
     */
    protected function GetEmpWorkData(){
        $Model=new ATEmployeeMod();  
        if (!$Model->GetEmpWorkData()){
            echo('Ошибка БД: неверно записан пароль');                        
            exit();
        } 
                
        $_SESSION['EmBranch']=$Model->GetEmpWorkData()->EMBRANCH;
        $_SESSION['EmRole']=$Model->GetEmpWorkData()->EMROLE;
        $_SESSION['EmName']=$Model->GetEmpWorkData()->EMNAME;
        
    } 
    
    /*
     * получение списка клиентов
     */
    protected function LoadList(){
        if ($this->Params==[]){
            $Model=new ATClientMod();
            $this->ClList=$Model->GetClientList();
        } else {
            $Model=new ATClientMod();
            $this->ClList=$Model->SearchClient($this->Params[0],$this->Params[1],$this->Params[2]);
        }
    }
    
    /* получение списков для проведения ЭПЭ
     */
    protected function getExpList(){
        $Model=new ExpertMod();
        $this->ExpList[1]=$Model->getExpList();
        $this->ExpList[2]=$Model->getExpJurList();
        $this->ExpList[3]=$Model->getExpDirList();        
    }
    
    /*получение списка реферальных ссылок
     */
    protected function GetRefers(){
        if ((isset($_GET['DateF']))&&($_GET['DateF']!='')&&(isset($_GET['DateL']))&&($_GET['DateL']!='')){            
            $this->Refers=(new AT7ReferProg())->GetAgentListDate($_GET['DateF'],$_GET['DateL']);        
        } else {
            $this->Refers=(new AT7ReferProg())->GetAgentList();
        }
        $this->ExportToExcel();
    }
    
    /*формирование эксель файла с выгрузкой списка реферальнй программы
     * 
     */
    protected function ExportToExcel(){
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
        
        foreach ($this->Refers as $reprow){
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
        $fileName="{$_SERVER['DOCUMENT_ROOT']}/AltTech/downloads/RefRefers.xlsx";
        //вывод в файл и сохранение
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $objWriter->save($fileName);
    }
}

