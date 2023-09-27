<?php

/**
 * Description of ContCtrl
 * контроллер для работы с шаблоном договора
 * @author Andrey
 * СХЕМА работы:
 * приходит ссылка из ПО CLIENT. из неё достаём переменные ClCode, ContCode, Branch
 * по полученным переменным собирает необходимые данные из базы данных
 * получив сведения о используемом тарифе, получает из БД таблицу закладок
 * создаёт объект ПРИНТЕР и используя его заполняет закладки в шаблоне соответствующими значениями (по таблице закладок)
 * используя объект ПРИНТЕР сохраняет договор в папку downloads
 * показывает вьюшку для скачивания договора, передавая туда ссылку на скачивание и название документа для отображения на кнопке
 * 
 */
class ContCtrl extends ControllerMain{
    protected $contCode;
    protected $clCode;
    protected $brName;
    protected $pac;
    protected $dataFront;
    protected $dataAnketa;
    protected $dataClient;
    protected $dataClProperty;
    protected $dataPartProperty;
    protected $dataOrg;
    protected $dataBranch;
    protected $dataPac;
    protected $dataCalend;
    protected $dataBookmarkList;
    protected $fileName;
    
    public function actionIndex(){
        /*получает ссылку и разбирает её на параметры
         * здесь сделаем вилку для переходного периода от старых договоров к новым
         * вилка по пакету
         */
       
        $this->getVariables();//получает из ссылки переменные с кодами клиента, договора и названием филиала
        
        //потом определить пакет, по которому заключается договор
        //для этого загрузить модель Contract
        $this->getFront();//здесь получим данные договора включая код пакета
        $this->getPac();
        $this->getClient();
        $this->getOrg();
        $this->getBranch();
        $this->getCalend();
        /*проверяем значение пакета
         * если пакет старый (до pac45), то используем старый алгоритм
         */
        #new MyCheck($this->dataPac,0);
        if($this->dataPac->ID<40){
            $Model=new Bookmarks();
            $this->dataBookmarkList=$Model->getBookmarksList($this->dataPac->PCBOOKMARKSLIST);        
            $this->createDoc();                
        }
        else{//для новых шаблонов используем новый ПРИНТЕР список закладок по типу документа получаем в самом ПРИНТЕРЕ
            
            $Printer2=new PrintDoc('ContNewType1',$this->dataPac->PCTEMPLATEROOT,[
                'Client'=>$this->dataClient,
                'ClProperty'=>$this->dataClProperty,
                'PartProperty'=>$this->dataPartProperty,
                'Cont'=>$this->dataFront,
                'Anketa'=>$this->dataAnketa,
                'BranchRec'=>$this->dataBranch,
                'OrgRec'=>$this->dataOrg,
                'PayCalend'=>$this->dataCalend,
                'Pac'=>$this->dataPac
            ]);        
            $this->fileName=$Printer2->PrintDoc();
            $args=[
                'docname'=> $this->fileName,
                'client'=>$this->dataClient
            ];
            $this->ViewName='Скачать договор';
            $this->render('ContDownload2',$args);            
        }
        
                 
    }
    
    public function createDoc(){
        $Printer=new PrintTrics(); //печать договора через старый принтер
        $Printer->GetTemplate($this->dataPac->PCTEMPLATEROOT);
        foreach($this->dataBookmarkList as $Bookmark){            
            if ($Bookmark->BMTABLE=='tblClients'){
                $Printer->PasteData($Bookmark,$this->dataClient->{$Bookmark->BMFIELD});
            }
            if ($Bookmark->BMTABLE=='tblPN1Front'){
                $Printer->PasteData($Bookmark,$this->dataFront->{$Bookmark->BMFIELD});
            }
            if ($Bookmark->BMTABLE=='tblOrgRec'){
                $Printer->PasteData($Bookmark,$this->dataOrg->{$Bookmark->BMFIELD});
            }
            if ($Bookmark->BMTABLE=='vwBranchRec'){
                $Printer->PasteData($Bookmark,$this->dataBranch->{$Bookmark->BMFIELD});
            }
            if ($Bookmark->BMTABLE=='tblEmp'){
                $Printer->PasteData($Bookmark,$this->dataBranch->{$Bookmark->BMFIELD});
            }
            if ($Bookmark->BMTABLE=='tblPayCalend2'){
                $Printer->PasteData($Bookmark,$this->dataCalend);
            }
        }
        $this->fileName[0]='contract '.$this->dataClient->CLFIO.'.docx';
        $Printer->SaveDoc($this->fileName[0]);
        //$this->fileName[1]='АНКЕТА'.$this->dataClient->CLFIO.'.docx';
        $Printer2=new PrintDoc('Anketa','Анкета БФЛ',['Client'=>$this->dataClient,'Cont'=>$this->dataFront,'BranchRec'=>$this->dataBranch,'OrgRec'=>$this->dataOrg]);
        $this->fileName[1]=$Printer2->PrintDoc();        
        //$this->fileName[2]='ПРИЛОЖЕНИЕ 4'.$this->dataClient->CLFIO.'.docx';
        $Printer2=new PrintDoc('ContPr4','Приложение4',['Client'=>$this->dataClient,'Cont'=>$this->dataFront,'BranchRec'=>$this->dataBranch,'OrgRec'=>$this->dataOrg]);        
        $this->fileName[2]=$Printer2->PrintDoc();        
        $args=[
            'docname'=>$this->fileName,
            'client'=>$this->dataClient
        ];
        
        $this->render('ContDownload',$args);
    }
    
    public function getCalend(){ //получение графика платежей
        $Model=new PayCalend2();
        if ($this->dataFront->FRTARPROG=='Банкротство физлиц'){
            $this->dataCalend=$Model->getData($this->contCode);
        }
        if ($this->dataFront->FRTARPROG=='Защита от кредиторов'){
            $this->dataCalend=$Model->GetCalendZOK($this->contCode);
        }
    }
    
    public function getFront(){ //получение данных по фронту
        $Model=new Contract();
        $this->dataFront=$Model->getFrontPN1($this->contCode);
        $Model=new Anketa1();
        $this->dataAnketa=$Model->getAnketaByCode($this->contCode);
    }
    
    public function getClient(){ //получение данных по клиенту
        $Model=new ClientMod();
        $this->dataClient=$Model->getClientById($this->clCode);
        $this->dataClProperty=$Model->getClProperty($this->clCode);
        $this->dataPartProperty=$Model->getPartProperty($this->clCode);        
    }
    
    public function getPac(){ //получение данных по пакету
        $Model=new Pacs();
        $this->dataPac=$Model->getPacByName($this->dataFront->FRTARPAC);
    }
    
    public function getOrg(){ //получение данных по организации
        $Model=new OrgRecMod();
        if (($this->dataFront->FROFFICE)=='Омск'){ 
            $this->dataOrg=$Model->getOrg('Альт5');                    
        } elseif (($this->dataFront->FROFFICE)=='Краснодар'){
            $this->dataOrg=$Model->getOrg('Альт23');
        } elseif (($this->dataFront->FROFFICE)=='Санкт-Петербург'){
            $this->dataOrg=$Model->getOrg('Альт78');
        }else {
            $this->dataOrg=$Model->getOrg('Альт');
        }
    }
    
    public function getBranch(){ //получение данных по филиалу
        $Model=new BranchRecMod();
        $this->dataBranch=$Model->getBranch($this->dataFront->FROFFICE);
    }
    
    public function getVariables(){ //получение переменных из запроса
        if (isset($_GET) && isset($_GET['contCode']) && isset($_GET['clCode']) && isset($_GET['brName'])) {
            $this->contCode=$_GET['contCode'];
            $this->clCode=$_GET['clCode'];
            $this->brName=$_GET['brName'];                
        }    
        else 
        {
            echo('НЕДОСТАТОЧНО ПАРАМЕТРОВ');
        }
    }
    
    public function showData(){
        var_dump($this->dataClient);
        echo('<br>');
        var_dump($this->dataFront);
        echo('<br>');
        var_dump($this->dataPac);
    }
        
    public function branchRec(){
        $model=new BranchRecMod();
        $list=$model->getBranch($this->brName);
        var_dump($list);
        $this->render('tarif_pac_new',[]);
    }
}
