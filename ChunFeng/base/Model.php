<?php
/**
 * 框架Model基类
 * Created by PhpStorm.
 * User: 860646000@qq.com
 * Date: 2019/10/10
 * Time: 12:13
 */

namespace ChunFeng\base;

use ChunFeng\db\PdoClass;

class Model
{
    private static $tableName = [];

	/**
	 * 查询
	 * @param string $field
	 * @param string $where
	 * @param string $queryMode
	 * @param bool $debug
	 * @return array
	 * @throws \Exception
	 */
	public static function query($field = '*',$where = '', $queryMode = 'All', $debug = false)
    {
	    $table = self::getTableName(get_called_class());
        return  PdoClass::getInstance()->query($table, $field, $where, $queryMode, $debug);
    }

	/**
	 * 更新
	 * @param $arrayDataValue
	 * @param string $where
	 * @param bool $debug
	 * @return int
	 * @throws \Exception
	 */
    public static function update($arrayDataValue, $where = '', $debug = false)
    {
    	$table = self::getTableName(get_called_class());
        return PdoClass::getInstance()->update($table, $arrayDataValue, $where, $debug);
    }

	/**
	 * 插入记录
	 * @param $arrayDataValue
	 * @param bool $debug
	 * @return int
	 * @throws \Exception
	 */
	public static function insert($arrayDataValue, $debug = false)
	{
		$table = self::getTableName(get_called_class());
		return PdoClass::getInstance()->insert($table, $arrayDataValue, $debug);
	}

	/**
	 * 删除数据
	 * @param $table
	 * @param string $where
	 * @param bool $debug
	 * @return int
	 * @throws \Exception
	 */
	public static function delete($where = '', $debug = false)
	{
		$table = self::getTableName(get_called_class());
		return PdoClass::getInstance()->delete($table, $where, $debug);
	}

	/**
	 * 执行SQL语句
	 * 返回影响条数 不会从一条 SELECT 语句中返回结果
	 * @param $strSql
	 * @param bool $debug
	 * @return Int
	 * @throws \Exception
	 */
	public static function execSql($strSql, $debug = false)
	{
		return PdoClass::getInstance()->execSql($strSql, $debug);
	}

	/**
	 * SQL查询
	 * Pod query 执行SQL
	 * @param $sql
	 * @return false|\PDOStatement
	 * @throws \Exception
	 *
	 * querySql($sql)->
	 * bindColumn — 绑定一列到一个 PHP 变量
	 * bindParam — 绑定一个参数到指定的变量名
	 * bindValue — 把一个值绑定到一个参数
	 * closeCursor — 关闭游标，使语句能再次被执行。
	 * columnCount — 返回结果集中的列数
	 * debugDumpParams — 打印一条 SQL 预处理命令
	 * errorCode — 获取跟上一次语句句柄操作相关的 SQLSTATE
	 * errorInfo — 获取跟上一次语句句柄操作相关的扩展错误信息
	 * execute — 执行一条预处理语句
	 * fetch — 从结果集中获取下一行
	 * fetchAll — 返回一个包含结果集中所有行的数组
	 * fetchColumn — 从结果集中的下一行返回单独的一列。
	 * fetchObject — 获取下一行并作为一个对象返回。
	 * getAttribute — 检索一个语句属性
	 * getColumnMeta — 返回结果集中一列的元数据
	 * nextRowset — 在一个多行集语句句柄中推进到下一个行集
	 * rowCount — 返回受上一个 SQL 语句影响的行数
	 * setAttribute — 设置一个语句属性
	 * setFetchMode — 为语句设置默认的获取模式。
	 */
	public static function querySql($sql,$debug = false)
	{
		return PdoClass::getInstance()->querySql($sql, $debug);
	}
	/**
	 * 获取数据表名
	 * @param $class
	 * @return mixed
	 */
    private static function getTableName($class)
    {
    	if(isset(self::$tableName[$class])){
    		return self::$tableName[$class];
	    }else{
		    self::$tableName[$class] = $class::tableName();
		    return self::$tableName[$class];
	    }
    }

}