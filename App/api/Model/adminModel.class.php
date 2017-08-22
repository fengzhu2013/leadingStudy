<?php
namespace App\api\Model;

use App\common\Model\baseModel;
use App\common\Model\commonModel;
use App\common\Model\tableInfoModel;
use App\common\Model\verifyModel;

class adminModel extends baseModel
{
    const TOKEN_EXPTIME     = 7200;                         //邮箱验证码有效期2h，单位秒
    private $obj;
    private $table;                             //当前操作表
    private $info;                              //当前获得的信息
    public function __construct($isVerify = false)
    {
        parent::__construct($isVerify);
        $this->obj = new commonModel($isVerify);
        $this->table = '';
    }

    /**
     * 用户注册
     * @return array|string
     */
    public function sign()
    {
        global $_LS;
        extract($_LS);
        //递交的信息不齐全
        if (!($mobile && $name && $password && $caseId && $email))
            return '20001';
        //不存在手机验证码，默认123456，前期资本考虑，不加入手机验证码
        if (!isset($verifyCode))
            $verifyCode = '123456';
        //不存在推荐账号，默认为空
        if (!isset($invitation))
            $invitation = null;
        //不是手机号
        if (!isMobile($mobile))
            return '30005';
        //邮箱账号格式错误
        if (!isMail($email))
            return '30010';
        return $this->obj->sign($mobile,$email,$name,$password,$caseId,$verifyCode,$invitation);
    }

    /**
     * 忘记密码，通过邮件找回密码
     * 先验证传入的账号信息是否正确，如果正确，就发送邮件
     * @return int|string
     */
    public function forgetPass()
    {
        global $_LS;
        extract($_LS);
        if (!($mobile && $email))
            return '20001';
        if (!isMobile($mobile))
            return '30005';
        if (!isMail($email))
            return '30010';
        $obj = new tableInfoModel();
        $tableArr = $obj->getUserTable();
        //获得账号所在的数据表
        $where = ['mobile' => $mobile,'email' => $email];
        foreach ($tableArr as $table) {
            $res = $this->fetchOneInfo($table,['id','name','caseId'],$where);
            if (count($res)) {
                $this->table = $table;
                $this->info  = $res;
                break;
            }
        }
        //账号信息错误
        if (!$this->table)
            return '50004';
        $token = myMd5($this->table.time());
        $token_exptime = time();
        //发送邮件
        $resp = $this->obj->sendEMail($email,$this->info['name'],$mobile,$this->info['caseId'],$token);
        if ($resp) {
            //更新token及token_exptime，并返回成功代号
            $this->updateInfo($this->table,['token' => $token,'token_exptime' => $token_exptime],$where);
            return '0';
        } else {
            return '10001';                         //发送邮件失败
        }
    }


    /**
     * 验证邮箱的链接是否有效
     * @return bool
     */
    public function verifyEmailLinkIsTrue()
    {
        global $_LG;
        extract($_LG);
        //传递参数不全
        if (!($mobile && $token && $caseId))
            return '20001';
        return verifyModel::verifyEmailLinkIsTrue($mobile,$token,$caseId,self::TOKEN_EXPTIME);
    }

    /**
     * 重置密码
     * @return array|string
     */
    public function resetPass()
    {
        global $_LS;
        extract($_LS);
        if (!($mobile && $caseId && $password_1 && $password_2))
            return '20001';
        if ($password_1 !== $password_2)
            return '40003';
        $obj = new tableInfoModel();
        $table = $obj->getTableByCase($caseId);
        $where = ['mobile' => $mobile];
        $res = $this->fetchOneInfo($table,['id','token_exptime'],$where);
        //标识符错误
        if (!count($res)) {
            return '50004';
        }
        if (isset($res['token_exptime']) && $res['token_exptime'] + self::TOKEN_EXPTIME > time())
            $resp = $this->updateInfo($table,['password' => myMd5($password_2)],$where);
        else
            return '40005';                             //链接失效
        return $this->formatDatabaseResponse($resp);
    }

    public function login()
    {
        global $_LG;
        extract($_LG);
        //传参不全
        if (!($accNumber && $password && $verifyCode))
            return '20001';

    }




}