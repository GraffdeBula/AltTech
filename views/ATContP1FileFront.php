<?php
/*
 * досье клиента
 *  */
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <div class="g">      
        <div class="g-row">
            <div class='g-12'>
                <h3>
                    <p>АЛЬТ-ТЕХ</p>
                </h3>   
            </div>
        </div>
        <div class="g-row">
            <div class='g-12'>
                <h3>
                    <p>ДОГОВОР БФЛ - ДОСЬЕ ДОГОВОРА</p>
                </h3>   
            </div>
        </div>
        <?php
            echo("<div class='g-row'>");
            echo("<p>ФИО КЛИЕНТА:   {$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}<p>");
            //echo("</div>");        
            //echo("<div class='g-row'>");
            echo("<p>Филиал обслуживания:   {$Cont->FROFFICE}<p>");
            //echo("</div>");
            //echo("<div class='g-row'>");
            echo("<p>Персональный менеджер:   {$Cont->FRPERSMANAGER}<p>");
            echo("<p>Код клиента:   {$Client->CLCODE}<p>");
            echo("<p>Код договора:   {$Cont->CONTCODE}<p>");
            echo("</div>");
            echo("<div class='g-row'>");            
            echo("<a target='_blank' href='index_admin.php?controller=ATContP1AnketaCtrl&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'>");
            echo("<button class='f-bu f-bu-default'>ОТКРЫТЬ АНКЕТУ ДОГОВОРА</button></a>");
            echo("</div>");
        ?>
          
        <div class='g-row'>    
            <div class='g-3'>                                                                 
                <form method='get'>
                    <input type='hidden' name='controller' value='ATContP1FileFrontCtrl'>
                    <input type='hidden' name='action' value='FrontSave'>
                    <button class='f-bu f-bu-warning'>СОХРАНИТЬ</button>
                    <?php
                        echo("<input type='hidden' name='ClCode' value={$Client->CLCODE}>");
                        echo("<input type='hidden' name='ContCode' value={$Cont->CONTCODE}>");                        
                        echo("<div class='g-row'><label>ДАТА ДОГОВОРА ЭПЭ</label><input type='date' name='FREXPDATE' value={$Cont->FREXPDATE}></div>");
                        echo("<div class='g-row'><label>СТОИМОСТЬ ЭПЭ</label><input type='text' name='FREXPSUM' value={$Cont->FREXPSUM}></div>");
                        echo("<div class='g-row'><label>ДАТА ПОДПИСАНИЯ АКТА ЭПЭ</label><input type='date' name='FREXPACTDATE' value={$Cont->FREXPACTDATE}></div>");
                        echo("<div class='g-row'><label>ДАТА ДОГОВОРА УСЛУГ</label><input type='date' name='FRCONTDATE' value={$Cont->FRCONTDATE}></div>");
                        echo("<div class='g-row'><label>ДАТА ДОГОВОРА ДОВЕРЕННОСТИ</label><input type='date' name='FRDOVDATE' value={$Cont->FRDOVDATE}></div>");
                    ?>
                </form>
                <div class="g-row"></div>
                <div class="g-row"></div>
            </div>
            <div class='g-3'> 
                <div class="g-row">
                    <?php
                        echo("<a target='_blank' href='index_admin.php?controller=ATContP1FileFrontCtrl&action=ExpertContPrint&ClCode={$Client->CLCODE}&ContCode={$Cont->CONTCODE}'><button class='f-bu f-bu-default'>ПЕЧАТЬ ДОГОВОРА ЭПЭ</button></a>");
                    ?>
                </div>
                <h5>Результаты ЭПЭ</h5>
                <div class='g-row'>
                    <?php
                        echo("<div class='g-row'><label>Рекомендуемый продукт</label><input disabled type='text' name='EXPRODREC' value={$Cont->EXPRODREC}></div>");
                        echo("<div class='g-row'><label>Сумма долга</label><input type='text' disabled name='EXTOTDEBTSUM' value={$Cont->EXTOTDEBTSUM}></div>");
                        echo("<div class='g-row'><label>Сумма основного долга</label><input disabled type='text' name='FREXPACTDAEXMAINDEBTSUMTE' value={$Cont->EXMAINDEBTSUM}></div>");
                    ?>
                </div> 
                                
            </div>
            <div class='g-3'> 
                <p>ВНЕСЁННЫЕ ПЛАТЕЖИ</p>
            </div>
            <div class='g-3'> 
                <p>КОММЕНТАРИИ</p>
            </div>
        </div>
    </div>
</body>
</html>
