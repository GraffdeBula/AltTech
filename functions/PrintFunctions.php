<?php

/**
 * функеции для нестандартного вывода данных
 *
 * @author Andrey
 */
class PrintFunctions {
    public function CredList($ContCode){
        $List=(new CreditorsMod)->getCredAll($ContCode);
        $CredList='';
        foreach($List as $Key => $Name){
            if ($Key==0){
                $CredList=$Name->CRBANKCURNAME;
            } else {
                $CredList=$CredList.', '.$Name->CRBANKCURNAME;
            }
        }
        return $CredList;
    }
    
    
    public function Discounts($Bookmark,$CredSum,$TrPac,$Period,$ContSum){
        $Tarif=(new Pacs)->getTarifByName($TrPac, $CredSum);
       
        $TarSums=(new Pacs)->getTarifByPeriod($Tarif->TRCOMMENT, $CredSum, $Period);
                
        $qryPeriod=3;
        if ($Bookmark=='DISCOUNT18'){$qryPeriod=18;}
        if ($Bookmark=='DISCOUNT12'){$qryPeriod=12;}
        if ($Bookmark=='DISCOUNT6'){$qryPeriod=6;}
        if ($Bookmark=='DISCOUNT3'){$qryPeriod=3;}
        if ($Bookmark=='DISCOUNT1'){$qryPeriod=1;}
        
        $TarSums=(new Pacs)->getTarifByPeriod($Tarif->TRCOMMENT, $CredSum, $qryPeriod);
        (new logger)->logToFile($Bookmark.$CredSum.$TrPac.$Period.$ContSum);
        if (isset($TarSums->TRSUMFIX)){
            $DISCSUM=$ContSum-$TarSums->TRSUMFIX;
            $TOTSUM=$TarSums->TRSUMFIX;
            
            if ($qryPeriod==1){
                $Discount="Стороны согласовали, что если Заказчик оплачивает всю стоимость услуг Исполнителя в течение 30 дней с момента подписания Договора, "
                    . "то Заказчику предоставляется скидка на услуги Исполнителя в размере {$DISCSUM} руб. от стоимости услуг Исполнителя, указанной в п. 4.1 "
                    . "настоящего Договора, в этом случае стоимость услуг Исполнителя с учётом скидки составит {$TOTSUM} руб";                
            } else {
                $Discount="Стороны согласовали, что если Заказчик оплачивает всю стоимость услуг Исполнителя в течение {$qryPeriod} месяцев с момента подписания Договора, "
                    . "то Заказчику предоставляется скидка на услуги Исполнителя в размере {$DISCSUM} руб. от стоимости услуг Исполнителя, указанной в п. 4.1 "
                    . "настоящего Договора, в этом случае стоимость услуг Исполнителя с учётом скидки составит {$TOTSUM} руб";            
            }
            
            (new logger)->logToFile($Discount);
            if ($qryPeriod<$Period){
                return $Discount;
            } else {
                return ' ';
            }
        } else return ' ';
    }
    
    public function DateToStr($Date){
        return substr($Date,8,2).".".substr($Date,5,2).".".substr($Date,0,4);
    }
    
    public function SumToStr($SumFloat){
        static $dic = array(
	
		// словарь необходимых чисел
		array(
			-2	=> 'две',
			-1	=> 'одна',
			1	=> 'один',
			2	=> 'два',
			3	=> 'три',
			4	=> 'четыре',
			5	=> 'пять',
			6	=> 'шесть',
			7	=> 'семь',
			8	=> 'восемь',
			9	=> 'девять',
			10	=> 'десять',
			11	=> 'одиннадцать',
			12	=> 'двенадцать',
			13	=> 'тринадцать',
			14	=> 'четырнадцать' ,
			15	=> 'пятнадцать',
			16	=> 'шестнадцать',
			17	=> 'семнадцать',
			18	=> 'восемнадцать',
			19	=> 'девятнадцать',
			20	=> 'двадцать',
			30	=> 'тридцать',
			40	=> 'сорок',
			50	=> 'пятьдесят',
			60	=> 'шестьдесят',
			70	=> 'семьдесят',
			80	=> 'восемьдесят',
			90	=> 'девяносто',
			100	=> 'сто',
			200	=> 'двести',
			300	=> 'триста',
			400	=> 'четыреста',
			500	=> 'пятьсот',
			600	=> 'шестьсот',
			700	=> 'семьсот',
			800	=> 'восемьсот',
			900	=> 'девятьсот'
		),
		
		// словарь порядков со склонениями для плюрализации
		array(
                        array('', '', ''),
			array('рубль', 'рубля', 'рублей'),
			array('тысяча', 'тысячи', 'тысяч'),
			array('миллион', 'миллиона', 'миллионов')			
		),		
		// карта плюрализации
		array(
			2, 0, 1, 1, 1, 2
		)
	);
	
	// обозначаем переменную в которую будем писать сгенерированный текст
	$string = array();
	
	// дополняем число нулями слева до количества цифр кратного трем,
	// например 1234, преобразуется в 001234
	$SumFloat = str_pad($SumFloat, ceil(strlen($SumFloat)/3)*3, 0, STR_PAD_LEFT);
	
	// разбиваем число на части из 3 цифр (порядки) и инвертируем порядок частей,
	// т.к. мы не знаем максимальный порядок числа и будем бежать снизу
	// единицы, тысячи, миллионы и т.д.
	$parts = array_reverse(str_split($SumFloat,3));

	// бежим по каждой части
	foreach($parts as $i=>$part) {
		
            // если часть не равна нулю, нам надо преобразовать ее в текст
            if($part>0) {

                // обозначаем переменную в которую будем писать составные числа для текущей части
                $digits = array();

                // если число треххзначное, запоминаем количество сотен
                if($part>99) {
                    $digits[] = floor($part/100)*100;
                }

                // если последние 2 цифры не равны нулю, продолжаем искать составные числа
                // (данный блок прокомментирую при необходимости)
                if($mod1=$part%100) { //mod1 - остаток от деления на 100, mod2 - единицы                   
                    $mod2 = $part%10;                    
                    $flag = $i==1 && $mod1!=11 && $mod1!=12 && $mod2<3 && $mod2>0 ? -1 : 1;
                    #echo($flag);
                    #exit();
                    if($mod1<20 || !$mod2) {
                        $digits[] = $flag*$mod1;
                    } else {
                        $digits[] = floor($mod1/10)*10;
                        $digits[] = $flag*$mod2;
                    }
                }

                // берем последнее составное число, для плюрализации
                $last = abs(end($digits));

                // преобразуем все составные числа в слова
                foreach($digits as $j=>$digit) {
                    $digits[$j] = $dic[0][$digit];
                }

                // добавляем обозначение порядка или валюту
                
                $digits[] = $dic[1][$i][(($last%=100)>4 && $last<20) ? 2 : $dic[2][min($last%10,5)]];
                $j=array_key_last($digits);
                if (($digits[$j]=='тысяча')&&($digits[$j-1]=='один')){
                    $digits[$j-1]='одна';
                }
                if (($digits[$j]=='тысячи')&&($digits[$j-1]=='два')){
                    $digits[$j-1]='две';
                }
                // объединяем составные числа в единый текст и добавляем в переменную, которую вернет функция
                array_unshift($string, join(' ', $digits));
            }
	}
	
	// преобразуем переменную в текст и возвращаем из функции, ура!
	return join(' ', $string);
    }
}

