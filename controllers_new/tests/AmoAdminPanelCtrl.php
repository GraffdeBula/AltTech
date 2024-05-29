<?php
/**
 * Контролоер для админпанели амо
 *
 * @author Andrey
 */
class AmoAdminPanelCtrl  extends ControllerMain {
    
    public function actionIndex(){
        $this->ViewName='AmoAdminPanel';
        $args=[];
        $this->render('dr/AmoAdminPanel', $args);
    }
    
    public function actionGetPipeLines(){
        $PipeLineList=(new AmoMethods())->getPipeLineList();
        $args=['PipeLineList'=>$PipeLineList];
        $this->render('dr/AmoAdminPanel', $args);
    }
}
