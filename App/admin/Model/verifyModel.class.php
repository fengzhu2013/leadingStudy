<?php
namespace App\admin\Model;
use App\admin\Model\checkModel;
class verifyModel
{
    
    /**
     * @验证手机号是否已经注册
     * @return boolean true表示有注册
     */
    public static function verifyMobile($mobile)
    {
        $obj = new checkModel();
        $arr = array();
        $where['mobile'] = $mobile; 
        $table = array('leading_student','leading_teacher','leading_staff_info','leading_company','temp_register');
        foreach($table as $key=>$value){
            $res = $obj->getInfo_byArr($value,$arr,$where);
            if(count($res) >0 && ($res['id'] > 0)){
                $res = true;
                break;
            }
        }
        return $res;
    }
    
    /**
     * @验证邮箱是否已经注册
     * @return boolean true 表示有注册
     */
    public static function verifyEmail($email)
    {
        $obj = new checkModel();
        $arr = array();
        $where['email'] = $email;
        $table = array('leading_student','leading_teacher','leading_staff_info','leading_company','temp_register');
        foreach($table as $key=>$value){
            $res = $obj->getInfo_byArr($value,$arr,$where);
            if(count($res)>0 && ($res['id'] > 0)){
                $res = true;
                break;
            }
        }
        return $res;
    }
    
    /**
     * @获得图片的4位验证码
     */
    public static function getVerifyCode()
    {
        $str = '';
        $data = [];
        $strAll = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz0123456789';
        $max = strlen($strAll) - 1;
        for($i=0;$i<4;$i++){
            $str .= $strAll[rand(0,$max)];
        }
        if($str){
            $time = time();
            //存入session中
            $_SESSION['verifyCode'] = strtolower($str);//换成小写
            $_SESSION['codeExpTime'] = $time;
            $data['info'] = array("verifyCode"=>$str,"codeExpTime"=>$time);
            $data['status'] = 0;
            $data['msg'] = 'success';
        }else{
            $data['status'] = 1;
            $data['msg'] = '获取验证码失败';
        }
        return $data;
    }
    /**
     * @验证图片验证码是否有效
     * @return boolean true 表示有效
     */
    public static function verifyPicCode($verifyCode)
    {
        $res = false;
        $now = time();
        if(($now-120) > $_SESSION['codeExpTime']){//120失效
            $res = false;
        }else{
            if(strtolower($verifyCode) == $_SESSION['verifyCode']){//相等
                $res = true;   
            }
        }
        return $res;
    }
    /**
    * 根据省份编号获得省份名称
    * @date: 2017年5月15日 下午4:25:46
    * @author: lenovo2013
    * @param: int 省份编号
    * @return:
    */
    public static function  province($provinceId)
    {
        $obj = M('province');
        $arr = array('province');
        $where['provinceId'] = $provinceId;
        $data = $obj->getInfo_byArr($arr,$where);
        return $data;
    }
    public static function verifyEducation($stuId)
    {
        $obj = M('student_education');
        $arr = array('id','major','eduSchool');
        $where['stuId'] = $stuId;
        $where2 = "order by dateOut desc";
        return $obj->getInfo_byArr($arr,$where,$where2);
    }
}