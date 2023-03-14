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
           
    <?php
        echo("<h4>ФИО Клиента: {$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}</h4>");
        echo("<h4>Статус: {$Cont->STATUS}</h4>");
            ?>
        </div>
        
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#result">Результат ЭПЭ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#comments">Комментарии</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#creditors">Кредиторы</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#risks">Риски</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#work">Сведения о работе</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#incomes">История доходов</a>
            </li>            
        </ul>
        
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active show" id="result">
                <div class='row'>
                    <div class='col-lg-2'>
                        <div class="card text-white bg-secondary mb-3" style="max-width: 20rem;">
                            <div class="card-header">Согласование андеррайтера</div>
                            <div class="card-body">
                                <h4 class="card-title"></h4>  
                                <p class="card-text"></p>
                                <input disabled type='text' name='EXRESEMP' value='<?=$Expert->EXRESEMP;?>'>
                                <input disabled type='date' name='EXRESDAT' value='<?=$Expert->EXRESDAT?>'>
                                <form method='get'>
                                    <?php
                                        (new MyForm('ATContP1FileExpertCtrl','ExpSogl',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                                    
                                        if (($_SESSION['EmRole']=='admin') or ($_SESSION['EmRole']=='expert') or ($_SESSION['EmRole']=='top')){
                                            echo("<button type='submit' class='btn btn-dark'>Согласовать заключение договора</button>");
                                        }                                        
                                    ?>            
                                </form>
                            </div>
                        </div> 
                    </div>
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
                                                or ($_SESSION['EmName']=='Ольга Щеглова')
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
                                        if (($_SESSION['EmRole']=='admin') or ($_SESSION['EmRole']=='director') or ($_SESSION['EmRole']=='top')){                                    
                                            echo("<button type='submit' class='btn btn-secondary'>Согласовать заключение договора</button>");
                                        }
                                    ?>    
                                </form>
                            </div>
                        </div> 
                    </div>    
                </div>   
                <div class='row'> 
                    <div class='col-lg-4'>
                        <form method='get'>
                            <?php
                                (new MyForm('ATContP1FileExpertCtrl','ExpRes',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                            
                                echo("<p><label>Результат ЭПЭ</label><select name='EXRES'>");
                                echo("<option value='{$Expert->EXRES}'>{$Expert->EXRES}</option>");
                                echo("<option value='ЭПЭ не проведена. Доработка'>Экспертиза не проведена. Доработка</option>");
                                echo("<option value='ЭПЭ проведена'>ЭПЭ проведена</option>");
                                echo("<option value='Требуется согласование юриста'>Требуется согласование юриста</option>");
                                echo("</select>");
                                echo("<label>Рекомендуемая программа</label><select name='EXPRODREC'>");
                                echo("<option value='{$Expert->EXPRODREC}'>{$Expert->EXPRODREC}</option>");
                                echo("<option value='Банкротство физлиц'>Банкротство физлиц</option>");
                                echo("<option value='Защита от кредиторов'>Защита от кредиторов</option>");
                                echo("</select></p>");
                                echo("<p><label>Сумма долга</label><input name='EXTOTDEBTSUM' value={$Expert->EXTOTDEBTSUM}></p>");
                                echo("<p><label>Сумма основного долга</label><input name='EXMAINDEBTSUM' value={$Expert->EXMAINDEBTSUM}></p>");
                                echo("<p><label>Общий доход</label><input name='EXANNTOTINC' value={$Expert->EXANNTOTINC}></p>");
                                echo("<p><label>Общий ежемесячный платёж</label><input name='EXANNTOTPAY' value={$Expert->EXANNTOTPAY}></p>");
                            ?>
                            <button type='summit' class='btn btn-info'>Сохранить результат</button>
                        </form>
                    </div>
                    <div class='col-lg-3'>
                        <form method='get'>
                            <?php (new MyForm('ATContP1FileExpertCtrl','AddToJurist',$_GET['ClCode'],$_GET['ContCode']))->AddForm() ?>
                            <div class="form-group">
                                <label for="exampleTextarea" class="form-label mt-4">Причина согласования юристом</label>
                                <textarea class="form-control" id="exampleTextarea" rows="3" style="height: 60px;" name='EXCOMMENT' maxlength=250 ><?=$Expert->EXCOMMENT?></textarea>
                            </div>
                            <button type='summit' class='btn btn-warning'>Сохранить причину</button>               
                        </form>                        
                    </div>
                </div>
                
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
                          <th scope="col">Удалить</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($Comments as $Comment){
                                echo("<tr class='table-active'>");
                                echo("<td>{$Comment->CMDATE}</td><td>{$Comment->CMAUTHOR}</td><td>{$Comment->CMTEXT}</td>");
                                echo("</tr>");
                            }
                        ?>
                    </tbody>
                </table>
                
                
            </div>
            <div class="tab-pane fade" id="creditors">
                <table class='table table-hover'>
                    <thead>
                        <tr>
                            <th>CRCODE</th>
                            <th>По договору</th>
                            <th>Текущий кредитор</th>
                            <th>Номер договора</th>
                            <th>Дата договора</th>
                            <th>Сумма кредита</th>
                            <th>Общий долг</th>
                            <th>Основной долг</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($CredList as $Credit){
                            $CrDate=(new PrintFunctions())->DateToStr($Credit->CROPENDAT);
                            
                            echo("<tr class='table-secondary'>");
                            //(new MyForm('ATClientFileCtrl','Index',$_GET['ClCode'],0))->AddForm();
                            //echo("<input type='hidden' name='ClAccID' value='{$Comment->ID}'>");
                            echo("<td>$Credit->CRCODE</td>");
                            echo("<td>$Credit->CRBANKCONTNAME</td>");
                            echo("<td>$Credit->CRBANKCURNAME</td>");
                            echo("<td>$Credit->CRCONTNUM</td>");
                            echo("<td>$CrDate</td>");
                            echo("<td>$Credit->CRSUM</td>");
                            echo("<td>$Credit->CRSUMREST</td>");
                            echo("<td>$Credit->CRSUMRESTMAIN</td>");
                            echo("</tr>");
                            //echo("<td><button class='btn btn-danger btn-sm'>Удалить</button></td>");
                        }
                    ?>
                    </tbody>    
                </table>
                
            </div>
            <div class="tab-pane fade" id="risks">

                <table class='table table-hover'>
                    <thead>
                        <tr>
                            
                            <th>РИСК</th>
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
            </div>
            <div class="tab-pane fade" id="work">
                <div class="g-2">
                <a target='_blank' href="index_admin.php?controller=ATContP1FileExpertCtrl&action=ShowAddViewInc&ClCode=<?=$Client->CLCODE?>&ContCode=<?=$Cont->CONTCODE?>"><button class='f-bu f-bu-default'>Сведения о работе</button></a>
            </div>
            </div>
            <div class="tab-pane fade" id="incomes">
                <a href="index_admin.php?controller=ATContP1FileExpertCtrl&action=ShowIncHist&ClCode=<?=$Client->CLCODE?>&ContCode=<?=$Cont->CONTCODE?>"><button class='btn btn-primary'>Расчитать сведения о доходах</button></a>
            </div>
        </div>                                                                                              
                                                                              
    <script src="./js/expfile.js"></script>
    
</body>
</html>

