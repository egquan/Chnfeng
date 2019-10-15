<?php
/**
 * Created by PhpStorm.
 * User: 860646000@qq.com
 * Date: 2019/10/13
 * Time: 18:23
 */
namespace app\model;
use ChunFeng\base\Model;

//需要链接数据库 以及实现查询方法必须继承 Model 基类
class User extends Model
{
	//继承Model 必须实现此方法;
    public static function tableName()
    {
    	// return 数据表名
        return 'user';
    }

}