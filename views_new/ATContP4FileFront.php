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
            <form method='get'>
            <?php
                (new MyForm('ATContP4FileFrontCtrl','ChangeBranch',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                echo("Филиал обслуживания:   <select name='FROFFICE'>");
                echo("<option value='{$Front->FROFFICE}'>{$Front->FROFFICE}</option>");
                /* ГОВНОКОДИЩЕ!!!
                 */
                $BranchList=(new Branch(''))->getBranchList();
                foreach($BranchList as $Branch){
                    echo("<option value='{$Branch->BRNAME}'>{$Branch->BRNAME}</option>");
                }                
                echo("</select>");
                if (in_array($_SESSION['EmName'],['Трубенева Галина','Никита Прокопьев','Андрей Булавский','Лунева Тамара'])){
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
        echo("<a target='_blank' href='index_admin.php?controller=ATContP4FilePrintCtrl&action=MainCont&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-info'>Договор РУ</button></a>");
        echo("<a target='_blank' href='index_admin.php?controller=ATContP4FilePrintCtrl&action=DovComp&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-info'>Доверенность</button></a>");
        echo("<a target='_blank' href='index_admin.php?controller=ATContP4FilePrintCtrl&action=DovCompJur&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-info'>Передоверие</button></a>");
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
            <div class='row'>
            <div class="col-3">                                                               
            <?php
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP4FileFrontCtrl','Cons',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
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
                    (new MyForm('ATContP4FileFrontCtrl','ContSigned',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    if ($Front->FROFFICE==''){
                        echo("<input type='hidden' name=FROFFICE value='{$_SESSION['EmBranch']}'>");
                    } else {
                        echo("<input type='hidden' name=FROFFICE value='{$Front->FROFFICE}'>");                    
                    }
                    echo("<p><label>ДАТА ДОГОВОРА УСЛУГ</label><input type='date' name='FRCONTDATE' value={$Front->FRCONTDATE}></p>
                    <p><label>СУММА ПО ДОГОВОРУ</label><input type='text' name='FRCONTSUM' value='{$Front->FRCONTSUM}' autocomplete='off'></p>    
                    <button type='submit' class='btn btn-warning'>Заключён договор услуг</button>
                </form>");     
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP4FileFrontCtrl','DovGet',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    if ($Front->FROFFICE==''){
                        echo("<input type='hidden' name=FROFFICE value='{$_SESSION['EmBranch']}'>");
                    } else {
                        echo("<input type='hidden' name=FROFFICE value='{$Front->FROFFICE}'>");                    
                    }
                    echo("<p><label>ДАТА ДОВЕРЕННОСТИ</label><input type='date' name='FRDOVDATE' value={$Front->FRDOVDATE}></p>
                    <button type='submit' class='btn btn-warning'>Получена доверенность</button>
                </form>");         
                    
                echo("<form method='get' autocomplete='off'>");
                    (new MyForm('ATContP4FileFrontCtrl','JurSave',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                    echo("<p><lable>Ответственный юрист</lable><select name='FRJURIST'>");
                    echo("<option value='{$Front->FRJURIST}'>{$Front->FRJURIST}</option>");
                    foreach($EmpList as $Emp){
                        echo("<option value='{$Emp->EMNAME}'>{$Emp->EMNAME}</option>");
                    }   
                    echo("</select></p>");
                    echo("<p><button class='btn btn-warning'>Сохранить</button></p>");
                echo("</form>");
                
                
                    
            ?>
            </div>
            <div class="col-4">
                <h4>Описание услуги</h4>
                <form method='get' autocomplete='off'>
                    <?php (new MyForm('ATContP4FileFrontCtrl','ServiceSave',$Client->CLCODE,$Anketa->CONTCODE))->AddForm(); ?>
                    <p><label for="exampleTextarea1" class="form-label mt-4">Услуга</label>
                        <textarea class="form-control" id="exampleTextarea1" rows="3" style="height: 60px;" name='FrContService'><?=$Front->FRCONTSERVICE?></textarea></p>
                    <p><label>Сфера права</label><input type='text' name='FrJurBranch' value='<?=$Front->FRJURBRANCH?>'></p>
                    <p><label>Канал привлечения</label><input type='text' name='FrAttrChannel' value='<?=$Front->FRATTRCHANNEL?>'></p>
                    <p><label>Исполнитель</label><input type='text' name='FrJurist' value='<?=$Front->FRJURIST?>'></p>
                    <p><label for="exampleTextarea2" class="form-label mt-4">Комментарий</label>
                        <textarea class="form-control" id="exampleTextarea2" rows="3" style="height: 60px;" name='FrContResult'><?=$Front->FRCONTRESULT?></textarea></p>
                    <p><label>Дата завершения работы</label><input type='date' name='FrFinWorkDate' value='<?=$Front->FRFINWORKDATE?>'></p>
                    <button class='btn btn-info'>Сохранить информацию об услуге</button>
                </form>
            </div>
            </div>

        </div>
                
        <div class="tab-pane fade" id="Pays">
            <form method='get'>
                <button class='btn btn-primary'>Принять платёж</button>
                <?php (new MyForm('ATContP4FileFrontCtrl','AddPayment',$_GET['ClCode'],$_GET['ContCode']))->AddForm(); ?>
                <input type='hidden' name='FRPERSMANAGER' value='<?=$Front->FRPERSMANAGER?>'>
                <input type='hidden' name='FROFFICE' value='<?=$Front->FROFFICE?>'>
                <div class='col-10'>
                    <label>Сумма</label><input type='text' value='0' name='PAYSUM'>
                    <label>Дата</label><input type='date' name='PAYDATE' value=''>
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
                        if ($_SESSION['EmRole']=='admin'){
                            echo("<td><a href=index_admin.php?controller=ATContP4FileFrontCtrl&action=FormPayBill&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}><button>FORM</button></a></td>");
                        }
                        if ((new CheckRole)->Check($_SESSION['EmRole'],'ATContP4FileFrontCtrl','DelPayment')){
                            echo("<td><a href=index_admin.php?controller=ATContP4FileFrontCtrl&action=DelPayment&ClCode={$_GET['ClCode']}&ContCode={$_GET['ContCode']}&PayId={$Pay->ID}><button class='btn btn-danger'>УДАЛИТЬ_{$Pay->ID}</button></a></td>");
                        }
                        echo('</tr>');
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div><!--Внесение платежей-->
        <div class="tab-pane fade" id="Comments">
            <form method='get'>
                <?php (new MyForm('ATContP4FileFrontCtrl','AddComment',$_GET['ClCode'],$_GET['ContCode']))->AddForm() ?>
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
            
            <input type='date' value=<?=$Front->FRARCHDATE?> >Договор в архиве
            
            <a href="index_admin.php?controller=ATContP4FileFrontCtrl&action=WorkFinal&ClCode=<?=$_GET['ClCode']?>&ContCode=<?=$_GET['ContCode']?>"><button class='btn btn-danger'>Завершить работу</button></a>
            
        </div>
    </div>
    
    <div>
        
    </div>
        
</body>
</html>
