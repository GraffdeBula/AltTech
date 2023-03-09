<?php
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>    
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#home">Список клиентов</a>
        </li>
        <?php        
        echo("
            <li class='nav-item'>
                <a class='nav-link' data-bs-toggle='tab' href='#refer'>Реферальная программа</a>
            </li>");        
        ?>
        <?php        
        echo("
            <li class='nav-item'>
                <a class='nav-link' data-bs-toggle='tab' href='#expert'>На экспертизе</a>
            </li>");        
        ?>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#iski">Иски</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#reports">Отчёты</a>
        </li>        
        <?php
        if (($_SESSION['EmRole']=='admin')or ($_SESSION['EmRole']=='top')){
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
                      
        ?>
        
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active show" id="home">
            
        <form method='get' autocomplete='off'>
            <input type="hidden" name='controller' value='ATMainFormCtrl'>
            <input type="hidden" name='action' value='ClIns'>
            <div>
                <label>Фамилия</label>
                <input type="text" name="ClFName" value="" id='fname'>
                <label>Имя</label>
                <input type="text" name="Cl1Name" value="" id='1name'>
                <label>Отчество</label>
                <input type="text" name="Cl2Name" value="" id='2name'>
            </div>
            <div>
                <label>паспорт серия</label>
                <input type="text" name="ClPasSer" value="" maxlength="4">
                <label>номер</label>
                <input type="text" name="ClPasNum" value="" maxlength="6">
            </div>
            <?php
                
                echo("<div>
                    <button type='submit' class='btn btn-warning'>ДОБАВИТЬ</button>            
                </div>");
                
            ?>
        </form>
        <form method='get' autocomplete="off">    
            <input type="hidden" name='controller' value='ATMainFormCtrl'>
            <input type="hidden" name='action' value='ClSearch'>
            <input type="hidden" name="ClFName" value="" id='fname-f'>
            <input type="hidden" name="Cl1Name" value="" id='1name-f'>
            <input type="hidden" name="Cl2Name" value="" id='2name-f'>
            <button type='submit' class='btn btn-info' id='btn-find'>НАЙТИ</button>
            <a href="index_admin.php"><button class='btn btn-warning'>ОЧИСТИТЬ</button></a>
        </form>
                            
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
        <div class="tab-pane fade" id="refer">
            <div class='row'>
                <div class='col-lg-5'>
                    <form method='get' autocomplete="off">
                        <?php (new MyForm('ATMainFormCtrl','Index',0,0))->AddForm2();?>
                        <label>Внесены за период c </label><input type='date' name='DateF'>
                        <label> до </label><input type='date' name='DateL'>
                        <button type='submit' class='btn btn-primary'>Выбрать за период</button>                
                    </form>
                </div>
                <div class='col-lg-1'>
                    <form>
                        <button type='submit' class='btn btn-info'>Сбросить период</button>                
                    </form>
                </div>
            </div>
            <a target="_blank" href='downloads/RefRefers.xlsx'><button class='btn btn-success'>Выгрузить в Excel</button></a>
            <form method='get'autocomplete="off">
                <?php (new MyForm('ATMainFormCtrl','SaveAgent',0,0))->AddForm2();?>
                <label>ФИО</label><input name='AgName'>
                <label>Телефон</label><input name='AgPhone' maxlength="12">                
                <button type='submit' class='btn btn-warning'>Добавить</button>
            </form>
            <table class="table table-hover">
                <thead>
                    <tr>                      
                      <th scope="col">ФИО</th>
                      <th scope="col">Телефон</th>
                      <th scope="col">ПромоКод</th>
                      <th scope="col">Реферальная ссылка</th>
                      <th scope="col">Кто внёс</th>
                      <th scope="col">Удалить</th>
                      <th scope="col">Причина удаления</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php               
                        foreach($Refers as $Refer){//таблица
                            echo("<tr class='table-info'>");
                            echo("<td>$Refer->NAME</td>");
                            echo("<td>$Refer->PHONE</td>");
                            echo("<td>$Refer->CODE</td>");
                            echo("<td>$Refer->REFER</td>");
                            echo("<td>$Refer->LGEMP</td>");
                            if (($_SESSION['EmRole']=='admin') or ($_SESSION['EmRole']=='admin')){
                            echo("<form method='get' class='delAgForm'>");
                            (new MyForm('ATMainFormCtrl','DelAgent',0,0))->AddForm2();
                            echo("<input type='hidden' name='RefId' value='{$Refer->ID}'>");
                            echo("<td><button type='submit' class='btn btn-danger delAgBtn'>Удалить</button></td>");
                            echo("<td><input name='DelComment' class='delComment' value=''></td>");
                            echo("</form>");
                            }
                            echo("</tr>");
                        }                                
                    ?>    
                </tbody>
            </table>
        </div><!--Реферальная программа-->
        <div  class='tab-pane fade' id='expert'>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-bs-toggle="tab" href="#exp1">Требуется экспертиза</a>
                  
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#exp2">Согласование юриста</a>
                  
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#exp3">Согласование руководителя</a>
                  
                </li>
            </ul>
            <div id="ExpertContent" class="tab-content">
                <div class="tab-pane fade show active" id="exp1" role="tabpanel">
                    <p>провеcти ЭПЭ<p>
                    <?php foreach($ExpList[1] as $ExpCont){                                                
                        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$ExpCont->CLCODE}&ContCode={$ExpCont->CONTCODE}'>");
                        echo("<button class='btn btn-success'>".$ExpCont->CONTCODE."   ".$ExpCont->CLFIO);
                        echo("</button><a>   ".$ExpCont->FROFFICE."   ".$ExpCont->FREXPDATE);
                        echo("<br>");
                    }
                    ?>
                </div>
                <div class="tab-pane fade" id="exp2" role="tabpanel">
                    <p>согласовать у юриста<p>
                    <?php foreach($ExpList[2] as $ExpCont){                                                
                        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$ExpCont->CLCODE}&ContCode={$ExpCont->CONTCODE}'>");
                        echo("<button class='btn btn-info'>".$ExpCont->CONTCODE."   ".$ExpCont->CLFIO);
                        echo("</button><a>");
                        echo("<br>");
                    }
                    ?>
                </div>
                <div class="tab-pane fade" id="exp3" role="tabpanel">
                    <p>согласовать договор<p>
                    <?php foreach($ExpList[3] as $ExpCont){                                                
                        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$ExpCont->CLCODE}&ContCode={$ExpCont->CONTCODE}'>");
                        echo("<button class='btn btn-primary'>".$ExpCont->CONTCODE."   ".$ExpCont->CLFIO);
                        echo("</button><a>");
                        echo("<br>");
                    }
                    ?>
                </div>
            </div>
        </div><!--экспертизы-->
        <div  class='tab-pane fade' id='iski'>
            <a target="_blank" href="index_admin.php?controller=ClInfoCtrl"><button class="btn btn-outline-warning">ИСКИ</button></a>
        </div><!--печать исков-->
        <div class="tab-pane fade" id="reports">
            <p><a target="_blank" href="index_admin.php?controller=report1_ctrl&repInd=rep1"><button class="btn btn-success">ОСТАТКИ ОХ</button></a></p>
            <p><a target="_blank" href="index_admin.php?controller=report1_ctrl&repInd=rep2"><button class="btn btn-info">ДВИЖЕНИЕ ОХ ЗА ПЕРИОД</button></a></p>
            <p><a target="_blank" href="index_admin.php?controller=ExpReportCtrl"><button class="btn btn-success">ЭКСПЕРТИЗЫ</button></a></p>
            <p><a target="_blank" href="index_admin.php?controller=RepPaymentsCtrl&DateF=<?=date("d.m.Y")?>&DateL=<?=date("d.m.Y")?>"><button class="btn btn-success">ОТЧЁТ ПО ПЛАТЕЖАМ</button></a></p>
            
            <p><a target="_blank" href="index_admin.php?controller=P4ReportCtrl"><button class="btn btn-info">Отчёт по разовым услугам</button></p>
            <p><a target="_blank" href="index_admin.php?controller=ATPaysCtrl"><button class="btn btn-outline-primary">Отчёт по действующим клиентам</button></p>
        </div>
        <div class="tab-pane fade" id="lists">
            <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDREmployee"><button class="btn btn-success">Сотрудники [НОВАЯ БД]</button></a></p>            
            <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRBookmarks"><button class="btn btn-warning">Закладки для документов / НОВАЯ БД</button></a></p>            
            
            <p><a target="_blank" href="index_admin.php?controller=ATOldClientsCtrl"><button class="btn btn-warning">Ручное исправление статусов</button></a></p>            
            <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRBanks"><button class="btn btn-primary">Банки/МФО/Коллекторы [НОВАЯ БД]</button></a></p>
            <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDROrg"><button class="btn btn-warning">Организации [НОВАЯ БД]</button></a></p>
            <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRBranch"><button class="btn btn-info">Филиалы [НОВАЯ БД]</button></a></p>
            <p><a target="_blank" href="index_admin.php?controller=ATDRCtrl&action=ShowDRRegions"><button class="btn btn-success">Регионы [НОВАЯ БД]</button></a></p>
        </div>
        <div class="tab-pane fade" id="tests">
            <div>
                <a target='_blank' href="index_admin.php?controller=ATNewDZTest"><button class="btn btn-warning">Test new DZ</button></a>
            </div>
            <div>
                <a target='_blank' href="index_admin.php?controller=ATAmoFileCtrl"><button class="btn btn-danger">AMO FILE</button></a>
            </div>
            <div>
                <a target='_blank' href="index_admin.php?controller=TabIskBookmarkCtrl&action=ShowList"><button class="btn btn-warning">ИскЗакладки</button></a>
            </div>
                        
        </div>     
        <div class="tab-pane fade" id="adminka">
            <a target='_blank' href="index_admin.php?controller=PkoListCtrl&action=Index"><button class="btn btn-outline-primary">Платежи</button></a>
            <br>            
            <a target='_blank' href="index_admin.php?controller=ATPaysCtrl&action=ShowDate"><button class="btn btn-outline-primary">Дата</button></a>
            <br>
            
        </div>
              
                
    </div>
    <script>
        const MyButton=document.getElementById('btn-find');
        MyButton.addEventListener('mouseover',function(){
            document.getElementById('fname-f').value=document.getElementById('fname').value;
            document.getElementById('1name-f').value=document.getElementById('1name').value;
            document.getElementById('2name-f').value=document.getElementById('2name').value;
        });

        console.log('yes2')
    </script>
    <!--
    <script src="./js/MainForm.js"></script>
    -->
</body>
</html>
