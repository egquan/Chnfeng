## Chunfeng 1.0

ChunFeng 是一个PHPMini微框架 结构简单易用，实现了简单的MVC,SPL类的自动加载 基于Pdo驱动开发，在不用修改代码的情况下支持所有数据库，已加入Compose支持。



## 开发环境
PHP 7.3


Apache

Mysql 8.0

##目录结构
入口文件 index

应用目录 /app  控制器 模型 视图目录

配置文件目录 /config

框架核心目录 /ChunFeng

Composer库目录 /vendor

##使用说明
###控制器
编写控制器(Ctrl)时 控制器必须加 Ctrl后缀，文件名格式为 控制器名+Ctrl.php， 如果需要渲染视图文件必须继承Ctrl基类，详情在Index控制器里有说明！

###模型
编写Model 如果需要连接数据库必须继承Model基类， 并实现 tableName 静态方法， 详情请看Use模型文件。

##模型 数据库操作方法
###必须继承Model基类  并实现 tableName 静态方法！

    	//插入数据
	     User::insert(['username' => 'xiaogang','passwd' => '123456']);

	    //查询数据
	    User::query('id,username,passwd','id >= 600 LIMIT 10');

	    //更新数据
	    User::update(['username' => 'Xiaogang'],'id = 1');

	    //删除数据
	    User::delete('id > 645');

	    //执行SQL语句 返回影响条数 不会从一条 SELECT 语句中返回结果
	    User::execSql('UPDATE user SET passwd = 88886666 WHERE id > 640');

	    //SQL查询
	    User::querySql('SELECT * FROM user WHERE id >=  600 ORDER BY id DESC LIMIT 20')->fetchAll();
##未完待续
