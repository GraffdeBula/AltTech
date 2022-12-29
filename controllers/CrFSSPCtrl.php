<?php

/**
 * контроллер для работы со списком исполпроизводств
 *
 * @author Andrey
 */
class CrFSSPCtrl extends Controller{
    protected $ClCode;
    protected $Client;
    protected $FsspList=[];
        
    public function actionIndex(){                
        $this->ClCode=$_GET['ClCode'];
                
        $this->Client=(new Client)->getClientById($this->ClCode);
        
        #var_dump($this->Client);
        #exit();
        echo($this->Client->CLADRRREGION);
        exit();
        $Model=new FSSP();
        $this->FsspList=$Model->GetInfo([$Client->CLFNAME,$Client->CL1NAME,$Client->CL2NAME,$Client->CLBIRTHDAT,'54']);
        
        $fssplist=['fssplist'=>$this->FsspList];
        $this->render('ClFsspList',$fssplist);
    }
}