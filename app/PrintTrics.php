<?php

/**
 * LEGACY
 * старый сервис для печати договоров (из Клиента1)
 * Description of PrintTrics
 *
 * @author Andrey
 */
class PrintTrics{
    protected $MyDocument;
    protected $MyTable;

    public function GetTemplate ($TemplName){//открывает шаблон с переданным именем
        $this->MyDocument=new \PhpOffice\PhpWord\TemplateProcessor("{$_SERVER['DOCUMENT_ROOT']}/AltTech/templates/{$TemplName}.docx");        
    }
    
    public function SaveDoc($DocName){//сохраняет документ с переданными именем
        $this->MyDocument->saveAs("{$_SERVER['DOCUMENT_ROOT']}/AltTech/documents/{$DocName}");
    }
    
    public function PasteData($BookMark,$Data){//выбирает, какой метод вставки использовать
        if ($BookMark->BMCHANGE==2){ //вызов вставки с параметром
            $this->PasteDataParam($BookMark->BMNAME,$Data,$BookMark->BMCHECKDATA,$BookMark->BMINSDATA);
        } elseif ($BookMark->BMCHANGE==1){ //вызов вставки даты (преобразование из строки)
            $this->PasteDataSimple($BookMark->BMNAME,$this->StrToDate($Data));
        } elseif ($BookMark->BMCHANGE==3){ //вызов вставки числа (суммы) прописью           
            $this->PasteDataSimple($BookMark->BMNAME,$this->SumStr($Data));
        } elseif ($BookMark->BMCHANGE==4){ //вызов вставки таблицы            
            $this->PasteTable($BookMark->BMNAME,$Data);
        } else { //вызов обычной вставки
            $this->PasteDataSimple($BookMark->BMNAME,$Data);
        }
    }
    
    protected function PasteDataSimple($BookMark,$Data){// простая вставка данных       
        $this->MyDocument->setValue($BookMark, $Data);        
    }
    
    protected function PasteDataParam($BookMark,$Data,$CheckData,$InsData){//вставка данных с параметром (какие-то фиксированные данные, в зависимости от данных в таблице        
        if ($Data===$CheckData){
            $this->MyDocument->setValue($BookMark, $InsData);        
        }
    }
    
    protected function StrToDate($StrDate){
        $day=substr($StrDate,8,2); //день начала периода
        $month=substr($StrDate,5,2); //месяц начала периода
        $year=substr($StrDate,0,4);
        return $day.'.'.$month.'.'.$year;
    }
    
    protected function PasteTable($BookMark,$Data){
        
        $this->MyTable = new \PhpOffice\PhpWord\Element\Table(array('borderSize'=>10,'borderColor'=>'black'));        
        $this->MyTable->addRow();            
        $this->MyTable->addCell(1500)->addText('Дата');            
        $this->MyTable->addCell(1500)->addText('СУММА');
        foreach($Data as $Row){        
            $this->MyTable->addRow();            
            $this->MyTable->addCell(1500)->addText($this->StrToDate($Row->PAYDAT));            
            $this->MyTable->addCell(1500)->addText($Row->PAYSUM);            
        } 
        $this->MyDocument->setComplexBlock($BookMark, $this->MyTable);        
    }


    public function SumStr($SumFloat){
        // обозначаем словарь в виде статической переменной функции, чтобы 
	// при повторном использовании функции его не определять заново
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
			if($mod1=$part%100) {
				$mod2 = $part%10;
				$flag = $i==1 && $mod1!=11 && $mod1!=12 && $mod2<3 ? -1 : 1;
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
			
			// объединяем составные числа в единый текст и добавляем в переменную, которую вернет функция
			array_unshift($string, join(' ', $digits));
		}
	}
	
	// преобразуем переменную в текст и возвращаем из функции, ура!
	return join(' ', $string);
    }
}
