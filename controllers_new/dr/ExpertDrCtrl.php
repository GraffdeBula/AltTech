<?php

/**
 * Description of ExpertDrCtrl
 *
 * @author Andrey
 */
class ExpertDrCtrl extends Controller{
    public function actionIndex(){
        $Model=new ExpertMod();        
        $this->render('ExpertDr',['ExpertDr'=>$Model->getExpListDr()]);
    }
    
    public function actionExpRiskAdd(){
        if ((isset($_GET['ExpRisk'])) and ($_GET['ExpRisk']!='')){
            $param=[$_GET['ExpRisk']];
            $Model=new ExpertMod();
            $Model->insExpListDr($param);
        }
        
        header("Location: http://37.193.61.130/AltTech/index_admin.php?controller=ExpertDrCtrl&action=index");
    }
    
    public function actionExpRiskDel(){
        if ((isset($_GET['ExpRiskID'])) and ($_GET['ExpRiskID']!='')){
            $param=[$_GET['ExpRiskID']];
            
            $Model=new ExpertMod();
            $Model->delExpListDr($param);
        }
        
        header("Location: http://37.193.61.130/AltTech/index_admin.php?controller=ExpertDrCtrl&action=index");
    }
}
