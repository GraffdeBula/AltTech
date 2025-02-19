<?php 

?>
<!DOCTYPE html>
<html>
    <head>
                    
    </head>
    <body>
        <h3>СПРАВОЧНИК ПАКЕТ - ТИП ПЛАТЕЖА</h3>                      
                
        <table class="table table-hover">            
            <thead>
                    <tr>                      
                      <th scope="col">ID</th>
                      <th scope="col">Филиал</th>
                      <th scope="col">Пакет</th>
                      <th scope="col">Тариф</th>  
                      <th scope="col">Срок</th>
                      <th scope="col">Тип</th>
                      <th scope="col">Изменить</th>
                    </tr>
            </thead>
            <tbody>
            <?php
                foreach($PacList as $Row){
                    echo("<tr>");
                        echo("<form method='get' autocomplete='off'>");
                        (new MyForm('ATDRCtrl','UpdPacBr',0,0))->AddForm();
                        echo("<td><input type='text' name='PacId' size='3' value='{$Row->ID}'></td>");
                        echo("<td>{$Row->PACBRNAME}</td>");
                        echo("<td>{$Row->PACNAME}</td>");
                        echo("<td>{$Row->PCTEMPLATEROOT}</td>");
                        echo("<td>{$Row->PCPERIOD}</td>");
                        echo("<td><input type='text' name='PacContType' size='5' value='{$Row->PACCONTTYPE}'></td>");                        
                        echo("<td><button class='btn btn-success'>Изменить</button></td>");
                        echo("</form>");                        
                    echo("</tr>");
                }
            ?>
            </tbody>
        </table>
                                                       
    </body>
</html>
