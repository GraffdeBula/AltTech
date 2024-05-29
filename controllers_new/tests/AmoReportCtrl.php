<?php
/**
 * Контролоер для админпанели амо
 *
 * @author Andrey
 */
class AmoReportCtrl  extends ControllerMain {
    
    public function actionIndex(){
        $this->ViewName='AmoReport';
        $args=[];
        $this->render('reports/AmoReport', $args);
    }
}
