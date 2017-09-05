<?php
namespace App\api\Controller;

use App\api\Model\adminModel;
use App\common\Controller\baseController;

class adminController extends baseController
{
    private $obj;

    public function __construct()
    {
        $this->obj = new adminModel();
    }

    //注册
    public function sign()
    {
        $response = $this->obj->sign();
        parent::ajaxReturn($response);
    }

    //忘记密码
    public function forgetPass()
    {
        $response = $this->obj->forgetPass();
        parent::ajaxReturn($response);
    }

    //验证邮箱链接是否有效
    public function verifyEmailLinkIsTrue()
    {
        $response = $this->obj->verifyEmailLinkIsTrue();
        parent::ajaxReturn($response);
    }

    //重置密码
    public function resetPass()
    {
        $response = $this->obj->resetPass();
        parent::ajaxReturn($response);
    }

    //登录
    public function login()
    {
        $response = $this->obj->login();
        parent::ajaxReturn($response);
    }

    //获得图片验证码
    public function getImageCode()
    {
        return $this->obj->getImageCode();
    }

    public function logout()
    {
        $response = $this->obj->logout();
        parent::ajaxReturn($response);
    }

    public function sendSignMsg()
    {
        $response = $this->obj->sendSignMsg();
        parent::ajaxReturn($response);
    }

    //仅使用手机号注册
    public function signMobile()
    {
        $response = $this->obj->sendSignMsg();
        parent::ajaxReturn($response);
    }






}