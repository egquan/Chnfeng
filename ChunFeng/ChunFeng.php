<?php
/**
 * 框架核心文件
 * Created by PhpStorm.
 * User: 860646000@qq.com
 * Date: 2019/10/6
 * Time: 20:53
 */

namespace core;

class ChunFeng
{
    public static $classMap = [];

    /**
     * Run
     */
    public static function run()
    {
        $route = new \ChunFeng\Route();
        $ctrlClass = $route->ctrl;
        $action = $route->action;
        $ctrlClass = APP_CTRL.'\\'.$ctrlClass.'Ctrl';
        $ctrl = new $ctrlClass();
        return $ctrl->$action();
    }

    /**
     * 自动加载
     * @param $class
     * @return bool
     * @throws \Exception
     */
    public static function load($class)
    {
        if (isset(self::$classMap[$class])) {
            return true;
        } else {
            $class = str_replace('\\', '/', $class);
            $file = CHUNFENG .'/'. $class . '.php';
            if (is_file($file)) {
                include $file;
                self::$classMap[$class] = $class;
                return true;
            } else {
                throw  new \Exception('找不到类文件'.$class);
            }
        }
    }
}