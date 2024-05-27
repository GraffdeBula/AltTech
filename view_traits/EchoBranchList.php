<?php

/**
 * список филиалов для вставки в разные вьюшки
 *
 * @author Andrey
 */
class EchoBranchList {
    public function echoList($SelectedBranch='',$SelectName='BranchName'){
        
        $BranchList=(new Branch())->getBranchList();
        
        echo("<select name='{$SelectName}'>");
        echo("<option value='{$SelectedBranch}'>{$SelectedBranch}</option>");
        foreach($BranchList as $key=>$Branch){
            echo("<option value='{$Branch->BRNAME}'>{$Branch->BRNAME}</option>");
        }
        echo('</select>');
    }
}
