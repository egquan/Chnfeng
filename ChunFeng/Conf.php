<?php
/**
 * 框架配置文件加载类
 * Created by PhpStorm.
 * User: 860646000@qq.com
 * Date: 2019/10/10
 * Time: 21:34
 */

namespace ChunFeng;
class Conf
{
    private static $configMap = [];

    /**
     * 加载配置键
     * @param $name
     * @param $file
     * @return mixed
     * @throws \Exception
     */
    public static function get($name, $file)
    {
        if (isset(self::$configMap[$file])) {
            return self::$configMap[$file][$name];
        } else {
            $path = CHUNFENG . '/config/' . $file . '.php';
            if (is_file($path)) {
                $config = include $path;
                self::$configMap[$file] = $config;
                if(isset($config[$name])){
                    return $config[$name];
                }else{
                    throw new \Exception('找不到配置项'.$name.' 请检查 '.$file. '配置文件');
                }
            }
            throw new \Exception('找不到配置文件' . $path);
        }
    }

    public static function all($file)
    {
        if (isset(self::$configMap[$file])) {
            return self::$configMap[$file];
        } else {
            $path = CHUNFENG . '/config/' . $file . '.php';
            if (is_file($path)) {
                $config = include $path;
                self::$configMap[$file] = $config;
                return $config;
            }
        }
        throw new \Exception('找不到配置文件' . $path);
    }
}