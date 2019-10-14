<?php
/**
 * 框架PDO类 单列模式
 * Created by PhpStorm.
 * User: 860646000@qq.com
 * Date: 2019/10/13
 * Time: 14:52
 */
namespace ChunFeng\db;
class PdoClass
{
    protected static $_instance = null;
    protected $dsn;
    protected $db;
    public $dbh;

    /**
     * 构造器
     * PdoClass constructor.
     * @throws \Exception
     */
    private function __construct()
    {
        $database = \ChunFeng\Conf::all('database');
        $database = $database['PDO'];
        try {
            $this->dsn = $database['DSN'] . ';' . $database['CHARACTER'];
            $this->dbh = new \PDO($this->dsn, $database['USERNAME'], $database['PASSWD']);
        } catch (\PDOException $e) {
            $this->outputError($e->getMessage());
        }
    }

    /**
     * 防止克隆
     */
    private function __clone()
    {
    }

    /**
     * 单列模式
     * @return PdoClass|null
     * @throws \Exception
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 查询
     * @param string $table 表名
     * @param string $field 显示字段 默认全部显示
     * @param string $where 条件
     * @param string $queryMode 模式
     * @param bool $debug
     * @return array
     */
	public function query($table, $field = '*', $where = '', $queryMode = 'All', $debug = true)
	{
		if($where){
			$strSql = "SELECT $field FROM `$table` WHERE $where";
		}else{
			$strSql = "SELECT $field FROM `$table`";
		}

		$recordset = $this->dbh->query($strSql);
		$this->getPDOError();

		if ($recordset) {
			$recordset->setFetchMode(\PDO::FETCH_ASSOC);
			if ($queryMode == 'All') {
				$result = $recordset->fetchAll();
			} elseif ($queryMode == 'Row') {
				$result = $recordset->fetch();
			}else{
				$result = 'queryMode 只能为 All或Row 注意大小写';
				$recordset = null;
			}
		} else {
			$result = null;
		}
		return $result;
	}

    /**
     * Update 更新
     * @param string $table $table 表名
     * @param array $arrayDataValue 字段值键值对
     * @param string $where 条件
     * @param bool $debug
     * @return int
     * @throws \Exception
     */
    public function update($table, $arrayDataValue, $where = '', $debug = false)
    {
        $this->checkFields($table, $arrayDataValue);
        if ($where) {
            $strSql = '';
            foreach ($arrayDataValue as $key => $value) {
                $strSql .= ", `$key` = '$value'";
            }
            $strSql = substr($strSql, 1);
            $strSql = "UPDATE `$table` SET $strSql WHERE $where";
        } else {
            $strSql = "REPLACE INTO $table (`".implode('`,`', array_keys($arrayDataValue))."`) VALUES ('".implode("','", $arrayDataValue)."')";
        }
        if ($debug === true) $this->debug($strSql);
        $result = $this->dbh->exec($strSql);
        $this->getPDOError();
        return $result;
    }

    /**
     * Insert 插入
     * @param string $table 表名
     * @param array $arrayDataValue 字段值 键值对
     * @param bool $debug
     * @return int
     * @throws \Exception
     */
    public function insert($table, $arrayDataValue, $debug = false)
    {
        $this->checkFields($table, $arrayDataValue);
        $strSql = "INSERT INTO `$table` (`".implode('`,`', array_keys($arrayDataValue))."`) VALUES ('".implode("','", $arrayDataValue)."')";
        if ($debug === true) $this->debug($strSql);
        $result = $this->dbh->exec($strSql);
        $this->getPDOError();
        return $result;
    }

    /**
     * @param string $table $table 表名
     * @param array $arrayDataValue 字段值键值对
     * @param bool $debug
     * @return int
     * @throws \Exception
     */
    public function replace($table, $arrayDataValue, $debug = false)
    {
        $this->checkFields($table, $arrayDataValue);
        $strSql = "REPLACE INTO `$table`(`".implode('`,`', array_keys($arrayDataValue))."`) VALUES ('".implode("','", $arrayDataValue)."')";
        if ($debug === true) $this->debug($strSql);
        $result = $this->dbh->exec($strSql);
        $this->getPDOError();
        return $result;
    }

    /**
     * Delete 删除
     * @param String $table 表名
     * @param String $where 条件
     * @param bool $debug
     * @return int
     * @throws \Exception
     */
    public function delete($table, $where = '', $debug = false)
    {
        if ($where == '') {
            $this->outputError("'WHERE' is Null");
        } else {
            $strSql = "DELETE FROM `$table` WHERE $where";
            if ($debug === true) $this->debug($strSql);
            $result = $this->dbh->exec($strSql);
            $this->getPDOError();
            return $result;
        }
    }

    /**
     * execSql 执行SQL语句
     *
     * @param String $strSql
     * @param Boolean $debug
     * @return Int
     */
    public function execSql($strSql, $debug = false)
    {
        if ($debug === true) $this->debug($strSql);
        $result = $this->dbh->exec($strSql);
        $this->getPDOError();
        return $result;
    }

	/**
	 * 执行查询 SQL语句
	 * @param $Sql
	 * @param bool $debug
	 * @return false|\PDOStatement
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
	public function querySql($Sql, $debug = false)
	{
		if ($debug === true) $this->debug($Sql);
		$result = $this->dbh->query($Sql);
		$this->getPDOError();
		return $result;
	}

    /**
     * 获取字段最大值
     *
     * @param string $table 表名
     * @param string $field_name 字段名
     * @param string $where 条件
     */
    public function getMaxValue($table, $field_name, $where = '', $debug = false)
    {
        $strSql = "SELECT MAX(".$field_name.") AS MAX_VALUE FROM $table";
        if ($where != '') $strSql .= " WHERE $where";
        if ($debug === true) $this->debug($strSql);
        $arrTemp = $this->query($strSql, 'Row');
        $maxValue = $arrTemp["MAX_VALUE"];
        if ($maxValue == "" || $maxValue == null) {
            $maxValue = 0;
        }
        return $maxValue;
    }

    /**
     * 获取指定列的数量
     *
     * @param string $table
     * @param string $field_name
     * @param string $where
     * @param bool $debug
     * @return int
     */
    public function getCount($table, $field_name, $where = '', $debug = false)
    {
        $strSql = "SELECT COUNT($field_name) AS NUM FROM $table";
        if ($where != '') $strSql .= " WHERE $where";
        if ($debug === true) $this->debug($strSql);
        $arrTemp = $this->query($strSql, 'Row');
        return $arrTemp['NUM'];
    }

    /**
     * 获取表引擎
     *
     * @param String $dbName 库名
     * @param String $tableName 表名
     * @param Boolean $debug
     * @return String
     */
    public function getTableEngine($dbName, $tableName)
    {
        $strSql = "SHOW TABLE STATUS FROM $dbName WHERE Name='".$tableName."'";
        $arrayTableInfo = $this->query($strSql);
        $this->getPDOError();
        return $arrayTableInfo[0]['Engine'];
    }

    /**
     * beginTransaction 事务开始
     */
    private function beginTransaction()
    {
        $this->dbh->beginTransaction();
    }

    /**
     * commit 事务提交
     */
    private function commit()
    {
        $this->dbh->commit();
    }

    /**
     * rollback 事务回滚
     */
    private function rollback()
    {
        $this->dbh->rollback();
    }

    /**
     * transaction 通过事务处理多条SQL语句
     * 调用前需通过getTableEngine判断表引擎是否支持事务
     *
     * @param array $arraySql
     * @return Boolean
     */
    public function execTransaction($arraySql)
    {
        $retval = 1;
        $this->beginTransaction();
        foreach ($arraySql as $strSql) {
            if ($this->execSql($strSql) == 0) $retval = 0;
        }
        if ($retval == 0) {
            $this->rollback();
            return false;
        } else {
            $this->commit();
            return true;
        }
    }

    /**
     * getPDOError 捕获PDO错误信息
     */
    private function getPDOError()
    {
        if ($this->dbh->errorCode() != '00000') {
            $arrayError = $this->dbh->errorInfo();
            $this->outputError($arrayError[2]);
        }
    }

    /**
     * checkFields 检查指定字段是否在指定数据表中存在
     * @param $table
     * @param $arrayFields
     * @throws \Exception
     */
    private function checkFields($table, $arrayFields)
    {
        $fields = $this->getFields($table);
        foreach ($arrayFields as $key => $value) {
            if (!in_array($key, $fields)) {
                $this->outputError("Unknown column `$key` in field list.");
            }
        }
    }

    /**
     * getFields 获取指定数据表中的全部字段名
     * @param $table
     * @return array
     */
    private function getFields($table)
    {
        $fields = array();
        $recordset = $this->dbh->query("SHOW COLUMNS FROM $table");
        $this->getPDOError();
        $recordset->setFetchMode(\PDO::FETCH_ASSOC);
        $result = $recordset->fetchAll();
        foreach ($result as $rows) {
            $fields[] = $rows['Field'];
        }
        return $fields;
    }
    /**
     * debug
     *
     * @param mixed $debuginfo
     */
    private function debug($debuginfo)
    {
        var_dump($debuginfo);
        exit();
    }

    /**
     * 输出错误信息
     * @param $strErrMsg
     * @throws \Exception
     */
    private function outputError($strErrMsg)
    {
        throw new \Exception('MySQL Error: ' . $strErrMsg);
    }

    /**
     * destruct 关闭数据库连接
     */
    public function destruct()
    {
        $this->dbh = null;
    }
}