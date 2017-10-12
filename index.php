<?php
	header("Content-type:text/html;charset=utf-8");

	//跨域处理
	header('Access-Controller-Allow-origin:*');
	header('Access-Controller-Allow-Methods:POST,GET');

	//开启错误提示
    ini_set("display_errors", "On");
    error_reporting(E_ALL);

    //开启session
	session_start();

	//定义日期
	date_default_timezone_set('Asia/Shanghai');

	//刺透域名

	//加载相应的文件
	require_once('framework/autoLoad.php');
	require_once('config/config.php');
	require_once('framework/pc.php');
	//��һ����ļ�
	use framework\PC;

	//允许框架
	PC::run($config);








