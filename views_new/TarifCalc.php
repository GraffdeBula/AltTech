<?php
/*
 * калькулятор ед тарифа
 *  */
    if (isset($_GET['Tarif'])){
        $Tarif=$_GET['Tarif'];    
    } else {
        $Tarif='';
    }
    if (isset($_GET['AnnNum'])){
        $AnnNum=$_GET['AnnNum'];    
    } else {
        $AnnNum=1;
    }
    if (isset($_GET['CB01'])){
        $CB01='checked=""';    
    } else {
        $CB01='';
    }
    if (isset($_GET['count01'])){
        $count01=$_GET['count01'];    
    } else {
        $count01='';
    }
    if (isset($_GET['CB02'])){
        $CB02='checked=""';    
    } else {
        $CB02='';
    }
    if (isset($_GET['count02'])){
        $count02=$_GET['count02'];    
    } else {
        $count02='';
    }
    if (isset($_GET['CB03'])){
        $CB03='checked=""';    
    } else {
        $CB03='';
    }
    if (isset($_GET['CB04'])){
        $CB04='checked=""';    
    } else {
        $CB04='';
    }
    if (isset($_GET['CB05'])){
        $CB05='checked=""';    
    } else {
        $CB05='';
    }
    if ((isset($_GET['RB01']))&&($_GET['RB01']=='rb01-1')){
        $RB01='checked=""';    
    } else {
        $RB01='';
    }
    if ((isset($_GET['RB01']))&&($_GET['RB01']=='rb01-2')){
        $RB02='checked=""';    
    } else {
        $RB02='';
    }
    if ((isset($_GET['RB01']))&&($_GET['RB01']=='rb01-3')){
        $RB03='checked=""';    
    } else {
        $RB03='';
    }
    if ((isset($_GET['RB01']))&&($_GET['RB01']=='rb01-4')){
        $RB04='checked=""';    
    } else {
        $RB04='';
    }
    
    for ($i = 1; $i <= 16; $i++){
        if (isset($_GET['Dop'.$i])){
            ${'Dop'.$i}='checked=""';
        }else{
            ${'Dop'.$i}='';
        }
    }

?>
<!DOCTYPE html>
<html>

<body>
    <h1>Калькулятор</h1>
    
    <form>
        <div class="row">    
            <div class="col-4">

                <h4>Тариф</h4>

                    <?php
                        (new MyForm('TarifCalcCtrl', 'CountTarif'))->AddForm2();
                    ?>
                    <div>
                        <label>Тариф</label><select name="Tarif">
                            <option value="<?=$Tarif?>"><?=$Tarif?></option>
                            <option value="Оплата сразу">Оплата сразу</option>
                            <option value="Рассрочка">Рассрочка</option>                        
                        </select>
                    </div>    
                    <div>
                        <lable>Срок расрочки (месяцев)</lable><select name="AnnNum">
                            <option value="<?=$AnnNum?>"><?=$AnnNum?></option>
                            <option value="6">6</option>
                            <option value="12">12</option>
                            <option value="18">18</option>
                        </select>
                    </div>

                    <h4>Доплаты</h4>
                    <div >
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox' value='' id='01' name="CB01" <?=$CB01?>>
                            <label class='form-check-label' >Число кредитов</label>
                            <input type='number' value='<?=$count01?>' name='count01'>
                        </div>
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox' value='' id='02' name="CB02" <?=$CB02?>>
                            <label class='form-check-label' >Число сложных кредиторов</label>
                            <input type='number' value='<?=$count02?>' name='count02'>
                        </div>
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox' value='' id='03' name="CB03" <?=$CB03?>>
                            <label class='form-check-label' >Сохранение ипотеки</label>

                        </div>
                    </div>                  

                    <h4>Вычеты</h4>
                    <div >
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox' value='' id='01' name="CB04" <?=$CB04?>>
                            <label class='form-check-label' >Сумма долга до 400 000 руб.</label>

                        </div>
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox' value='' id='02' name="CB05" <?=$CB05?>>
                            <label class='form-check-label' >Простой должник (3 обязательства, нет имущества, нет мошенников)</label>                        
                        </div>
                    </div>
                    <h4>Скидки</h4>
                    <div >
                        <fieldset>
                        <div class='form-check'>
                            <input class='form-check-input' type="radio" value='rb01-1' name="RB01" <?=$RB01?>>
                            <label class='form-check-label' >Клиент имеет инвалидность. Скидка 12000 руб.</label>                        
                        </div>
                        <div class='form-check'>
                            <input class='form-check-input' type="radio" value='rb01-2' name="RB01" <?=$RB02?>>
                            <label class='form-check-label' >Совместное банкротство (супруги). Скидка 9000 </label>                        
                        </div>
                        <div class='form-check'>
                            <input class='form-check-input' type="radio" value='rb01-3' name="RB01" <?=$RB03?>>
                            <label class='form-check-label' >Рекомендация. Скидка 5000</label>                        
                        </div>
                        <div class='form-check'>
                            <input class='form-check-input' type="radio" value='rb01-4' name="RB01" <?=$RB04?>>
                            <label class='form-check-label' >Клиент пенсионер. Скидка 12000</label>                        
                        </div>
                        </fieldset>
                    </div>
                    <hr>
                    <h4>Расчёт тарифа</h4>                
                    <div>        
                        <lable>Платёж при заключении договора</lable><input name='ZeroPay' value="9000">
                    </div>
                    <button class='btn btn-warning'>Рассчитать ежемесячный платёж</button>
                    <div>        
                        <lable>Общая сумма по договору</lable><input id="TarifSum" value="<?=$TarifSum?>">
                    </div>
                    <lable>Ежемесячный платёж</lable><input id="AnnPay" value="<?=$PaySum?>">

            </div>    
            <div class="col-5">
                <h4>Доплаты за риски</h4>
                <select id='MySelect' onchange="MySelectFunction(this.options[this.selectedIndex].value)"> 
                    <option></option>
                    <option value="В связи с не внесением ежемесячных платежей по обязательствам/одному из обязательств есть риск не списания долга по завершении процедуры банкротства из-за недобросовестных действий должника">1. В связи с не внесением ежемесячных платежей по обязательствам/одному из обязательств есть риск не списания долга по завершении процедуры банкротства из-за недобросовестных действий должника</option>
                    <option value="Сделка СУПРУГА по отчуждению имущества может быть признана недействительной и имущество может быть включено в конкурсную массу и реализовано">2. Сделка СУПРУГА по отчуждению имущества может быть признана недействительной и имущество может быть включено в конкурсную массу и реализовано</option>
                    <option value="Сделка БЫВШЕГО СУПРУГА по отчуждению имущества может быть признана недействительной и имущество может быть включено в конкурсную массу и реализовано">3. Сделка БЫВШЕГО СУПРУГА по отчуждению имущества может быть признана недействительной и имущество может быть включено в конкурсную массу и реализовано</option>
                    <option value="Имущество БЫВШЕГО СУПРУГА может быть включено в конкурсную массу и реализовано">4. Имущество БЫВШЕГО СУПРУГА может быть включено в конкурсную массу и реализовано</option>
                    <option value="Имущество СУПРУГА может быть включено в конкурсную массу и реализовано">5. Имущество СУПРУГА может быть включено в конкурсную массу и реализовано</option>
                    <option value="В связи с наличием высокого официального дохода есть риск в процедуре реструктуризации утверждения плана реструктуризации">6. В связи с наличием высокого официального дохода есть риск в процедуре реструктуризации утверждения плана реструктуризации</option>
                    <option value="Имущество может быть включено в конкурсную массу и реализовано">7. Имущество может быть включено в конкурсную массу и реализовано</option>
                    <option value="Сделка по отчуждению имущества может быть признана недействительной и имущество может быть включено в конкурсную массу и реализовано">8. Сделка по отчуждению имущества может быть признана недействительной и имущество может быть включено в конкурсную массу и реализовано</option>
                </select>
                <div id='RiskList'  class="col-4">
                    
                </div>
                
                
                
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' name="Dop9" <?=$Dop9?>>
                    <label class='form-check-label' >
                        По причине предоставления кредитору заведомо ложных сведений при получении кредита правила об освобождении от исполнения обязательств не применяются
                    </label>
                </div><hr>
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' name="Dop10" <?=$Dop10?>>
                    <label class='form-check-label' >
                        Необходимо предоставить договор ГПХ, действующий в период получения кредитов для увеличения дохода
                    </label>
                </div><hr>
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' name="Dop11" <?=$Dop11?>>
                    <label class='form-check-label' >
                        Наличие паев в собственности
                    </label>
                </div><hr>
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' name="Dop12" <?=$Dop12?>>
                    <label class='form-check-label' >
                        Кредиты оформлены единовременно в короткий период (в т.ч. через брокера)/либо кредиты "свежие" взятые в срок до 3х месяцев
                    </label>
                </div><hr>
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' name="Dop13" <?=$Dop13?>>
                    <label class='form-check-label' >
                        Кредит, который планируется списать, был направлены на погашение залогового кредита
                    </label>
                </div><hr>
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' name="Dop14" <?=$Dop14?>>
                    <label class='form-check-label' >
                        В связи с привлечением клиента к ответственности по ряду статей УК/КОАП, есть риск, что правила об освобождении от исполнения обязательств не будут применены
                    </label>
                </div><hr>
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' name="Dop15" <?=$Dop15?>>
                    <label class='form-check-label' >
                        Учитывая трудоспособный возраст Заказчика и отсутствие официального дохода, есть риск введения процедуры реструктуризации долгов
                    </label>
                </div><hr>
                <div class='form-check'>
                    <input class='form-check-input' type='checkbox' name="Dop16" <?=$Dop16?>>
                    <label class='form-check-label' >
                        Не утверждение локального плана реструктуризации в отношении жилого помещения, являющегося единственным жильем и предметом ипотеки в связи с наличием сделок
                    </label>
                </div><hr>
                <div>        
                    <lable>Общая сумма по договору с учётом рисков</lable><input value="<?=$TarifExSum?>">
                </div>
                <lable>Ежемесячный платёж с учётом рисков</lable><input value="<?=$PayExSum?>">
            </div>
        </div>
    </form>
    <script src="./js/TarifCalc.js"></script>
</body>
    
</html>
             