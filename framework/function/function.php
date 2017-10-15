<?php
	use framework\libs\core\VIEW;
	use framework\libs\core\DB;
	/**
	实例化控制器，且调用该控制器的$method方法
	
	@params string $name控制器名称
	@params string $method控制器中的方法
	原则上控制器的方法不能有参数
	@return void
	**/
	function C($module,$name,$method)
	{
		$class = "App\\{$module}\\Controller\\$name".'Controller';
		$obj   = new $class();//实例化
		$obj   -> $method();
	}
	// function C($name,$method)
	// {
		// $class = "App\\{$name}\\Controller\\$name".'Controller';
		// $obj   = new $class();//实例化
		// $obj   -> $method();
	// }

	
	
	
	/**
	实例化模型
	
	@params string $name模型名称
	
	@return object 实例化后的对象
	**/

	function M($name)
	{
	    if (is_array($name))
	        $modelName = $name[0];
	    else
	        $modelName = $name;
		$class = "libs\\Model\\$modelName".'Model';
		$obj   = new $class();//实例化
		return $obj;
	}
	
	/**
	实例化视图
	
	@params string $name视图名称
	
	@return object 实例化后的对象
	**/
	function V($name)
	{
		$class = "libs\\View\\$name".'View';
		$obj = new $class();//实例化
		return $obj;
	}

	//判断一个变量存在且不为空，返回true
	function is_emp($string)
    {
        if (isset($string) && !empty($string))
            return true;
        return false;
    }
	
	/**
	
	//对特殊字符进行转义
	@params string $str 要转义的字符
	@return string 操作后的字符
	
	**/
	function daddslashes($str)
	{
		return (!get_magic_quotes_gpc())?addslashes($str):$str;//当魔法符号打开时，会自动对特殊字符进行转义
	}
	
	/**
	实例化第三方类
	@params string $path 第三方类的路径
	@params string $name 第三方类的名称
	@params array  $params 第三方类初始化需要指定、赋值的属性
		格式为 array(属性名=>属性值，......)
	@return Object $obj  第三方类实例化后的对象
	**/
	
	function ORG($path,$name,$params=array())
	{
		require_once('libs/ORG/'.$path.$name.'.class.php');//引入第三方类主文件
		$obj = new $name();
		if(!empty($params)){
			foreach($params as $key=>$value){
				$obj->$key = $value;
			}
		}
		return $obj;
	}
	/**
	 * 获得当前格式化的日期
	 */
	function getFormatDate()
	{
	    date_default_timezone_set('Asia/Shanghai');//设置时区
	    return date('m/d/Y',time());
	}



    /**
     * 获得分页的页码信息
     * @param $table
     * @param $arr
     * @param $where
     * @param $page
     * @param $pageSize
     * @return mixed
     */
    function getPages($table,$arr,$where,$page,$pageSize)
    {
        $pages['totalNums'] = getNum($table,$arr,$where);                                       //总条数
        $pages['pageNums']  = ceil($pages['totalNums']/$pageSize);                        //总页数
        $pages['page']      = ($page > $pages['pageNums'])?$pages['pageNums']:$page;            //当前页
        $pages['index']     = 1;                                                                //首页
        $pages['last']      = $pages['pageNums'];                                               //最后一页
        $pages['pre']       = ($page - 1 >= 0)?$page-1:1;                                       //上一页
        $pages['next']      = ($page + 1 > $pages['pageNums'])?$pages['pageNums']:$page + 1;    //下一页
        $pages['page']      = empty($pages['page'])?1:$pages['page'];
        return $pages;
    }

    function getNum($table,$arr,$where)
    {
        if (is_array($table)) {
            $obj = M("$table[0]");
            return $obj -> getNum($table,$arr,$where);
        } else {
            $obj = M("$table");
            return $obj -> getNum($table,$arr,$where);
        }
    }

    /**
     * 获得分页的具体内容信息
     * @param $table
     * @param $arr
     * @param $where
     * @param $page
     * @param $pageSize
     * @return mixed
     */
    function getPageInfos($table,$arr,$where,$page,$pageSize)
    {
        $offset = ($page -1) * $pageSize;
        if (isset($where['where2'])) {
            /*preg_match('/\border\b/i',$where['where2'],$matches,PREG_OFFSET_CAPTURE);
            if ($matches) {
                $split = $matches[0][1];                            //分割点
                $left  = substr($where['where2'],0,$split);     //左部分
                $right = substr($where['where2'],$split);           //右部分
                $where['where2'] = $left." LIMIT $offset,$pageSize ".$right;
            } else {

            }*/
            $where['where2'] .= " LIMIT $offset,$pageSize";
        } else {
            $where['where2'] = " LIMIT $offset,$pageSize";
        }
        if (is_array($table)) {
            $obj = M("$table[0]");
            return $obj -> fetchAllInfo($table,$arr,$where);
        } else {
            $obj = M("$table");
            return $obj -> fetchAllInfo($table,$arr,$where);
        }

    }

    /**
     * 获得分页的所有信息
     * @param $table
     * @param $arr
     * @param $where
     * @param $page
     * @param $pageSize
     * @return mixed
     */
    function getPage($table,$arr,$where,$page,$pageSize)
    {
        $pages['data'] = getPageInfos($table,$arr,$where,$page,$pageSize);
        $pages['page'] = getPages($table,$arr,$where,$page,$pageSize);
        return $pages;
    }
	
	/**
	*md5密钥加密
	***/
	function myMd5($string)
	{
		$miyao = 'hujie';
		$string = $miyao.$string;
		return md5($string);
	}
	
	function isMobile($mobile)
	{
		$res = '';
		$len = is_string($mobile)?strlen(trim($mobile)):0;
		if($len == 11){
			$res = preg_match('/^1[34578]{1}\d{9}$/',trim($mobile));
		}
		return $res;
	}

    /**
     * 验证字符串是否符合是邮箱格式
     * @param string $mail
     * @return bool 符合返回true
     */
    function isMail($mail)
    {
        if (filter_var($mail,FILTER_VALIDATE_EMAIL))
            return true;
    }

    /**
     * 检验字符串的长度是否在$min和$max之间
     * @param $string
     * @param $min
     * @param $max
     * @return bool
     */
    function verifyLen($string,$min,$max)
    {
        @$len = strlen($string);
        if ($len >= $min && $len <= $max)
            return true;
        return false;
    }