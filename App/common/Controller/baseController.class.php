<?php
namespace App\common\Controller;

class baseController
{
    private static $status = [
        '0'     => 'success',
        '10001' => 'failed',
        '10002' => '未知错误',
        '10003' => '系统维修中，请稍后再试',

        '20001' => '递交的信息不齐全',
        '20002' => '递交的信息不安全',
        '20003' => '没有相关信息',

        '30001' => '不用重复修改',
        '30002' => '不用重复添加',
        '30003' => '已超过数额限制',
        '30004' => '信息不唯一',
        '30005' => '手机格式不正确',
        '30006' => '图片验证码错误',
        '30007' => '手机验证码错误',
        '30008' => '手机号已注册',
        '30009' => '邮箱已注册',
        '30010' => '邮箱账号格式错误',
        '30011' => '手机号当天发送的信息已到上限',
        '30012' => '验证码失效',

        '40001' => '旧密码错误',
        '40002' => '新密码与旧密码一样',
        '40003' => '新密码与确认密码不一致',
        '40004' => '密码长度不符合规定',
        '40005' => '链接失效',

        '50001' => '已登录',
        '50002' => '未登录',
        '50003' => '与登录信息不符、未登录或已失效',
        '50004' => '标识符错误',
        '50005' => '账号或密码错误',
        '50006' => '账号未通过验证，请拨打客服电话',
        '50007' => '账号已冻结',
        '50008' => '没有身份标识符',
        '50009' => '账号未激活',

        '60001' => '还没有职位信息，请到管理职位页面添加职位',
        '60002' => '该学员没有投递贵公司简历的记录',
        '60003' => '已达到每月投递次数的限额',
        '60004' => '已达到每日投递次数的限额',
        '60005' => '30天内不能重复投递同一岗位',
        '60006' => '该项目不能更改',

        '70001' => '上传失败',
        '70002' => '超过了配置文件上传文件的大小',
        '70003' => '超过了表单设置上传文件的大小',
        '70004' => '文件部分被上传',
        '70005' => '没有文件被上传',
        '70006' => '没有找到临时目录',
        '70007' => '文件不可写',
        '70008' => '由于PHP的扩展程序中断了文件上传',

        '80001' => '不能更改自己的权限',
        '80002' => '没有修改的权限',

    ];

    private static $table;

    private static $obj;

    public function __construct()
    {

    }

    /**
     *Ajax方式返回数据到客服端
     *@params mixed $data 要返回的数据,格式为$data['info'],$data['status'],$data['msg'];分别表示返回的数据、状态及提示信息
     *@retrun void
     **/
    public static function ajaxReturn($data,$type = '')
    {
        header('Content-type:application/json;charset=utf-8');
        //返回值是true和false时
        if ($data && is_bool($data))
            $response['status'] = '0';
        if (!$data && is_bool($data))
            $response['status'] = '10001';
        //如果只是返回状态值
        if (is_string($data))
            $response["status"] = $data;
        //如果不存在status状态值，设为未知错误
        if (!isset($response['status']) && !isset($data['status']))
            $response['status'] = '10002';
        if (isset($data['status']))
            $response['status'] = $data['status'];
        $response['msg'] = self::$status[$response['status']];
        if (isset($data['info']))
            $response['info'] = $data['info'];
        exit(json_encode($response));
    }
}