<?php
/**
 * 框架入口文件
 * Created by PhpStorm.
 * User: 860646000@qq.com
 * Date: 2019/10/6
 * Time: 20:11
 */
//根目录
define('CHUNFENG',__DIR__);
//框架核心文件
define('CORE',CHUNFENG.'/ChunFeng');
// App目录
define('APP',CHUNFENG.'/app');
//开启错误显示
define('DEBUG',true);
//Controller 命名空间前缀
define('APP_CTRL','\app\ctrl');

if (DEBUG){
    ini_set('display_errors','On');
}else{
    ini_set('display_errors','Off');
}
require CHUNFENG . '/vendor/autoload.php';
//加载函数库
require CORE.'/common/function.php';
//加载核心文件
require CORE.'/ChunFeng.php';
//自动加载
spl_autoload_register('\core\ChunFeng::load');

\core\ChunFeng::run();
