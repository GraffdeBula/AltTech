<?php
/*
 *  точка входа для печати договора
 *  запускает AdminController
 */
header('Content-Type: text/html; charset=utf8');
//подключение моего автолоадера
include_once "{$_SERVER['DOCUMENT_ROOT']}/AltTech/services/autoloader.php";
echo($_SERVER['DOCUMENT_ROOT']);
#spl_autoload_register([new autoloader(), 'getClass']);

//подключение composer
#require_once "{$_SERVER['DOCUMENT_ROOT']}/AltTech/vendor/autoload.php";

//запуск обработчика ошибок WHOOPS
#$whoops = new \Whoops\Run;
#$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
#$whoops->register();

//сначала проверим hash
#(new Hash())->CheckHash($_GET['hash']);
#$WebChecker=new WebChecker();
#$WebChecker->CheckHash();

#(new AdminMainController())->run();
echo('Everything is OK 4');
