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
            <p>ДОГОВОР БФЛ - ДОСЬЕ ДОГОВОРА</p>
        </h3>   
    </div>
    <?php
        echo("<div>");
        echo("<p>ФИО КЛИЕНТА:   {$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}<p>");
        echo("<p>Филиал обслуживания:   {$Front->FROFFICE}<p>");
        echo("<p>Персональный менеджер:   {$Front->FRPERSMANAGER}<p>");
        echo("<p>Код клиента:   {$Client->CLCODE}<p>");
        echo("<p>Код договора:   {$Anketa->CONTCODE}<p>");
        echo("<p>Статус договора:   {$Cont->STATUS}<p>");
        echo("</div>");
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
        . "<button class='btn btn-info'>АКТ УСЛУГ</button></a>");
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileFrontPrintCtrl&action=DovTemplate&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-info'>ШАБЛОН ДОВЕРЕННОСТИ</button></a>");
        
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
                    echo("                
                    <p><label>ДАТА ДОГОВОРА ЭПЭ</label><input type='date' name='FREXPDATE' value={$Front->FREXPDATE}></p>
                    <p><label>СТОИМОСТЬ ЭПЭ</label><input type='text' name='FREXPSUM' value={$Front->FREXPSUM}></p>
                    <button type='submit' class='btn btn-warning'>Заключён договор ЭПЭ</button>
                </form>");    
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP1FileFrontCtrl','ExpAct',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    echo("                
                        <p><label>ДАТА ПОДПИСАНИЯ АКТА ЭПЭ</label><input type='date' name='FREXPACTDATE' value={$Front->FREXPACTDATE}></p>
                        <button type='submit' class='btn btn-warning'>Подписан акт ЭПЭ</button>
                </form>");     
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP1FileFrontCtrl','ContSigned',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    echo("<p><label>ДАТА ДОГОВОРА УСЛУГ</label><input type='date' name='FRCONTDATE' value={$Front->FRCONTDATE}></p>
                    <button type='submit' class='btn btn-warning'>Заключён договор услуг</button>
                </form>");     
                echo("<form method='get' autoload='off'>");
                    (new MyForm('ATContP1FileFrontCtrl','DovGet',$Client->CLCODE,$Anketa->CONTCODE))->AddForm();
                    
                    echo("<p><label>ДАТА ДОВЕРЕННОСТИ</label><input type='date' name='FRDOVDATE' value={$Front->FRDOVDATE}></p>
                    <button type='submit' class='btn btn-warning'>Получена доверенность</button>
                </form>");                
            ?>
            

        </div>
        <div class="tab-pane fade" id="Tarif">
            <h5>Выбор тарифа</h5>
            <label>Скидка по старому договору</label><br>
            <label>Скидка по полномочиям</label><br>
            <label>Выбранная программа</label><br>
            <label>Выбранный тариф</label><br>
        </div>
        <div class="tab-pane fade" id="ExpRes">
            <h5>Результаты ЭПЭ</h5>
            <?php
            echo("<p><label>Рекомендуемый продукт</label><input disabled type='text' name='EXPRODREC' value={$Expert->EXPRODREC}></p>");
            echo("<p><label>Сумма долга</label><input type='text' disabled name='EXTOTDEBTSUM' value={$Expert->EXTOTDEBTSUM}></p>");
            echo("<p><label>Сумма основного долга</label><input disabled type='text' name='FREXPACTDAEXMAINDEBTSUMTE' value={$Expert->EXMAINDEBTSUM}></p>");
            echo("<p><label>Число кредитов</label><input disabled type='text' name='FREXPACTDAEXMAINDEBTSUMTE' value={$Expert->EXMAINDEBTSUM}></p>");            
            ?>
            
        </div>
        <div class="tab-pane fade" id="Pays">
            <p>ВНЕСЁННЫЕ ПЛАТЕЖИ</p>
        </div>
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
