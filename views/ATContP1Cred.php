<?php
/*
 * карточка кредита
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
                    <p>КАРТОЧКА КРЕДИТА/ЗАЙМА КЛИЕНТА</p>
                </h3>   
            </div>
        </div>
        <div class="g-row">
            <?php
            echo("<p>ФИО Клиента: {$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}</p>");
            ?>
        </div>        
        <form method='get'>
            <?php
                (new MyForm('ATContP1CredCtrl','UpdBankCont',$Client->CLCODE,$Cont->CONTCODE))->AddForm();
                echo("<input type='hidden' name='CrCode' value='{$Credit->CRCODE}'>");
            ?>
            <div class="g-row">                
                <?php
                echo("<p>Кредитор по договору</p><div class='g-2'>Тип: <input type='text' name='CRBANKCONTTYPE' value='{$Credit->CRBANKCONTTYPE}'></div>");
                echo("<div class='g-3'>Название: <input type='text' name='CRBANKCONTNAME' value='{$Credit->CRBANKCONTNAME}'></div>");
                echo("<div class='g-2'>ИНН: <input type='text' name='CRBANKCONTINN' value='{$Credit->CRBANKCONTINN}'></div>");
                ?>
                <button type='submit' class='f-bu f-bu-warning'>СОХРАНИТЬ КРЕДИТОРА ПО ДОГОВОРУ</button> 
            </div>
        </form>
        <form method='get'>
            <?php
                (new MyForm('ATContP1CredCtrl','UpdBankCur',$Client->CLCODE,$Cont->CONTCODE))->AddForm();
                echo("<input type='hidden' name='CrCode' value='{$Credit->CRCODE}'>");
            ?>
            <div class="g-row">

                <?php
                echo("<p>Текущий кредитор</p><div class='g-2'>Тип: <input type='text' name='CRBANKCURTYPE' value='{$Credit->CRBANKCURTYPE}'></div>");
                echo("<div class='g-3'>Название: <input type='text' name='CRBANKCURNAME' value='{$Credit->CRBANKCURNAME}'></div>");
                echo("<div class='g-2'>ИНН: <input type='text' name='CRBANKCURINN' value='{$Credit->CRBANKCURINN}'></div>");
                ?>
                <button type='submit' class='f-bu f-bu-warning'>СОХРАНИТЬ ТЕКУЩЕГО КРЕДИТОРА</button>                    
            </div>
        </form>    
        <div class="g-row"></div>
        <form method='get'>
            <div class="g-row">
                <?php
                    (new MyForm('ATContP1CredCtrl','UpdCred',$Client->CLCODE,$Cont->CONTCODE))->AddForm();
                    echo("<input type='hidden' name='CrCode' value='{$Credit->CRCODE}'>");
                ?>                  
            
                <button type='submit' class='f-bu f-bu-warning'>СОХРАНИТЬ КРЕДИТ</button>
            </div>
            <div class="g-row">
                <?php
                echo("<p>Передан ли коллектору по агентскому договору</p><div class='g-3'><select name='CRCOLLAGYN'></div>");
                echo("<option value='{$Credit->CRCOLLAGYN}'>{$Credit->CRCOLLAGYN}</option>");
                echo("<option value='Да'>Да</option>");
                echo("<option value='Нет'>Нет</option>");
                echo("</select></div>");  
                
                echo("<div class='g-3'>Название КА: <input type='text' name='CRCOLLAGNAME' value='{$Credit->CRCOLLAGNAME}'></div>");
                ?>
            </div>
            <div class="g-row">
                <?php
                echo("<div class='g-3'>Программа: <select name='CRPROG'>");
                
                echo("<option value='{$Credit->CRPROG}'>{$Credit->CRPROG}</option>");
                echo("<option value=' '> </option>");
                foreach($AnketaListDr as $CredProg){
                    if (($CredProg->DRNAME)=='CredProg'){
                        echo("<option value='{$CredProg->DRVALUE}'>{$CredProg->DRVALUE}</option>");
                    }                        
                }
                                 
                echo("</select></div>");                                
                echo("<div class='g-3'>Номер договора: <input type='text' name='CRCONTNUM' value='{$Credit->CRCONTNUM}'></div>");
                echo("<div class='g-3'>Дата: <input type='date' name='CROPENDAT' value='{$Credit->CROPENDAT}'></div>");
                echo("<div class='g-3'>Срок: <input type='text' name='CRPERIOD' value='{$Credit->CRPERIOD}'></div>");
                ?>
            </div>
            <div class="g-row">
                <?php
                echo("<div class='g-3'>Наличие просрочки <select name='CRDELAYYN'></div>");
                echo("<option value='{$Credit->CRDELAYYN}'>{$Credit->CRDELAYYN}</option>");
                echo("<option value='Да'>Да</option>");
                echo("<option value='Нет'>Нет</option>");
                echo("</select></div>"); 
                
                echo("<div class='g-3'>Дата последнего платежа <input type='date' name='CRPAYLASTDAT' value='{$Credit->CRPAYLASTDAT}'></div>");
                echo("<div class='g-3'>Сумма последнего платежа: <input type='text' name='CRPAYLASTSUM' value='{$Credit->CRPAYLASTSUM}'></div>");
                ?>
            </div>
            <div class="g-row">
                <?php
                echo("<div class='g-3'>Сумма кредита: <input type='text' name='CRSUM' value='{$Credit->CRSUM}'></div>");
                echo("<div class='g-3'>Остаток по кредиту: <input type='text' name='CRSUMREST' value='{$Credit->CRSUMREST}'></div>");
                echo("<div class='g-3'>Платёж: <input type='text' name='CRPAYSUM' value='{$Credit->CRPAYSUM}'></div>");
                echo("<div class='g-3'>Ставка: <input type='text' name='CRRATE' value='{$Credit->CRRATE}'></div>");
                ?>
            </div>
            <div class="g-row">
                <?php
                echo("<p>Кредитная карта</p><div class='g-3'>Общий лимит: <input type='text' name='CRCARDLIMITSUM' value='{$Credit->CRCARDLIMITSUM}'></div>");
                echo("<div class='g-3'>Израсходованный лимит: <input type='text' name='CRCARDUSEDSUM' value='{$Credit->CRCARDUSEDSUM}'></div>");            
                echo("<div class='g-3'>Минимальный платёж: <input type='text' name='CRCARDMINPAY' value='{$Credit->CRCARDMINPAY}'></div>");            
                ?>
            </div>
            <div class="g-row">
                <?php
                echo("<div class='g-3'>Есть документы по кредиту <select name='CRCONTDOCSYN'></div>");
                echo("<option value='{$Credit->CRCONTDOCSYN}'>{$Credit->CRCONTDOCSYN}</option>");
                echo("<option value='Да'>Да</option>");
                echo("<option value='Нет'>Нет</option>");
                echo("</select></div>");        
                
                echo("<div class='g-3'>Цель кредита: <select name='CRREASON'>");
                echo("<option value='{$Credit->CRREASON}'>{$Credit->CRREASON}</option>");
                foreach($AnketaListDr as $CredReason){
                    if (($CredReason->DRNAME)=='CredReason'){
                        echo("<option value='{$CredReason->DRVALUE}'>{$CredReason->DRVALUE}</option>");
                    }                        
                }
                echo("</select></div>");
                ?>
            </div>
            <div class="g-row">
                <?php
                echo("<div class='g-3'>Кодовое слово <input type='text' name='CRCODEWORD' value='{$Credit->CRCODEWORD}'></div>");
                echo("<div class='g-3'>Есть ли поручитель: <select name='CRWARRANTYN'></div>");
                echo("<option value='{$Credit->CRWARRANTYN}'>{$Credit->CRWARRANTYN}</option>");
                echo("<option value='Да'>Да</option>");
                echo("<option value='Нет'>Нет</option>");
                echo("</select></div>");  
                
                echo("<div class='g-3'>ФИО поручителя: <input type='text' name='CRWARRANTNAME' value='{$Credit->CRWARRANTNAME}'></div>");
                ?>
            </div>
            <div class="g-row">
                <?php
                echo("<div class='g-3'>Место работы соответствовало документам? <select name='CRCONTWORKREALYN'></div>");
                echo("<option value='{$Credit->CRCONTWORKREALYN}'>{$Credit->CRCONTWORKREALYN}</option>");
                echo("<option value='Да'>Да</option>");
                echo("<option value='Нет'>Нет</option>");
                echo("</select></div>");                
                echo("<div class='g-3'>Место работы на момент получения кредита: <input type='text' name='CRWORKORG' value='{$Credit->CRWORKORG}'></div>");
                ?>
            </div>
            <div class="g-row">
                <?php
                echo("<div class='g-3'>Каким документом подтверждён доход <select name='CRINCOMEDOC'>");
                echo("<option value='{$Credit->CRINCOMEDOC}'>{$Credit->CRINCOMEDOC}</option>");
                foreach($AnketaListDr as $IncDoc ){
                    if (($IncDoc->DRNAME)=='IncDoc'){
                        echo("<option value='{$IncDoc->DRVALUE}'>{$IncDoc->DRVALUE}</option>");
                    }                        
                }
                echo("</select></div>");
                echo("<div class='g-3'>Официальный доход: <input type='text' name='CRINCOMEOFSUM' value='{$Credit->CRINCOMEOFSUM}'></div>");
                echo("<div class='g-3'>Фактический доход: <input type='text' name='CRINCOMEREALSUM' value='{$Credit->CRINCOMEREALSUM}'></div>");
                ?>
            </div>
        </form>                                                                                      
    </div>
    
</body>
</html>


