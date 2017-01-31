<?php
define('IN_PRODUCTION', true);
define('PRODUCTION_ROOT', dirname(dirname(dirname(__FILE__))));
define('SYSTEM_VAR', PRODUCTION_ROOT . '/var/');

//应用配置
define('APP_NAME', 'Test'); // 配置是哪个实例
define('APP_PATH', PRODUCTION_ROOT . '/App/' . APP_NAME); // 配置实例的APP路径

//数据库配置
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '123456');
define('DB_CHARSET', 'utf8');

//一些常用的配置
defined('SYSTEM_HOST') || define('SYSTEM_HOST', 'localhost');
// 调试模式
define('IS_DEBUGGING' , $_SERVER['SERVER_NAME'] != SYSTEM_HOST || strpos($_SERVER['SERVER_NAME'], "test") !== false );
// 生产状态
define('IS_PRODUCTION', $_SERVER['SERVER_NAME'] == SYSTEM_HOST );

if(!IS_DEBUGGING){
    error_reporting(0);
    ini_set("display_errors", 0);
}else{
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    
}

require_once(PRODUCTION_ROOT . '/init.php');

ZF::setNameSpace(APP_PATH);                #注册后台应用
ZF::setNameSpace(PRODUCTION_ROOT . '/Libs');#注册类库
ZF::setNameSpace(PRODUCTION_ROOT . '/Db');#注册数据库链接类
ZF::setNameSpace(PRODUCTION_ROOT . '/Helper');#助手实例
ZF_Controller_Front::run();