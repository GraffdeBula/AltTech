<?php
/**
 * контроллер для работы со списком кредиторов
 *
 * @author Andrey
 */
class CrDocsCtrl extends Controller{
    protected $ContCode;
    protected $CrCode;
    protected $CredDocList;
        
    public function actionIndex(){
        if (isset($_POST['DOCUPD']) and ($_POST['DOCUPD']=='DOCUPD')){
            //$this->UpdateDoc();            
            var_dump($_POST);
        }
        
        $this->ContCode=$_GET['ContCode'];
        
        $Model=new CredDocsMod;
        $this->CredDocList=$Model->GetDocList($this->ContCode);
        
        $Documents=['Documents'=>$this->CredDocList];
        $this->render('ClCrDocList',$Documents);
    }
    
    public function UpdateDoc(){
        $DocID=$_POST['ID'];
        $DocUpd=[$_POST['DOCNUM'],$_POST['DOCDAT'],$_POST['DOCPAGES'],$_POST['DOCTOISK'],$_POST['ID']];
        $Model=new CredDocsMod();
        $Model->UpdDoc($DocUpd);
    }
 
}
