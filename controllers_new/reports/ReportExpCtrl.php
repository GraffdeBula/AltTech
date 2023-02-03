<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class ReportExpCtrl extends Controller{
    protected $ReportExp;
    public function actionIndex() {
        $this->ReportExp=(new ExpRepMod())->GetReport();
        $Report=[];
        $this->render('ReportExp',$Report);
    }
}
