<?php
    
?>
<!DOCTYPE html>
<html>
<head>
    <title>СПИСОК КРЕДИТОРОВ</title>
    
</head>
<body>
    <div class='g'>
	<div class='g-row'><br></div>
        <div class='g-row'><br></div>
        <div class='g-row'>
        <table>
	<caption>СПИСОК ДОКУМЕНТОВ ПО КРЕДИТАМ</caption>
	<thead>
            <tr>		
                <th>БАНК</th>
                <th>ДОГОВОР №</th>
                <th>ДОГОВОР ДАТА</th>
                <th>НАИМЕНОВАНИЕ ДОКУМЕНТА</th>
                <th>НОМЕР</th>
                <th>ДАТА</th>
                <th>СТРАНИЦ</th>
                <th>В иск</th>
                <th>Подтверждение</th>
            </tr>
	</thead>
	<tbody>
            <?php 
            function istrue($ind){
                if ($ind=='1'){
                    return TRUE;
                }else{return FALSE;}
            }
            foreach($args['Documents'] as $Document){
            echo('<tr>');
                echo("<form method='POST'>");
                echo("<input type='hidden' name='DOCUPD' value='DOCUPD'>");
                echo("<input type='hidden' name='ID' value='{$Document->ID}'>");
                echo("<th><input type='text' disabled name='BNNAME' value='{$Document->BNNAME}'></th>");
                echo("<th><input type='text' disabled name='CRCONTNUM' value='{$Document->CRCONTNUM}'></th>");
                echo("<th><input type='date' disabled name='CROPENDAT' value='{$Document->CROPENDAT}'></th>");
                echo("<th><input type='text' name='DOCNAME' value='{$Document->DOCNAME}'></th>");
                echo("<th><input type='text' name='DOCNUM' value='{$Document->DOCNUM}'></th>");
                echo("<th><input type='date' name='DOCDAT' value='{$Document->DOCDAT}'></th>");
                echo("<th><input type='text' name='DOCPAGES' value='{$Document->DOCPAGES}'></th>");
                echo("<th><input type='checkbox' name='DOCTOISK' value='".istrue($Document->DOCTOISK)."'></th>");
                echo("<th><button type='submit' class='f-bu f-bu-warning'>Сохранить</button></th>");
                echo("</form>");
             echo('</tr>');
            }
            ?>
	</tbody>

        </table>     
        </div>
    </div>
</body>
</html>