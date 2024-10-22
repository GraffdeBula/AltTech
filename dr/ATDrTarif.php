<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h3>СПРАВОЧНИК ТАРИФОВ</h3>                      
        
        <div>
            <form method='get' autocomplete='off'>
                <?php (new MyForm('ATDRCtrl','AddTarif',0,0))->AddForm(); ?>                                
                <label>Статус</label><input type="text" size='3' name="TRSTATUS" value="0">
                <label>Дата</label><input type="date" size='20' name="TRDATE">
                <label>Тариф</label><input type="text" size='20' name="TRNAME">
                <label>Коммент</label><input type="text" size='10' name="TRCOMMENT">
                <label>Пакет</label><input type="text" size='4' name="TRPAC">
                <label>Сумма от</label><input type="text" size='15' name="TRSUMMIN" value="0">
                <label>Сумма до</label><input type="text" size='15' name="TRSUMMAX" value="0">
                <label>Оплата</label><input type="text" size='8' name="TRTYPE">
                <label>Сумма договора</label><input type="text" size='15' name="TRSUMFIX" value="0">
                <label>Сумма платежа</label><input type="text" size='15' name="TRSUMANN" value="0">
                <label>Процент от долга</label><input type="text" size='15' name="TRSUMPERC" value="0">
                <button class='btn btn-warning'>Добавить</button>
            </form>
            
        </div>
        
        <table class="table table-hover">            
            <thead>
                    <tr>                      
                      <th scope="col">ID</th>
                      <th scope="col">Статус</th>
                      <th scope="col">Дата</th>
                      <th scope="col">Тариф</th>
                      <th scope="col">Коммент</th>
                      <th scope="col">Пакет</th>
                      <th scope="col">Сумма от</th>
                      <th scope="col">Сумма до</th>
                      <th scope="col">Оплата</th>
                      <th scope="col">Сумма договора</th>
                      <th scope="col">Сумма платежа</th>
                      <th scope="col">Процент от долга</th>
                      <th scope="col">Изменить</th>
                      <th scope="col">Удалить</th>
                    </tr>
            </thead>
            <tbody>
            <?php
                foreach($TarifList as $Row){
                    echo("<tr>");
                        echo("<form>");
                        (new MyForm('ATDRCtrl','UpdTarif',0,0))->AddForm();
                        echo("<td><input type='text' name='ID' size='3' value='{$Row->ID}'></td>");
                        echo("<td><input type='text' name='TRSTATUS' size='3' value='{$Row->TRSTATUS}'></td>");
                        echo("<td><input type='date' name='TRDATE' value='{$Row->TRDATE}'></td>");
                        echo("<td><input type='text' name='TRNAME' value='{$Row->TRNAME}'></td>");
                        echo("<td><input type='text' name='TRCOMMENT' size='10' value='{$Row->TRCOMMENT}'></td>");
                        echo("<td><input type='text' name='TRPAC' size='4' value='{$Row->TRPAC}'></td>");
                        echo("<td><input type='text' name='TRSUMMIN' size='15' value='{$Row->TRSUMMIN}'></td>");
                        echo("<td><input type='text' name='TRSUMMAX' size='15' value='{$Row->TRSUMMAX}'></td>");
                        echo("<td><input type='text' name='TRTYPE' size='8' value='{$Row->TRTYPE}'></td>");
                        echo("<td><input type='text' name='TRSUMFIX' size='15' value='{$Row->TRSUMFIX}'></td>");
                        echo("<td><input type='text' name='TRSUMANN' size='15' value='{$Row->TRSUMANN}'></td>");
                        echo("<td><input type='text' name='TRSUMPERC' size='15' value='{$Row->TRSUMPERC}'></td>");
                        echo("<td><button class='btn btn-success'>Изменить</button></td>");
                        echo("</form>");
                        echo("<td><a href='index_admin.php?controller=ATDRCtrl&action=DelTarif&Id={$Row->ID}'>
                            <button class='btn btn-danger'>Удалить</button></a></td>");
                    echo("</tr>");
                }
            ?>
            </tbody>
        </table>
               
                                                       
    </body>
</html>