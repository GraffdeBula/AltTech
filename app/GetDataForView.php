<?php

/**
 * класс для получения данных при выводе на страницу
 *
 * @author Andrey
 */
class GetDataForView {
            
    public function getData($DataName){
        switch ($DataName){
            case 'BranchList':
                return (new Branch())->getBranchList();
        }
            
    }
}
