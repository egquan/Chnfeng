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
			ob_start();
			ob_implicit_flush(false);
			extract($data,EXTR_OVERWRITE);
			include $file;
			return ob_get_clean();
		}else{
			throw new \Exception('视图文件不存在！'.$file);
		}

	}
}