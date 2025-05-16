<?php
    var_dump($Agent);
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>           

    <div class='row'>
       <h1>Программа активных рекомендаций</h1>
    </div>       
    <div>
        <h2>Данные лица (агента) передавшего контакты</h2>
        <div>
            <form method='get' autocomplete='off'>
                <?php
                    (new MyForm('RefProgContactsCtrl','SaveAgent'))->AddForm2();
                ?>
                <label>ФИО агента</label><input type='text' name='AgName' value=''>
                <label>телефон</label><input class='tel' type='text' name='AgPhone' value=''>
                <label>тип</label><select name='Status'>
                    <option value=''></option>
                    <option value='3'>открытый</option>
                    <option value='4'>аноним</option>
                </select>
                <label>способ вознаграждения</label><select name='PayType'>
                    <option value=''></option>
                    <option value='скидка'>скидка</option>
                    <option value='оплата'>оплата</option>
                </select>

                <button class='btn btn-warning'>СОХРАНИТЬ</button>
                <?=$_SESSION['EmName']?>
            </form>
        </div>
    </div>
        
    <div>    
        <table class="table table-hover">
            <thead>
                <tr>                      
                  <th scope="col">ФИО</th>
                  <th scope="col">Телефон</th>
                  <th scope="col">ПромоКод</th>
                  <th scope="col">Реферальная ссылка</th>
                  <th scope="col">Статус</th>
                  <th scope="col">Вознаграждение</th>
                  <th scope="col">Кто внёс</th>
                  <th scope="col">Изменить</th>
                  <th scope="col">Удалить</th>
                  <th scope="col">Причина удаления</th>
                </tr>
            </thead>
            <tbody>

                <?php               
                    foreach($Refers as $Refer){//таблица
                        switch ($Refer->STATUS){                                        
                            case 3:
                                $Status='АктивОткрытый';
                                break;
                            case 4:
                                $Status='АктивАноним';
                                break;
                        }

                        echo("<tr class='table-info'>");
                        echo("<form method='get'>");
                        (new MyForm('RefProgContactsCtrl','UpdAgent',0,0))->AddForm2();
                        echo("<input type='hidden' name='Id' value='$Refer->ID'>");
                        echo("<td><input type='text' name='Name' value='$Refer->NAME'></td>");
                        echo("<td><input type='text' name='Phone' value='$Refer->PHONE' maxlength='12'></td>");
                        echo("<td><input type='text' name='Code' value='$Refer->CODE'></td>");
                        echo("<td><input type='text' name='Refer' value='$Refer->REFER'></td>");
                        echo("<td>$Status</td>");
                        echo("<td>$Refer->PAYTYPE</td>");
                        echo("<td>$Refer->LGEMP</td>");
                        if (($_SESSION['EmRole']=='admin') or ($_SESSION['EmName']=='Алёна Пышняк')){
                            echo("<td><button type='submit' class='btn btn-success'>Изменить</button></td>");
                        }
                        echo("</form>");                        
                        if (($_SESSION['EmRole']=='admin') or (in_array($_SESSION['EmName'],['Алёна Пышняк']))){
                            echo("<form method='get' class='delAgForm'>");
                            (new MyForm('RefProgContactsCtrl','DelAgent',0,0))->AddForm2();
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

    <div>

        <h2>Список контактов</h2>
        <table>
            <thead>
                <tr>        
                    <th></th>
                    <th scope='col'>Контакт</th>
                    <th scope='col'>Телефон</th>                    
                    <th scope='col'>Добавить</th>                                                           
                </tr>
            </thead>
            <tbody>
                <tr class='table-secondary'>
                    <form method='get' autocomplete='off'>
                        <td>
                            <?php
                                (new MyForm('RefProgContactsCtrl','SaveContact'))->AddForm2();
                            ?>
                            <input type='hidden' name='AgCode' value='<?=$Agent->CODE?>'>
                            <input type='hidden' name='AgStatus' value='<?=$Agent->STATUS?>'>
                            <input type='hidden' name='AgPhone' value='<?=$Agent->PHONE?>'>
                        </td>
                        <td>                            
                            <input type='text' name='ContName'>
                        </td>
                        <td>
                            <input type='text' class='tel' name='ContPhone'>
                        </td>
                        <td>
                            <button class='btn btn-warning'>Добавить</button>
                        </td>                          
                    </form>
                </tr>
                <?php
                foreach($Contacts as $Contact){
                    echo("<tr>
                        <td></td>
                        <td>$Contact->NAME</td>
                        <td>$Contact->PHONE</td>                            
                    </tr>");
                }
                ?>
            </tbody>
        </table>
    </div>
               
    <script src="./js/RefProgContacts.js"></script>    
</body>
</html>
