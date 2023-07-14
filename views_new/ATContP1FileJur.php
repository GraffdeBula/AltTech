<?php
/*
 * досье клиента
 *  */
#var_dump($Tarif->getTarifList());
#exit();
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <div>
        <h3>
            <p>ДОГОВОР БФЛ - ДОСЬЕ ЮРБЛОКА</p>
        </h3>   
    </div>
    <div class='row'>
        <div class='col-3'>
            <?="ФИО КЛИЕНТА:   {$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}"?>
        </div>
        <div class='col-3'>
            <?="Филиал обслуживания:   {$Front->FROFFICE}"?>
        </div>
    </div>
    <div class='row'>
        <div class='col-3'>
            <?="Персональный менеджер:   {$Front->FRPERSMANAGER}"?>
        </div>
        <div class='col-3'>
            <?="Юрист:   {$BackOf->BOJURNAME}"?>
        </div>
    </div>
    <div class='row'>
        <div class='col-3'>
            <?="Статус договора:   {$Cont->STATUS}"?>
        </div>
        <div class='col-3'>
            <?="Код клиента:   {$Client->CLCODE}"?>
        </div>
        <div class='col-3'>
            <?="Код договора:   {$Anketa->CONTCODE}"?>
        </div>
            
    <?php
    //кнопки для анкеты и печати документов
        echo("<div>");            
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1AnketaCtrl&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>");
        echo("<button class='btn btn-success'>ОТКРЫТЬ АНКЕТУ ДОГОВОРА</button></a>");
        
        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FilePrintCtrl&action=DovCompJur&ClCode={$Client->CLCODE}&ContCode={$Anketa->CONTCODE}'>"
        . "<button class='btn btn-info'>Передоверие</button></a>");
                
        echo("</div>");
    ?>

    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" data-bs-toggle="tab" href="#Main">Основная инф</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#CredList">Список кредиторов</a>
        </li>        
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="tab" href="#Add">дополнительное</a>
        </li>        
    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active show" id="Main">  
            <form method='get' autocomplete="off">
                <?php
                    (new MyForm('ATContP1FileJurCtrl','JurSave',$_GET['ClCode'],$_GET['ContCode']))->AddForm();
                    echo("<lable>Ответственный юрист</lable><select name='BOJURNAME'>");
                    echo("<option value='{$BackOf->BOJURNAME}'>{$BackOf->BOJURNAME}</option>");
                    foreach($EmpList as $Emp){
                        echo("<option value='{$Emp->EMNAME}'>{$Emp->EMNAME}</option>");
                    }   
                    echo("</select>");
                ?>   
                <button class='btn btn-warning'>save</button>
            </form>
        </div>
        <div class="tab-pane fade" id="CredList">
            <h5>Список кредиторов</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>                      
                            <th scope="col">Кредитор</th>
                            <th scope="col">ИНН</th>
                            <th scope="col">ОГРН</th>
                            <th scope="col">Номер договора</th>
                            <th scope="col">Дата договора</th>
                            <th scope="col">Долг по ЭПЭ</th>
                            <th scope="col">Просроченный долг</th>
                            <th scope="col">Штрафы</th>
                        </tr
                    </thead>
                    <tbody>                    
                    <?php
                        foreach($CreditList as $Credit){
                            echo("<tr>");
                            echo("<td><p>{$Credit->CRBANKCONTNAME}</p><p>ИНН: {$Credit->CRBANKCONTINN}</p></td>");
                            echo("<td>{$Credit->CRBANKCONTINN}</td>");
                            echo("<td>{$Credit->CRBANKCONTINN}</td>");
                            echo("<td>{$Credit->CRCONTNUM}</td>");
                            echo("<td>{$Credit->CROPENDAT}</td>");
                            echo("<td>{$Credit->CRSUMREST}</td>");
                            echo("<td>{$Credit->CRSUMOVERDUE}</td>");
                            echo("<td>{$Credit->CRSUMFINE}</td>");
                            echo("</tr>");
                        }
                    ?>         
                    </tbody>
                </table>
        </div>    
        <div class="tab-pane fade" id="Add">
            <h5>этапы например</h5>
                       
        </div>        
    </div>
                
</body>
</html>
