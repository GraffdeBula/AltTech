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
            <p>ДОСЬЕ КЛИЕНТА</p>
        </h3>           
    </div>
        
    <div>                   
        <?php                
            echo("<p>Код Клиента:   {$Client->CLCODE}      ");
        ?>        
                
        <?php                
            echo("ФИО Клиента:   <b>{$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}</b></p>");
            echo("<p>Филиал обслужвания: <b>");
            if(isset($ContP1List[0])){
                echo($ContP1List[0]->FROFFICE);
            }
            if(isset($ContP1List[0])){
                echo("</b>|       Персональный менеджер: <b>{$ContP1List[0]->FRPERSMANAGER}</b>");
            }
            echo("</p>");
                        
            echo("<a target='_blank' href='index_admin.php?controller=ATClientAnketaCtrl&ClCode={$Client->CLCODE}'><button id='btn1' class='btn btn-success'>АНКЕТА КЛИЕНТА</button></a><br>");
            
        ?>
    </div>    
    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#contlist1">Договоры БФЛ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#contlist4">Договоры разовые</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#comments">Комментарии</a>
        </li>
        
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active show" id="contlist1">
            <form method='get' class='newContForm'>
                <input type='hidden' name='controller' value='ATClientFileCtrl'><br>
                <input type='hidden' name='action' value='ContP1Create'><br>
                <input type='hidden' name='ClCode' value='<?php echo($Client->CLCODE);?>'><br>
                <label>ID сделки (amoCRM)</label><input type='number' required maxlength='12' class='MyID' name='AkLeadId'><br>
                <button type='submit' class='btn btn-warning newContBtn'>Добавить договор БФЛ</button><br>
            </form>
            <?php
                foreach($ContP1List as $Cont){

                    echo("<div> ID договора: ".$Cont->CONTCODE."</div><div> Дата анкеты: ".$Cont->AKDAT."</div><div> Дата договора: ".$Cont->FRCONTDATE."</div><div> Статус договора: ".$Cont->STATUS."</div>");
                    echo("<div>");
                    echo("<a href='index_admin.php?controller=ATContP1AnketaCtrl&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='btn btn-primary'>Анкета договора (кредиты)</button></a>");
                    echo("<a href='index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='btn btn-success'>ДОСЬЕ ДЛЯ МЕНЕДЖЕРА</button></a>");
                    echo("<a href='index_admin.php?controller=ATContP1FileExpertCtrl&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='btn btn-info'>ДОСЬЕ ДЛЯ ЭКСПЕРТИЗЫ</button></a>");
                    echo("<a href='index_admin.php?controller=ATContP1FileJurCtrl&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='btn btn-success'>ДОСЬЕ ДЛЯ ЮРИСТА</button></a>");
                    echo("<a href='index_admin.php?controller=ATClientFileCtrl&action=ContP1Copy&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='btn btn-warning'>Копировать</button></a>");
                    if ((new CheckRole)->Check($_SESSION['EmRole'],'ATClientFileCtrl','ContP1Del')){
                        echo("<a href='index_admin.php?controller=ATClientFileCtrl&action=ContP1Del&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='btn btn-danger'>УДАЛИТЬ</button></a>");
                    }
                    echo("</div>");
                }
            ?>
        </div><!--форма с договорами БФЛ-->
        <div class="tab-pane fade" id="contlist4">
            <form method='get' class='newContFormP4'>
                <input type='hidden' name='controller' value='ATClientFileCtrl'><br>
                <input type='hidden' name='action' value='ContP4Create'><br>
                <input type='hidden' name='ClCode' value='<?php echo($Client->CLCODE);?>'><br>
                <label>ID сделки (amoCRM)</label><input type='text' maxlength='10' class='MyIDP4' name='AkLeadId'><br>
                <button type='submit' class='btn btn-warning newContBtnP4'>Добавить разовый договор</button><br>        
            </form>
            <?php  
                foreach($ContP4List as $Cont){
                    echo("<div> ID договора: ".$Cont->CONTCODE."</div><div> Дата анкеты: ".$Cont->AKDAT."</div><div> Дата договора: ".$Cont->FRCONTDATE."</div><div> Статус договора: ".$Cont->STATUS."</div>");
                    echo("<div>");
                    echo("<a href='index_admin.php?controller=ATContP4FileFrontCtrl&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='btn btn-success'>ДОСЬЕ ДОГОВОРА</button></a>");                    
                    echo("<a href='index_admin.php?controller=ATClientFileCtrl&action=ContP4Del&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='btn btn-danger'>УДАЛИТЬ</button></a>");
                    echo("</div>");  
                }
            ?>
        </div><!--форма с разовыми договорами-->
        <div class="tab-pane fade" id="comments">
            <div>
                <form>
                    <?php (new MyForm('ATClientFileCtrl','AddComment',$_GET['ClCode'],0))->AddForm(); ?>
                    <label>Комментарий</label>
                    <textarea class="form-control" id="exampleTextarea" rows="3" style="width:500; height: 120px;" name='NewComment'></textarea>
                    <button class='btn btn-warning'>сохранить комментарий</button>
                </form>
            </div>            
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
                            (new MyForm('ATClientFileCtrl','UpdComment',$_GET['ClCode']))->AddForm();
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
                            (new MyForm('ATClientFileCtrl','DelComment',$_GET['ClCode'],0))->AddForm();
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
    </div>
    <script src="./js/ClFile.js"></script>
</body>
</html>
