<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h3>СПРАВОЧНИК ТАРИФОВ 2</h3>                      
        
        <div>
            <form method='get' autocomplete='off'>
                <?php (new MyForm('ATDRCtrl','AddTarifEl',0,0))->AddForm(); ?>                                
                <label>Вид</label><input type="text" size='20' name="ELTYPE">
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
                        echo("<td><input type='text' name='ID' size='3' value='{$Row->ID}'></td>");
                        echo("<td><input type='text' name='ELTYPE' size='3' value='{$Row->ELTYPE}'></td>");
                        echo("<td><input type='date' name='ELNAME' value='{$Row->ELNAME}'></td>");
                        echo("<td><input type='text' name='ELSUM' value='{$Row->ELSUM}'></td>");                        
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