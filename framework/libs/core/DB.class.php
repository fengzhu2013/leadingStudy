<?php
namespace framework\libs\core;
//use framework\libs\db\mysqli;
/**实现DB工厂类**/
class DB
{
	public static $db;//
	public static $link;
	
	/**
	*实例DB类
	*@params string $dbType 数据库类
	*@params array  $config 该类数据库的配置信息
	*@return void
	**/
	public static function init($dbType,$config)
	{
		$class = "framework\\libs\\db\\"."$dbType";
		self::$db = new $class($config);//这样调用时一定要注意写全地址
		
		self::$link = self::$db -> getLink();
		// return self::$link;
	}
	
	/**封装query函数**/
	public static function query($sql)
	{
		return self::$db->query($sql);
	}
	
	/**封装insert函数**/
	public static function insert($table,$arr)
	{
		return self::$db->insert($table,$arr);
	}
	public static function insertSql($sql)
    {
        return self::$db->insertSql($sql);
    }
	
	/**封装deleteRow函数**/
	public static function deleteRow($table,$where)
	{
		return self::$db->deleteRow($table,$where);
	}
	public static function deleteArr($table,$where)
    {
        return self::$db->deleteArr($table,$where);
    }
	
	/**封装update函数**/
	public static function updateInfo($table,$arr,$where,$tableArr = null)
	{
		return self::$db->updateInfo($table,$arr,$where,$tableArr);
	}

	public static function updateSql($sql)
    {
        return self::$db->updateSql($sql);
    }
	/**封装fetchOne函数**/
	public static function fetchOneSql($sql)
	{
		return self::$db->fetchOneSql($sql);
	}
	/***封装fetchOne_byArr函数****/
	public static function fetchOneInfo($table,$arr,$where,$tableArr = null)
	{
	    return self::$db->fetchOneInfo($table,$arr,$where,$tableArr);
	}
	/**封装fetchAll函数**/
	public static function fetchAllSql($sql)
	{
		return self::$db->fetchAllSql($sql);
	}
	public static function fetchAllInfo($table,$arr,$where,$tableArr = null)
    {
        return self::$db->fetchAllInfo($table,$arr,$where,$tableArr);
    }
	/**封装getNums函数**/
	public static function getNums($sql)
	{
		return self::$db->getNums($sql);
	}
	public static function getNum($table,$arr,$where,$tableArr = null)
    {
        return self::$db->getNum($table,$arr,$where,$tableArr);
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
















