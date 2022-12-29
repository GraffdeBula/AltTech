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
                    <p>ДОГОВОР БФЛ - ЭКСПЕРТИЗА</p>
                </h3>   
            </div>
        </div>
        <div class="g-row">
            <div class='g-12'>
                <h3>
                    <p>ДОП ВКЛАДКА: КРЕДИТ</p>
                </h3>   
            </div>
        </div>
        <div class="g-row">
            <?php
            echo("<p>ФИО Клиента: {$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}</p>");
            ?>
        </div>
        <div class="g-row">
            <?php
            echo("<p>Кредитор по договору</p><div class='g-3'>Тип: <input type='text' value='{$Credit->CRBANKCONTTYPE}'></div>");
            echo("<div class='g-3'>Название: <input type='text' value='{$Credit->CRBANKCONTNAME}'></div>");
            echo("<div class='g-3'>ИНН: <input type='text' value='{$Credit->CRBANKCONTINN}'></div>");
            ?>
        </div>
        <div class="g-row">
            <?php
            echo("<p>Текущий кредитор</p><div class='g-3'>Тип: <input type='text' value='{$Credit->CRBANKCURTYPE}'></div>");
            echo("<div class='g-3'>Название: <input type='text' value='{$Credit->CRBANKCURNAME}'></div>");
            echo("<div class='g-3'>ИНН: <input type='text' value='{$Credit->CRBANKCURINN}'></div>");
            ?>
        </div>
        <div class="g-row">
            <?php
            echo("<p>Передан ли коллектору по агентскому договору</p><div class='g-3'><input type='text' value='{$Credit->CRCOLLAGYN}'></div>");
            echo("<div class='g-3'>Название КА: <input type='text' value='{$Credit->CRCOLLAGNAME}'></div>");
            ?>
        </div>
        <div class="g-row">
            <?php
            echo("<div class='g-3'>Программа: <input type='text' value='{$Credit->CRPROG}'></div>");
            echo("<div class='g-3'>Номер договора: <input type='text' value='{$Credit->CRCONTNUM}'></div>");
            echo("<div class='g-3'>Дата: <input type='date' value='{$Credit->CROPENDAT}'></div>");
            echo("<div class='g-3'>Срок: <input type='text' value='{$Credit->CRPERIOD}'></div>");
            ?>
        </div>
        <div class="g-row">
            <?php
            echo("<div class='g-3'>Наличие просрочки <input type='text' value='{$Credit->CRDELAYYN}'></div>");
            echo("<div class='g-3'>Дата последнего платежа <input type='date' value='{$Credit->CRPAYLASTDAT}'></div>");
            echo("<div class='g-3'>Сумма последнего платежа: <input type='text' value='{$Credit->CRPAYLASTSUM}'></div>");
            ?>
        </div>
        <div class="g-row">
            <?php
            echo("<div class='g-3'>Сумма кредита: <input type='text' value='{$Credit->CRSUM}'></div>");
            echo("<div class='g-3'>Остаток по кредиту: <input type='text' value='{$Credit->CRSUMREST}'></div>");
            echo("<div class='g-3'>Платёж: <input type='text' value='{$Credit->CRPAYSUM}'></div>");
            echo("<div class='g-3'>Ставка: <input type='text' value='{$Credit->CRRATE}'></div>");
            ?>
        </div>
        <div class="g-row">
            <?php
            echo("<p>Кредитная карта</p><div class='g-3'>Общий лимит: <input type='text' value='{$Credit->CRCARDLIMITSUM}'></div>");
            echo("<div class='g-3'>Израсходованный лимит: <input type='text' value='{$Credit->CRCARDUSEDSUM}'></div>");            
            echo("<div class='g-3'>Минимальный платёж: <input type='text' value='{$Credit->CRCARDMINPAY}'></div>");            
            ?>
        </div>
        <div class="g-row">
            <?php
            echo("<div class='g-3'>Есть документы по кредиту <input type='text' value='{$Credit->CRCONTDOCSYN}'></div>");
            echo("<div class='g-3'>Цель кредита: <input type='text' value='{$Credit->CRREASON}'></div>");
            ?>
        </div>
        <div class="g-row">
            <?php
            echo("<div class='g-3'>Кодовое слово <input type='text' value='{$Credit->CRCODEWORD}'></div>");
            echo("<div class='g-3'>Есть ли поручитель: <input type='text' value='{$Credit->CRWARRANTYN}'></div>");
            echo("<div class='g-3'>ФИО поручителя: <input type='text' value='{$Credit->CRWARRANTNAME}'></div>");
            ?>
        </div>
        <div class="g-row">
            <?php
            echo("<p></p><div class='g-3'>Место работы соответствовало документам? <input type='text' value='{$Credit->CRCONTWORKREALYN}'></div>");
            echo("<div class='g-3'>Место работы на момент получения кредита: <input type='text' value='{$Credit->CRWORKORG}'></div>");
            ?>
        </div>
        <div class="g-row">
            <?php
            echo("<div class='g-3'>Каким документом подтверждён доход <input type='text' value='{$Credit->CRINCOMEDOC}'></div>");
            echo("<div class='g-3'>Официальный доход: <input type='text' value='{$Credit->CRINCOMEOFSUM}'></div>");
            echo("<div class='g-3'>Фактический доход: <input type='text' value='{$Credit->CRINCOMEREALSUM}'></div>");
            ?>
        </div>
                                                                                              
    </div>
    
</body>
</html>


