<?php
namespace framework\libs\db;

/**使用mysqli操作MySQL**/

class mysqli
{
	
	private static $link;//定义链接

    /**
     *构造函数，执行数据库连接函数
     *@params array $config 数据库的配置信息
     *@return object $link 数据库的链接
     **/
    public function __construct($config)
    {
        extract($config);
        self::$link = mysqli_connect($dbHost,$dbUser,$dbPsw,$dbName);//获得链接
        if(!self::$link){
            $this->err(mysql_error());
            //$this->err(mysqli_errno(self::$link));
        }
        self::$link->set_charset($charset);//设置字符集
    }
	
	/**
	*报错信息
	*@params string $error 错误信息
	*@return void 
	**/
	public function err($error)
	{
		die("对不起，您操作有误，错误信息为：".$error);
	}
	
	
	/**
	*mysql数据库的连接及设置字符集为utf8
	*@params array $config 			MySQL配置数组，格式为array('dbHost'=>服务器地址,'dbUser'=>用户名,'dbPsw'=>密码,'dbName'=>数据库名,'charset'=>字符集)
	@return bool
	**/
	public function connect($cofing = null)
	{
		 return self::$link;
	}
	
	
	/**
	*执行sql语句
	*@params string $sql sql语句
	*@return mixed $query 返回执行成功、资源或执行失败
	**/
	public function query($sql)
	{
		$query = '';
		$query = self::$link-> query($sql);//获得资源句柄
		if(!$query){//出错时
			$query = '';
			$this->err($sql."<br />".mysql_error());
		}
		return $query;
	}
	
	
	
	/**
	*数据库的插入
	*@params string $table 要插入的表名
	*@params array  $arr 包含表明要插入的字段及值得一维数组
	*@return int 最后插入的id
	**/
	public function insert($table,Array $arr)
	{
		foreach($arr as $key=>$value){
			$value = mysqli_real_escape_string(self::$link,$value);//转义 SQL 语句中使用的字符串中的特殊字符
			$keyArr[] = "`".$key."`";//把$arr中的所有key放在$keyArr数组中
			$valArr[] = "'".$value."'";
		}
		$keys = implode(',',$keyArr);//把字段所在的数组合成一个字符串
		$values = implode(',',$valArr);
		$sql = "insert into $table(".$keys.") values(".$values.")";//要插入的sql语句
		$this->query($sql);
		return self::$link->insert_id;
	}
	
	
	
	/**
	*删除记录
	*@params string $table 表名
	*@params string $where 删除时的条件
	*@return int 受影响的记录条数
	**/
	public function deleteRow($table,$where)
	{
		$sql = "delete from {$table} where {$where}";//删除sql语句格式
		$this->query($sql);
		return self::$link->affected_rows;
	}
	
	
	/**
	*更新一条记录
	*@params string $table 表名
	*@params array $arr 要更新的字段及值
	*@params string $where 更新条件
	*@return int 返回更新后受影响的记录条数
	**/
	public function update($table,$arr,$where)
	{
		foreach($arr as $key=>$value){
			$value = mysqli_real_escape_string(self::$link,$value);//过滤sql语句的值
			$keyAndVal[] = "`{$key}`='{$value}'";
		}
		$keyAndVals = implode(',',$keyAndVal);//把数组合成一个字符串
		$sql = "update {$table} set {$keyAndVals} where {$where}";//sql语句
		$this->query($sql);
		return self::$link->affected_rows;
	}
	
	
	/**
	*获得一条记录信息
	*@params source $query query函数执行后所获得的资源句柄
	*@return array 关联数组
	**/
	public function fetchOne($query)
	{
		$result = $query->fetch_assoc();//获得关联数组
		return $result;
	}
	/**
	* 根据字段数组获得相应的一条信息
	* @date: 2017年5月16日 下午1:44:09
	* @author: lenovo2013
	* @param: string $table 表名
	* @param: array $arr字段数组
	* @param: array $where1 查询条件数组
	* @param: string $where2 查询条件
	* @return:array
	*/
	public function fetchOne_byArr($table,$arr,$where1,$where2)
	{
	    $where = '';
	    if(count($arr) > 1){
	        $value = implode(',',$arr);
	    }else{
	        $value = implode(' ',$arr);
	    }
	    foreach($where1 as $key=>$val){
	        $where .= " and {$key} = '{$val}'";
	    }
	    $where = !empty($where2)?$where.$where2:$where;
	    $sql = "select {$value} from {$table} where 1 = 1 {$where} limit 0,1";
	    return $this->fetchOne($this->query($sql));
	}
	/**
	 * 根据字段数组获得相应的多条信息
	 * @date: 2017年5月16日 下午1:44:09
	 * @author: lenovo2013
	 * @param: string $table 表名
	 * @param: array $arr字段数组
	 * @param: array $where1 查询条件数组
	 * @param: string $where2 查询条件
	 * @return:array
	 */
	public function fetchAll_byArr($table,$arr,$where1,$where2,$distinct=true)
	{
	    $where = '';
	    if(count($arr) > 1){
	        $value = implode(',',$arr);
	    }else{
	        $value = implode(' ',$arr);
	    }
	    foreach($where1 as $key=>$val){
	        $where .= " and {$key} = '{$val}'";
	    }
	    $where = !empty($where2)?$where.$where2:$where;
		if($distinct){
			$value = " distinct {$value} ";
		}
	    $sql = "SELECT {$value} FROM {$table} WHERE 1 = 1 {$where}";
	    return $this->fetchAll($this->query($sql));
	}
	/**
	*获得多条记录信息
	*@params source $query query函数执行后所获得的资源句柄
	*@return array 多维关联数组
	**/
	public function fetchAll($query)
	{
		$result = array();
		while($res = $query->fetch_assoc()){//有记录时存入结果数组
			$result[] = $res;
		}
		return $result;
	}
	
	
	
	/**
	*获得记录数目
	*@params source $query query函数执行后所获得的资源句柄
	*@return int 所有的记录数目
	**/
	public function getNums($query)
	{
		return $query->num_rows;
	}
	
	public function getNum($table,$arr,$where,$tableArr = null)
    {

    }

	
	
	/**获得链接**/
	public function getLink()
	{
		return self::$link;
	}
	/**
	*联合查询，获得一条数据
	*/
	public function fetchOne_byArrJoin($arr,$where,$table,$table2,$tableArr,$table2Arr)
	{
		$i = $j = 0;
		foreach($arr as $val){
            if(in_array($val,$tableArr)){
                $value[] = " s.{$val} ";
                $i++;
                continue;
            }
            if(in_array($val,$table2Arr)){
                $value[] = " f.{$val} ";
                $j++;
            }
        }
		$selectInfo = implode(',',$value);
        if( $j == 0 && $i > 0){//表名
            $table = '`'.$table.'` as s ';
        }
        if($i==0 && $j > 0){
            $table = '`'.$table2.'` as f ';
        }
        if($i>0 && $j>0){//联合表名
            $table = $table." as s ,".$table2." as f";
        }
        $sql = "SELECT ".$selectInfo." FORM ".$table." WHERE ".$where." LIMIT 0,1";
        return $this->fetchOne($this->query($sql));
	}
	/**
	*联合查询，获得多条数据
	*/
	public function fetchAll_byArrJoin($arr,$where,$table,$table2,$tableArr,$table2Arr)
	{
		$i = $j = 0;
		foreach($arr as $val){
            if(in_array($val,$tableArr)){
                $value[] = " s.{$val} ";
                $i++;
                continue;
            }
            if(in_array($val,$table2Arr)){
                $value[] = " f.{$val} ";
                $j++;
            }
        }
		$selectInfo = implode(',',$value);
        if( $j == 0 && $i > 0){//表名
            $table = '`'.$table.'` as s ';
        }
        if($i==0 && $j > 0){
            $table = '`'.$table2.'` as f ';
        }
        if($i>0 && $j>0){//联合表名
            $table = $table." as s ,".$table2." as f";
        }
        $sql = "SELECT ".$selectInfo." FROM ".$table." WHERE ".$where;
        return $this->fetchAll($this->query($sql));
	}

    /**
     * 格式化数据表
     * @param $table    array|string  表
     * @param bool $i
     * @param bool $j
     * @return string   sql语句中数据表字符
     */
	private function formatTable($table,$i = false,$j = false)
    {
        if (is_string($table))                                                  //只有一个表，直接返回
            return ' `'.$table.'` ';
        if ( $i && $j) {                                                        // 两个表且每个表都有查询字段
            return ' `'.$table[0]."` as s ,`".$table[1]."` as f ";
        }
        if ($i)                                                                 //只有一个表有查询字段
            return ' `'.$table[0].'` as s ';
        if ($j)                                                                 //只有一个表有查询字段
            return ' `'.$table[1].'` as f ';
    }

    /**
     * 格式化搜索条件
     * @param $where    array 条件数组
     * @param null $tableArr    多个表的所有字段
     * @return string   sql语句的搜索条件
     */
    private function formatWhere($where,$tableArr = null)
    {
        $whereStr = '';
        $where_2  = array_diff_assoc($where,array_flip(['where2']));
        foreach ($where_2 as $key => $val) {
            $val = mysqli_real_escape_string(self::$link,$val);
            if (!is_null($tableArr) && in_array($key,$tableArr[0] && in_array($key,$tableArr[1])))
                $whereStr .= ' AND s.`'.$key.'` = '.$val.' AND f.`'.$key.'` = s.`'.$key.'`';
            elseif (!is_null($tableArr) && in_array($key,$tableArr[0]))
                $whereStr .= ' AND s.`'.$key.'` ='.$val;
            elseif (!is_null($tableArr) && in_array($key,$tableArr[1]))
                $whereStr .= ' AND f.`'.$key.'` ='.$val;
            else
                $whereStr .= " AND `{$key}` = '{$val}''";                  //一个数据表的搜索条件
        }
        if ($where['where2'])
            $whereStr .= $where['where2'];
        return $whereStr;
    }

    /**
     * 格式化搜索的字段
     * @param $arr  array 搜索的字段
     * @param null $tableArr    多表时所有可能的字段
     * @param bool $isAll       当两个表中都有一个字段时是否都显示，默认不显示
     * @return array            有搜索字段信息，还有为相应搜索的表提供信息
     */
    private function formatValue($arr,$tableArr = null,$isAll = false)
    {
        //1、两个表的相同字段都搜索
        //2、两个表的相同字段只取其一
        //3、只要存在tableArr，就用s，f表示
        $info   = ['i' => false,j => false];
        foreach ($arr as $val) {
            $val = mysqli_real_escape_string(self::$link,$val);//转义 SQL 语句中使用的字符串中的特殊字符
            if (is_null($tableArr))                                             //单表
                $valArr[] = "`{$val}`";
            if (in_array($val,$tableArr[0]) && in_array($val,$tableArr[1])) {   //多表，且搜索的字段两个表中都有
                if ($isAll)
                    $valArr[] = " s.`{$val}`,f.`{$val}` ";                       //两个表中相同的字段都要搜索
                else
                    $valArr[] = " s.`{$val}` ";                                  //两个表中相同的字段只搜索其一
            } elseif (in_array($val,$tableArr[0]))                              //只有一个表
                $valArr[] = " s.`{$val}` ";
            else
                $valArr[] = " f.`{$val}` ";
        }
        $valStr = implode(',',$valArr);
        //bug?
        if (preg_match('/s\./i',$valStr))
            $info['i'] = true;
        if (preg_match('/f\./i',$valStr))
            $info['j'] = true;
        $info['valStr'] = $valStr;
        return $info;
    }

    private function formatInsertVal($arr)
    {
            foreach ($arr as $key => $val) {
                $val = mysqli_real_escape_string(self::$link,$val);
                $keyArr[] = "`".$key."`";               //把$arr中的所有key放在$keyArr数组中
                $valArr[] = "'".$val."'";
            }

    }
	
}


























