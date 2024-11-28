<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Действующая база клиентов</title>       
    </head>
    <body>
        <div>
            <?php
                if ((isset($_GET['Branch']))&&($_GET['Branch']!='')){
                    echo("<a href='/AltTech/downloads/Действующая база {$_GET['Branch']}.xlsx'><button class='btn btn-success'>Выгрузить в Excel</button></a>");
                }
            ?>
            <form method="get">
                <?php (new MyForm('CurBaseBranchCtrl','ShowBrBase',0,0))->AddForm2();
                
                    $Branch='';
                    
                    echo("<label>|  филиал  |</label><select name='Branch' value='{$Branch}'>");
                    echo("<option value='{$Branch}'>$Branch</option>");
                    foreach($BranchList as $Branch){
                        echo("<option value='{$Branch->BRNAME}'>$Branch->BRNAME</option>");
                    }
                    echo("</select>");
                    
                ?>        
                <button class='btn btn-dark'>Получить отчёт</button>
            </form>  
            
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" data-bs-toggle="tab" href="#repaggr">Действующая база клиентов</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#repcomp">Действующая база клиентов</a>
                </li>                

            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active show" id="repaggr">
                    <table class="table table-hover">
                        <thead>
                            <tr>                      
                              <th scope="col">ClCode</th>
                              <th scope="col">ContCode</th>
                              <th scope="col">ФИО</th>
                              <th scope="col">Филиал</th>
                              <th scope="col">Менеджер</th>
                              <th scope="col">ДатаДоговора</th>
                              <th scope="col">Тариф</th>
                              <th scope="col">Сумма договора</th>                              
                              <th scope="col">Статус</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $Sum=0;
                            foreach($ContList as $Cont){
                                $ContDate=(new PrintFunctions())->DateToStr($Cont->FRCONTDATE);                                
                                echo("<tr class='table-info'>");
                                echo("<td>{$Cont->CLCODE}</td>");
                                echo("<td>{$Cont->CONTCODE}</td>");
                                echo("<td><a target='_blanc' href='index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$Cont->CLCODE}&ContCode={$Cont->CONTCODE}'>{$Cont->CLFIO}</a></td>");
                                echo("<td>{$Cont->FROFFICE}</td>");
                                echo("<td>{$Cont->FRPERSMANAGER}</td>");
                                echo("<td>{$ContDate}</td>");
                                echo("<td>{$Cont->FRCONTTARIF}</td>");
                                echo("<td>{$Cont->FRCONTSUM}</td>");
                                echo("<td>{$Cont->STATUS}</td>");                                
                                echo("</tr>");
                            }
                        ?>                            
                        </tbody>
                    </table>
                    
                </div>
                
                <div class="tab-pane fade" id="repcomp">
                    
                </div>
                
                                                                                                                                                         
        </div>
    </body>
</html>
