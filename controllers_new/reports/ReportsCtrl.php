<?php
/**
 * Контроллер для загрузки отчёта по экспертизам
 *
 * @author Andrey
 */
class ReportsCtrl extends ControllerMain{
    protected $Report;
    public function actionContP1Rep(){//отчёт по новым договорам
        $this->Report=(new ReportsMod())->getContP1();        
        $this->render('reports/ContP1Rep',['Report'=> $this->Report]);
    }
    
    public function actionContExpRep(){//отчёт по новым экспертизам
        $this->Report=(new ReportsMod())->getContExp();     
        #new MyCheck($this->Report,0);
        $this->render('reports/ContExpRep',['Report'=> $this->Report]);
    }
}
