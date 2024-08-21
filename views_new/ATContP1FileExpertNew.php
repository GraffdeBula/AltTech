<?php
/*
 * досье ЭПЭ
 *  */
#var_dump($RiskList);
#exit();
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    
    <h3>
        <p>АЛЬТ-ТЕХ</p>
    </h3>   

    <h3>
        <p>ДОГОВОР БФЛ - ЭКСПЕРТИЗА</p>
    </h3> 
    <a href='index_admin.php?controller=ATClientFileCtrl&ClCode=<?=$Client->CLCODE?>'><button class='btn btn-danger'>Вернуться в досье клиента</button></a>
           
    <?php
        echo("<h4>ФИО Клиента: {$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}</h4>");
        echo("<h4>Статус: {$Cont->STATUS}</h4>");
            ?>
        </div>
        
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#result">Правовой анализ</a>
            </li>            
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#risks">Риски</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#mininc">Расчёт прожиточного минимума</a>
            </li>            
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#comments">Комментарии</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#under">Проверка андеррайтера</a>
            </li>
        </ul>
        
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active show" id="result">
                <div class="accordion" id="accordionExp">                                
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                Заключение юриста
                            </button>
                        </h3>
                        <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExp" style="">
                            <div class="accordion-body" style="background-color: <?=VIEW_BACKGROUND?>">              
                                <form method='get'>
                                    <?php (new MyForm('ATContP1FileExpertCtrl','AddFromJurist',$_GET['ClCode'],$_GET['ContCode']))->AddForm() ?>
                                    <div class="form-group">
                                        <label for="exampleTextarea" class="form-label mt-4"></label>
                                        <textarea class="form-control" id="exampleTextarea" rows="3" style="height: 60px;" name='EXJURCOMMENT' maxlength=5000 ><?=$Expert->EXJURCOMMENT?></textarea>
                                    </div>
                                    
                                    <p><label>Сумма доплаты за сложность</label><input name='FRDOPSUM' value=<?=$Front->FRDOPSUM?>></p>
                                    <button type='summit' class='btn btn-info'>Сохранить заключение</button>           
                                </form>  
                            </div>    
                        </div>
                    </div><!<!-- collapse1 -->    
                    
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                Общая информация
                            </button>
                        </h3>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExp" style="">
                            <div class="accordion-body" style="background-color: <?=VIEW_BACKGROUND?>">                            
                                <form method='get'>
                                    <?php
                                        (new MyForm('ATContP1FileExpertCtrl','ExpRes',$_GET['ClCode'],$_GET['ContCode']))->AddForm();

                                        echo("<p><label>Результат ЭПЭ</label><select name='EXRES'>");
                                        echo("<option value='{$Expert->EXRES}'>{$Expert->EXRES}</option>");                                        
                                        echo("<option value='ЭПЭ проведена'>ЭПЭ проведена</option>");                                        
                                        echo("</select>");
                                        echo("<label>Рекомендуемая программа</label><select name='EXPRODREC'>");
                                        echo("<option value='{$Expert->EXPRODREC}'>{$Expert->EXPRODREC}</option>");
                                        echo("<option value='Банкротство физлиц'>Банкротство физлиц</option>");
                                        echo("<option value='Банкротство физлиц с ипотекой'>Банкротство физлиц с ипотекой</option>");
                                        echo("<option value='Внесудебное банкротство'>Внесудебное банкротство</option>");
                                        echo("<option value='Судебное банкротство (внесудебное не подходит)'>Судебное банкротство (внесудебное не подходит)</option>");
                                        echo("<option value='Защита от кредиторов'>Защита от кредиторов</option>");                                
                                        echo("<option value='Не подходит внесудебное банкротство'>Не подходит внесудебное банкротство</option>");
                                        echo("</select></p>");
                                        echo("<p><label>Сумма долга</label><input name='EXTOTDEBTSUM' value={$Expert->EXTOTDEBTSUM}></p>");
                                        echo("<p><label>Сумма основного долга</label><input name='EXMAINDEBTSUM' value={$Expert->EXMAINDEBTSUM}></p>");
                                        echo("<p><label>Общий доход</label><input name='EXANNTOTINC' value={$Expert->EXANNTOTINC}></p>");
                                        echo("<p><label>Общий ежемесячный платёж</label><input name='EXANNTOTPAY' value={$Expert->EXANNTOTPAY}></p>");                            
                                        if (in_array($_SESSION['EmRole'],['admin','expert','top','director','jurist'])){
                                            echo("<button type='summit' class='btn btn-info'>Сохранить результат</button>");
                                        }
                                    ?>
                                </form>
                            </div>    
                        </div>
                    </div><!<!-- collapse2 -->
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                Согласование договора
                            </button>
                        </h3>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExp" style="">
                            <div class="accordion-body" style="background-color: <?=VIEW_BACKGROUND?>">                            
                                <div class='row'>                    
                                    <div class='col-lg-2'>
                                        <div class="card text-white bg-primary mb-3" style="max-width: 20rem;">
                                            <div class="card-header">Согласование юриста</div>
                                            <div class="card-body">
                                                <h4 class="card-title"></h4>  
                                                <p class="card-text"></p>
                                                <input disabled type='text' name='EXRESEMP' value='<?=$Expert->EXJURSOGLNAME;?>'>
                                                <input disabled type='date' name='EXRESDAT' value='<?=$Expert->EXJURSOGLDATE;?>'>
                                                <form method='get'>
                                                    <?php
                                                        (new MyForm('ATContP1FileExpertCtrl','JurSogl',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                                                        if (($_SESSION['EmRole']=='admin') 
                                                                or ($_SESSION['EmRole']=='jurist') 
                                                                or ($_SESSION['EmRole']=='top')
                                                                or ($_SESSION['EmRole']=='expert')
                                                                or ($_SESSION['EmRole']=='director')
                                                            ){                                    
                                                            echo("<button type='submit' class='btn btn-secondary'>Согласовать заключение договора</button>");
                                                        }
                                                    ?>    
                                                </form>
                                            </div>
                                        </div> 
                                    </div>    
                                    <div class='col-lg-2'>
                                        <div class="card text-white bg-secondary mb-3" style="max-width: 20rem;">
                                            <div class="card-header">Согласование руководителя</div>
                                            <div class="card-body">
                                                <h4 class="card-title"></h4>  
                                                <p class="card-text"></p>
                                                <input disabled type='text' name='EXRESEMP' value='<?=$Expert->EXDIRSOGLNAME;?>'>
                                                <input disabled type='date' name='EXRESDAT' value='<?=$Expert->EXDIRSOGLDATE;?>'>
                                                <form method='get'>
                                                    <?php
                                                        (new MyForm('ATContP1FileExpertCtrl','DirSogl',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                                                        if (in_array($_SESSION['EmRole'],['admin','director','franshdir','top'])){                                    
                                                            echo("<button type='submit' class='btn btn-secondary'>Согласовать заключение договора</button>");
                                                        }
                                                    ?>    
                                                </form>
                                            </div>
                                        </div> 
                                    </div>    
                                </div>                                
                            </div>    
                        </div>
                    </div><!<!-- collapse3 -->
                </div><!<!-- accordion -->                                           
                
            </div>
            <div class="tab-pane fade" id="comments">
                <form method='get'>
                <?php (new MyForm('ATContP1FileExpertCtrl','AddComment',$_GET['ClCode'],$_GET['ContCode']))->AddForm() ?>
                <div class="form-group">
                    <label for="exampleTextarea" class="form-label mt-4">Добавить комментарий</label>
                    <textarea class="form-control" id="exampleTextarea" rows="3" style="height: 60px;" name='NewComment'></textarea>
                </div>
                <button class='btn btn-warning'>Добавить</button>
                </form>
                
                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th scope="col">Дата</th>
                          <th scope="col">Автор</th>
                          <th scope="col">Текст</th>
                          <th scope="col">Изменить</th>
                          <th scope="col">Удалить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($Comments as $Comment){
                                echo("<tr class='table-active'>");
                                echo("<td>{$Comment->CMDATE}</td><td>{$Comment->CMAUTHOR}</td>"); 
                                echo("<form method='get' autocomplete='off'>");
                                (new MyForm('ATContP1FileExpertCtrl','UpdComment',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                                echo("<td><textarea type='text' name='CmText' size=120 rows='5' style='height: 90px; width: 900px;'>$Comment->CMTEXT</textarea></td>");
                                echo("<input type='hidden' name='ComID' value='{$Comment->ID}'>");
                                if ($Comment->CMAUTHOR==$_SESSION['EmName']){
                                    echo("<td><button class='btn btn-success btn-sm'>Изменить</button></td>");
                                                                                                            
                                } else {
                                    echo("<td>-----</td>");                                    
                                }
                                echo("</form>");
                                
                                if ($Comment->CMAUTHOR==$_SESSION['EmName']){
                                    echo("<form method='get'>");
                                    (new MyForm('ATContP1FileExpertCtrl','DelComment',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                                    echo("<input type='hidden' name='ComID' value='{$Comment->ID}'>");
                                    echo("<td><button class='btn btn-danger btn-sm'>Удалить</button></td>");
                                    echo("</form>");
                                } else {
                                    echo("<td>-----</td>");
                                }
                                echo("</tr>");
                            }
                        ?>
                    </tbody>
                </table>               
                
            </div>
            
            <div class="tab-pane fade" id="risks">

                <table class='table table-hover'>
                    <thead>
                        <tr>
                            
                            <th>РИСК ДЛЯ КЛАССИЧЕСКОГО БФЛ</th>
                            <th>УДАЛИТЬ<th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                    
                    foreach($RiskList as $Risk){
                        echo("<tr>");
                        echo("<form method='get'>");
                        (new MyForm('ATContP1FileExpertCtrl','DelRisk',$Client->CLCODE,$Cont->CONTCODE))->AddForm();
                        echo("<input type='hidden' name='RiskID' value='{$Risk->ID}'>");
                        echo("<th>{$Risk->EXLISTVALUE}</th>");
                        if ((new CheckRole)->Check($_SESSION['EmRole'],'ATContP1FileExpertCtrl','DelRisk')){
                            echo("<th><button type='submit' class='btn btn-danger'>УДАЛИТЬ</button></th>");
                        }
                        echo("</form>");
                        echo("<tr>");
                    }                    
                ?>
                    </tbody>
                </table>
                
                <h6>Добавить риск заключения БФЛ</h6>
                <form method='get'>                    
                    <?php (new MyForm('ATContP1FileExpertCtrl','AddRisk',$Client->CLCODE,$Cont->CONTCODE))->AddForm(); ?>
                    <label>РИСК</label>                    
                    <select name='AddRisk' value='' id='RiskSelect'>                            
                        <option value=''></option>
                        <?php
                            foreach($RiskListDr as $RiskDr){
                                echo("<option value='{$RiskDr->DRVALUE}'>{$RiskDr->DRVALUE}</option>");
                            }
                        ?>
                    </select>
                    <?php
                        if ((new CheckRole)->Check($_SESSION['EmRole'],'ATContP1FileExpertCtrl','AddRisk')){
                            echo("<button class='btn btn-warning' type='submit'>ДОБАВИТЬ</button>");
                        }
                    ?>
                </form>
                
                <table class='table table-hover'>
                    <thead>
                        <tr>
                            
                            <th>РИСК ДЛЯ ВНЕСУДЕБНОГО БФЛ</th>
                            <th>УДАЛИТЬ<th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                    
                    foreach($RiskList2 as $Risk){
                        echo("<tr>");
                        echo("<form method='get'>");
                        (new MyForm('ATContP1FileExpertCtrl','DelRisk',$Client->CLCODE,$Cont->CONTCODE))->AddForm();
                        echo("<input type='hidden' name='RiskID' value='{$Risk->ID}'>");
                        echo("<th>{$Risk->EXLISTVALUE}</th>");
                        if ((new CheckRole)->Check($_SESSION['EmRole'],'ATContP1FileExpertCtrl','DelRisk')){
                            echo("<th><button type='submit' class='btn btn-danger'>УДАЛИТЬ</button></th>");
                        }
                        echo("</form>");
                        echo("<tr>");
                    }                    
                ?>
                    </tbody>
                </table>
                
                <h6>Добавить риск для внесудебного БФЛ</h6>
                <select name='AddRisk2' value='' id='Risk2Select'>
                    <option value=''></option>
                    <?php
                            foreach($RiskListDr2 as $RiskDr){
                                echo("<option value='{$RiskDr->DRVALUE}'>{$RiskDr->DRVALUE}</option>");
                            }
                        ?>
                </select>
                <form method='get'>
                    <?php (new MyForm('ATContP1FileExpertCtrl','AddRisk2',$Client->CLCODE,$Cont->CONTCODE))->AddForm(); ?>
                    <textarea class="form-control" id="AddRisk2" rows="7" style="height: 80px;" name='AddRisk2' maxlength=750></textarea>
                    <input type="hidden" id="Risk2Value2" name="Risk2Value2" value="">
                    <button class='btn btn-warning' type='submit'>ДОБАВИТЬ</button>
                </form>
            </div>
            <div class="tab-pane fade" id="mininc">                            
                <form autocomplete='off'>
                    <?php (new MyForm('ATContP1FileExpertCtrl','SaveMinInc',$Client->CLCODE,$Cont->CONTCODE))->AddForm(); ?>
                    <label>в расчете на душу населения</label><input name='MinIncAvg' value='<?=$MinIncList['Avg']?>'><br>
                    <label>для трудоспособного населения</label><input name='MinIncWork' value='<?=$MinIncList['Work']?>'><br>
                    <label>для пенсионеров</label><input name='MinIncPens' value='<?=$MinIncList['Pens']?>'><br>
                    <label>для детей</label><input name='MinIncChild' value='<?=$MinIncList['Child']?>'><br>                
                    <div class="form-group">
                        <label for="exampleTextarea" class="form-label mt-4">Расчёт</label>
                        <textarea class="form-control" id="exampleTextarea" rows="10" style="height: 60px;" name='MinIncResult' maxlength=5000 ><?=$MinIncList['Result']?></textarea>
                    </div>
                    <button type='summit' class='btn btn-info'>Сохранить результат</button>
                </form>                
            </div>
            
            <div class="tab-pane fade" id="under">
                <form>
                    <?php (new MyForm('ATContP1FileExpertCtrl','SaveUnder',$Client->CLCODE,$Cont->CONTCODE))->AddForm(); ?>
                    <select name='EXPUNDERRES'>
                        <option value="<?=$Expert->EXPUNDERRES?>"><?=$Expert->EXPUNDERRES?></option>
                        <option value="Без замечаний">Без замечаний</option>
                        <option value="Несущественные замечания">Несущественные замечания</option>
                        <option value="Существенные замечания">Существенные замечания</option>
                    </select>
                    <div class="form-group">
                        <label for="UnderTextarea" class="form-label mt-4">Комментарий андеррайтера</label>
                        <textarea class="form-control" id="UnderTextarea" rows="10" style="height: 200px;" name='EXPUNDERCOMMENT' maxlength=3000 ><?=$Expert->EXPUNDERCOMMENT?></textarea>
                    </div>
                    <button type='summit' class='btn btn-success'>Сохранить результат проверки</button>
                </form>
                
                
                <?php
                
                ?>  
                
            </div>
        </div>                                                                                              
                                                                              
    <script src="./js/expfile.js"></script>
    
</body>
</html>

