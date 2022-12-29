<?php
#var_dump($Client);
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
                        <p>ДЛЯ ПЕЧАТИ ДОКЗИЛЛЫ</p>
                    </h3>                      
                </div>
            </div>
            <div class="g-row">
                <div class='g-3'>
                    <a href="index_admin.php?controller=ClInfoCtrl&view=AdminClientSearch"><button class="f-bu f-bu-default">НАЗАД</button></a><br>
                </div>                
            </div>     
            <div>
                <form method='POST'>
                    <input type='hidden' name='controller' value='ClInfoCtrl'>
                    <input type='hidden' name='action' value='UpdateData'>
                    <div class='f-row'>
                        <div class='f-input'>
                            <label for='clCode'>CLCODE</label>
                            <input type='text' name='clCode' value='<?=$Client->CLCODE?>' id='clCode' autocomplete="off">

                            <label for='contCode'>CONTCODE</label>
                            <input type='text' name='contCode' value='<?=$Contract->CONTCODE?>' id='contCode' autocomplete="off">
                        </div>
                        <div class='f-input'>
                            <label for='clFName'>Фамилия</label>
                            <input type='text' name='clFName' value='<?=$Client->CLFNAME?>' id='clFName' autocomplete="off">

                            <label for='cl1Name'>Имя</label>
                            <input type='text' name='cl1Name' value='<?=$Client->CL1NAME?>' id='cl1Name' autocomplete="off">

                            <label for='cl2Name'>Отчество</label>
                            <input type='text' name='cl2Name' value='<?=$Client->CL2NAME?>' id='cl2Name' autocomplete="off">
                        </div>
                        <div class='f-input'>
                            <label for='crdebt'>Долг</label>
                            <input type='text' name='crdebt' value='<?=$Contract->CRDEBTSUM?>' id='crdebt' autocomplete="off">

                            <label for='crdelay'>Просроченный долг</label>
                            <input type='text' name='crdelay' value='<?=$Contract->CRDEBTDELAYSUM?>' id='crdelay' autocomplete="off">

                            <label for='crfee'>Штрафы</label>
                            <input type='text' name='crfee' value='<?=$Contract->CRDEBTFEESUM?>' id='crfee' autocomplete="off">
                        </div>
                        <div class='f-input'>
                            <label for='iskDate'>Дата подписания иска</label>
                            <input type='date' name='iskDate' value='<?=$Contract->BOISKSIGNEDDAT?>' id='iskDate' autocomplete="off">
                        </div>      
                        </div>
                    <div class='f-actions'>
                        <button type='submit' class='f-bu f-bu-warning'>СОХРАНИТЬ</button>
                    </div>
                </form>               
            </div>
            <div class='g-row'>
                <div class='g-1'>
                    <a href="index_admin.php?controller=PrintIskCtrl&ClCode=<?=$Client->CLCODE?>&ContCode=<?=$Contract->CONTCODE?>" target="_blank"><button class="f-bu f-bu-warning">ПЕЧАТЬ ИСКА</button>
                </div>
                <div class='g-1'>
                    <a href="index_admin.php?controller=CreditorsCtrl&CONTCODE=<?=$Contract->CONTCODE?>" target="_blank"><button class="f-bu f-bu-success">СПИСОК КРЕДИТОРОВ</button>
                </div>
                <div class='g-1'>
                    <a href="index_admin.php?controller=CrDocsCtrl&ContCode=<?=$Contract->CONTCODE?>" target="_blank"><button class="f-bu f-bu-success">СПИСОК ДОКУМЕНТОВ</button>
                </div>
                <div class='g-1'>
                    <a href="index_admin.php?controller=CrFSSPCtrl&ClCode=<?=$Client->CLCODE?>" target="_blank"><button class="f-bu f-bu-success">ИСПОЛ. ПРОИЗВОДСТВА</button>
                </div>
                <div class='g-1'>
                    <a href="index_admin.php?" target="_blank"><button class="f-bu">СУДЕБНЫЕ АКТЫ</button>
                </div>
                
            </div>
        </div>
    </body>
</html>
