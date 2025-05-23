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
        
    <div class="accordion" id="accordionAgentList">
        <?php   
            $i=0;
            foreach($Agents as $Key=>$Agent){
                $i++;
                if ($i==1){
                    echo("
                        <div class='accordion-item'>
                          <h2 class='accordion-header' id='heading".$i."'>
                            <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse".$i."' aria-expanded='false' aria-controls='collapse".$i."'>
                              Новый Агент__<strong>$Agent->NAME</strong>__телефон__<strong>$Agent->PHONE</strong>__с кодом__<strong>$Agent->CODE</strong>
                            </button>
                          </h2>
                          <div id='collapse".$i."' class='accordion-collapse collapse' aria-labelledby='heading".$i."' data-bs-parent='#accordionAgentList' style=''>
                            <div class='accordion-body'>
                              <h3>Контакты агента ".$i."</h3>
                            </div>
                          </div>
                        </div>
                    ");
                }else{
                echo("                
                    <div class='accordion-item'>
                      <h2 class='accordion-header' id='heading".$i."'>
                        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse".$i."' aria-expanded='false' aria-controls='collapse".$i."'>
                          Агент__<strong>$Agent->NAME</strong>__телефон__<strong>$Agent->PHONE</strong>__с кодом__<strong>$Agent->CODE</strong>
                        </button>
                      </h2>
                      <div id='collapse".$i."' class='accordion-collapse collapse' aria-labelledby='heading".$i."' data-bs-parent='#accordionAgentList'>
                        <div class='accordion-body'>
                          <h6>Контакты агента ".$i."</h6>
                              
                        </div>
                      </div>
                    </div>
                ");
                }            
            }
        
        ?>
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
