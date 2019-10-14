<?php
/**
 * 框架路由类
 * Created by PhpStorm.
 * User: 860646000@qq.com
 * Date: 2019/10/6
 * Time: 20:59
 */
namespace ChunFeng;

class Route
{
    public $ctrl;
    public $action;

    public function __construct()
    {
        if (isset($_SERVER['REDIRECT_URL']) && $_SERVER['REDIRECT_URL'] != '/') {
            $path = $_SERVER['REDIRECT_URL'];
            $patharr = explode('/', trim($path, '/'));
            if (isset($patharr[0])) {
                $this->ctrl = $patharr[0];
                unset($patharr[0]);
            }
            if (isset($patharr[1])){
                $this->action = $patharr[1];
                unset($patharr[1]);
            }else{
                $this->action = conf::get('ROUTE','config')['DEFAULT_CTRL'];
            }
            $count = count($patharr)+2;
            $i = 2;
            while ($i < $count){
                if (isset($patharr[$i +1])) {
                    $_GET[$patharr[$i]] = $patharr[$i + 1];
                }
                $i =$i + 2;
            }
        } else {
            $this->ctrl = Conf::get('ROUTE','config')['DEFAULT_CTRL'];
            $this->action = Conf::get('ROUTE','config')['DEFAULT_ACTION'];
        }

    }
}