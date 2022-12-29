<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <div class="g">      
        <div class="g-row">
            <div class='g-12'>
                <h3>
                    <p>ГЛАВНОЕ МЕНЮ</p>
                </h3>   
            </div>
        </div>
        <div class="g-row" style="height: 30px"></div>
            <div class='g-row'>
            <div class='g-2'>
                <h4>Для юриста</h4>
                <div class="g-row">
                    <div class="g-1">-</div>
                    <div class="g-1">
                        <a target="_blank" href="index_admin.php?controller=ClInfoCtrl"><button class="f-bu f-bu-default">ИСКИ</button></a><br>
                    </div>
                </div> 
            </div>
            <div class='g-2'>
                <h4>Для менеджера</h4>
                <div class="g-row">
                    <div class='g-2'>
                        <a href="index_admin.php?controller=ClientListCtrl"><button class="f-bu">КЛИЕНТЫ</button></a>
                    </div>
                </div>
                <div class="g-row">
                    <div class="g-2">
                        <a href="index_admin.php?controller=MarkAnketaCtrl&action=ShowForm"><button class="f-bu">Маркетинговая анкета</button></a>
                    </div>
                </div>
            </div>
            <div class='g-2'>
                <h4>Для руководителя</h4>
                <div class="g-row">
                    <div class="g-1">
                        <a href="index_admin.php?controller=report1_ctrl&repInd=rep1"><button class="f-bu f-bu-success">ОСТАТКИ ОХ</button></a>
                    </div>
                </div>
                <div class="g-row">
                    <div class="g-1">
                        <a href="index_admin.php?controller=report1_ctrl&repInd=rep2"><button class="f-bu f-bu-success">ДВИЖЕНИЕ ОХ ЗА ПЕРИОД</button></a>
                    </div>
                </div>
                <div class="g-row">
                    <div class="g-1">
                        <a href="index_admin.php?controller=ExpReportCtrl"><button class="f-bu f-bu-success">ЭКСПЕРТИЗЫ</button></a>
                    </div>
                </div>
            </div>
            <div class='g-2'>
                <h4>Для администратора</h4>
                <div class="g-row">
                    <div class='g-2'>
                        <a href="index_admin.php?controller=ATMainFormCtrl"><button class="f-bu f-bu-default">КЛИЕНТ 2.0</button></a>
                    </div>
                </div>
                <div class="g-row">
                    <div class='g-2'>
                        <a href="index_admin.php?controller=PkoCtrl"><button class="f-bu f-bu-default">ПЛАТЕЖИ</button></a>
                    </div>
                </div>
                
                
                <div class="g-2">
                    <a href="index_admin.php?controller=DZCtrl&action=DocList"><button class="f-bu">ДОКУМЕНТЫ</button></a>
                </div>
                <div class="g-2">
                    <a href="index_admin.php?controller=CheckCurl&action=SavePage"><button class="f-bu">CheckCurl</button></a>
                </div>
                
                <div class="g-2">
                    <a href="index_admin.php?controller=DZCtrl&action=TestAc"><button class="f-bu">КОПИЯ</button></a>
                </div>
                <div class="g-2">
                    <a href="index_admin.php?controller=TabIskBookmarkCtrl&action=ShowList"><button class="f-bu">ИскЗакладки</button></a>
                </div>
                <div class="g-2">
                    <a target='_blank' href="index_admin.php?controller=ATNewDZTest"><button class="f-bu f-bu-warning">Test new DZ</button></a>
                </div>        
                <div class="g-2">                    
                    <a target='_blank' href="index_admin.php?controller=ATAmoFileCtrl"><button class="f-bu f-bu-warning">AMO FILE</button></a>
                </div> 
            </div>
            <div class='g-2'>
                <h4>Справочники</h4>
                <div class='g-2'>
                    <a target="_blank" href="index_admin.php?controller=ExpertDrCtrl"><button class="f-bu">ЭКСПЕРТИЗЫ РИСКИ / СТАРАЯ БД</button></a>
                </div>
                <div class='g-2'>
                    <a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRRegions"><button class="f-bu">РЕГИОНЫ / НОВАЯ БД</button></a>
                </div>
                <div class='g-2'>
                    <a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDREmployee"><button class="f-bu">СОТРУДНИКИ / НОВАЯ БД</button></a>
                </div>
                <div class='g-2'>
                    <a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRExpRisks"><button class="f-bu">ЭКСПЕРТИЗЫ РИСКИ / НОВАЯ БД</button></a>
                </div>
                <div class='g-2'>
                    <a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRCredit"><button class="f-bu">АНКЕТА КРЕДИТА / НОВАЯ БД</button></a>
                </div>
                <div class='g-2'>
                    <a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRBranch"><button class="f-bu">ФИЛИАЛЫ / НОВАЯ БД</button></a>
                </div>
            </div>
        </div>                                                                       
    </div>
</body>
</html>
