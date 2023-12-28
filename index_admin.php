<?php
/*
 *  точка входа для печати договора
 *  запускает AdminController
 */
header('Content-Type: text/html; charset=utf8');
//подключение настроек
include_once "app/Settings.php";

//подключение моего автолоадера
include_once "{$_SERVER['DOCUMENT_ROOT']}/".WORK_FOLDER."/app/autoloader.php";
spl_autoload_register([new autoloader(), 'getClass']);

//подключение composer
require_once "{$_SERVER['DOCUMENT_ROOT']}/AltTech/vendor/autoload.php";

//запуск обработчика ошибок WHOOPS
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

//сначала проверим hash
(new SessionChecker())->checkSession();

(new AdminMainController())->run();

