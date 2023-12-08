<?php

/**
 * Description of PrintDocCtrl
 *
 * @author Andrey
 * класс для печати документов
 * класс обеспечивает печать документа, т.е. работу с пакетом phpoffice. он не должен запрашивать информацию у БД. это задача контроллера
 * класс получает информацию какой документ напечатать и какой информацией его заполнить. он сам отвечает только за то, чтобы
 * правильно заполнить нужный шаблон имеющейся информацией.
 * 
 * может прийти только массив данных по клиенту, а может массив по клиенту и договору, а может по кредиту, 
 *  
 */
class PrintDoc{
    protected $DocClass='';        
    protected $DocData;//массив данных для заполнения документа. может содержать один или несколько объектов/массивов в зависимости от документа
    
    protected $DocObj; //объект документа для заполнения
    protected $DocName; //имя файла, в который будет сохранён заполненный документ-объект
    protected $TemplName; //название шаблона
    protected $BookMarks; //массив данных, получаемый из таблицы соответствий
    
    public function __construct($DocClass,$TemplName,$DocData){
        $this->DocClass=$DocClass;
        $this->DocData=$DocData;  
        $this->TemplName=$TemplName;          
        #new MyCheck($DocData,2);
    }

    public function PrintDoc(){//метод печатает документ, параметры для которого переданы при создании объекта        
        #foreach($this->DocData as $key=>$value){
        #    echo($key."<br>");
        #}
        #var_dump($this->DocData['Emp']);
        #exit;
        //получение данных
        $this->GetTemplate();
        $this->GetBookmarkTable();        
        //обход массива закладок              
        foreach($this->BookMarks as $BookMark){
                         
            $this->InsBookMark($BookMark);
            
        }       
        $this->DocName=$this->DocClass.$this->DocData['Client']->CLFNAME;     
        $this->SaveDoc();
        
        return "documents/{$this->DocName}.docx";
    }
            
    protected function GetTemplate(){                            
        $this->DocObj=new \PhpOffice\PhpWord\TemplateProcessor("{$_SERVER['DOCUMENT_ROOT']}/AltTech/templates/{$this->TemplName}.docx");
    }
    
    public function SaveDoc(){//сохраняет документ с переданными именем
        $this->DocObj->saveAs("{$_SERVER['DOCUMENT_ROOT']}/AltTech/documents/{$this->DocName}.docx");
    }
    
    protected function GetBookmarkTable(){
        $this->BookMarks=db2::getInstance()->FetchAll("SELECT * FROM tblDocBookMarks WHERE bmDocName=?;",[$this->DocClass]);  
    }
    
    protected function InsBookMark($BookMark){
//        if ($BookMark->BMNAME=='CONTSUM'){
//            new MyCheck($this->DocData['Front'],0);
//        }
        
        if ($BookMark->BMCHANGE<4){
            $Data=$this->
                DocData[$BookMark->BMTABLE]->
                {$BookMark->BMFIELD};             
        }
   
        if ($BookMark->BMCHANGE==0){ //проста вставка без преобразований
            $this->PasteDataSimple($BookMark->BMNAME,$Data);
        } elseif ($BookMark->BMCHANGE==1){ //вызов вставки даты (преобразование из строки)
            $this->PasteDataSimple($BookMark->BMNAME,$this->StrToDate($Data));
        } elseif ($BookMark->BMCHANGE==2){ //вызов вставки с параметром
            $this->PasteDataParam($BookMark->BMNAME,$Data,$BookMark->BMCHECKDATA,$BookMark->BMINSDATA);       
        } elseif ($BookMark->BMCHANGE==3){ //вызов вставки числа (суммы) прописью           
            $this->PasteDataSimple($BookMark->BMNAME,(new PrintFunctions())->SumToStr($Data));
        } elseif ($BookMark->BMCHANGE==4){ //вызов вставки таблицы            
            $this->PasteTable($BookMark->BMNAME);
        } elseif ($BookMark->BMCHANGE==5){ //вызов вставки таблицы            
            $this->PasteTable($BookMark->BMNAME);
        } elseif ($BookMark->BMCHANGE==6){ //вставка куска текста про скидки           
            $this->PasteText($BookMark->BMNAME);
        } elseif ($BookMark->BMCHANGE==7){ //вставка куска текста про кредиторов           
            $this->PasteCreditors($BookMark->BMNAME);
        } elseif ($BookMark->BMCHANGE==8){ //вставка единственного жилья                       
            if (($BookMark->BMDOCNAME=='ContNewType1')
                &&($BookMark->BMNAME=='HOME1')
                && $this->DocData['Client']->CLADRRPROPYN=='Да')
            { 
                $this->PasteDataSimple($BookMark->BMNAME,$this->DocData['Client']->CLADRREG);
            } else {
                $this->PasteDataSimple($BookMark->BMNAME,'Нет');
            }    
            
        } elseif ($BookMark->BMCHANGE==9){ //вставка графика платежей
            $this->PastePayCalend();
        } elseif ($BookMark->BMCHANGE==10){ //вставка таблицы с собственностью
            $this->PasteClProperty();
        } elseif ($BookMark->BMCHANGE==11){ //вставка таблицы со сделками
            $this->PasteClDeals();
        } elseif ($BookMark->BMCHANGE==12){ //вставка списка договоров на кредиты
            $this->PasteCredContList();
        } elseif ($BookMark->BMCHANGE==13){ //вставка списка доходов
            $this->PasteClIncome();
        } 
    }
    
    protected function InsBookMark2($BookMark){
        if ($BookMark->BMCHANGE<4){
            $Data=$this->DocData[$BookMark->BMTABLE]->{$BookMark->BMFIELD}; 
        }
    }
    
    protected function PasteDataSimple($BookMark,$Data){// простая вставка данных       
        if ($Data=='') {
            $this->DocObj->setValue($BookMark,'---');        
        }
        if ($Data=='NULL') {
            $this->DocObj->setValue($BookMark,'------');        
        }
        $this->DocObj->setValue($BookMark, $Data);        
    }
    
    protected function PasteDataParam($BookMark,$Data,$CheckData,$InsData){//вставка данных с параметром (какие-то фиксированные данные, в зависимости от данных в таблице        
        if ($Data==$CheckData){
            $this->DocObj->setValue($BookMark, $InsData);        
        }
    }
    
    protected function StrToDate($StrDate){//вставка даты в корректном формате
        $day=substr($StrDate,8,2); //день начала периода
        $month=substr($StrDate,5,2); //месяц начала периода
        $year=substr($StrDate,0,4);
        return $day.'.'.$month.'.'.$year;
    }
    
    protected function PasteTable($BookMark){//вставка таблицы
        
        $this->MyTable = new \PhpOffice\PhpWord\Element\Table(array('borderSize'=>10,'borderColor'=>'black'));        
        $this->MyTable->addRow();            
        $this->MyTable->addCell(1500)->addText('Дата');            
        $this->MyTable->addCell(1500)->addText('СУММА');
        foreach($this->DocData['PayCalend'] as $Row){        
            $this->MyTable->addRow();            
            $this->MyTable->addCell(1500)->addText($this->StrToDate($Row->PAYDAT));            
            $this->MyTable->addCell(1500)->addText($Row->PAYSUM);            
        } 
        $this->DocObj->setComplexBlock($BookMark, $this->MyTable);        
    }
    
    protected function PasteText($BookMark){//вставка куска текста про скидки             
        $InsData=(new PrintFunctions())->Discounts($BookMark, $this->DocData['Anketa']->AKCREDTOTSUM, $this->DocData['Front']->FRCONTPAC, 
                $this->DocData['Pac']->PCPERIOD,$this->DocData['Front']->FRCONTSUM,$this->DocData['Front']->FROFFICE);
        $this->DocObj->setValue($BookMark, $InsData);
    }
    
    protected function PasteCreditors($BookMark){//вставка куска текста про кредиторов
        $CredList=(new PrintFunctions)->CredList($this->DocData['Front']->CONTCODE);
        $this->DocObj->setValue($BookMark, $CredList);
    }
    
    protected function PastePayCalend(){
        $PayCalend=[];
        foreach($this->DocData['PayCalend'] as $Pay){
            $PayCalend[]=[
                'PAYID'=>$Pay->PAYNUM." платёж" ,
                'PAYSUM'=>$Pay->PAYSUM." рублей",
                'PAYDATE'=>$this->StrToDate($Pay->PAYDATE)
            ];
        }
        $this->DocObj->cloneRowAndSetValues('PAYID', $PayCalend);
    }
    
    protected function PasteClProperty(){
        $PropertyList=[];
        foreach($this->DocData['ClProperty'] as $Property){
            $PropertyList[]=[
                'CLPROPTYPE'=>$Property->CLPROPTYPE,
                'CLPROPDESC'=>$Property->CLPROPDESC,
                'CLPROPCOST'=>$Property->CLPROPCOST,
                'CLPROPOWNER'=>$Property->CLPROPOWNER,
            ];
        }        
        $this->DocObj->cloneRowAndSetValues('CLPROPTYPE', $PropertyList);
    }
    
    protected function PasteClDeals(){
        $DealList=[];
        foreach($this->DocData['ClDeals'] as $Deal){
            $DealList[]=[
                'CLDLOBJ'=>$Deal->CLDLOBJ,
                'CLDLCOMMENT'=>$Deal->CLDLCOMMENT,
                'CLDLSUM'=>$Deal->CLDLSUM,
                'CLDLOWNER'=>$Deal->CLDLOWNER
            ];
        }
        $this->DocObj->cloneRowAndSetValues('CLDLOBJ', $DealList);
    }
    
    protected function PasteClIncome(){
        $IncomeList=[];
        foreach($this->DocData['ClIncome'] as $Income){
            $IncomeList[]=[
                'INCNAME'=>$Income->CLINCNAME,
                'INCSUM'=>$Income->CLINCSUM,
                'INCSUMOF'=>$Income->CLINCSUMOF,
                'INCDEDUCT'=>$Income->CLINCDEDUCT,
                'INCFACT'=>$Income->CLINCSUMREAL,
                'INCCARD'=>$Income->CLINCCARDYN,
                'INCPENS'=>$Income->CLINCPENSDATE,                
            ];
        }
        $this->DocObj->cloneRowAndSetValues('INCNAME', $IncomeList);
    }
    
    protected function PasteCredContList(){
        $CredContList='';
        foreach($this->DocData['CreditorContList'] as $CredCont){
            $CredContList=$CredContList.', договор '.$CredCont->CRCONTNUM.' от '.$CredCont->CROPENDAT;
        }
        $this->DocObj->setValue('CREDLIST', $CredContList);
    }
        
}
