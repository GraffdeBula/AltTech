<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h3>СПРАВОЧНИК БАНКОВ</h3>
        <div>
            <form method="get" autocomplete='off'>
                <?php
                (new MyForm('ATDRCtrl','BanksAdd','',''))->AddForm2();            
                ?>
                <p>
                    <label>Вид кредитора</label><select name='BNTYPE'>
                        <option></option>
                        <option value='Банк'>Банк</option>
                        <option value='МФО'>МФО</option>
                        <option value='Коллектор'>Коллектор</option>
                    </select>
                    <label>Наименование</label><input type='text' name='BNNAME'>
                    <label>ИНН</label><input type='text' name='BNINN' maxlength='10'>
                </p>
                <p>
                    <label>Полное наименование</label><input type='text' name='BNFULLNAME'>
                    <label>Адрес регистрации</label><input type='text' name='BNADRREG'>
                    <label>Доп адрес</label><input type='text' name='BNADRDOP'>
                </p>
                <p>
                    <label>ОГРН</label><input type='text' name='BNOGRN'>
                    <label>e-mail</label><input type='text' name='BNEMAIL'>
                    <label>Комментарий</label><input type='text' name='BNCOMMENT'>
                </p>
                <button type='submit' class='btn btn-outline-warning'>Сохранить</button>
            </form>
        </div>
        <div>
            <h4>Список банков/мфо/коллекторов</h4>
            <table class="table table-hover">
                <thead>
                    <tr>                      
                      <th scope="col">ИНН</th>
                      <th scope="col">Название</th>
                      <th scope="col">Вид</th>
                      <th scope="col">Полное наименование</th>
                      <th scope="col">Адрес рег.</th>
                      <th scope="col">Доп адрес</th>
                      <th scope="col">ОГРН</th>
                      <th scope="col">E-mail</th>
                      <th scope="col">Комментарий</th>
                      <th scope="col">---</th>
                      <th scope="col">---</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $check=true;
                foreach($BankList as $Bank){
                    if ($check){
                        echo("<tr class='table-primary'>");
                        $check=false;
                    } else {
                        echo("<tr class='table-light'>");
                        $check=true;
                    }                    
                    echo("<td>$Bank->BNINN</td>");
                    echo("<td>$Bank->BNNAME</td>");
                    echo("<td>$Bank->BNTYPE</td>");
                    echo("<td>$Bank->BNFULLNAME</td>");
                    echo("<td>$Bank->BNADRREG</td>");
                    echo("<td>$Bank->BNADRDOP</td>");
                    echo("<td>$Bank->BNOGRN</td>");
                    echo("<td>$Bank->BNEMAIL</td>");
                    echo("<td>$Bank->BNCOMMENT</td>");
                    echo("<td><button class='btn'>сохранить</button></td>");
                    echo("<td><form method='get'>");
                        (new MyForm('ATDRCtrl','BanksDel','',''))->AddForm2();
                        echo("<input type='hidden' name='BnID' value='{$Bank->ID}'>");
                        echo("<button class='btn btn-danger'>удалить</button></form></td>");
                    echo("</tr>");
                }
                ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
