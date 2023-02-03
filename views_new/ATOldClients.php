<?php
/*
 * досье клиента
 *  */
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <div>        
        <h3>
            <p>Правка статуса договора</p>
        </h3>           
    </div>
    
    <form>
        <?php (new MyForm('ATOldClientsCtrl','SearchCont','',''))->AddForm2(); ?>
        <p>
            <label>Фамилия</label><input name='ClFName' autocomplete="off">
            <label>Имя</label><input name='Cl1Name' autocomplete="off">
            <label>Отчество</label><input name='Cl2Name' autocomplete="off">
        </p>
        <p><button class='btn btn-info'>Найти</button></p>
    </form>
    <?php
        if (isset($ClList)){
            echo("<table class='table table-hover'>");
            echo("<thead><tr>");
            echo("<th scope='col'>ClCode</th>");
            echo("<th scope='col'>ФИО</th>");                      
            echo("<th scope='col'>Статус</th>");                      
            echo("<th scope='col'>Долг</th>");                      
            echo("<th scope='col'>ЭПЭ</th>");
            echo("<th scope='col'>Возврат статуса</th>");
            echo("</tr></thead><tbody>");                    
          
            foreach($ClList as $Client){//таблица
                echo("<tr class='table-info'>");
                echo("<td>$Client->CLCODE</td>");
                echo("<td>$Client->CLNAME</td>");
                echo("<td>$Client->STATUS</td>");                
                echo("<form>");
                (new MyForm('ATOldClientsCtrl','SaveExp','',$Client->CONTCODE))->AddForm();
                echo("<td><input name='EXTOTDEBTSUM' value=$Client->EXTOTDEBTSUM></td>");
                echo("<td><button class='btn btn-warning'>ЭПЭ проведена</button></td>");                
                echo("</form>");
                echo("<form>");
                (new MyForm('ATOldClientsCtrl','ReturnStatus','',$Client->CONTCODE))->AddForm();
                echo("<td><button class='btn btn-warning'>Вернуть статус</button></td>");                
                echo("</form>");
                echo("</tr>");
            }                                
            echo("</tbody>");
            echo("</table>");
        }
    ?>
    
</body>
</html>
