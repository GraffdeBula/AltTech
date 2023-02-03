<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class ExpReportCtrl extends Controller{
    protected $ReportExp;
    public function actionIndex() {
        $this->ReportExp=(new ExpReportMod())->GetReport();
        $Report=['Report'=>$this->ReportExp];
        $this->render('ExpReport',$Report);
    }
}
