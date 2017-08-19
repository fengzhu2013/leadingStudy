<?php
namespace framework;
use framework\libs\core\DB;
use framework\libs\core\VIEW;
include_once('function/function.php');
include_once('function/common.php');
use App\index\Controller\indexController;//1
class PC
{
	public static $controller;
	public static $method;
	public static $module;
	private static $config;
	private static $controllerArr;
	private static $methodArr;
	private static $aplication;
	private static $http_host;
	private static $https;
	private static $query_string;
	// private static $controllerArr = array('index','test');
	// private static $methodArr = array('index','test','show');
	//public static $link;
	
	private static function init_db()
	{
		DB::init('mysqli',self::$config['dbConfig']);
	}
	
	private static function init_view()
	{
		VIEW::init('smarty',self::$config['viewConfig']);
	}
	
	private static function init_controller()
	{
		//self::$Controller = in_array($_GET['Controller'],self::$controllerArr)?daddslashes($_GET['Controller']):'index';
		if($_GET && isset($_GET['Controller']) && !empty($_GET['Controller'])){
			self::$controller = $_GET['Controller'];
		}else{
			self::$controller = (!empty($_GET['module']))?$_GET['module']:'index';
			//self::$Controller = 'index';
		}
	}
	
	private static function init_method()
	{
		//self::$method = in_array($_GET['method'],self::$methodArr)?daddslashes($_GET['method']):'index';
		if($_GET  && isset($_GET['method']) && !empty($_GET['method'])){
			self::$method = $_GET['method'];//的确有问题
		}else{
			self::$method = 'index';
		}
	}

	private static function init_route()
    {
        //1、获取到整个URL
        self::$query_string = str_replace($_SERVER['SCRIPT_NAME'],null,$_SERVER['PHP_SELF']);
        preg_match_all('/\/\w+/',self::$query_string,$matches);
        if ($matches[0][0])
            self::$module = str_replace('/',null,$matches[0][0]);
        if ($matches[0][1])
            self::$controller = str_replace('/',null,$matches[0][1]);
        if ($matches[0][1])
            self::$method = str_replace('/',null,$matches[0][2]);
        /*var_dump($_SERVER['PHP_SELF'].' 4<br />');
        var_dump($_SERVER['QUERY_STRING'].' 5<br />');
        var_dump($_SERVER['DOCUMENT_ROOT'].' 6<br />');
        var_dump($_SERVER['REMOTE_ADDR'].' 7<br />');
        var_dump($_SERVER['REMOTE_HOST'].' 8<br />');
        var_dump($_SERVER['SCRIPT_FILENAME'].' 9<br />');
        var_dump($_SERVER['SERVER_ADMIN'].' 10<br />');
        var_dump($_SERVER['PATH_TRANSLATED'].' 11<br />');
        var_dump($_SERVER['SCRIPT_NAME'].' 12<br />');
        var_dump($_SERVER['REQUEST_URI'].' 13<br />');
        var_dump($_SERVER['HTTPS'].' 14<br />');
        exit;*/
    }

    private static function init_pathDefine()
    {
        $scriptName = $_SERVER['SCRIPT_NAME'];              // /leadingStudy/index.php
        if (preg_match('/\/index.php/',$scriptName))
            self::$aplication = str_replace('index.php',null,$scriptName);
        else
            self::$aplication = str_replace('index',null,$scriptName);
        self::$http_host = $_SERVER['HTTP_HOST'];
        if ($_SERVER['HTTPS'])
            self::$https = 'https://';
        else
            self::$https = 'http://';
        define('ROOT_PATH',self::$https.self::$http_host.self::$aplication);
    }

    private static function init_params($data,$name = '_LS')
    {
        if(count($data)) {
            foreach ($data as $key => $val) {
                if (is_array($val)) {
                    ${$name}["{$key}"] = $val;
                    self::init_post($val);
                } elseif (is_int($val)) {
                    ${$name}["{$key}"] = intval(daddslashes($val));
                } else {
                    ${$name}["{$key}"] = strval(daddslashes($val));
                }
            }
            return ${$name};
        }
    }

	public static function run($config)
	{
	    if (count($_GET)) {
	        global $_LG;
	        $_LG = self::init_params($_GET);
        }
        if (count($_POST)) {
	        global $_LP;
	        $_LP = self::init_params($_POST);
        }
		self::$config = $config;
		self::init_db();
		self::init_pathDefine();
		self::init_route();
		if (self::$module != 'api')
		    self::init_view();
		if (!self::$method)
            self::init_method();
		if (!self::$controller)
		    self::init_controller();
		if (!self::$module)
		    self::$module = 'index';
		C(self::$module,self::$controller,self::$method);
	}
	
}





































