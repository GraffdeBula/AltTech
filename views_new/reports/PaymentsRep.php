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
                    $ContType='';
                    if (isset($_GET['Branch'])){
                        $Branch=$_GET['Branch'];
                    }                
                    if ((isset($_GET['ContType'])) && ($_GET['ContType']==1)){
                        $ContType='по ПКО';
                    }
                    if ((isset($_GET['ContType'])) && ($_GET['ContType']==2)){
                        $ContType='по чеку';
                    }
                    echo("<label>|  филиал  |</label><select name='Branch' value='{$Branch}'>");
                    echo("<option value='{$Branch}'>$Branch</option>");
                    foreach($BranchList as $Branch){
                        echo("<option value='{$Branch->BRNAME}'>$Branch->BRNAME</option>");
                    }
                    echo("</select>");
                    
                    echo("");
                    
                    #echo("<label>|  тип платежа  |</label><select name='ContType'>");
                    #echo("<option value='{$ContType}'>{$ContType}</option>");
                    #echo("<option value=1>по ПКО</option>");
                    #echo("<option value=2>по чеку</option>");    
                    #echo("</select>");
                ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="PayTypeRep" id="payType1" value="Inc" checked="">
                    <label class="form-check-label" for="payType1">
                        Платежи по договорам
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="PayTypeRep" id="payType2" value="Dep" checked="">
                    <label class="form-check-label" for="payType2">
                        Платежи в ОХ
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="PayTypeRep" id="payType3" value="IncDep" checked="">
                    <label class="form-check-label" for="payType3">
                        Платежи по договорам и в ОХ
                    </label>
                </div>
                
                <button>Получить отчёт</button>
            </form>  
            
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-bs-toggle="tab" href="#repaggr">Отчёт по выручке</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#repcomp">Отчёт по выручке компания</a>
                </li>                
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#repfull">Реестр платежей</a>
                </li> 
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#repmethod">Отчёт по способу платежа</a>
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
                                    switch($Pay->PAYNAME){
                                        case 'Новые договоры':
                                            echo("<tr class='table-success'>");
                                            break;
                                        case 'Действующие договоры':
                                            echo("<tr class='table-info'>");
                                            break;
                                        case 'Разовые услуги юристов':
                                        case 'Разовые услуги менеджеров':
                                            echo("<tr class='table-warning'>");
                                            break;
                                        case 'Ответственное хранение':
                                            echo("<tr class='table-dark'>");
                                            break;
                                        
                                    }
                                    
                                    echo("<td>{$Pay->PAYNAME}</td>");                              
                                    echo("<td>{$Pay->CONTBRANCH}</td>");
                                    echo str_replace('.',',',"<td>{$Pay->PAYSUM}</td>");                                    
                                    echo("<tr>");
                                }                    
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="tab-pane fade" id="repcomp">
                    <table class='table table-hover'>
                        <thead>
                            <tr>                       
                                <th scope='col'>Вид выручки</th>                                
                                <th scope='col'>Сумма</th>                                                                         
                            </tr>
                        </thead>
                        <tbody>                    
                            <?php
                                echo("<tr class='table-dark'>");
                                echo("<td>Выручка всего</td>");                                                                  
                                echo("<td>{$TotalIncome->PAYSUM}</td>");                                    
                                echo("<tr>");
                                foreach ($Report3 as $Pay){
                                    echo("<tr class='table-secondary'>");
                                    echo("<td>{$Pay->PAYNAME}</td>");                                                                  
                                    echo str_replace('.',',',"<td>{$Pay->PAYSUM}</td>");                                    
                                    echo("<tr>");
                                }                    
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="tab-pane fade" id="repfull">
                    <a href='downloads/PaymentRep.xlsx'><button class='btn btn-success'>В EXCEL</button></a>
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
                                <th scope='col'>Продукт</th>
                                <th scope='col'>Клиент</th>                                                
                                <th scope='col'>Способ платежа</th>
                            </tr>
                        </thead>
                        <tbody>                    
                            <?php
                                foreach ($Report1 as $Pay){
                                    $PayDate=(new PrintFunctions())->DateToStr($Pay->PAYDATE);
                                    if ($Pay->PRODCODE==1) {
                                        $Controller='ATContP1FileFrontCtrl';
                                        $Product='БФЛ';
                                    }
                                    if ($Pay->PRODCODE==4) {
                                        $Controller='ATContP4FileFrontCtrl';
                                        $Product='РУ';
                                    }
                                    echo("<tr class='table-secondary'>");
                                    echo("<td>{$Pay->ID}</td>");                              
                                    echo("<td>{$Pay->PAYCODE}</td>");
                                    echo("<td>{$Pay->CONTBRANCH}</td>");
                                    echo("<td>{$PayDate}</td>");
                                    echo str_replace('.',',',"<td>{$Pay->PAYSUM}</td>");
                                    echo("<td>{$Pay->PAYPR}</td>");                                                                 
                                    echo("<td><a target='_blank' href='index.php?controller=$Controller&ClCode={$Pay->CLCODE}&ContCode={$Pay->CONTCODE}'>{$Pay->CONTCODE}</a></td>");
                                    echo("<td>$Product</td>");       
                                    echo("<td>{$Pay->CONTCLIENT}</td>");
                                    echo("<td>{$Pay->PAYMETHOD}</td>");
                                    echo("<tr>");
                                }                    
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="tab-pane fade" id="repmethod">
                    <table class='table table-hover'>
                        <thead>
                            <tr>                       
                                <th scope='col'>ContBranch</th>
                                <th scope='col'>PayMethod</th>
                                <th scope='col'>PaySum</th>                                
                            </tr>
                        </thead>
                        <tbody>                    
                            <?php
                            #var_dump($Report4);
                                foreach ($Report4 as $Pay){
                                    echo("<tr class='table-secondary'>");                                                                                               
                                    echo("<td>{$Pay->CONTBRANCH}</td>");
                                    echo("<td>{$Pay->PAYMETHOD}</td>");
                                    echo str_replace('.',',',"<td>{$Pay->PAYSUM}</td>");                                    
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
