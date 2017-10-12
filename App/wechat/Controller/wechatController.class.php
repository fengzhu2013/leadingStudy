<?php
namespace App\wechat\Controller;
use App\wechat\Model\indexModel;
use App\wechat\Model\wechatModel;

class wechatController
{
	/**
	*检查签名或回复消息
	*/
	private static $obj = '';

	public function __construct()
	{
		self::$obj = new indexModel();
	}
	public function index()
	{
		self::$obj->index();
	}

	//创建菜单
	public function create_menu()
	{
		self::$obj->create_menu();
	}

	public function getOpenId()
    {
        $obj = new wechatModel();
        $obj->getOpenId();
    }

    public function getCode()
    {
        $obj = new wechatModel();
        $obj->getCode();
    }

    public function getUserInfo()
    {
        $obj = new wechatModel();
        $obj->getUserInfo();
    }
}