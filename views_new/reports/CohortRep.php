<?php

?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>       
    </head>
    <body>
        <div>
            <h5>Когортный анализ договоров</h5>    
            <a href='downloads/ПланПоНовым.xlsx'><button class='btn btn-success'></button></a>
            <form>     
                <?php
                    (new MyForm('ReportsCohortCtrl','CohortRep'))->AddForm2()
                ?>
                <label>Показать договоры от </label><input type='date' name='DateF'>
                <label> до </label><input type='date' name='DateL'> 
                <button class='btn btn-info'>Сформировать отчёт</button>
            </form>
                        
            <table class='table table-hover'>
                <thead>
                    <tr>                       
                        <th scope='col'>Филиал</th>
                        <th scope='col'>Заключено договоров</th>
                        <th scope='col'>На сумму</th>
                        <th scope='col'>Платежей+1</th>
                        <th scope='col'>Сумма+1</th>
                        <th scope='col'>Платежей+2</th>
                        <th scope='col'>Сумма+2</th>
                        <th scope='col'>Платежей+3</th>
                        <th scope='col'>Сумма+3</th>
                    </tr>
                </thead>
                <tbody>                    
                <?php
                    
                    foreach ($Contracts as $Branch=>$Cont){                                                
                        echo("<tr class='table-secondary'>");                        
                        echo("<td>{$Branch}</td>");
                        echo("<td>{$Cont[0]}</td>");
                        echo("<td>{$Cont[1]}</td>");  
                        if (isset($Pays1[$Branch][0])){
                            echo("<td>{$Pays1[$Branch][0]}</td>");                            
                        } else {
                            echo("<td>-</td>");
                        }
                        if (isset($Pays1[$Branch][1])){
                            echo("<td>{$Pays1[$Branch][1]}</td>");                            
                        } else {
                            echo("<td>-</td>");
                        }
                        if (isset($Pays2[$Branch][0])){
                            echo("<td>{$Pays2[$Branch][0]}</td>");                            
                        } else {
                            echo("<td>-</td>");
                        }
                        if (isset($Pays2[$Branch][1])){
                            echo("<td>{$Pays2[$Branch][1]}</td>");                            
                        } else {
                            echo("<td>-</td>");
                        }
                        if (isset($Pays3[$Branch][0])){
                            echo("<td>{$Pays3[$Branch][0]}</td>");                            
                        } else {
                            echo("<td>-</td>");
                        }
                        if (isset($Pays3[$Branch][1])){
                            echo("<td>{$Pays3[$Branch][1]}</td>");                            
                        } else {
                            echo("<td>-</td>");
                        }
                        echo("<tr>");
                    }                    
                ?>
                </tbody>
            </table>                                                                                                                    
        </div>
    </body>
</html>
