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
            <label> до </label><input type='date' name='DateL' value='<?=$_SESSION['DateL']?>'> 
            <button class='btn btn-info'>Сформировать спиок</button>
        </form>
    <h5><u>Финансовый результат</u></h5>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Безналичные</th>
                    <th scope="col">Наличные Б</th>
                    <th scope="col">Наличные С</th>
                </tr>
            </thead>
                <tr>
                    <th>Приход</th>
                    <th><?=$TotalIncomes[0]?></th>
                    <th><?=$TotalIncomes[1]?></th>
                    <th><?=$TotalIncomes[2]?></th>
                </tr>
                <tr>
                    <th>Расход</th>
                    <th><?=$TotalOutcomes[0]?></th>
                    <th><?=$TotalOutcomes[1]?></th>
                    <th><?=$TotalOutcomes[2]?></th>
                </tr>
                <tr>
                    <th>ИТОГО</th>
                    <th><?=$TotalIncomes[0]-$TotalOutcomes[0]?></th>
                    <th><?=$TotalIncomes[1]-$TotalOutcomes[1]?></th>
                    <th><?=$TotalIncomes[2]-$TotalOutcomes[2]?></th>
                </tr>
            <tbody>
                
            </tbody>
        </table>
    </div>
    <ul class="nav nav-tabs">
        <li class='nav-item'>
            <a class='nav-link active' data-bs-toggle='tab' href='#Outcomes'>Внесение расходов</a>
        </li>
        <li class='nav-item'>
            <a class='nav-link' data-bs-toggle='tab' href='#OutByDays'>Расходы по дням</a>
        </li>
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active show" id="Outcomes">
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
                    <option>С расчётного счёта</option>
                    <option>Наличные Б</option>
                    <option>Наличные С</option>
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
        </div>
        <div class="tab-pane fade" id="OutByDays">
            <h5>Расходы по дням</h5>
            <table class='table table-hover'>
                <thead>
                    <tr>
                        <th scope='col'>Дата</th>
                        <th scope='col'>С расчётного счёта</th>
                        <th scope='col'>Наличные Б</th>
                        <th scope='col'>Наличные С</th>
                    <tr>
                </thead>
                <tbody>
                    <?php
                        foreach($TotalIncomesDays as $Day=>$Outcomes){
                            echo("<tr>");
                            echo("<td>$Day</td>");
                            echo("<td>$Outcomes[0]</td>");
                            echo("<td>$Outcomes[1]</td>");
                            echo("<td>$Outcomes[2]</td>");
                            echo("</tr>");
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
</body>   

</html>
