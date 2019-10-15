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
//控制器需要用到视图时 必须继承 控制器基类
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
	    //User::querySql('SELECT * FROM user WHERE id >=  600 ORDER BY id DESC LIMIT 20')->fetchAll();
	    $datas = [
	    	'0' =>[
	    		'id' => 1,
			    'username' => 'admin',
			    'passwd' => '123456'
		    ],
		    '1' =>[
			    'id' => 1,
			    'username' => 'admin',
			    'passwd' => '123456'
		    ],
		    '2' =>[
			    'id' => 1,
			    'username' => 'admin',
			    'passwd' => '123456'
		    ]

	    ];

	    //$this->assign('data','Hello World');
	    //$this->display('index/index.html');
	    $data = 'Hello World I am ChunFengMini PHP Framework';

	    //render 第一个参数为视图文件路径 根目录为 app/views
	    //第二个参数为数据 格式为array 键为视图调用的变量明  值为数据
	    return $this->render('index/index.php',['data' =>$data,'datas' =>$datas]);

    }
}