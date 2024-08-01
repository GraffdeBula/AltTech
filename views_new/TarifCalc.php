<?php
/*
 * калькулятор ед тарифа
 *  */

?>
<!DOCTYPE html>
<html>

<body>
    <h1>Калькулятор</h1>
    
    <div>        
        <lable>Общая сумма по договору</lable><input id="TarifSum" value="0">
    </div>
    <div>        
        <lable>Платёж при заключении договора</lable><input value="9000">
    </div>
    <div>
        <lable>Срок расрочки (месяцев)</lable><select id="AnnNum">
            <option>1</option>
            <option>6</option>
            <option>12</option>
            <option>18</option>
        </select>
        <lable>Ежемесячный платёж</lable><input id="AnnPay" value="0">
        <button class='btn btn-warning' onclick='CountAnnPay()'>Рассчитать</button>
    </div>
    <h4>Тариф</h4>
    <div id="TarifList0">
        
    </div>                  
    <h4>Доплаты</h4>
    <div id="TarifList1">
        
    </div>                  
    <h4>Вычеты</h4>
    <div id="TarifList2">
        
    </div>
    <h4>Скидки</h4>
    <div id="TarifList3">
        
    </div>
    
</body>
    <script src="./js/TarifCalc.js"></script>
</html>
             