<?php
/**
 * класс для выгрузки отчётов в эксель
 *
 * @author Andrey
 */
class RepToExcel {
    public function exportReport($Data=[],$Names=[],$Title,$File){
        $xls = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $xls->setActiveSheetIndex(0);
        $sheet = $xls->getActiveSheet();
        $sheet->setTitle($Title);
        $i=1;
        foreach($Names as $Cell=>$Name){
            $sheet->setCellValue($Cell, $Name);
            $i++;
        }        
     
        $i=3;
        foreach ($Data as $reprow){
            $j=1;
            foreach ($reprow as $repfield){
                $sheet->setCellValueByColumnAndRow($j,$i,$repfield);
                $j++;
            }            
            $i++;
        }
        //create file name  
        $FileName="{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/downloads/{$File}.xlsx";
        //вывод в файл и сохранение
        $objWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($xls);
        $objWriter->save($FileName);
    }
}
