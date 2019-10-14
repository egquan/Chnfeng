<?php
/**
 * 框架公共函数库
 * Created by PhpStorm.
 * User: 860646000@qq.com
 * Date: 2019/10/6
 * Time: 20:34
 */
function p($var)
{
    if (is_bool($var)) {
        var_dump($var);
    } elseif (is_null($var)) {
        var_dump($var);
    } else {
        echo "<pre style ='position:relative;z-index: 1000;padding: 10px;border-radius: 5px;background: #F5F5F5;border: 1px solid #aaa;font-size: 14px;line-height: 18px;opacity: 0.9;'>" . print_r($var, true) . "</pre>";
    }
}