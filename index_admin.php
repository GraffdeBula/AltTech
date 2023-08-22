<?php
/*
 *  точка входа для печати договора
 *  запускает AdminController
 */
header('Content-Type: text/html; charset=utf8');
//подключение моего автолоадера
include_once "{$_SERVER['DOCUMENT_ROOT']}/AltTech/app/autoloader.php";
spl_autoload_register([new autoloader(), 'getClass']);

//подключение composer
require_once "{$_SERVER['DOCUMENT_ROOT']}/AltTech/vendor/autoload.php";

#подключение библиотеки PHPExcel
#include_once "{$_SERVER['DOCUMENT_ROOT']}/AltTech/PHPExcel.php";
#include_once "{$_SERVER['DOCUMENT_ROOT']}/AltTech/PHPExcel/Writer/Excel5.php";

//запуск обработчика ошибок WHOOPS
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

//сначала проверим hash
(new SessionChecker())->checkSession();

(new AdminMainController())->run();

