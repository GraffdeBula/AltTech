<?php
    if ($Agent->STATUS==3){
        $Status='открытый';
    }elseif($Agent->STATUS==4){
        $Status='аноним';
    }else{
        $Status='';        
    }
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>           
    <div>
        <div class='row'>
           <h1>Форма ввода контактов для обзвона</h1>
        </div>       
        
        <div class='row'>
            <h2>Данные лица (агента) передавшего контакты</h2>
            <div>
                <form method='get' autocomplete='off'>
                    <?php
                        (new MyForm('RefProgContactsCtrl','SaveAgent'))->AddForm2();
                    ?>
                    <label>ФИО агента</label><input type='text' name='AgName' value='<?=$Agent->NAME?>'>
                    <label>телефон</label><input type='text' name='AgPhone' value='<?=$Agent->PHONE?>'>
                    <label>тип</label><select name='Status'>
                        <option value='<?=$Agent->STATUS?>'><?=$Status?></option>
                        <option value='3'>открытый</option>
                        <option value='4'>аноним</option>
                    </select>
                    <label>Промо код</label><input type='text' name='AgCode' value='<?=$Agent->CODE?>'>
                    <button class='btn btn-warning'>СОХРАНИТЬ</button>
                </form>
            </div>
        </div>
        <h2>Список контактов</h2>
        <table>
            <thead>
                <tr>                                               
                    <th scope='col'>ID</th>
                    <th scope='col'>ИМЯ</th>
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
                            <input type='hidden' name='AgPhone' value='<?=$Agent->PHONE?>'>
                        </td>
                        <td>
                            
                            <input type='text' name='ContName'>
                        </td>
                        <td>
                            <input type='text' name='ContPhone'>
                        </td>
                        <td>
                            <button class='btn btn-warning'>Добавить</button>
                        </td>                        
                    </form>
                </tr>
                <?php
                    foreach($Contacts as $Contact){
                        echo("<tr>
                            <td>$Contact->ID<td>
                            <td>$Contact->NAME<td>
                            <td>$Contact->PHONE<td>
                                <td></td>
                        </tr>");
                    }
                ?>
            </tbody>
        </table>
        
           
    </div>
    
    <script src="./js/RefProgContacts.js"></script>    
</body>
</html>
