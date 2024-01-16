<?php
/**
 * Description of amoLeads
 *
 * @author Andrey
 */
class amoLeads {
    public $amoLead=[]; //весь массив из амо
    public $amoLeadName=''; //имя
    public $amoLeadId=''; //id
    public $amoLeadNewInfo=[]; //массив для изменения сделки
    
    public function __construct(){
    
    }
    
    public function setVar($name,$value){ //сеттер для свойств объекта
        $this->{$name}=$value;
    }
    
    public function getName(){        
        (new logger)->logToFile('запуск вэбхука');
        $this->amoLeadId=$this->amoLead['_embedded']['items'][0]['id'];
        $this->amoLeadName=$this->amoLead['_embedded']['items'][0]['name'];        
    }
    
    public function updateLead(){                
        (new amoTools)->updLead($this->amoLeadId, $this->amoLeadNewInfo);
    }
    
    public function addTag($TagName){
        (new amoTools)->addTag($this->amoLeadId, $TagName);
    }
    
    public function addPromo($Code){
        (new amoTools)->addPromo($this->amoLeadId, $Code);
        #$tmp=(new amoTools)->addPromo($this->amoLeadId, $Code);
        #var_dump($tmp);
    }
    
    public function checkName($SubStr){
        $pos= strpos($this->amoLeadName, $SubStr);//"utm_source=inst"
        
        if($pos){            
        
            return TRUE;            
        }
        else {
        
            return FALSE;            
        }
    } 
        
}
