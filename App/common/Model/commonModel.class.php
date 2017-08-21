<?php
namespace App\common\Model;
use framework\common\Model\uploadFileModel;
use framework\common\Model\mailerModel;
class commonModel extends baseModel
{
    private $mailPassTitle = '上海领思教育科技有限公司，找回密码邮件系统：';

    public function __construct($isVerify = true)
    {
        parent::__construct($isVerify);
    }

    /**
     * 根据班级及上学地点生成学号
     * 学号10位数字组成的字符串
     * 1,2位是当前年份后两位，如2017年的17
     * 3，4，位是班级号，1改为01，两位数不变
     * 5，6位是上课地点编号，改变如上
     * 7，8，9，10位是该班级的第几位学员
     * return string
     */
    public function productStuId($classId = null,$addressId = null)
    {
        //获得1，2位
        $classId          = is_null($classId)?1:$classId;
        $addressId        = is_null($addressId)?1:$addressId;
        $year             = substr(date('y-m-d'),0,2);//获取入学年份

        //获得最后一个学生学号
        $arr              = array('id','stuId');
        $where['classId'] = $classId;
        $where['where2']  = " ORDER BY  id DESC ";
        $data = parent::fetchOneInfo(tableInfoModel::getLeading_student_info(),$arr,$where);

        //规定学生数量，获得7，8，9，10
        if(count($data)>0){
            $lastStuId = substr($data['stuId'],-4,4);
            $num       = $lastStuId + 1;
        }else{
            $num = '0001';
        }
        //规定班级号，获得3，4位
        $len = strlen($classId);
        if($len == 1){
            $classId = "0".$classId;
        }
        //获得5，6位
        $addressId = (strlen($addressId) == 2)?$addressId:"0".$addressId;
        $stuId     = $year.$classId.$addressId.$num;
        return $stuId;
    }


    /**
     * 生成教师号如   t56801,不超过十位
     * 获得最后一个教师号，去除‘t’字符，然后加1
     * return string
     */
    public function productTeacherId()
    {
        $teacherId       = '';
        $arr             = array('id','teacherId');
        $where['where2'] = ' ORDER BY id DESC ';
        $res             = parent::fetchOneInfo(tableInfoModel::getLeading_teacher(),$arr,$where);
        //去除学号的第一't'字符
        if(count($res) > 0){
            $last = substr($res['teacherId'],1);
            $num  = $last + 1;
        }
        if($num)
            $teacherId = 't'.$num;
        return $teacherId;
    }


    /**
     * 生成企业号 如com5680001,不超过10位
     * 获得最后一个企业号，去掉前缀'com'，然后加1
     * return string
     */
    public function productCompId()
    {
        $compId = '';
        $arr             = array('id','compId');
        $where['where2'] = ' ORDER BY id DESC ';
        $res             = parent::fetchOneInfo(tableInfoModel::getLeading_company(),$arr,$where);
        //去掉前缀，然后加1
        if(count($res) > 0){
            $last = substr($res['compId'],3);
            $num  = $last + 1;
            $compId = 'com'.$num;
        }
        return $compId;
    }


    /**
     * 生成员工号 如 ls5680001
     * return string
     */
    public function productStaffId()
    {
        $staffId         = '';
        $arr             = array('id','accNumber');
        $where['where2'] = ' ORDER BY id DESC ';
        $res             = parent::fetchOneInfo(tableInfoModel::getLeading_staff_info(),$arr,$where);
        if(count($res) > 0){
            $last = substr($res['accNumber'],2);
            $num  = $last + 1;
            $staffId = 'ls'.$num;
        }
        return $staffId;
    }


    /**
     * 生成临时号 如 tmp5680001
     */
    public function productTempId()
    {
        $tempId          = '';
        $arr             = array('tmpId','id');
        $where['where2'] = ' ORDER BY id DESC';
        $res             = parent::fetchOneInfo(tableInfoModel::getTemp_register(),$arr,$where);
        if(count($res) > 0){
            $last = substr($res['tmpId'],3);
            $num  = $last + 1;
            $tempId = 'tmp'.$num;
        }
        return $tempId;
    }

    /**
     * 验证学号
     * @param string $accNumber
     * @return number
     */
    public function verifyIsStuId($accNumber)
    {
        $res = 0;
        $len = is_string($accNumber)?strlen(trim($accNumber)):0;
        if ($len == 10)
            $res = preg_match('/^[\d]{10}$/',trim($accNumber));
        return $res;
    }

    /**
     * 验证企业号
     * @param string $accNumber
     * @return int 0|1
     */
    public function verifyIsCompId($accNumber)
    {
        $res = 0;
        $len = is_string($accNumber)?strlen(trim($accNumber)):0;
        if ($len == 10) {
            $res = preg_match('/^(com)([\d]{7})$/',trim($accNumber));
        }
        return $res;
    }

    /**
     * 验证员工号
     * @param string $accNumber
     * @return int 0|1
     */
    public function verifyIsStaffId($accNumber)
    {
        $res = 0;
        $len = is_string($accNumber)?strlen(trim($accNumber)):0;
        if ($len == 9)
            $res = preg_match('/^(ls)([\d]{7})$/',trim($accNumber));
        return $res;
    }


    /**
     * 验证临时账号
     * @param string $accNumber
     * @return number 1|0
     */
    public function verifyIsTmpId($accNumber)
    {
        $res = 0;
        $len = is_string($accNumber)?strlen(trim($accNumber)):0;
        if ($len == 10)
            $res = preg_match('/^(tmp)([\d]{7})$/',trim($accNumber));
        return $res;
    }

    /**
     * 验证教师号
     * @param string $accNumber
     * @return int 0|1
     */
    public function verifyIsTeacherId($accNumber)
    {
        $res = 0;
        $len = is_string($accNumber)?strlen(trim($accNumber)):0;
        if ($len == 6)
            $res = preg_match('/^(t)([\d]{5})$/',trim($accNumber));
        return $res;
    }

    /**
     * 验证角色号
     * @param string $accNumber
     * @return int
     */
    public function verifyAccNumberType($accNumber)
    {
        $obj = new tableInfoModel();
        //手机号
        if (isMobile($accNumber))
            return 'mobile';
        //邮箱号
        if (isMail($accNumber))
            return 'email';
        //学号
        if ($this->verifyIsStuId($accNumber))
            return $obj->getKeyByUser(tableInfoModel::getLeading_student());
        //教师号
        if ($this->verifyIsTeacherId($accNumber))
            return $obj->getKeyByUser(tableInfoModel::getLeading_teacher());
        //员工号
        if ($this->verifyIsStaffId($accNumber))
            return $obj->getKeyByUser(tableInfoModel::getLeading_staff_info());
        //企业号
        if ($this->verifyIsCompId($accNumber))
            return $obj->getKeyByUser(tableInfoModel::getLeading_company());
        //临时号
        if ($this->verifyIsTmpId($accNumber))
            return $obj->getKeyByUser(tableInfoModel::getTemp_register());
    }


    /**
     * 上传图片，默认生成149x185大小的缩略图，更新相关数据表字段
     * @param $table    string  需要更新的数据表
     * @param $where    array   更新条件
     * @param $destination  string  存放地址 static/image/upload/student/thumb
     * @param null $urlName string  更新字段,默认为picUrl
     * @param null $size    int     上传的文件不能超过该值,默认为2M 单位为字节
     * @param bool $thumb           是否生成缩略图,默认生成149x185
     * @param int $dst_w    int     缩略图的宽
     * @param int $dst_h    int     缩略图的高
     * @param bool $isReservedSource    是否保存原图资源
     * @return mixed
     */
    public function uploadPic($table,$where,$destination,$urlName=null,$size = null,$thumb = true,$dst_w = 149,$dst_h = 185,$isReservedSource = false)
    {
        $obj = new uploadFileModel();
        $msg = $obj->uploadFileImg($size);
        $status = '70001';                          //上传失败
        if (is_array($msg)) {                               //文件上传成功
            if (count($msg) > 0 ) {                         //且数量超过一个
                $fileName    = $obj->getImgPath().'/'.$msg[0]['name'];
                $destination = $destination.$msg[0]['name'];
                if ($thumb) {
                    $resource = $obj->thumb($fileName,$destination,$dst_w,$dst_h,$isReservedSource);
                } else {
                    $resource = $obj->thumb($fileName,$destination,null,null,$isReservedSource,1);  //不生成缩略图
                }
                $des         = preg_replace('/^[\.]/','',$destination);
                $url         = ROOT_PATH.$des;
                $urlName     = is_null($urlName)?'picUrl':$urlName;
                $arr         = array("{$urlName}" => $url);
                $res         = parent::updateInfo($table,$arr,$where);
                return parent::formatDatabaseResponse($res);
            }
        }
        return $status;
    }




    /**
     * @param $email
     * @param $name
     * @param $mobile
     * @param $caseId
     * @param $token
     * @return int|string
     */
    public function sendEMail($email,$name,$mobile,$caseId,$token)
    {
        $toUser   = $email;
        $title    = $this->mailPassTitle;
        $content  = $this->formatEmailContent($name,$mobile,$caseId,$token);
        $flag     = $this->sendMail($toUser,$title,$content);
        if ($flag)
            return 0;
        else
            return '10001';
        /* $flag = $this->sendMail('359418894@qq.com','上海领思教育重置密码','<span style="color:red;">重置密码</span><br/>重置密码');
        return parent::formatResponse($flag); */
    }
    /**
     * 格式化邮箱内容
     * @param string $name      用户名|企业名
     * @param string $mobile    手机号
     * @param int $caseId       账号类型
     * @param string $token     验证码
     * @return string
     */
    public function formatEmailContent($name,$mobile,$caseId,$token)
    {
        $content = "尊敬的" . $name . "：<br/>此邮件仅是帮您重置密码。<br/>点击链接重置你的密码。<br/><a href='".ROOT_PATH."index.php/api/admin/verifyEmailLinkIsTrue?token=" . $token . "&caseId=".$caseId."&mobile=".$mobile."' target='_blank'>".ROOT_PATH."index.php/api/admin/verifyEmailLinkIsTrue?token=" .  $token . "&caseId=".$caseId."&mobile=".$mobile . "</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接2小时内有效。<br/>如果此次操作请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'>-------- 上海领思教育科技有限公司</p>";
        return $content;
    }

    /**
     * 发送邮箱
     * @param string $to        邮箱接受者
     * @param string $title     邮箱主题
     * @param string $content   邮箱内容
     * @return boolean          发送成功为true
     */
    public function sendMail($to, $title, $content)
    {
        $mail = new mailerModel();                  // 实例化PHPMailer核心类
        // $mail->SMTPDebug = 1;                    //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->isSMTP();                            // 使用smtp鉴权方式发送邮件
        $mail->SMTPAuth   = true;                   // smtp需要鉴权 这个必须是true
        $mail->Host       = 'smtp.qq.com';          // 链接qq域名邮箱的服务器地址
        $mail->SMTPSecure = 'ssl';                  // 设置使用ssl加密方式登录鉴权
        $mail->Port       = 465;                    // 设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
        $mail->CharSet    = 'UTF-8';                // 设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
        $mail->FromName   = '测试邮件发送';            // 设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->Username   = '913346548@qq.com';     // smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Password   = 'veyveedaidgwbeed';     // smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）【非常重要：在网页上登陆邮箱后在设置中去获取此授权码】
        $mail->From       = '913346548@qq.com';     // 设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
        $mail->isHTML(true);                        // 邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
        $mail->addAddress($to);                     // 设置收件人邮箱地址
        $mail->Subject    = $title;                 // 添加该邮件的主题
        $mail->Body       = $content;               // 添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
        // 简单的判断与提示信息
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }



    public function forgetPass($newPass,$accNumber )
    {

    }



}