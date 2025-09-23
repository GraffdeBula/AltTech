<?php
#new MyCheck($ExpList,1);
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>    
    <ul class="nav nav-tabs">
        <?php 
        echo("
            <li class='nav-item'>
              <a class='nav-link active' data-bs-toggle='tab' href='#home'>Список клиентов</a>
            </li>");
        echo("
            <li class='nav-item'>
                <a class='nav-link' data-bs-toggle='tab' href='#calc'>Калькулятор тарифа</a>
            </li>");
        echo("
            <li class='nav-item'>
                <a class='nav-link' data-bs-toggle='tab' href='#refer'>Реферальная программа</a>
            </li>");   
        if (in_array($_SESSION['EmRole'],['admin','top','director','expert','jurist','front','frontextra'])){
        echo("
            <li class='nav-item'>
                <a class='nav-link' data-bs-toggle='tab' href='#expert'>Списки на ЭПЭ/правовой анализ</a>
            </li>");     
        }
        if ((in_array($_SESSION['EmRole'],['admin','top','director']))or(in_array($_SESSION['EmName'],['Елизавета Яковлева']))){
        echo("
            <li class='nav-item'>
              <a class='nav-link' data-bs-toggle='tab' href='#reports'>Отчёты</a>
            </li>"); 
        }        
        if ((in_array($_SESSION['EmRole'],['admin','top']))or(in_array($_SESSION['EmName'],['Андрей Догаев']))){
            echo("
            <li class='nav-item'>
              <a class='nav-link' data-bs-toggle='tab' href='#outcomes'>Расходы</a>
            </li>");
        }
        if (in_array($_SESSION['EmRole'],['admin','top'])){
            echo("
            <li class='nav-item'>
              <a class='nav-link' data-bs-toggle='tab' href='#discounts'>Согласование скидок</a>
            </li>");
        }
        if (in_array($_SESSION['EmRole'],['admin'])){
            echo("
            <li class='nav-item'>
              <a class='nav-link' data-bs-toggle='tab' href='#amo'>AmoCRM</a>
            </li>");
        }
        if (in_array($_SESSION['EmRole'],['admin','top'])){
            echo("
            <li class='nav-item'>
              <a class='nav-link' data-bs-toggle='tab' href='#lists'>Справочники</a>
            </li>");
        }
                
        if ($_SESSION['EmRole']=='admin'){
            echo("
            <li class='nav-item'>
              <a class='nav-link' data-bs-toggle='tab' href='#tests'>Tests</a>
            </li>");
        }
       
        if ($_SESSION['EmRole']=='admin'){
            echo("
            <li class='nav-item'>
              <a class='nav-link' data-bs-toggle='tab' href='#adminka'>АДМИНКА</a>
            </li>");
        }
        
        echo("
            <li class='nav-item'>
              <a class='nav-link' data-bs-toggle='tab' href='#radio'>Радио</a>
            </li>");
                      
        ?>
        
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active show" id="home">
            
            <form method='get' autocomplete='off' id='frm-add'>
                <input type="hidden" name='controller' value='ATMainFormCtrl'>
                <input type="hidden" name='action' value='ClIns'>
                <div>
                    <label>Фамилия</label>
                    <input type="text" name="ClFName" value="" required id='fname' style="::placeholder{color:red}">
                    <label>Имя</label>
                    <input type="text" name="Cl1Name" value="" required id='1name' required>
                    <label>Отчество</label>
                    <input type="text" name="Cl2Name" value="" required id='2name' required>
                </div>
                <div>
                    <label>паспорт серия</label>
                    <input type="text" name="ClPasSer" value="" required id="ClPasSer" maxlength="4">
                    <label>номер</label>
                    <input type="text" name="ClPasNum" value="" required id="ClPasNum" maxlength="6">
                </div>            
            </form>

            <form method='get' autocomplete="off" id='frm-find'>    
                <input type="hidden" name='controller' value='ATMainFormCtrl'>
                <input type="hidden" name='action' value='ClSearch'>
                <input type="hidden" name="ClFName" value="" id='fname-f'>
                <input type="hidden" name="Cl1Name" value="" id='1name-f'>
                <input type="hidden" name="Cl2Name" value="" id='2name-f'>                        
                <input type="hidden" name="ClPasSer" value="" id='pass-f'>
                <input type="hidden" name="ClPasNum" value="" id='pasn-f'>
            </form>
            
                <button type='submit' class='btn btn-info' id='btn-find'>НАЙТИ</button>
            -----
                <button type='submit' class='btn btn-warning' id='btn-add'>ДОБАВИТЬ</button> 
            -----  
                <button class='btn btn-secondary' id='btn-clear'>ОЧИСТИТЬ</button>
                
                        
            <?php  
             
                foreach($ClList as $Client){
                    echo("<p><a target='_blank' href='index_admin.php?controller=ATClientFileCtrl&ClCode={$Client->CLCODE}'>");
                    echo("<button class='btn btn-success'>ДОСЬЕ КЛИЕНТА</button></a>");
                    
                    echo($Client->CLCODE." ".$Client->CLFNAME." ".$Client->CL1NAME." ".$Client->CL2NAME." ".$Client->CLDOCSER." ".$Client->CLDOCNUM);
                                        
                    if ((new CheckRole)->Check($_SESSION['EmRole'],'ATMainFormCtrl','ClDel')){
                        echo("<a disabled href='index_admin.php?controller=ATMainFormCtrl&action=ClDel&ClCode={$Client->CLCODE}'>");                                        
                        echo("<button class='btn btn-danger'>УДАЛИТЬ</button></a></p><br>");
                    }
                }
            ?>
        </div><!--список клиентов-->
        
        <div class="tab-pane fade" id="calc">
            <p><a target='_blank' href='index_admin.php?controller=TarifCalcCtrl&action=Index'><button class="btn btn-success">Калькулятор единого тарифа</button></a></p>
            
        </div><!--калькулятор ед тарифа-->
        
        <div class="tab-pane fade" id="refer">
            <p><a target='_blank' href='index_admin.php?controller=RefProgContactsCtrl'><button class="btn btn-warning">Активные рекомендации</button></a></p>
            <p><a target='_blank' href='index_admin.php?controller=ATRefProgCtrl'><button class="btn btn-secondary">Классические рекомендации</button></a></p>
        </div><!--Реферальная программа-->
        <div  class='tab-pane fade' id='expert'>
<!--            <a target='_blank' href='index_admin.php?controller=ATExpListCtrl'><button class="btn btn-primary">Списки на ЭПЭ/правовой анализ</button></a>-->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-bs-toggle="tab" href="#exp01" style='color:#000000; background-color: #b1d17d'>Подписан договор услуг</a>                  
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#exp02" style='color:#000000; background-color: #ffcd3c'>Предоставлены документы для анализа</a>                  
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#exp03" style='color:#000000; background-color: #d1b97d'>Экспертиза проведена</a>                  
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#exp04" style='color:#000000; background-color: #7d83d1'>Итоговые условия согласованы с клиентом</a>                  
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#exp05" style='color:#000000; background-color: #5ea7e9'>Договор  согласован руководителем</a>                  
                </li>                
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#exp06" style='color:#000000; background-color: #7d83d1'>Проведён андеррайтинг</a>                  
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#exp07" style='color:#000000; background-color: #d17d7d'>Выявлены ошибки в правовом анализе</a>                  
                </li>                
              
            </ul>
            <div id="ExpertContent" class="tab-content">
                <div class="tab-pane fade show active" id="exp01" role="tabpanel">
                    <p>Подписан договор услуг</p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ФИО клиента</th>
                                <th scope="col">ID договора</th>
                                <th scope="col">Филиал</th>
                                <th scope="col">Дата договора</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ExpList[11] as $ExpCont){ 
                                $ContDate=(new PrintFunctions())->DateToStr($ExpCont->FRCONTDATE);
                                echo("<tr class='table-info'>"
                                    ."<th scope='row'>{$ExpCont->CLFIO}</th>"
                                    ."<td><a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode=$ExpCont->CLCODE&ContCode=$ExpCont->CONTCODE'>$ExpCont->CONTCODE</a></td>"
                                    ."<td>$ExpCont->FROFFICE</td>"
                                    ."<td>$ContDate</td>"
                                ."</tr>");
                                
                            }
                            ?>
                        </tbody>
                    </table>                            
                </div>
                <div class="tab-pane fade" id="exp02" role="tabpanel">
                    <p>Предоставлены документы для анализа</p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ФИО клиента</th>
                                <th scope="col">ID договора</th>
                                <th scope="col">Филиал</th>
                                <th scope="col">Дата договора</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ExpList[12] as $ExpCont){ 
                                $ContDate=(new PrintFunctions())->DateToStr($ExpCont->FRCONTDATE);
                                echo("<tr class='table-info'>"
                                    ."<th scope='row'>{$ExpCont->CLFIO}</th>"
                                    ."<td><a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode=$ExpCont->CLCODE&ContCode=$ExpCont->CONTCODE'>$ExpCont->CONTCODE</a></td>"
                                    ."<td>$ExpCont->FROFFICE</td>"
                                    ."<td>$ContDate</td>"
                                ."</tr>");
                                
                            }
                            ?>
                        </tbody>
                    </table>                            
                </div>    
                <div class="tab-pane fade" id="exp03" role="tabpanel">
                    <p>Экспертиза проведена</p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ФИО клиента</th>
                                <th scope="col">ID договора</th>
                                <th scope="col">Филиал</th>
                                <th scope="col">Дата договора</th>
                                <th scope="col">Дата правового анализа</th>
                                <th scope="col">ФИО юриста</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ExpList[13] as $ExpCont){ 
                                $ContDate=(new PrintFunctions())->DateToStr($ExpCont->FRCONTDATE);
                                $ExpDate=(new PrintFunctions())->DateToStr($ExpCont->EXJURSOGLDATE);
                                echo("<tr class='table-info'>"
                                    ."<th scope='row'>{$ExpCont->CLFIO}</th>"
                                    ."<td><a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode=$ExpCont->CLCODE&ContCode=$ExpCont->CONTCODE'>$ExpCont->CONTCODE</a></td>"
                                    ."<td>$ExpCont->FROFFICE</td>"
                                    ."<td>$ContDate</td>"
                                    ."<td>$ExpDate</td>"
                                    ."<td>$ExpCont->EXJURSOGLNAME</td>"
                                ."</tr>");
                                
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="exp04" role="tabpanel">
                    <p>Итоговые условия согласованы с клиентом</p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ФИО клиента</th>
                                <th scope="col">ID договора</th>
                                <th scope="col">Филиал</th>
                                <th scope="col">Дата договора</th>
                                <th scope="col">Дата правового анализа</th>
                                <th scope="col">Дата согласования с клиентом</th>
                                <th scope="col">ФИО менеджера</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ExpList[14] as $ExpCont){ 
                                $ContDate=(new PrintFunctions())->DateToStr($ExpCont->FRCONTDATE);
                                $ExpDate=(new PrintFunctions())->DateToStr($ExpCont->EXJURSOGLDATE);
                                echo("<tr class='table-info'>"
                                    ."<th scope='row'>{$ExpCont->CLFIO}</th>"
                                    ."<td><a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode=$ExpCont->CLCODE&ContCode=$ExpCont->CONTCODE'>$ExpCont->CONTCODE</a></td>"
                                    ."<td>$ExpCont->FROFFICE</td>"
                                    ."<td>$ContDate</td>"
                                    ."<td>$ExpDate</td>"
                                    ."<td>".(new PrintFunctions())->DateToStr($ExpCont->FRMANSOGLDATE)."</td>"
                                    ."<td>$ExpCont->FRMANSOGLNAME</td>"
                                ."</tr>");
                                
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="exp05" role="tabpanel">
                    <p>Согласованы руководителем</p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ФИО клиента</th>
                                <th scope="col">ID договора</th>
                                <th scope="col">Филиал</th>
                                <th scope="col">Дата договора</th>
                                <th scope="col">Дата правового анализа</th>
                                <th scope="col">ФИО юриста</th>
                                <th scope="col">Дата согласования руководителя</th>
                                <th scope="col">m</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ExpList[15] as $ExpCont){ 
                                $DateNow=new DateTime('now');
                                $DateSogl=new DateTime($ExpCont->EXDIRSOGLDATE);
                                $m=$DateNow->diff($DateSogl)->m;
                                if ($m>1){
                                    continue;
                                }
                                
                                $ContDate=(new PrintFunctions())->DateToStr($ExpCont->FRCONTDATE);
                                echo("<tr class='table-info'>"
                                    ."<th scope='row'>{$ExpCont->CLFIO}</th>"
                                    ."<td><a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode=$ExpCont->CLCODE&ContCode=$ExpCont->CONTCODE'>$ExpCont->CONTCODE</a></td>"
                                    ."<td>$ExpCont->FROFFICE</td>"
                                    ."<td>$ContDate</td>"
                                    ."<td>".(new PrintFunctions())->DateToStr($ExpCont->EXJURSOGLDATE)."</td>"
                                    ."<td>$ExpCont->EXJURSOGLNAME</td>"
                                    ."<td>".(new PrintFunctions())->DateToStr($ExpCont->EXDIRSOGLDATE)."</td>"
                                            ."<td>".$m."</td>"
                                ."</tr>");
                                
                            }
                            ?>
                        </tbody>
                    </table>                            
                </div>
                <div class="tab-pane fade" id="exp06" role="tabpanel">
                    <p>Андеррайтинг проведён</p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ФИО клиента</th>
                                <th scope="col">ID договора</th>
                                <th scope="col">Филиал</th>
                                <th scope="col">Дата договора</th>
                                <th scope="col">Дата правового анализа</th>
                                <th scope="col">Дата проверки</th>
                                <th scope="col">ФИО юриста</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($ExpList[16] as $ExpCont){ 
                                $ContDate=(new PrintFunctions())->DateToStr($ExpCont->FRCONTDATE);
                                $ExpDate=(new PrintFunctions())->DateToStr($ExpCont->EXRESDAT);
                                $UnderDate=(new PrintFunctions())->DateToStr($ExpCont->EXPUNDERDATE);
                                echo("<tr class='table-info'>"
                                    ."<th scope='row'>{$ExpCont->CLFIO}</th>"
                                    ."<td><a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode=$ExpCont->CLCODE&ContCode=$ExpCont->CONTCODE'>$ExpCont->CONTCODE</a></td>"
                                    ."<td>$ExpCont->FROFFICE</td>"
                                    ."<td>$ContDate</td>"
                                    ."<td>$ExpDate</td>"
                                    ."<td>$UnderDate</td>"
                                    ."<td>$ExpCont->EXJURSOGLNAME</td>"
                                ."</tr>");
                                
                            }
                            ?>
                        </tbody>
                    </table>                            
                </div>
                <div class="tab-pane fade" id="exp07" role="tabpanel">
                    <p>Критические ошибки в анализе</p>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ФИО клиента</th>
                                <th scope="col">ID договора</th>
                                <th scope="col">Филиал</th>
                                <th scope="col">Дата договора</th>
                                <th scope="col">Дата правового анализа</th>
                                <th scope="col">ФИО юриста</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($ExpList[17] as $ExpCont){ 
                                $ContDate=(new PrintFunctions())->DateToStr($ExpCont->FRCONTDATE);
                                $ExpDate=(new PrintFunctions())->DateToStr($ExpCont->EXRESDAT);
                                echo("<tr class='table-info'>"
                                    ."<th scope='row'>{$ExpCont->CLFIO}</th>"
                                    ."<td><a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode=$ExpCont->CLCODE&ContCode=$ExpCont->CONTCODE'>$ExpCont->CONTCODE</a></td>"
                                    ."<td>$ExpCont->FROFFICE</td>"
                                    ."<td>$ContDate</td>"
                                    ."<td>$ExpDate</td>"                                    
                                    ."<td>$ExpCont->EXJURSOGLNAME</td>"
                                ."</tr>");
                                
                            }
                            ?>
                        </tbody>
                    </table>                            
                </div>
                
                                                
            </div>
        </div><!--экспертизы-->        
        <div class="tab-pane fade" id="reports">
            <div class="row">
                <div class="col-lg-2">            
                    <p><a target="_blank" href="index_admin.php?controller=ReportsCtrl&action=ShowContExpForm"><button class="btn btn-success">НОВЫЕ ЭКСПЕРТИЗЫ</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=ReportsCtrl&action=ShowContP1RepForm"><button class="btn btn-info">НОВЫЕ ДОГОВОРЫ БФЛ/ЗОК</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=ReportsCtrl&action=ShowContP1DropForm"><button class="btn btn-info">Отчёт по расторжениям</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=P4ReportCtrl"><button class="btn btn-success">Отчёт по разовым услугам</button></p>                    
                    <p><a target="_blank" href="index_admin.php?controller=ReportsCtrl&action=ShowContP1AfterUnderForm"><button class="btn btn-warning">Отчёт Замечания андеррайтера</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=ReportsCtrl&action=ContP1DiscRepForm"><button class="btn btn-success">Отчёт по скидкам</button></a></p>
                    
                </div>
                <div class="col-lg-2">
                    <p><a target="_blank" href="index_admin.php?controller=RepPaymentsCtrl&DateF=<?=date("d.m.Y")?>&DateL=<?=date("d.m.Y")?>"><button class="btn btn-info">ОТЧЁТ ПО ПЛАТЕЖАМ</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=CurBasePlanCtrl"><button class="btn btn-success">Списки плановых платежей</button></a></p>                    
                    <p><a target="_blank" href="index_admin.php?controller=ReportsCtrl&action=ShowContNew"><button class="btn btn-info">Плановые платежи по новым договорам</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=CurBaseBranchCtrl"><button class="btn btn-success">База действующих договоров</button></a></p>                    
                </div>  
                <div class="col-lg-2">                    
                    <p><a target="_blank" href="index_admin.php?controller=report1_ctrl&repInd=rep1"><button class="btn btn-success">ОСТАТКИ ОХ</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=report1_ctrl&repInd=rep2"><button class="btn btn-info">ДВИЖЕНИЕ ОХ ЗА ПЕРИОД</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=ReportsCohortCtrl&action=CohortRepForm"><button class="btn btn-primary">Когортный анализ договоров</button></a></p>
                </div>
                
            </div>
            
        </div><!--отчёты-->   
        <div class="tab-pane fade" id="outcomes"> 
            <a target="_blank" href="index_admin.php?controller=OutcomesCtrl"><button class='btn btn-info'>ОТКРЫТЬ УЧЁТ РАСХОДОВ</button></a>
        </div>
        <div class="tab-pane fade" id="discounts"> 
            <?php
                foreach($DiscList as $key=>$Cont){
                    echo("{$Cont->CLFIO} : {$Cont->FROFFICE} : {$Cont->FRDISCSUM} {$Cont->FRDISCCOMMENT}");
                    echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$Cont->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='btn btn-info'>Перейти в досье</button></a>");
                    echo("<br>");
                }                    
            ?>
        </div>
        <div class="tab-pane fade" id="amo"> 
            <a target="_blank" href="index_admin.php?controller=AmoCtrl"><button class='btn btn-info'>ОТКРЫТЬ ФОРМУ АМО</button></a>
        </div>
        <div class="tab-pane fade" id="lists">
            <div class="row">
                <div class="col-lg-2">
                    <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDROrg"><button class="btn btn-warning">Организации</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRBranch"><button class="btn btn-info">Филиалы</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRRegions"><button class="btn btn-success">Регионы</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDREmployee"><button class="btn btn-success">Сотрудники</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDREmpDov"><button class="btn btn-primary">Доверенности</button></a></p>
                </div>
                <div class="col-lg-2">
                    <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRPac"><button class="btn btn-warning">Пакеты тарифов</button></a></p>                                    
                    <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRTarif"><button class="btn btn-primary">Тарифы</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRPacBranch"><button class="btn btn-warning">Типы пакетов по филиалам</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRTarif2"><button class="btn btn-danger">Единый тариф</button></a></p>
                </div>
                <div class="col-lg-2">
                    <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRBookmarks"><button class="btn btn-warning">Закладки для документов</button></a></p>                                    
                    <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRBanks"><button class="btn btn-primary">Банки/МФО/Коллекторы</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDROrganizations"><button class="btn btn-success">СУДЫ/ИФНС/Др.организации</button></a></p>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tests">            
            <div>
                <a target='_blank' href="index_admin.php?controller=ATAmoFileCtrl"><button class="btn btn-danger">AMO FILE</button></a>
            </div>            
            <div>
                <a target='_blank' href="index_admin.php?controller=AsynchTestCtrl"><button class="btn btn-info">АСИНХРОННОЕ СОХРАНЕНИЕ</button></a>
            </div>
            <div>
                <a target='_blank' href="index_admin.php?controller=AmoAdminPanelCtrl"><button class="btn btn-info">Админ панель АМО</button></a>
            </div>
                        
        </div>     
        <div class="tab-pane fade" id="adminka">
                     
            <a target='_blank' href="index_admin.php?controller=ATPaysCtrl&action=ShowDate"><button class="btn btn-outline-primary">Дата</button></a>
            <br>
            
            <a target='_blank' href="index_admin.php?controller=MedTest1&action=GetWord"><button class="btn btn-outline-primary">Чтение док</button></a>
            <br>
            
        </div>
        
        <div class="tab-pane fade" id="radio">
                     
            <div class="RP-SCRIPT"><a class="RP-LINK" href="https://radiopotok.ru/radio/1494">Beautiful Instrumentals Channel</a></div><script defer src="https://radiopotok.ru/f/script6.1/1494.js" charset="UTF-8"></script>
            
        </div>
        
        
              
                
    </div>
    
    <!---->
    <script src="./js/MainForm.js"></script>
    <!---->
</body>
</html>
