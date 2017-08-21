<?php
namespace App\common\Model;

class verifyModel extends baseModel
{
    const CODE_EXPTIME      = 12000;                        //图片验证码有效期，单位秒
    const TOKEN_EXPTIME     = 7200;                         //邮箱验证码有效期2h，单位秒

    public function __construct($isVerify = false)
    {
        parent::__construct($isVerify);
    }

    /**
     * 验证验证码是否正确
     * @param $code  string 验证码
     * @return bool 正确返回true
     */
    public static function verifyCode($code)
    {
        $res = false;
        if (isset($_SESSION['code']) && isset($_SESSION['code_exptime']) && ($_SESSION['code_exptime'] + self::CODE_EXPTIME > time())) {
            if (strtolower($code) == strtolower($_SESSION['code']))
                $res = true;
        }
        return $res;
    }

    /**
     * @param $accNumber string  需要验证的账号
     * @return bool 如果注册了，返回true
     */
    public static function verifyAccNumberIsLogined($accNumber)
    {
        $res = false;
        if (isMobile($accNumber))
            $key = 'mobile';
        if (isMail($accNumber))
            $key = 'email';
        $resp = parent::fetchOneInfo(tableInfoModel::getTemp_register(),['id'],[$key => $accNumber]);
        if (count($resp))
            $res = true;
        return $res;
    }

    /**
     * 验证邮箱链接是否有效
     * @param $mobile
     * @param $token
     * @param $case
     * @return bool
     */
    public static function verifyEmailLinkIsTrue($mobile,$token,$case)
    {
        $res   = false;
        $where = ['token' => $token,'mobile' => $mobile];
        $obj   = new tableInfoModel();
        $table = $obj->getTableByCase($case);
        $resp  = parent::fetchOneInfo($table,['id','token_exptime'],$where);
        if (count($resp) && isset($resp['token_exptime']) && $resp['token_exptime'] + self::TOKEN_EXPTIME > time())
            $res = true;
        return $res;
    }



}