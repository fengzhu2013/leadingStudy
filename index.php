<?php
	header("Content-type:text/html;charset=utf-8");
	header('Access-Controller-Allow-origin:*');
	header('Access-Controller-Allow-Methods:POST,GET');

	session_start();
	date_default_timezone_set('Asia/Shanghai');
	require_once('framework/autoLoad.php');
	require_once('config/config.php');
	require_once('framework/pc.php');
	//��һ����ļ�
	use framework\PC;
	PC::run($config);








