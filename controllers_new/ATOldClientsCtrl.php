<?php
/**
 * контроллер управления главной формой
 *
 * функции
 * 
 */
class ATOldClientsCtrl extends ControllerMain {
    protected $Params=[];
    protected $ClList=[];
    protected $Refers=[];
    
    
    public function actionIndex(){
        $this->render('ATOldClients',[]);
    }
    
    public function actionSearchCont(){        
        $this->ClList=(new ATOldClientsMod())->SearchClient($_GET['ClFName'],$_GET['Cl1Name'], $_GET['Cl2Name']);
        
        $this->render('ATOldClients',['ClList'=>$this->ClList]);
    }
    
    public function actionSaveExp(){
        $Model=new ATOldClientsMod;
        $Model->UpdDebt($_GET['EXTOTDEBTSUM'], $_GET['ContCode']);
        $Model->UpdStatus('4',$_GET['ContCode']);
        header("Location: index_admin.php?controller=ATOldClientsCtrl");
    }
    
    public function actionReturnStatus(){
        (new ATOldClientsMod())->UpdStatus('11', $_GET['ContCode']);
        header("Location: index_admin.php?controller=ATOldClientsCtrl");
    }
   
}

