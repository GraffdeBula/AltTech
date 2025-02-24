<?php
    if (isset($Contracts[0][5])){
        $MonthsNum=count($Contracts[0][5]);
    } else {
        $MonthsNum=0;                
    }
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
                        <th scope='col'>Тариф</th>
                        <th scope='col'>Заключено договоров</th>
                        <th scope='col'>На сумму</th>
                        <?php
                            for($i=1; $i<=$MonthsNum; $i++){
                                echo("<th scope='col'>M".$i."</th>");
                            }
                        ?>
                        
                    </tr>
                </thead>
                <tbody>                    
                <?php                    
                    foreach ($Contracts as $Branch){                                                
                        echo("<tr class='table-secondary'>");                        
                        echo("<td>{$Branch[0]}</td>");
                        echo("<td>{$Branch[1]} мес.</td>");
                        echo("<td>{$Branch[2]} шт.</td>");
                        echo("<td>на {$Branch[3]} руб.</td>");
                        for($i=1; $i<=$MonthsNum; $i++){
                            if (isset($Branch[5][$i])){
                                echo("<td>{$Branch[5][$i]} шт.</td>");
                            } else {
                                echo("<td>-</td>");
                            }
                        }
                        echo("<tr>");
                    }                    
                ?>
                </tbody>
            </table>                                                                                                                    
        </div>
    </body>
</html>
