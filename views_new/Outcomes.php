<?php
/*
 * для внесения расходов в таблицу
 *  */

?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <h1>Учёт расходов</h1>
    <h2>Финаносвый результат</h2>
    <?php
        $Total=$TotalIncomes-$TotalOutcomes;
        echo("Доходы всего: ".$TotalIncomes);
        echo("<br>Расходы всего: ".$TotalOutcomes);
        echo("<br>Итого финрез: ".$Total);
    ?>
    <h2>Внесение расходов</h2>
    <form>
        <?php
            (new MyForm('OutcomesCtrl', 'AddOutcome'))->AddForm2();
        ?>
        <label>Расход</label><input type="text" name='Outcome'><!-- какой расход -->            
        <label>Сумма</label><input type="number" name='OutSum'><!-- сумма -->
        <label>Дата</label><input type="date" name="OutDate"><!-- дата расхода -->
        <button class="btn btn-primary">ДОБАВИТЬ</button>
    </form>
    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col">ID</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Сумма</th>
                    <th scope="col">Расход</th>                                
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach($OutcomeList AS $key=>$Outcome){ 
                    //$ContDate=(new PrintFunctions())->DateToStr($Cont->FRCONTDATE);
                    echo("<tr class='table-info'>"                        
                        ."<td> </td>"
                        ."<td>$Outcome->ID</td>"
                        ."<td>".(new PrintFunctions())->DateToStr($Outcome->OUTDATE)."</td>"
                        ."<td>$Outcome->OUTSUM</td>"
                        ."<td>$Outcome->OUTCOME</td>"
                    ."</tr>");

                }
            ?>
            </tbody>
        </table>
        
    </div>
    
    
</body>   

</html>
