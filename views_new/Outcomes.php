value='<?=$_SESSION['DateF']?>'<?php
/*
 * для внесения расходов в таблицу
 *  */
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <h2>Учёт расходов</h2>
    <a style="pointer-events: none;" href='downloads/Расходы.xlsx'><button  type='button' class='btn btn-success disabled'>В EXCEL</button></a>
        <form>            
            <?php   
                if (in_array($_SESSION['EmRole'],['top','admin'])){
                    echo("<label>Филиал</label>");
                    (new EchoBranchList())->echoList($_SESSION['EmBranch'],'BranchName');
                } else {
                    echo("<input type='hidden' name='BranchName' value='{$_SESSION['EmBranch']}'>");
                }
                (new MyForm('OutcomesCtrl','FilterOutcomes'))->AddForm2();
            ?>
            <label>Показать расходы от </label><input type='date' name='DateF' value='<?=$_SESSION['DateF']?>'>
            <label> до </label><input type='date' name='DateL' > 
            <button class='btn btn-info'>Сформировать спиок</button>
        </form>
    <h5><u>Финансовый результат</u></h5>
    
    <h5><u>Внесение расходов</u></h5>
    <form autocomplete='off'>
        <?php
            (new MyForm('OutcomesCtrl', 'AddOutcome'))->AddForm2();        
            if (in_array($_SESSION['EmRole'],['top','admin'])){
                echo("<label>Филиал</label>");
                (new EchoBranchList())->echoList('','OutBranch');
            } else {
                echo("<input type='hidden' name='OutBranch' value='{$_SESSION['EmBranch']}'>");
            }
        
        ?>
        <label>Расход</label><select type="text" name='Outcome'><!-- расход по справочнику --> 
            <option></option>
            <?php
                foreach($OutcomeDr as $Outcome){
                    echo("<option value='$Outcome->OUTCOME'>$Outcome->OUTCOME</option>");
                }
            ?>
        </select>
        <label>Способ оплаты</label><select type="text" name='OutcomeType' required="on"><!-- способ оплаты --> 
            <option></option>
            <option>с расчётного счёта</option>
            <option>наличными</option>
            <option>другими наличными</option>
        </select>
        <br>
        <label>Комментарий</label><input type="text" size='80' name='Comment' required="on"><!-- расшифровка расхода -->  
        <label>Сумма</label><input type="number" name='OutSum' required="on"><!-- сумма -->
        <label>Дата</label><input type="date" name="OutDate" required="on"><!-- дата расхода -->
        
        
        <button class="btn btn-primary">ДОБАВИТЬ</button>
    </form>
    <div class="row">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"> </th>
                    <th scope="col">ID</th>
                    <th scope="col">Филиал</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Сумма</th>
                    <th scope="col">Способ оплаты</th>
                    <th scope="col">Расход</th>
                    <th scope="col">Комментарий</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach($OutcomeList AS $key=>$Outcome){                     
                    if ((new DateTime($Outcome->OUTDATE))==(new DateTime($Outcome->OUTFACTDATE))){
                        $OutType='table-info';
                    }else{
                        $OutType='table-warning';
                    }
                    echo("<tr class='{$OutType}'>"                        
                        ."<td> </td>"
                        ."<td>$Outcome->ID</td>"
                        ."<td>$Outcome->OUTBRANCH</td>"
                        ."<td>".(new PrintFunctions())->DateToStr($Outcome->OUTDATE)."</td>"
                        ."<td>$Outcome->OUTSUM</td>"
                        ."<td>$Outcome->OUTCOMETYPE</td>"
                        ."<td>$Outcome->OUTCOME</td>"
                        ."<td>$Outcome->COMMENT</td>"
                    ."</tr>");

                }
            ?>
            </tbody>
        </table>
        
    </div>
    
    
</body>   

</html>
