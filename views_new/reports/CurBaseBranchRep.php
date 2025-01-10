<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Действующая база клиентов</title>       
    </head>
    <body>
        <div>            
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
                  <a class="nav-link active" data-bs-toggle="tab" href="#repbase">Действующие договоры</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#jurbase">Договоры на юр.стадии</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#stopbase">Приостановленные договоры</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-bs-toggle="tab" href="#archbase">Архивные договоры</a>
                </li>                
            </ul>
            <div id="myTabContent" class="tab-content">
                <div class="tab-pane fade active show" id="repbase">
                    <?php
                        if ((isset($_GET['Branch']))&&($_GET['Branch']!='')){
                            echo("<a href='/".WORK_FOLDER."/downloads/Действующая база {$_GET['Branch']}.xlsx'><button class='btn btn-success'>Выгрузить в Excel</button></a>");
                        }
                    ?>
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
                              <th scope="col">Внесено по договору</th>
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
                                echo("<td>{$Cont->PAYTOTSUM}</td>");
                                echo("<td>{$Cont->STATUS}</td>");                                
                                echo("</tr>");
                            }
                        ?>                            
                        </tbody>
                    </table>
                    
                </div>
                <div class="tab-pane fade" id="jurbase">
                    <?php
                        if ((isset($_GET['Branch']))&&($_GET['Branch']!='')){
                            echo("<a href='/".WORK_FOLDER."/downloads/ДД юрстадия {$_GET['Branch']}.xlsx'><button class='btn btn-success'>Выгрузить в Excel</button></a>");
                        }
                    ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>                      
                              <th scope="col">ClCode</th>
                              <th scope="col">ContCode</th>
                              <th scope="col">ФИО</th>
                              <th scope="col">Филиал</th>                              
                              <th scope="col">ДатаДоговора</th>
                              <th scope="col">Тариф</th>
                              <th scope="col">Сумма договора</th>                              
                              <th scope="col">Статус</th>
                              <th scope="col">Дата иска</th>
                              <th scope="col">Дата списания долга</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $Sum=0;
                            foreach($JurList as $Cont){
                                $ContDate=(new PrintFunctions())->DateToStr($Cont->FRCONTDATE);                                
                                echo("<tr class='table-info'>");
                                echo("<td>{$Cont->CLCODE}</td>");
                                echo("<td>{$Cont->CONTCODE}</td>");
                                echo("<td><a target='_blanc' href='index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$Cont->CLCODE}&ContCode={$Cont->CONTCODE}'>{$Cont->CLFIO}</a></td>");
                                echo("<td>{$Cont->FROFFICE}</td>");                                
                                echo("<td>{$ContDate}</td>");
                                echo("<td>{$Cont->FRCONTTARIF}</td>");
                                echo("<td>{$Cont->FRCONTSUM}</td>");                                
                                echo("<td>{$Cont->STATUS}</td>");   
                                echo("<td>{$Cont->BOISKDATE}</td>");   
                                echo("<td>{$Cont->BOBANKRFINDATE}</td>");   
                                echo("</tr>");
                            }
                        ?>                            
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="stopbase">
                    <?php
                        if ((isset($_GET['Branch']))&&($_GET['Branch']!='')){
                            echo("<a href='/".WORK_FOLDER."/downloads/ДД приостановлены {$_GET['Branch']}.xlsx'><button class='btn btn-success'>Выгрузить в Excel</button></a>");
                        }
                    ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>                      
                              <th scope="col">ClCode</th>
                              <th scope="col">ContCode</th>
                              <th scope="col">ФИО</th>
                              <th scope="col">Филиал</th>                              
                              <th scope="col">ДатаДоговора</th>
                              <th scope="col">Тариф</th>
                              <th scope="col">Сумма договора</th>                              
                              <th scope="col">Статус</th>
                              <th scope="col">Дата иска</th>
                              <th scope="col">Дата списания долга</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $Sum=0;
                            foreach($StopList as $Cont){
                                $ContDate=(new PrintFunctions())->DateToStr($Cont->FRCONTDATE);                                
                                echo("<tr class='table-info'>");
                                echo("<td>{$Cont->CLCODE}</td>");
                                echo("<td>{$Cont->CONTCODE}</td>");
                                echo("<td><a target='_blanc' href='index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$Cont->CLCODE}&ContCode={$Cont->CONTCODE}'>{$Cont->CLFIO}</a></td>");
                                echo("<td>{$Cont->FROFFICE}</td>");                                
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
                <div class="tab-pane fade" id="archbase">
                    <?php
                        if ((isset($_GET['Branch']))&&($_GET['Branch']!='')){
                            echo("<a href='/".WORK_FOLDER."/downloads/Архивные договоры {$_GET['Branch']}.xlsx'><button class='btn btn-success'>Выгрузить в Excel</button></a>");
                        }
                    ?>
                    <table class="table table-hover">
                        <thead>
                            <tr>                      
                              <th scope="col">ClCode</th>
                              <th scope="col">ContCode</th>
                              <th scope="col">ФИО</th>
                              <th scope="col">Филиал</th>                              
                              <th scope="col">ДатаДоговора</th>
                              <th scope="col">Тариф</th>
                              <th scope="col">Сумма договора</th>                              
                              <th scope="col">Статус</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $Sum=0;
                            foreach($ArchList as $Cont){
                                $ContDate=(new PrintFunctions())->DateToStr($Cont->FRCONTDATE);                                
                                echo("<tr class='table-info'>");
                                echo("<td>{$Cont->CLCODE}</td>");
                                echo("<td>{$Cont->CONTCODE}</td>");
                                echo("<td><a target='_blanc' href='index_admin.php?controller=ATContP1FileFrontCtrl&ClCode={$Cont->CLCODE}&ContCode={$Cont->CONTCODE}'>{$Cont->CLFIO}</a></td>");
                                echo("<td>{$Cont->FROFFICE}</td>");                                
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
            </div>                                                                                                                                   
        </div>
        
    </body>
</html>
