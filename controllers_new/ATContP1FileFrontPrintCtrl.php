<?php
/**
 * контроллер управления  формой досье договора P1
 *
 * функции
 * открыть досье договора - экшн
 * показать информацию по договору
 * сохранить информацию по договору - экшн
 * открыть анкету договора - переход по ссылке
 * распечатать договор ЭПЭ - экшн
 * ** запускается экшн печать договора ЭПЭ. он получаеткод клиента и код договора
 * ** экшн должен вызвать объект класса PrintDoc и передать ему всю необходимую информацию для печати договора
 * 
 */
class ATContP1FileFrontPrintCtrl extends ControllerMain {
    public function actionIndex(){
        (new ATMainFormCtrl())->actionIndex();
    }
    
    public function actionExpCont(){        
        $Client=new Client($_GET['ClCode']);             
        $ContP1=new ContP1($_GET['ContCode']);     
        if ($ContP1->getFront()->FROFFICE==""){
            $Branch=new Branch($_SESSION['EmBranch']);
        } else
        {
            $Branch=new Branch($ContP1->getFront()->FROFFICE);        
        }                
        $Org=new Organizaion($Branch->getRec()->BRORGPREF);
        if ($ContP1->getFront()->FRPERSMANAGER==""){
            $Emp=new Employee($_SESSION['EmName']);
        } else
        {
            $Emp=new Employee($ContP1->getFront()->FRPERSMANAGER);        
        }
        #var_dump($Client->getPhones()[0]);
        #exit();
        $Printer=new PrintDoc('Exp','Договор ЭПЭ',[
            'Client'=>$Client->getClRec(),
            'ClientPas'=>$Client->getPasport(),
            'ClientPhone'=>$Client->getContPhone(),
            'Front'=>$ContP1->getFront(),
            'Org'=>$Org->getRec(),
            'Branch'=>$Branch->getRec(),
            'Emp'=>$Emp->getEmp(),
            'EmpDov'=>$Emp->getEmpDov()
        ]
                
        );
        $DocName=$Printer->PrintDoc();
        header("Location: ".$DocName);
    }
    
    public function actionExpAct(){
        echo('Акт ЭПЭ');
    }
    
    public function actionMainCont(){
        echo('Договор услуг');
    }
    
    public function actionMainAct(){
        echo('Основной акт');
    }
    
    public function actionDovTemplate(){
        echo('Шаблон доверки');
    }
    
}
