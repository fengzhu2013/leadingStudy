<?php
namespace App\common\Model;

class verifyModel extends baseModel
{
    const CODE_EXPTIME      = 12000;                        //图片验证码有效期，单位秒

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
    public static function verifyAccNumberIsSigned($accNumber)
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
    public static function verifyEmailLinkIsTrue($mobile,$token,$case,$token_exptime)
    {
        $res   = false;
        $where = ['token' => $token,'mobile' => $mobile];
        $obj   = new tableInfoModel();
        $table = $obj->getTableByCase($case);
        $resp  = parent::fetchOneInfo($table,['id','token_exptime'],$where);
        if (count($resp) && isset($resp['token_exptime']) && $resp['token_exptime'] + $token_exptime > time())
            $res = true;
        return $res;
    }


    /**
     * 验证旧密码是否正确
     * @param $oldPass  string 旧密码
     * @param $userInfo array   已登录的信息数组，包含了密码信息
     * @return bool     相等返回true
     */
    public static function verifyOldPass($oldPass,$userInfo)
    {
        $res = false;
        if (count($userInfo) && !empty($userInfo['password']) && $userInfo['password'] == myMd5($oldPass))
            $res = true;
        return $res;
    }

    /**
     * 验证手机验证码是否正确
     * @param $code
     * @return bool
     */
    public static function verifyMobileCode($code,$mobile)
    {
        $where = ['msg_code' => $code,'mobile' => $mobile];
        $table = tableInfoModel::getLeading_message_code();
        $resp  = parent::fetchOneInfo($table,['create_time'],$where);
        //验证码错误
        if (empty($resp))
            return '30007';
        if (isset($resp['create_time']) && $resp['create_time'] + 180 > time())
            return true;
        //默认验证码失效
        return '30012';
    }

    /**
     * 验证信息是否安全，安全返回true
     * @param $table array|string   所在的表
     * @param $info  array          验证信息,字段
     * @return bool
     */
    public static function verifyInfoIsTrue($table,$info)
    {
        $obj = M($table);
        return $obj->verifyInfoIsTrue($table,$info);
    }

    /**
     * 验证是否重复执行某个动作，重复返回false
     * @param $table
     * @param $info
     * @return bool
     */
    public static function verifyIsRepeat($table,$info)
    {
        $res_2 = parent::fetchOneInfo($table,['id'],$info);
        if (count($res_2))
            return false;
        return true;
    }

    /**
     * 判断课程id是否正确，正确返回true
     * @param $courseId
     * @return bool
     */
    public static function verifyCourseIdIsTrue($courseId)
    {
        $res = parent::fetchOneInfo(tableInfoModel::getCourse(),['coursName'],['courseId' => $courseId]);
        return !empty($res);
    }

    public static function verifyAddressIdIsTrue($addressId)
    {
        $res = parent::fetchOneInfo(tableInfoModel::getLeading_address(),['address'],['addressId' => $addressId]);
        return !empty($res);
    }

    public static function verifyClassIdIsTrue($classId)
    {
        $res = parent::fetchOneInfo(tableInfoModel::getLeading_class(),['className'],['classId' => $classId]);
        return !empty($res);
    }
}