<?php
/*
 * калькулятор ед тарифа
 *  */

?>
<!DOCTYPE html>
<html>

<body>
    <h1>Калькулятор</h1>
    <div class="row">    
        <div class="col-4">

            <h4>Тариф</h4>
            <div id="TarifList0">

            </div>    
            <div>
                <lable>Срок расрочки (месяцев)</lable><select id="AnnNum">
                    <option></option>
                    <option>6</option>
                    <option>12</option>
                    <option>18</option>
                </select>
            </div>

            <h4>Доплаты</h4>
            <div id="TarifList1">
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' value='' id='01' onchange='getSum(1,9000,"01",1)'>
                    <label class='form-check-label' for='01'>Число кредитов 9000 рублей за каждые 10</label>
                    <input type='number' value=1 id='count01'>
                </div>
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' value='' id='02' onchange='getSum(1,9000,"02",1)'>
                    <label class='form-check-label' for='02'>Сложный кредитор 9000 рублей за каждого</label>
                    <input type='number' value=1 id='count02'>
                </div>
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' value='' id='03' onchange='getSum(1,100000,"03",1)'>
                    <label class='form-check-label' for='03'>Сохранение ипотеки 100000 рублей</label>
                    <input type='number' value=1 id='count03'>
                </div>
            </div>                  

            <h4>Вычеты</h4>
            <div id="TarifList2">

            </div>
            <h4>Скидки</h4>
            <div id="TarifList3">

            </div>
            <hr>
            <h4>Расчёт тарифа</h4>
            <div>        
                <lable>Общая сумма по договору</lable><input id="TarifSum" value="0">
            </div>
            <div>        
                <lable>Платёж при заключении договора</lable><input value="9000">
            </div>
            <button class='btn btn-warning' onclick='CountAnnPay()'>Рассчитать ежемесячный платёж</button>
            <lable>Ежемесячный платёж</lable><input id="AnnPay" value="0">
        </div>    
        <div class="col-4">
            <h4>Доплаты</h4>
        </div>
    </div>
</body>
    <script src="./js/TarifCalc.js"></script>
</html>
             