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
        <?php
            foreach($OutcomeList AS $key=>$Outcome){
                var_dump($Outcome);
                echo("<br>----------------------------------------------------------------------------------<br>");
            }
        ?>
    </div>
    
    
</body>   

</html>
