<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h3>СПРАВОЧНИК ПАКЕТОВ</h3>                      
        
        <div>
            <form method='get' autocomplete='off'>
                <?php (new MyForm('ATDRCtrl','AddPac',0,0))->AddForm(); ?>                                
                <label>Программа</label><input type="text" size='25' name="PCPROG">
                <label>Пакет</label><input type="text" size='5' name="PCPAC">
                <label>Активность</label><input type="text" size='5' name="PCACT" value="0">
                <label>Шаблон</label><input type="text" size='30' name="PCTEMPLATEROOT">
                <label>Закладки</label><input type="text" size='30' name="PCBOOKMARKSLIST">
                <label>Срок</label><input type="text" size='5' name="PCPERIOD">
                <button class='btn btn-warning'>Добавить</button>
            </form>
            
        </div>
        
        <table class="table table-hover">            
            <thead>
                    <tr>                      
                      <th scope="col">ID</th>
                      <th scope="col">Программа</th>
                      <th scope="col">Пакет</th>
                      <th scope="col">Активность</th>
                      <th scope="col">Шаблон</th>
                      <th scope="col">Тип в закладках</th>
                      <th scope="col">Срок</th>
                      <th scope="col">Изменить</th>
                      <th scope="col">Удалить</th>
                    </tr>
            </thead>
            <tbody>
            <?php
                foreach($PacList as $Row){
                    echo("<tr>");
                        echo("<form method='get' autocomplete='off'>");
                        (new MyForm('ATDRCtrl','UpdPac',0,0))->AddForm();
                        echo("<td><input type='text' name='ID' size='3' value='{$Row->ID}'></td>");
                        echo("<td><input type='text' name='PCPROG' size='20' value='{$Row->PCPROG}'></td>");
                        echo("<td><input type='text' name='PCPAC' size='5' value='{$Row->PCPAC}'></td>");
                        echo("<td><input type='text' name='PCACT' size='5' value='{$Row->PCACT}'></td>");
                        echo("<td><input type='text' name='PCTEMPLATEROOT' size='30' value='{$Row->PCTEMPLATEROOT}'></td>");
                        echo("<td><input type='text' name='PCBOOKMARKSLIST' size='30' value='{$Row->PCBOOKMARKSLIST}'></td>");
                        echo("<td><input type='text' name='PCPERIOD' size='5' value='{$Row->PCPERIOD}'></td>");
                        echo("<td><button class='btn btn-success'>Изменить</button></td>");
                        echo("</form>");
                        echo("<td><a href='index_admin.php?controller=ATDRCtrl&action=DelPac&Id={$Row->ID}'>
                            <button class='btn btn-danger'>Удалить</button></a></td>");
                    echo("</tr>");
                }
            ?>
            </tbody>
        </table>
                                                       
    </body>
</html>
