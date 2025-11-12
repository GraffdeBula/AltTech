<?php

/* 
 * настройки для работы приложения
 */
#define('WORK_FOLDER','AltTech');
define('WORK_FOLDER','AltTest');

#define('VIEW_BACKGROUND','#f0e3c5');
define('VIEW_BACKGROUND','#c4e4ff'); //test version

#define('DB_NAME_MAIN','firebird:dbname=localhost:atdatabase');
define('DB_NAME_MAIN','firebird:dbname=localhost:fbtest2');
#define('DB_NAME_RES','firebird:dbname=192.168.154.252:clientres');

define('CONFIG_ROOT', __DIR__);
define('UPPER_ROOT', dirname(CONFIG_ROOT));
define('DBSETTINGS_ROOT',dirname(dirname($_SERVER['DOCUMENT_ROOT'])).'/dbsettings/DBSettings.php');

/* подключение файла с настройками БД
 */
include DBSETTINGS_ROOT;