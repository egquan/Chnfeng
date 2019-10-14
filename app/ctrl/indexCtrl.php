<?php
/**
 * Created by PhpStorm.
 * User: 860646000@qq.com
 * Date: 2019/10/6
 * Time: 21:50
 */
namespace app\ctrl;

use app\model\User;
use ChunFeng\base\Ctrl;

class indexCtrl extends Ctrl
{
    public function index()
    {
    	//插入数据
	    // User::insert(['username' => 'xiaogang','passwd' => '123456']);

	    //查询数据
	    //User::query('id,username,passwd','id >= 600 LIMIT 10');

	    //更新数据
	    //User::update(['username' => 'Xiaogang'],'id = 1');

	    //删除数据
	    //User::delete('id > 645');

	    //执行SQL语句 返回影响条数 不会从一条 SELECT 语句中返回结果
	    //User::execSql('UPDATE user SET passwd = 88886666 WHERE id > 640');
	    //SQL查询
	    $datas = User::querySql('SELECT * FROM user WHERE id >=  630 LIMIT 10')->fetchAll();

	    //$this->assign('data','Hello World');
	    //$this->display('index/index.html');
	    $data = 'Hello World';
	    //$datas = 'Hello World2';
	    $this->render('index/index.html',['data' =>$data,'datas' =>$datas]);

    }
}