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
            <p>ДОГОВОР РАЗОВОЙ УСЛУГИ - ДОСЬЕ ДОГОВОРА</p>
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
        echo("тут будут кнопки");
        
        echo("</div>");
    ?>

    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#Main">Основная инф</a>
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
                    <p><label>ДАТА КОНСУЛЬТАЦИИ</label><input type='date' name='FRCONSDATE' value={$Front->FRCONSDATE}></p>                    
                    <button type='submit' class='btn btn-warning'>Проведена консультация</button>
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
