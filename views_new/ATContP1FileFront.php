<?php
/*
 * досье клиента
 *  */
#var_dump($Tarif->getTarifList());
#exit();
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <div>
        <h3>
            <p>ДОГОВОР БФЛ - ДОСЬЕ ДОГОВОРА</p>
        </h3>   
    </div>
    <div class='row'>
        <div class='col-3'>
            <?="ФИО КЛИЕНТА:   {$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}"?>
        </div>
        <div class='col-3'>
            <?="Филиал обслуживания:   {$Front->FROFFICE}"?>
        </div>
        <div class='col-3'>
            <?="Персональный менеджер:   {$Front->FRPERSMANAGER}"?>
        </div>
    </div>
    <div class='row'>
        <div class='col-3'>
            <?="Статус договора:   {$Cont->STATUS}"?>
        </div>
        <div class='col-3'>
            <?="Код клиента:   {$Client->CLCODE}"?>
        </div>
        <div class='col-3'>
            <?="Код договора:   {$Anketa->CONTCODE}"?>
        </div>
            
    <?php
    //кнопки для анкеты и печати документов
        echo("<div>");            
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1AnketaCtrl&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>");
        echo("<button class='btn btn-success'>ОТКРЫТЬ АНКЕТУ ДОГОВОРА</button></a>");
        
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileFrontPrintCtrl&action=ExpCont&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-info'>ДОГОВОР ЭПЭ</button></a>");
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileFrontPrintCtrl&action=ExpAct&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-info'>АКТ ЭПЭ</button></a>");
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileFrontPrintCtrl&action=MainCont&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-info'>ДОГОВОР УСЛУГ</button></a>");
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileFrontPrintCtrl&action=MainAct&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button disabled class='btn btn-info disabled'>АКТ УСЛУГ</button></a>");
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileFrontPrintCtrl&action=DovTemplate&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button disabled class='btn btn-info disabled'>ШАБЛОН ДОВЕРЕННОСТИ</button></a>");
        
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileFrontPrintCtrl&action=Test&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-secondary'>TEST</button></a>");
        
        echo("</div>");
    ?>

    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#Main">Основная инф</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#Tarif">Тариф, график платежей</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#ExpRes">Результаты ЭПЭ</a>
        </li>    
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#Pays">Платежи</a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#Comments">Комментарии</a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#Archive">Завершение работы</a>
        </li> 
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active show" id="main">
                                                                           
            <?php
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP1FileFrontCtrl','ExpCont',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    if ($Front->FROFFICE==''){
                        echo("<input type='hidden' name=FROFFICE value='{$_SESSION['EmBranch']}'>");
                    } else {
                        echo("<input type='hidden' name=FROFFICE value='{$Front->FROFFICE}'>");                    
                    }
                    echo("                
                    <p><label>ДАТА ДОГОВОРА ЭПЭ</label><input type='date' name='FREXPDATE' value={$Front->FREXPDATE}></p>
                    <p><label>СТОИМОСТЬ ЭПЭ</label><input type='text' name='FREXPSUM' value={$Front->FREXPSUM}></p>
                    <button type='submit' class='btn btn-warning'>Заключён договор ЭПЭ</button>
                </form>");    
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP1FileFrontCtrl','ExpAct',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    if ($Front->FROFFICE==''){
                        echo("<input type='hidden' name=FROFFICE value='{$_SESSION['EmBranch']}'>");
                    } else {
                        echo("<input type='hidden' name=FROFFICE value='{$Front->FROFFICE}'>");                    
                    }
                    echo("                
                        <p><label>ДАТА ПОДПИСАНИЯ АКТА ЭПЭ</label><input type='date' name='FREXPACTDATE' value={$Front->FREXPACTDATE}></p>
                        <button type='submit' class='btn btn-warning'>Подписан акт ЭПЭ</button>
                </form>");     
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP1FileFrontCtrl','ContSigned',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    if ($Front->FROFFICE==''){
                        echo("<input type='hidden' name=FROFFICE value='{$_SESSION['EmBranch']}'>");
                    } else {
                        echo("<input type='hidden' name=FROFFICE value='{$Front->FROFFICE}'>");                    
                    }
                    echo("<p><label>ДАТА ДОГОВОРА УСЛУГ</label><input type='date' name='FRCONTDATE' value={$Front->FRCONTDATE}></p>
                    <button type='submit' class='btn btn-warning'>Заключён договор услуг</button>
                </form>");     
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP1FileFrontCtrl','DovGet',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    if ($Front->FROFFICE==''){
                        echo("<input type='hidden' name=FROFFICE value='{$_SESSION['EmBranch']}'>");
                    } else {
                        echo("<input type='hidden' name=FROFFICE value='{$Front->FROFFICE}'>");                    
                    }
                    echo("<p><label>ДАТА ДОВЕРЕННОСТИ</label><input type='date' name='FRDOVDATE' value={$Front->FRDOVDATE}></p>
                    <button type='submit' class='btn btn-warning'>Получена доверенность</button>
                </form>");                
            ?>
            

        </div>
        <div class="tab-pane fade" id="Tarif">
            <h5>Выбор тарифа</h5>
            <div>
                <label>Выбранная программа</label><input name="FRCONTPROG" value='<?=$Front->FRCONTPROG?>'>
                <label>Выбранный тариф</label><input name="FRCONTTARIF" value='<?=$Front->FRCONTTARIF?>'>   <input name="FRCONTPAC" value='<?=$Front->FRCONTPAC?>'>
            </div>
            <div>
                <label>Стоимость договора</label><input name="FRCONTSUM" value='<?=$Front->FRCONTSUM?>'>
                
            </div>
            
        </div>
        <div class="tab-pane fade" id="ExpRes">
            <h5>Результаты ЭПЭ</h5>
            <?php
            echo("<div >
                <label>Рекомендуемый продукт</label><input disabled type='text' name='EXPRODREC' value='{$Expert->EXPRODREC}'>
            </div>");
            echo("<div >
                <label>Сумма долга</label><input type='text' disabled name='EXTOTDEBTSUM' value={$Expert->EXTOTDEBTSUM}>
                <label>Сумма основного долга</label><input disabled type='text' name='EXMAINDEBTSUM' value={$Expert->EXMAINDEBTSUM}> 
                <label>Число кредитов</label><input disabled type='text' name='AKCREDNUM' value={$Anketa->AKCREDNUM}>    
            </div>");                
                        
            echo("<form method='get'>");

                (new MyForm('ATContP1FileFrontCtrl','TarifChoose',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                echo("
                    <label>Программа</label><select name='FRCONTPROG'>
                        <option value=''></option>
                        <option value='Банкротство физлиц'>Банкротство физлиц</option>
                        <option value='Защита от кредиторов'>Защита от кредиторов</option>
                    </select>
                    <label>Тариф</label><select name='FRCONTTARIF'>
                        <option value=''></option>");
                        
                foreach($Tarif->getTarifList() as $TarifName ){
                    echo("<option value='{$TarifName->TRNAME}'>{$TarifName->TRNAME}</option>");
                }
                echo("</select>        
                <button class='btn btn-warning' type='submit'>ВЫБРАТЬ ТАРИФ</button>
            </form>");
            ?>
         
        </div>
        <div class="tab-pane fade" id="Pays">
            <form method='get'>
                <button class='btn btn-primary'>Принять платёж</button>
                <?php (new MyForm('ATContP1FileFrontCtrl','AddPayment',$_GET['ClCode'],$_GET['ContCode']))->AddForm(); ?>
                <input type='hidden' name='FRPERSMANAGER' value='<?=$Front->FRPERSMANAGER?>'>
                <input type='hidden' name='FROFFICE' value='<?=$Front->FROFFICE?>'>
                <div class='col-10'>
                    <label>Сумма</label><input type='text' value='0' name='PAYSUM'>
                    <label>Дата</label><input type='date' name='PAYDATE'>
                    <label>Тип</label><select name='PAYCONTTYPE'>
                        
                        <option value='1'>по ПКО</option>
                        <option value='2'>по чеку</option>
                    </select>
                </div>
                <div class='col-10'>
                    <label>Назначение платежа</label><select  name='PAYPR'>
                        <option></option>
                        <?php
                            foreach($Payment->getTypeList() as $PayPr){
                                echo("<option value='{$PayPr->NAME}'>{$PayPr->NAME}</option>");
                            }
                        ?>
                        </select>
                </div>
            </form>
            <div class='col-4'>
            <table class="table table-hover">
                <thead>
                    <tr>
                      <th scope="col">Код</th>
                      <th scope="col">Дата</th>
                      <th scope="col">Сумма</th>
                      <th scope="col">Назначение платежа</th>
                      <th scope="col">Скачать</th>
                    </tr>
                </thead>
                <tbody>                
                    <?php
                    foreach($Payment->getPaymentList() as $i => $Pay){
                        echo('<tr class="table-active">');
                        echo("<td>{$Pay->PAYCODE}</td>");
                        echo("<td>{$Pay->PAYDATE}</td>");
                        echo("<td>{$Pay->PAYSUM}</td>");
                        echo("<td>{$Pay->PAYPR}</td>");
                        if ($i==0) {echo("<td><a href='payments/{$Pay->CONTCODE}.xlsx'><button class='btn btn-success'>Скачать ПКО</button></a></td>");}
                        echo('</tr>');
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div><!--Внесение платежей-->
        <div class="tab-pane fade" id="Comments">
            <form method='get'>
                <?php (new MyForm('ATContP1FileFrontCtrl','AddComment',$_GET['ClCode'],$_GET['ContCode']))->AddForm() ?>
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
                        echo('<tr class="table-active">');
                        echo("<td>{$Comment->CMDATE}</td><td>{$Comment->CMAUTHOR}</td><td>{$Comment->CMTEXT}</td><td>");
                        if ($Comment->CMAUTHOR==$_SESSION['EmName']) {
                            echo("<button class='btn btn-danger>УДАЛИТЬ</button>");

                        }
                        echo('</td></tr>');
                    }
                    ?>
                </tbody>
            </table>
                        
        </div>
        <div class="tab-pane fade" id="Archive">            
            
            <input type=date''>Договор в архиве
            
            <button class='btn btn-danger'>Завершить работу</button>
            
        </div>
    </div>
    
    <div>
        
    </div>
        
</body>
</html>
