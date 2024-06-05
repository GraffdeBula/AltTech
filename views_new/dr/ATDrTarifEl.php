<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h3>СПРАВОЧНИК ТАРИФОВ 2</h3>                      
        
        <div>
            <form method='get' autocomplete='off'>
                <?php (new MyForm('ATDRCtrl','AddTarifEl',0,0))->AddForm(); ?>                                
                <label>Вид</label><select name="ELTYPE">
                    <option></option>
                    <option>Доплата</option>
                    <option>Вычет</option>
                    <option>Скидка</option>
                    <option>Базовый тариф рассрочка</option>
                    <option>Базовый тариф</option>
                </select>
                <label>Название</label><input type="text" size='20' name="ELNAME">
                <label>Сумма</label><input type="text" size='20' name="ELSUM" value="0">
                <button class='btn btn-warning'>Добавить</button>
            </form>
            
        </div>
        
        <table class="table table-hover">            
            <thead>
                    <tr>                      
                      <th scope="col">ID</th>
                      <th scope="col">Тип</th>
                      <th scope="col">Название</th>
                      <th scope="col">Сумма</th>                      
                    </tr>
            </thead>
            <tbody>
            <?php
                foreach($TarifList as $Row){
                    echo("<tr>");
                        echo("<form>");                        
                        echo("<td><input type='text' name='ID' size='5' value='{$Row->ID}'></td>");
                        echo("<td><input type='text' name='ELTYPE' value='{$Row->TRELTYPE}'></td>");
                        echo("<td><input type='text' name='ELNAME' value='{$Row->TRELNAME}'></td>");
                        echo("<td><input type='text' name='ELSUM' value='{$Row->TRELSUM}'></td>");                        
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