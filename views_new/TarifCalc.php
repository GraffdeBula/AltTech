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
    if ((isset($_GET['Sum04']))&&($_GET['Sum04']!='')){
        $Sum04=$_GET['Sum04'];           
    } else {
        $Sum04='';        
    }
    
    for ($i = 1; $i <= 30; $i++){
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
                            <option value="24">24</option>
                        </select>
                    </div>

                    <h4>Доплаты</h4>
                    <div >
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox' value='' id='01' name="CB01" <?=$CB01?>>
                            <label class='form-check-label' >Число кредитов/обязательств</label>
                            <input type='number' value='<?=$count01?>' name='count01'>
                        </div>
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox' value='' id='02' name="CB02" <?=$CB02?>>
                            <label class='form-check-label' >Число сложных кредиторов</label>
                            <input type='number' value='<?=$count02?>' name='count02'>
                        </div>
                        <div class='form-check'>
                            <input class='form-check-input' type='checkbox' value='' id='03' name="CB03" <?=$CB03?>>
                            <label class='form-check-label' >Доплата за сохранение ипотеки</label>
                            <input type='number' id='Sum04' name='Sum04' value='<?=$Sum04?>' placeholder='от 100 000'>

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
            </div>   
            <div class="col-5">
                <h4>Доплаты за риски</h4>
                
                <div id='RiskList' class="col-12">
                    <?php
                        $i=0;
                        foreach($ExpertDr as $Risk){                            
                            $i++;
                            $Sum='';
                            $Val='';                            
                            if ((isset($_GET['CheckSum'.$i]))&&($_GET['CheckSum'.$i]!=0)){
                                $Sum=$_GET['CheckSum'.$i];
                                $Val="checked=''";                                
                            }                            
                            echo("<div class='form-check'>");
                            echo("<input class='form-check-input' type='checkbox' value='' id='CBR".$i."' name='CBR".$i."' ".$Val.">");
                            echo($Risk->DRVALUE);
                            echo("<br><input type='number' id='CheckSum".$i."' name='CheckSum".$i."' value='".$Sum."' placeholder='от ".$Risk->DRVALUECOST."'>");
                            echo("</div>");
                            echo("<hr>");
                        }
                    ?>
                </div>
            </div>
        </div>    
        <div class="row">
            <div class="col-4">                
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
                <h4>Расчёт тарифа с рисками</h4>      
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
             