<?php
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>           
    <div>
        <div class='row'>
            <div class='col-lg-4'>
                <form method='get' autocomplete="off">
                    <?php (new MyForm('ATRefProgCtrl','Index',0,0))->AddForm2();?>
                    <label>Внесены за период c </label><input type='date' name='DateF'>
                    <label> до </label><input type='date' name='DateL'>
                    <button type='submit' class='btn btn-primary'>Выбрать за период</button>                
                </form>
            </div>
            <div class='col-lg-1'>
                <form>
                    <?php (new MyForm('ATRefProgCtrl','Index',0,0))->AddForm2();?>
                    <button type='submit' class='btn btn-info'>Сбросить период</button>                
                </form>
            </div>
        </div>
        <a target="_blank" href='downloads/RefRefers.xlsx'><button class='btn btn-success'>Выгрузить в Excel</button></a>
        <a target="_blank" href='downloads/RefFullRefers.xlsx'><button class='btn btn-success'>Полный список Выгрузить в Excel</button></a>
        <div class='row'>
            <div class='col-lg-4'>
                <form method='get'autocomplete="off">
                    <?php (new MyForm('ATRefProgCtrl','SaveAgent',0,0))->AddForm2();?>
                    <label>ФИО</label><input name='AgName'>
                    <label>Телефон</label><input name='AgPhone' maxlength="12">                
                    <button type='submit' class='btn btn-warning'>Добавить</button>
                </form>
            </div>
            <div class='col-lg-5'>
                <form method='get'autocomplete="off">
                    <?php (new MyForm('ATRefProgCtrl','SearchAgent',0,0))->AddForm2();?>
                    <label>ФИО</label><input name='AgName'>
                    <label>Код агента</label><input name='AgCode'>
                    <label>Телефон</label><input name='AgPhone' maxlength="12">                
                    <button type='submit' class='btn btn-info'>Найти</button>
                </form>
            </div>
        <table class="table table-hover">
            <thead>
                <tr>                      
                  <th scope="col">ФИО</th>
                  <th scope="col">Телефон</th>
                  <th scope="col">ПромоКод</th>
                  <th scope="col">Реферальная ссылка</th>
                  <th scope="col">Кто внёс</th>
                  <th scope="col">Изменить</th>
                  <th scope="col">Удалить</th>
                  <th scope="col">Причина удаления</th>
                </tr>
            </thead>
            <tbody>

                <?php               
                    foreach($Refers as $Refer){//таблица
                        echo("<tr class='table-info'>");
                        echo("<form method='get'>");
                        (new MyForm('ATRefProgCtrl','UpdAgent',0,0))->AddForm2();
                        echo("<input type='hidden' name='Id' value='$Refer->ID'>");
                        echo("<td><input type='text' name='Name' value='$Refer->NAME'></td>");
                        echo("<td><input type='text' name='Phone' value='$Refer->PHONE' maxlength='12'></td>");
                        echo("<td><input type='text' name='Code' value='$Refer->CODE'></td>");
                        echo("<td><input type='text' name='Refer' value='$Refer->REFER'></td>");
                        echo("<td>$Refer->LGEMP</td>");
                        if (($_SESSION['EmRole']=='admin') or ($_SESSION['EmName']=='Алёна Пышняк')){
                            echo("<td><button type='submit' class='btn btn-success'>Изменить</button></td>");
                        }
                        echo("</form>");                        
                        if (($_SESSION['EmRole']=='admin') or (in_array($_SESSION['EmName'],['Алёна Пышняк','Алина Смородина']))){
                            echo("<form method='get' class='delAgForm'>");
                            (new MyForm('ATRefProgCtrl','DelAgent',0,0))->AddForm2();
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
    </div>
        
</body>
</html>
