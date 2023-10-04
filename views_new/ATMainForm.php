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
            
            <form method='get' autocomplete='off' id='frm-add'>
                <input type="hidden" name='controller' value='ATMainFormCtrl'>
                <input type="hidden" name='action' value='ClIns'>
                <div>
                    <label>Фамилия</label>
                    <input type="text" name="ClFName" value="" required id='fname'>
                    <label>Имя</label>
                    <input type="text" name="Cl1Name" value="" required id='1name'>
                    <label>Отчество</label>
                    <input type="text" name="Cl2Name" value="" required id='2name'>
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
        
        <div class="tab-pane fade" id="refer">
            <a target='_blank' href='index_admin.php?controller=ATRefProgCtrl'><button class="btn btn-info">Список агентов</button></a>
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
                        $ExpDate=(new PrintFunctions())->DateToStr($ExpCont->FREXPDATE);
                        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$ExpCont->CLCODE}&ContCode={$ExpCont->CONTCODE}'>");
                        echo("<button class='btn btn-success'>".$ExpCont->CONTCODE."   ".$ExpCont->CLFIO);
                        echo("</button><a>   ".$ExpCont->FROFFICE."   ".$ExpDate);
                        echo("<br>");
                    }
                    ?>
                </div>
                <div class="tab-pane fade" id="exp2" role="tabpanel">
                    <p>согласовать у юриста<p>
                    <?php foreach($ExpList[2] as $ExpCont){   
                        $ExpDate=(new PrintFunctions())->DateToStr($ExpCont->FREXPDATE);
                        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$ExpCont->CLCODE}&ContCode={$ExpCont->CONTCODE}'>");
                        echo("<button class='btn btn-info'>".$ExpCont->CONTCODE."   ".$ExpCont->CLFIO);
                        echo("</button><a>   ".$ExpCont->FROFFICE."   ".$ExpDate);
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
        <div class="tab-pane fade" id="reports">
            <div class="row">
                <div class="col-lg-3">            
                    <p><a target="_blank" href="index_admin.php?controller=ReportsCtrl&action=ContExpRep"><button class="btn btn-success">НОВЫЕ ЭКСПЕРТИЗЫ</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=ReportsCtrl&action=ContP1Rep"><button class="btn btn-info">НОВЫЕ ДОГОВОРЫ БФЛ/ЗОК</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=P4ReportCtrl"><button class="btn btn-success">Отчёт по разовым услугам</button></p>
                    <p><a target="_blank" href="index_admin.php?controller=RepPaymentsCtrl&DateF=<?=date("d.m.Y")?>&DateL=<?=date("d.m.Y")?>"><button class="btn btn-info">ОТЧЁТ ПО ПЛАТЕЖАМ</button></a></p>
                </div>
                <div class="col-lg-3">
                    <p><a target="_blank" href="index_admin.php?controller=report1_ctrl&repInd=rep1"><button class="btn btn-success">ОСТАТКИ ОХ</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=report1_ctrl&repInd=rep2"><button class="btn btn-info">ДВИЖЕНИЕ ОХ ЗА ПЕРИОД</button></a></p>
                    <p><a target="_blank" href="index_admin.php?controller=CurBasePlanCtrl"><button class="btn btn-success">Списки плановых платежей</button></p>
                    <p><a target="_blank" href="index_admin.php?controller=CurBaseListCtrl"><button class="btn btn-dark">Списки действующих клиентов</button></p>
                </div>  
            </div>
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
                <a target='_blank' href="index_admin.php?controller=ATNewDZTest"><button class="btn btn-warning">Test new DZ</button></a>
            </div>
            <div>
                <a target='_blank' href="index_admin.php?controller=ATAmoFileCtrl"><button class="btn btn-danger">AMO FILE</button></a>
            </div>
            <div>
                <a target='_blank' href="index_admin.php?controller=TabIskBookmarkCtrl&action=ShowList"><button class="btn btn-warning">ИскЗакладки</button></a>
            </div>
            <div>
                <a target='_blank' href="index_admin.php?controller=JsonCtrl"><button class="btn btn-info">JSON</button></a>
            </div>
            <div>
                <?php
                $text=(new PrintFunctions())->SumToStr(1500.00);
                echo($text);
                ?>
            </div>            
        </div>     
        <div class="tab-pane fade" id="adminka">
            <a target='_blank' href="index_admin.php?controller=PkoListCtrl&action=Index"><button class="btn btn-outline-primary">Платежи</button></a>
                <br>            
            <a target='_blank' href="index_admin.php?controller=ATPaysCtrl&action=ShowDate"><button class="btn btn-outline-primary">Дата</button></a>
            <br>
            
            <a target='_blank' href="index_admin.php?controller=MedTest1&action=GetWord"><button class="btn btn-outline-primary">Чтение док</button></a>
            <br>
            
        </div>
              
                
    </div>
    <script>
        const MyButton=document.getElementById('btn-find');
        const FormFind=document.getElementById('frm-find');

        MyButton.addEventListener('mouseover',function(){
            document.getElementById('fname-f').value=document.getElementById('fname').value;
            document.getElementById('1name-f').value=document.getElementById('1name').value;
            document.getElementById('2name-f').value=document.getElementById('2name').value;
            document.getElementById('pass-f').value=document.getElementById('ClPasSer').value;
            document.getElementById('pasn-f').value=document.getElementById('ClPasNum').value;
        });
        MyButton.addEventListener('click',function(){
            FormFind.submit();
        });
        

        const MyButton2=document.getElementById('btn-clear');
        MyButton2.addEventListener('click',function(){            
            document.getElementById('fname').value='';
            document.getElementById('1name').value='';
            document.getElementById('2name').value='';
            document.getElementById('ClPasSer').value='';
            document.getElementById('ClPasNum').value='';            
        });

        const MyButton3=document.getElementById('btn-add');
        const FormAdd=document.getElementById('frm-add');
        MyButton3.addEventListener('click',function(){
            FormAdd.submit();
        });

        console.log('yes4')
    </script>
    <!--
    <script src="./js/MainForm.js"></script>
    -->
</body>
</html>
