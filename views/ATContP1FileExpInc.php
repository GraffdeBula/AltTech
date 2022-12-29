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
                    <p>ДОП ВКЛАДКА: ДОХОДЫ КЛИЕНТА</p>
                </h3>   
            </div>
        </div>
        <div class="g-row">
            <?php
            echo("<p>ФИО Клиента: {$Client->CLFNAME} {$Client->CL1NAME} {$Client->CL2NAME}</p>");
            ?>
        </div>
        
                                                                              
    </div>
    
</body>
</html>

