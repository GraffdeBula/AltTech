<?php
/**
 * ###тестовый контроллер для мед статистики
 *
 * функции
 * # чтение страницы с таблицами
 * 
 */
class MedTest1 extends ControllerMain {
    
    public function actionGetWord(){
        $source = $_SERVER['DOCUMENT_ROOT']."/AltTech/medicine/udmurt2.docx";
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
        $phpWord = $objReader->load($source);
        
        $i=0;
        foreach($phpWord->getSections() as $section) {
                $arrays = $section->getElements();
                $body='';
                foreach($arrays as $e) {
                        if(get_class($e) === 'PhpOffice\PhpWord\Element\TextRun') {
                            
                        }

                        else if(get_class($e) === 'PhpOffice\PhpWord\Element\TextBreak') {
                                
                        }

                        else if(get_class($e) === 'PhpOffice\PhpWord\Element\Table') {
                                $body .= '<table border="2px">';
                                $i++;
                                
                                #var_dump($e);
                                #echo("<br>===========================<br>".$i);
                                
                                $rows = $e->getRows();
                                
                                foreach($rows as $row) {
                                        $body .= '<tr>';

                                        $cells = $row->getCells();
                                        foreach($cells as $cell) {
                                                $body .= '<td style="width:'.$cell->getWidth().'">';
                                                $celements = $cell->getElements();
                                                foreach($celements as $celem) {
                                                        if(get_class($celem) === 'PhpOffice\PhpWord\Element\Text') {
                                                                $body .= $celem->getText();
                                                        }

                                                        else if(get_class($celem) === 'PhpOffice\PhpWord\Element\TextRun') {
                                                                foreach($celem->getElements() as $text) {
                                                                    var_dump($text);
                                                                    #echo("<br>===========================<br>".$i);
                                                                    exit();
                                                                    try{                                                                        
                                                                        $body .= $text->getText();
                                                                    }
                                                                    catch (\Exception $e) {
                                                                        $body .= '';
                                                                    }
                                                                }
                                                        }
                                                }	
                                                $body .= '</td>';
                                        }

                                        $body .= '</tr>';
                                }
                                
                                #$body .= '</table>';
                                if ($i==1) {
                                    break;
                                    
                                }
                        }
                        else {
                                
                        }
                }
            
        }
        echo("<br>===========================<br>".$i);
        var_dump($body);
        
    }
}

