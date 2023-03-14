<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Отчёт по выручке</title>       
    </head>
    <body>
        <div>
            <h5>Выручка и платежи за период</h5>
            <form method="get">
                <?php (new MyForm('RepPaymentsCtrl','Index',0,0))->AddForm() ?>
                <label>|  C  |</label><input type='date' name='DateF' value='<?=$_GET['DateF']?>'>
                <label>|  по  |</label><input type='date' name='DateL' value='<?=$_GET['DateL']?>'>
                <?php
                    $Branch='';
                    if (isset($_GET['Branch'])){
                        $Branch=$_GET['Branch'];
                    }                
                    echo("<label>|  филиал  |</label><select name='Branch' value='{$Branch}'>");
                    echo("<option value='{$Branch}'>$Branch</option>");
                    foreach($BranchList as $Branch){
                        echo("<option value='{$Branch->BRNAME}'>$Branch->BRNAME</option>");
                    }
                    echo("</select>");
                ?>        
                <button>Получить отчёт</button>
            </form>  
            
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-bs-toggle="tab" href="#repaggr">Отчёт по выручке</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#repfull">Реестр платежей</a>
                </li> 
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active show" id="repaggr">
                    <table class='table table-hover'>
                        <thead>
                            <tr>                       
                                <th scope='col'>Вид выручки</th>
                                <th scope='col'>Подразделение</th>
                                <th scope='col'>Сумма</th>                                                                         
                            </tr>
                        </thead>
                        <tbody>                    
                            <?php
                                foreach ($Report2 as $Pay){
                                    echo("<tr class='table-secondary'>");
                                    echo("<td>{$Pay->PAYNAME}</td>");                              
                                    echo("<td>{$Pay->PAYBRANCH}</td>");
                                    echo("<td>{$Pay->PAYSUM}</td>");                                    
                                    echo("<tr>");
                                }                    
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="tab-pane fade" id="repfull">
                    <table class='table table-hover'>
                        <thead>
                            <tr>                       
                                <th scope='col'>ID</th>
                                <th scope='col'>Номер ПКО</th>
                                <th scope='col'>Филиал</th>
                                <th scope='col'>Дата</th>
                                <th scope='col'>Сумма</th>
                                <th scope='col'>Назначение платежа</th>
                                <th scope='col'>Номер договора</th>
                                <th scope='col'>Клиент</th>                                                
                            </tr>
                        </thead>
                        <tbody>                    
                            <?php
                                foreach ($Report1 as $Pay){
                                    echo("<tr class='table-secondary'>");
                                    echo("<td>{$Pay->ID}</td>");                              
                                    echo("<td>{$Pay->PAYCODE}</td>");
                                    echo("<td>{$Pay->PAYBRANCH}</td>");
                                    echo("<td>{$Pay->PAYDATE}</td>");
                                    echo("<td>{$Pay->PAYSUM}</td>");
                                    echo("<td>{$Pay->PAYPR}</td>");
                                    echo("<td>{$Pay->CONTCODE}</td>");
                                    echo("<td>{$Pay->CONTCLIENT}</td>");
                                    echo("<tr>");
                                }                    
                            ?>
                        </tbody>
                    </table>
                </div>    
            </div>
                                                                    
                    
            
        </div>
    </body>
</html>
