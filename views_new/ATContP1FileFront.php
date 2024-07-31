<?php
/*
 * досье клиента
 *  */

?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <div>
        <h3>
            <p>ДОГОВОР БФЛ - ДОСЬЕ МЕНЕДЖЕРА</p>
        </h3>
        <a href='index_admin.php?controller=ATClientFileCtrl&ClCode=<?=$Client->CLCODE?>'><button class='btn btn-danger'>Вернуться в досье клиента</button></a>
    </div>
    <div class='row'>
        <div class='col-3'>
            <?="ФИО КЛИЕНТА:   {$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}"?>
        </div>
        <div class='col-3'>
            <form method='get'>
            <?php
                (new MyForm('ATContP1FileFrontCtrl','ChangeBranch',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                echo("Филиал обслуживания:");
                (new EchoBranchList())->echoList($Front->FROFFICE,'FROFFICE');                
                if (in_array($_SESSION['EmRole'],['top','admin','director']))
                {
                    echo("<button class='btn btn-warning'>Сменить</button>");
                }
            ?>
            </form>
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
        
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FilePrintCtrl&action=MainCont&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-info'>ДОГОВОР УСЛУГ</button></a>");
        
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FilePrintCtrl&action=ExpAct&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-primary'>Правовое заключение (акт ЭПЭ)</button></a>");
        
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FilePrintCtrl&action=DopCont&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-info'>Допсоглашение к договору</button></a>");
        
//        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FilePrintCtrl&action=PersDataPermit&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
//        . "<button class='btn btn-primary'>График платежей</button></a>");
        
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FilePrintCtrl&action=DopGaranty&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-info'>Соглашение о гарантиях</button></a>");
                                        
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FilePrintCtrl&action=DovTemplate&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-primary'>ШАБЛОН ДОВЕРЕННОСТИ</button></a>");
        
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FilePrintCtrl&action=WorkFinalAct&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-info'>ОТЧЁТ БФЛ ИТОГОВЫЙ</button></a>");
        
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FilePrintCtrl&action=PayBill&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-primary'>СПРАВКА О ПЛАТЕЖАХ</button></a>");
        
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileFrontCtrl&action=Test&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
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
<!--        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#ExpRes">Результаты ЭПЭ</a>
        </li>    -->
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#Pays">Платежи</a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#Credit">Расчёт по кредиту</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#Comments">Комментарии</a>
        </li> 
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#Archive">Завершение работы</a>
        </li> 
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active show" id="Main">
                                                                           
            <?php
//                echo("<form method='get' autoload='off'>");
//                    (new MyForm('ATContP1FileFrontCtrl','ExpCont',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
//                    if ($Front->FROFFICE==''){
//                        echo("<input type='hidden' name=FROFFICE value='{$_SESSION['EmBranch']}'>");
//                    } else {
//                        echo("<input type='hidden' name=FROFFICE value='{$Front->FROFFICE}'>");                    
//                    }
//                    echo("                
//                    <p><label>ДАТА ДОГОВОРА ЭПЭ</label><input type='date' name='FREXPDATE' value={$Front->FREXPDATE}></p>
//                    <p><label>СТОИМОСТЬ ЭПЭ</label><input type='text' name='FREXPSUM' value={$Front->FREXPSUM}></p>
//                    <button type='submit' class='btn btn-warning'>Заключён договор ЭПЭ</button>
//                </form>");  
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP1FileFrontCtrl','ContSigned',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    if ($Front->FROFFICE==''){
                        echo("<input type='hidden' name=FROFFICE value='{$_SESSION['EmBranch']}'>");
                    } else {
                        echo("<input type='hidden' name=FROFFICE value='{$Front->FROFFICE}'>");                    
                    }
                    if ($Anketa->STATUS>10){
                        echo("<p><label>ДАТА ДОГОВОРА УСЛУГ</label><input type='date' name='FRCONTDATE' value={$Front->FRCONTDATE}>
                            <button type='submit' class='btn btn-warning'>Заключён договор услуг</button></p>");     
                    }
                echo("</form>");
            
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP1FileFrontCtrl','ExpGet',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    echo("                
                    <p><label>ДАТА ПОЛУЧЕНИЯ ДОКУМЕНТОВ ОТ КЛИЕНТА</label><input type='date' name='FREXPGETDATE' value={$Front->FREXPGETDATE}>
                    <button type='submit' class='btn btn-warning'>Клиент предоставил документы на ЭПЭ</button></p>
                </form>");
//                echo("<form method='get' autoload='off'>");
//                    (new MyForm('ATContP1FileFrontCtrl','ExpSent',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();                    
//                    echo("                
//                    <p><label>ДАТА ОТПРАВКИ НА ЭПЭ</label><input type='date' name='FREXPSENTDATE' value={$Front->FREXPSENTDATE}></p>                    
//                    <button type='submit' class='btn btn-danger'>Документы отправлены на ЭПЭ</button>
//                </form>");
                    
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP1FileFrontCtrl','ExpAct',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    if ($Front->FROFFICE==''){
                        echo("<input type='hidden' name=FROFFICE value='{$_SESSION['EmBranch']}'>");
                    } else {
                        echo("<input type='hidden' name=FROFFICE value='{$Front->FROFFICE}'>");                    
                    }
                    if ($Anketa->STATUS>10){
                        echo("                
                            <p><label>ДАТА ПОДПИСАНИЯ АКТА ЭПЭ</label><input type='date' name='FREXPACTDATE' value={$Front->FREXPACTDATE}>
                            <button type='submit' class='btn btn-warning'>Подписан акт ЭПЭ</button></p>");
                    }
                echo("</form>");     
                
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP1FileFrontCtrl','DopSigned',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    if ($Front->FROFFICE==''){
                        echo("<input type='hidden' name=FROFFICE value='{$_SESSION['EmBranch']}'>");
                    } else {
                        echo("<input type='hidden' name=FROFFICE value='{$Front->FROFFICE}'>");                    
                    }
                    
                    echo("<p><label>ДАТА ДОПСОГЛАШЕНИЯ ОБ ИЗМЕНЕНИИ СТОИМОСТИ</label><input type='date' name='FRDOPDATE' value='{$Front->FRDOPDATE}'><br>
                        <label>УВЕЛИЧЕНИЕ СТОИМОСТИ ЗА СЛОЖНОСТЬ</label><input type='number' name='FRDOPSUM' value='{$Front->FRDOPSUM}'>
                    <button type='submit' class='btn btn-warning'>Допсолгашение подписано</button></p>
                </form>");
                
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP1FileFrontCtrl','DovGet',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    if ($Front->FROFFICE==''){
                        echo("<input type='hidden' name=FROFFICE value='{$_SESSION['EmBranch']}'>");
                    } else {
                        echo("<input type='hidden' name=FROFFICE value='{$Front->FROFFICE}'>");                    
                    }
                    echo("<p><label>ДАТА ДОВЕРЕННОСТИ</label><input type='date' name='FRDOVDATE' value={$Front->FRDOVDATE}>
                    <button type='submit' class='btn btn-warning'>Получена доверенность</button></p>
                </form>");                
            ?>
            

        </div>
        <div class="tab-pane fade" id="Tarif">
            <h5>Выбор тарифа</h5><input name="FRCONTPAC" value='<?=$Front->FRCONTPAC?>' size='5'>
            <?php
                echo("<form method='get'>");

                    (new MyForm('ATContP1FileFrontCtrl','TarifChoose',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    echo("
                        <label>Программа</label><select name='FRCONTPROG'>
                            <option value='{$Front->FRCONTPROG}'>{$Front->FRCONTPROG}</option>
                            <option value='Банкротство физлиц'>Банкротство физлиц</option>
                            <option value='Банкротство физлиц с ипотекой'>Банкротство физлиц с ипотекой</option>
                            <option value='Внесудебное банкротство'>Внесудебное банкротство</option>
                            <option value='Защита от кредиторов'>Защита от кредиторов</option>
                        </select>
                        <label>Тариф</label><select name='FRCONTTARIF'>
                            <option value='{$Front->FRCONTTARIF}'>{$Front->FRCONTTARIF}</option>");

                    foreach($Tarif->getTarifList() as $TarifName ){
                        echo("<option value='{$TarifName->TRNAME}'>{$TarifName->TRNAME}</option>");
                    }
                    echo("</select>");        
                    
                    echo("<button class='btn btn-warning' type='submit'>ВЫБРАТЬ ТАРИФ</button>");
                    

                echo("</form>");
            ?>
                        
            <div class='row'>
                <h4>Доплаты</h4>
                <div id="TarifList1"></div>                  
                <h4>Вычеты</h4>
                <div id="TarifList2"></div>
                <h4>Скидки</h4>
                <div id="TarifList3"></div>                
            </div>
            
            <div>
                <form method='get'>
                    <?php
                        (new MyForm('ATContP1FileFrontCtrl','SaveCalend',$_GET['ClCode'],$_GET['ContCode']))->AddForm()
                    ?>
                    <label>Стоимость договора</label><input name="FRCONTSUM" id="TarifSum" value='<?=$Front->FRCONTSUM?>'>
                    <input id="TarifPeriod" name='TarifPeriod' value="1" type='hidden'>
                    <button type='submit' class='btn btn-warning'>Сохранить сумму.Сформировать график по тарифу.</button>
                </form>
            </div>
            
            <div>        
                <lable>Платёж при заключении договора</lable><input value="9000">
            </div>
            <div>
                <lable>Срок расрочки (месяцев)</lable><select id="AnnNum" onchange='GetPeriod()'>
                    <option>1</option>
                    <option>6</option>
                    <option>12</option>
                    <option>18</option>
                </select>
                <lable>Ежемесячный платёж</lable><input id="AnnPay" value="0">
            </div>
            
            <div class='row'>
                <div class='col-lg-4'>
                    <h5>График плановых платежей</h5>
                    <hr>
                    <form method='get'>
                        <?php
                            (new MyForm('ATContP1FileFrontCtrl','AddPayCalend',$_GET['ClCode'],$_GET['ContCode']))->AddForm()
                        ?>
                        <h6>Добавить платёж</h6>
                        <input type='number' name='PayNum' value='' size='8'>
                        <input type='date' name='PayDate' value='' size='11'>
                        <input type='text' name='PaySum' value='0' size='11'>
                        <button class='btn btn-success'>Добавить</button>
                    </form>
                    <hr>
                    <form>
                        <?php
                            (new MyForm('ATContP1FileFrontCtrl','AddIndPayCalend',$_GET['ClCode'],$_GET['ContCode']))->AddForm()
                        ?>
                        <fieldset>
                            <h6>Рассчитать индивидуальный график</h6>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="CalendType" id="optionsRadios1" value="AnnSum" checked="">
                                <label class="form-check-label" for="optionsRadios1">
                                    По сумме ежемесячного платежа
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="CalendType" id="optionsRadios2" value="TotSum">
                                <label class="form-check-label" for="optionsRadios2">
                                    По общей сумме платежей
                                </label>
                                </div>      
                        </fieldset>                        
                        <p>
                            <label>Сумма</label><input type='text' name='PaySum' value='0' size='10'>
                            <label>Дата первого платежа</label><input type='date' name='PayDate' value='' size='10'>
                        </p>
                        <p>
                            <label>Число платежей</label><input type='number' name='PayCount' value='' size='4'>
                            <label>начиная с</label><input type='number' name='PayNum' value='' size='4'>
                        </p>
                        <button class='btn btn-success'>Сформировать индивидуальный график</button>
                    </form>
                    <a href='index_admin.php?controller=ATContP1FileFrontCtrl&action=DelCalend&ClCode=<?=$_GET['ClCode']?>&ContCode=<?=$_GET['ContCode']?>'><button class='btn btn-danger'>Удалить график</button></a>
                    <table class="table table-hover">
                        <thead>
                            <tr>                            
                            <th scope="col">Платёж</th>    
                            <th scope="col">Дата</th>
                            <th scope="col">Сумма</th>                            
                            </tr>
                        </thead>
                        <tbody>  
                            <?php
                                foreach($ContP1->getPayCalend() as $PlanPay){
                                    $PayDate=(new PrintFunctions)->DateToStr($PlanPay->PAYDATE);
                                    echo("<tr>");
                                    echo("<form method='get'>");
                                        (new MyForm('ATContP1FileFrontCtrl','UpdPayCalend',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                                        echo("<input type='hidden' name='ID' value={$PlanPay->ID}>");
                                        echo("<th>Платёж <input type=text name='PayNum' value={$PlanPay->PAYNUM} size=1></th>");                                    
                                        echo("<th><input type=date name='PayDate' value={$PlanPay->PAYDATE} size=7></th>");
                                        echo("<th><input type=text name='PaySum' value={$PlanPay->PAYSUM} size=7></th>");
                                        echo("<th><button class='btn btn-success'>V</button></th>");
                                    echo("</form>");
                                    echo("<th><form method='get'>");
                                    (new MyForm('ATContP1FileFrontCtrl','DelPayCalend',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                                    echo("<input type=hidden name='ID' value='{$PlanPay->ID}'>");
                                    echo("<button class='btn btn-danger'>X</button></form></th></tr>");
                                }
                            ?>
                        </tbody>
                    </table>

                </div>
                <div class='col-lg-4'><h5>Скидки</h5>
                    <hr>                    
                    <form method='get' autocomplete="off">
                        <?php
                            (new MyForm('ATContP1FileFrontCtrl','AddDiscount',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                        ?>
                        <p><label>Вид скидки</label>
                            <select type='text' required name='DiscountType'>
                                <option value='НД'>Новый договор</option>
                                <option value='ДД'>Действующий договор</option>
                            </select>
                        </p>
                        <p><label>Сумма скидки</label><input type='text' required name='DiscountSum'>рублей</p>
                        <p><label>Описание</label><input type='text' style='width:400' required name='DiscountComment'></p>
                        <button class='btn btn-warning'>Применить</button>
                    </form>
                    <hr>
                    <h6>Согласование скидки с директором</h6>                    
                    <form method='get' autocomplete="off">
                        <?php
                            (new MyForm('ATContP1FileFrontCtrl','RequestDiscount',$_GET['ClCode'],$_GET['ContCode']))->AddForm();                            
                            echo("<p><label>Сумма</label><br><input type='text' style='width:100' name='FRDISCSUM' value='{$Front->FRDISCSUM}'><br>");
                            echo("<p><label>Обоснование</label><br><textarea style='width: 500px;height: 80px' maxlength=500 name='FRDISCCOMMENT'>{$Front->FRDISCCOMMENT}</textarea><br>");
                            echo("<button class='btn btn-dark'>Отправить на согласование</button></p>");
                        ?>
                    </form>
                    <hr>
                    <form method='get' autocomplete="off">
                        <?php
                            (new MyForm('ATContP1FileFrontCtrl','ApproveDiscount',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                            echo("<label>Комментарий директора</label><br><textarea style='width: 500px;height: 80px' maxlength=500 name='FRDISCAPPROVECOMMENT'>{$Front->FRDISCAPPROVECOMMENT}</textarea><br>");
                            if (in_array($_SESSION['EmRole'],['top','admin'])){
                                echo("<button class='btn btn-danger'>Согласовать</button>");
                            }
                        ?>
                    </form>
                    <hr>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Сумма</th>
                                <th>Описание скидки</th>
                                <th>Тип скидки</th>
                                <th>Удалить</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            #var_dump($ContP1);
                                foreach($ContP1->getDiscounts() as $Discount){
                                    echo("<tr><td>{$Discount->DISCOUNTSUM}</td>");
                                    echo("<td>{$Discount->DISCOUNTCOMMENT}</td>");
                                    echo("<td>{$Discount->DISCOUNTTYPE}</td>");
                                    if ((new CheckRole)->Check($_SESSION['EmRole'],'ATContP1FileFrontCtrl','DelDiscount')){
                                        echo("<td><a href='index_admin.php?controller=ATContP1FileFrontCtrl&action=DelDiscount&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}&DiscId={$Discount->ID}'>"
                                            . "<button class='btn btn-danger'>Удалить</button></a></td>");
                                    }
                                    echo("</tr>");
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
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
                        <option value='{$Front->FRCONTPROG}'>{$Front->FRCONTPROG}</option>
                        <option value='Банкротство физлиц'>Банкротство физлиц</option>
                        <option value='Банкротство физлиц с ипотекой'>Банкротство физлиц с ипотекой</option>
                        <option value='Внесудебное банкротство'>Внесудебное банкротство</option>
                        <option value='Защита от кредиторов'>Защита от кредиторов</option>
                    </select>
                    <label>Тариф</label><select name='FRCONTTARIF'>
                        <option value='{$Front->FRCONTTARIF}'>{$Front->FRCONTTARIF}</option>");
                        
                foreach($Tarif->getTarifList() as $TarifName ){
                    echo("<option value='{$TarifName->TRNAME}'>{$TarifName->TRNAME}</option>");
                }
                echo("</select>");        
                    
                if ($Anketa->STATUS>3){
                    echo("<button class='btn btn-warning' type='submit'>ВЫБРАТЬ ТАРИФ</button>");
                }
                
            echo("</form>");
            ?>
         
        </div>
        <div class="tab-pane fade" id="Pays">
            <div>
                <p>Внесено по договору: <strong><?=$Payment->getTotalSum()['TotalInc']->PAYSUM ?> руб.</strong><p>
                <p>Внесено в ОХ: <strong><?=$Payment->getTotalSum()['TotalDep']->PAYSUM ?> руб.</strong><p>
                <p>Выдано из ОХ: <strong><?=$Payment->getTotalSum()['TotalDep2']->PAYSUM ?> руб.</strong><p>
            </div>
            <form method='get'>
                <button class='btn btn-primary' id='AddPayBtn'>Принять платёж</button>
                <?php (new MyForm('ATContP1FileFrontCtrl','AddPayment',$_GET['ClCode'],$_GET['ContCode']))->AddForm(); ?>
                <input type='hidden' name='FRPERSMANAGER' value='<?=$Front->FRPERSMANAGER?>'>
                <input type='hidden' name='FROFFICE' value='<?=$Front->FROFFICE?>'>
                <div class='col-10'>
                    <label>Сумма</label><input type='text' value='0' name='PAYSUM' required>
                    <?php
                        $CurDate=date("Y-m-d");
                        if (in_array($_SESSION['EmRole'],['top','admin'])){
                            echo("<label>Дата</label><input type='date' name='PAYDATE' value='{$CurDate}' required>");
                        } else {
                            echo("<input type='hidden' name='PAYDATE' value='{$CurDate}' required>");
                        }
                    ?>
                    <label>Тип</label><select name='PAYCONTTYPE'>
                        <?php
                        if ($Front->FRCONTTYPE==1){
                            echo("<option value='1'>по ПКО</option>");
                        }
                        if ($Front->FRCONTTYPE==2){
                            echo("<option value='2'>по чеку</option>");
                        }
                        ?>                        
                        <option value='1'>по ПКО</option>
                        <option value='2'>по чеку</option>
                    </select>
                </div>
                <div class='col-10'>
                    <label>Назначение платежа</label><select required name='PAYPR'>
                        <option></option>
                        <?php
                            foreach($Payment->getTypeList() as $PayPr){
                                echo("<option value='{$PayPr->NAME}'>{$PayPr->NAME}</option>");
                            }
                        ?>
                        </select>
                </div>
                <div class='col-10'>
                    <label>Способ внесения платежа</label><select required name='PAYMETHOD'>
                        <option></option>
                        <option>Наличные (Деньги в кассу)</option>
                        <option>Наличные (Перевод на карту)</option>
                        <option>Безналичный платёж (Оплата картой/QR-код/Перевод в банк)</option>
                        </select>
                </div>
            </form>
            <div class='col-6'>
            <table class="table table-hover">
                <thead>
                    <tr>
                      <th scope="col">Код</th>
                      <th scope="col">Дата</th>
                      <th scope="col">Сумма</th>
                      <th scope="col">Назначение платежа</th>
                      <th scope="col">Способ платежа</th>
                      <th scope="col">Скачать</th>
                    </tr>
                </thead>
                <tbody id='PaymentList'>        
                    
                    <?php
//                    foreach($Payment->getPaymentList() as $i => $Pay){
//                        $PayDate=(new PrintFunctions())->DateToStr($Pay->PAYDATE);
//                        echo('<tr class="table-active">');
//                        echo("<td>{$Pay->PAYCODE}</td>");
//                        echo("<td>{$PayDate}</td>");
//                        echo("<td>{$Pay->PAYSUM}</td>");
//                        echo("<td>{$Pay->PAYPR}</td>");
//                        
//                        echo("<td><a href='payments/{$Pay->ID}.xlsx'><button class='btn btn-success'>Скачать ПКО</button></a></td>");                            
//                        
//                        
//                        echo("<td><a href=index_admin.php?controller=ATContP1FileFrontCtrl&action=FormPayBill&Id={$Pay->ID}&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}><button class='btn btn-info'>Переформировать</button></a></td>");
//                        
//                        if ((new CheckRole)->Check($_SESSION['EmRole'],'ATContP1FileFrontCtrl','DelPayment')){
//                            echo("<td><a href=index_admin.php?controller=ATContP1FileFrontCtrl&action=DelPayment&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}&PayId={$Pay->ID}><button class='btn btn-danger'>УДАЛИТЬ_{$Pay->ID}</button></a></td>");
//                        }
//                        echo('</tr>');
//                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div><!--Внесение платежей-->
        <div class="tab-pane fade" id="Credit">
            <a href=index_admin.php?controller=ATContP1FileFrontCtrl&action=CredCount&ClCode=<?=$_GET['ClCode']?>&ContCode=<?=$_GET['ContCode']?>><button class='btn btn-primary'>Перерасчёт</button></a>
            <p>Сумма кредита: <?=$ContP1->Credit->CredSum?>   Ставка кредита: <?=$ContP1->Credit->CredRate?>   Срок кредита: <?=$ContP1->Credit->CredPeriod?></p>
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Платёж</th>
                    <th scope="col">Дата платежа</th>
                    <th scope="col">Дней в периоде</th>
                    <th scope="col">Сумма платежа</th>
                    <th scope="col">Долг до платежа</th>
                    <th scope="col">Проценты</th>
                    <th scope="col">Погашение ОД</th>
                    <th scope="col">Долг после платежа</th>
                  </tr>
                </thead>
                <tbody>                  
                    <?php
                        foreach($ContP1->Credit->CredPaysList as $Pay){
                            echo("<tr class='table-active'>");
                            echo("<td>$Pay->PAYNUM</td>");
                            echo("<td>$Pay->PAYDATE</td>");
                            echo("<td>$Pay->PAYDAYS</td>");
                            echo("<td>$Pay->PAYSUM</td>");
                            echo("<td>$Pay->DEBTSUM</td>");
                            echo("<td>$Pay->PERCSUM</td>");
                            echo("<td>$Pay->MAINSUM</td>");
                            echo("<td>$Pay->DEBTAFTERSUM</td>");
                            echo("</tr>");
                        }
                    ?>                                                        
                </tbody>
            </table>
        </div><!--расчёт по кредиту-->
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
                      <th scope="col">Изменить</th>
                      <th scope="col">Удалить</th>
                    </tr>
                </thead>
                <tbody>                
                    <?php
                    foreach($Comments as $Comment){
                        echo('<tr class="table-active">');
                        echo("<td>{$Comment->CMDATE}</td><td>{$Comment->CMAUTHOR}</td>");
                        echo("<form method='get' autocomplete='off'>");
                            (new MyForm('ATContP1FileFrontCtrl','UpdComment',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                            echo("<td><textarea type='text' name='CmText' size=120 rows='5' style='height: 90px; width: 900px;'>$Comment->CMTEXT</textarea></td>");                        
                        if ($Comment->CMAUTHOR==$_SESSION['EmName']) {
                            echo("<input type='hidden' name='ComID' value='{$Comment->ID}'>");
                            echo("<td><button class='btn btn-success'>ИЗМЕНИТЬ</button></td>");
                        } else {
                            echo("<td>-----</td>");
                        }
                        echo("</form>");
                                                
                        if ($Comment->CMAUTHOR==$_SESSION['EmName']) {
                            echo("<form method='get'>");
                            (new MyForm('ATContP1FileFrontCtrl','DelComment',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                            echo("<input type='hidden' name='ComID' value='{$Comment->ID}'>");
                            echo("<td><button class='btn btn-danger'>УДАЛИТЬ</button></td>");
                            echo("</form>");
                        } else {
                            echo("<td>-----</td>");
                        }
                        echo('</tr>');
                    }
                    ?>
                </tbody>
            </table>
                        
        </div>
        <div class="tab-pane fade" id="Archive">            
            
            <?php
                echo("<form method='get' autoload='off'>");
                (new MyForm('ATContP1FileFrontCtrl','WorkFinal',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    
                echo("<p><label>ДАТА ЗАВЕРШЕНИЯ РАБОТЫ</label><input type='date' name='FRARCHDATE' value={$Front->FRARCHDATE}></p>");
                echo("<p><label>Итоговая стоимость работ</label><input type='text' name='FRTOTALWORKSUM' value={$Front->FRTOTALWORKSUM}>  руб.</p>");
                echo("<button type='submit' class='btn btn-success'>Завершить работу (услуга оказана)</button>");
                echo("</form>");   
                
                echo("<form method='get' autoload='off' autocomplete='off'>");
                (new MyForm('ATContP1FileFrontCtrl','WorkBrake',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    
                echo("<p><label>ДАТА РАСТОРЖЕНИЯ ДОГОВОРА</label><input type='date' name='FRARCHDATE' value={$Front->FRARCHDATE}></p>");
                echo("<p><label>Причина расторжения</label><input type='text' name='FRARCHCOMMENT' value='{$Front->FRARCHCOMMENT}' required size='60'></p>");
                echo("<button type='submit' class='btn btn-warning'>Расторгнуть договор (услуга не оказана)</button>");
                echo("</form>");   
                
                echo("<a target='_blank' href='index_admin.php?controller=ATContP1FilePrintCtrl&action=ContDopWorkBrake&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
                . "<button class='btn btn-info'>Допсоглашение о расторжении</button></a>");
                
                echo("<form method='get' autoload='off' autocomplete='off'>");
                (new MyForm('ATContP1FileFrontCtrl','ExpBrake',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                #$CurDate=(new PrintFunctions())->DateToStr(date("Y-m-d"));
                $CurDate=date("Y-m-d");
                echo("<input type='hidden' name='FRARCHDATE' value='{$CurDate}'>");
                echo("<p><label>Почему не проведена ЭПЭ</label><input type='text' name='FRARCHCOMMENT' value='{$Front->FRARCHCOMMENT}' required size='60' ></p>");
                echo("<button type='submit' class='btn btn-danger'>Отправить в архив (ЭПЭ не проведена)</button>");
                echo("</form>");
            ?>        
                
        </div>
    </div>
    
    <div>
        
    </div>
        
    <script src="./js/ContP1FileFront.js"></script>
</body>
</html>
