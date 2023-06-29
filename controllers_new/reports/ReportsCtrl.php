<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class ReportsCtrl extends ControllerMain{
    protected $Report;
    public function actionContP1Rep(){
        $this->Report=(new ReportsMod())->getContP1();
        #var_dump($this->Report);
        #exit();
        $this->render('reports/ContP1Rep',['Report'=> $this->Report]);
    }
    
}
