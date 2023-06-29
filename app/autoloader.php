<?php
//echo('я крутецкий автолоадер');
/**
 * Description of autoloader
 *  функция для автоматичемской подгрузки классов
 * @author Andrey
 */
define('CONFIG_ROOT', __DIR__);
define('UPPER_ROOT', dirname(CONFIG_ROOT));

class autoloader {
    protected $paths=[        
        UPPER_ROOT.'/app',
        UPPER_ROOT.'/app/service',
        UPPER_ROOT.'/infrastructure',
        UPPER_ROOT.'/domain',
        
        UPPER_ROOT.'/functions',        
        UPPER_ROOT.'/traits',        
        UPPER_ROOT.'/amo',
        
        UPPER_ROOT.'/controllers_new',        
        UPPER_ROOT.'/controllers_new/app',        
        UPPER_ROOT.'/controllers_new/dr',        
        UPPER_ROOT.'/controllers_new/reports',
        UPPER_ROOT.'/controllers_new/transfer',
        
        UPPER_ROOT.'/controllers',
                        
        UPPER_ROOT.'/models',
        UPPER_ROOT.'/models/reports',
        UPPER_ROOT.'/models/transfer',
        UPPER_ROOT.'/dto',
                
    ];
    
    public function getClass($className){
        
        foreach($this->paths as $path){
            //echo("<br>ищем в  {$path}");
            $fileName="{$path}/{$className}.php";            
            if (file_exists($fileName)){
                //echo("<br> нашли {$className} в {$fileName}");
                include $fileName;                
                //echo("<br> подключили {$fileName}");
                break;
            } else {
                //echo("<br> не подключили {$fileName}");
            }
        }
    }
}
