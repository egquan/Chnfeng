<?php
/**
 * 控制器基类
 * Created by egquan@163.com
 * Date: 2019/10/14
 * Time: 16:32
 */
namespace ChunFeng\base;

class Ctrl
{

	public function render($views,$data = [])
	{
		$file = APP.'/views/'.$views;
		if(is_file($file)){
			extract($data);
			include $file;
		}else{
			throw new \Exception('视图文件不存在！'.$file);
		}

	}
}