<?php


/**
 * контроллер для сбора в БД информации о клиенте
 *
 * @author andrey
 */
class ClInfoCtrl extends Controller{
    protected $Client;
    protected $Cont;
    protected $Data;
    
    public function actionIndex(){
        $args=[];        
        $this->render('AdminClientSearch', $args);
    }
    
    protected function actionSearchData(){
        $this->ContCode=$_POST['contCode'];
        $this->ClCode=(new Anketa1)->getAnketaByCode($_POST['contCode'])->CLCODE;
        $this->Client=(new Client)->getClientById($this->ClCode);
        $this->Cont=(new IskMod)->getContract($this->ContCode);
        $args=['Client'=>$this->Client,'Contract'=>$this->Cont];
        $this->render('AdminClientPrint', $args);
        
    }
    //поиск инф
    //обновление инф
    protected function actionUpdateData(){
        $this->ClCode=$_POST['clCode'];
        $this->ContCode=$_POST['contCode'];
        
        $Model=new IskMod();
        $params=[$_POST['iskDate'],$this->ContCode];
        $Model->UpdIskDat($params);
        
        $this->Client=(new Client)->getClientById($this->ClCode);
        $this->Cont=(new IskMod)->getContract($this->ContCode);
        
        $args=['Client'=>$this->Client,'Contract'=>$this->Cont];   
        $this->render('AdminClientPrint', $args);
        
    }    
}
