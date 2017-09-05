<?php
namespace App\common\Model;
use framework\common\Model\ucpaasModel;

class messageModel extends baseModel
{
    const MSGNUMS       = 10;

    public $options     = [];
    public $ucpass;

    private $appid      = '9fa2742b7c2a49bbbc45b2384b5cce50';

    private $clientType = 0;                        //计费方式。0  开发者计费；1 云平台计费。默认为0

    //发送方手机号
    private $to         = '18917095102';

    private $mobile;

    private $templateType = [1 => '136583',2 => '136584'];    //1、注册验证，2、通知短信

    private $templateId;

    private $param      = '';

    private $paramNums  = 4;

    private $d_count    = 0;           //今日发送了多少次

    private $last_time  = '';         //上次发送的时间

    private $table;

    public function __construct($to,$type = 1,$paramNums = 4,$accountsid = 'a64930b1655fe2d43c3d374b8d53b099',$token = '5b6574cf0247efaa226c675ca43d4cfe')
    {
        $this->to           = $to;
        $this->templateId   = $this->templateType[$type];
        $this->paramNums    = $paramNums;
        //初始化必填
        $this->options['accountsid'] =$accountsid;
        $this->options['token']      =$token;
        $this->ucpass       = new ucpaasModel($this->options);
    }

    public function sendMsg()
    {
        //检验手机号
        if (!isMobile($this->to))
            return '30005';
        //获取改手机号上次发送的验证码信息
        $this->getMobileLastInfo();
        //验证上一次发送信息是否在同一天
        $this->verifyCreate_time();
        //发送的信息次数是否已到上限
        if ($this->d_count >= self::MSGNUMS)
            return '30011';
        //生成相应的验证码
        $this->createParam();
        //发送短信
        $resp = $this->ucpass->templateSMS($this->appid,$this->to,$this->templateId,$this->param);
        //解析成数组
        $response = json_decode($resp,true);
        $status = $response['resp']['respCode'];
        if ($status != '000000')
            return '10001';
        //插入数据
        $this->insertParam();
        return true;
    }

    /**
     * 把相应的数据插入数据库
     */
    private function insertParam()
    {
        $arr = ['msg_code' => $this->param,'create_time' => time(),'d_count' => $this->d_count + 1,'mobile' => $this->to];
        parent::insert($this->table,$arr);
    }


    /**
     * 生成相应几位的随机数
     */
    private function createParam()
    {
        for ($i = 0;$i < $this->paramNums;$i++) {
            $this->param .= mt_rand(1,9);
        }
    }

    /**
     * 获取改手机号上次发送的验证码信息
     */
    private function getMobileLastInfo()
    {
        $this->table  = tableInfoModel::getLeading_message_code();
        $arr    = ['create_time','d_count'];
        $where  = ['mobile' => $this->to,'where2' => ' ORDER BY create_time DESC'];
        $resp   = parent::fetchOneInfo($this->table,$arr,$where);
        if (isset($resp['create_time']))
            $this->last_time = $resp['create_time'];
        if (isset($resp['d_count']))
            $this->d_count = $resp['d_count'];
    }

    /**
     *验证上一次发送信息是否在同一天，如果在同一天，d_count不变，否则，归0
     */
    private function verifyCreate_time()
    {
        if ($this->last_time && !verifyInDay($this->last_time))
            $this->d_count = 0;
    }




}