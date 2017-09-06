<?php
namespace App\common\Model;
use framework\common\Model\uploadFileModel;
use framework\common\Model\mailerModel;
class commonModel extends baseModel
{
    private $mailPassTitle = '上海领思教育科技有限公司，找回密码邮件系统：';

    private $table;
    private $tableKey;

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
     * @return mixed
     */
    public function getAccNumberType($accNumber)
    {
        $obj = new tableInfoModel();
        $resp = [];
        //手机号
        if (isMobile($accNumber))
            return 'mobile';
        //邮箱号
        if (isMail($accNumber))
            return 'email';
        //学号
        if ($this->verifyIsStuId($accNumber)) {
            $resp['table'] = tableInfoModel::getLeading_student();
            $resp['key'] = $obj->getKeyByUser($resp['table']);
        }
        //教师号
        if ($this->verifyIsTeacherId($accNumber)) {
            $resp['table'] = tableInfoModel::getLeading_teacher();
            $resp['key'] = $obj->getKeyByUser($resp['table']);
        }
        //员工号
        if ($this->verifyIsStaffId($accNumber)) {
            $resp['table'] = tableInfoModel::getLeading_staff_info();
            $resp['key'] = $obj->getKeyByUser($resp['table']);
        }
        //企业号
        if ($this->verifyIsCompId($accNumber)) {
            $resp['table'] = tableInfoModel::getLeading_company();
            $resp['key'] = $obj->getKeyByUser($resp['table']);
        }
        //临时号
        if ($this->verifyIsTmpId($accNumber)) {
            $resp['table'] = tableInfoModel::getTemp_register();
            $resp['key'] = $obj->getKeyByUser($resp['table']);
        }
        return $resp;
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
     * @return bool
     */
    public function sendEMail($email,$name,$mobile,$caseId,$token)
    {
        $toUser   = $email;
        $title    = $this->mailPassTitle;
        $content  = $this->formatEmailContent($name,$mobile,$caseId,$token);
        return $this->sendMail($toUser,$title,$content);
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


    /**
     * 修改密码，主要应用于登录之后修改，不用于编辑员修改其他用户密码
     * @param $newPass  array 包括新密码及确认密码
     * @param $oldPass  string  修改密码时需要输入旧的密码
     * @return string
     */
    public function modifyPass($newPass,$oldPass)
    {
        //提交的信息不全
        if (!$oldPass || count($newPass) != 2)
            return '20001';
        //旧密码错误
        if (!verifyModel::verifyOldPass($oldPass,$this->getUserInfo()))
            return '40001';
        //如果没有传身份标识符，就用已登录的账号，主要是编辑员更改其他账号是需要传身份标识符
        $accNumber = $this->getAccNumber();
        //没有身份标识符
        if (!$accNumber)
            return '50008';
        //密码长度不符合规定
        if (!verifyLen($newPass[0],6,16))
            return '40004';
        //新密码与确认密码不一样
        if ($newPass[0] !== $newPass[1])
            return '40003';
        $password = myMd5($newPass[0]);
        //新密码与旧密码一至
        if ($newPass[0] == $oldPass)
            return '40002';
        $keyAndTable = $this->getAccNumberType($accNumber);
        $resp = $this->updateInfo($keyAndTable['table'],['password' => $password],[$keyAndTable['key'] => $accNumber]);
        if ($resp > 0) {
            //更新session中的密码值
            $_SESSION['user']['password'] = $password;
            return '0';
        } else {
            return '10001';
        }
    }

    /**
     * 登录，
     * @param $accNumber    string 账号，可以是手机号，邮箱号，或身份唯一标识符
     * @param $password     string 密码
     * @param $imageCode    string 图片验证码
     * @return array|string
     */
    public function login($accNumber,$password)
    {
        if ($this->getAccNumber())
            return '50001';                             //已登录
        /*if (!verifyModel::verifyCode($imageCode))
            return '30006'; */                            //图片验证码错误
        //获得账号类型
        $accNumberType = $this->getAccNumberType($accNumber);
        $password = myMd5($password);                   //密码加密
        if (is_string($accNumberType)) {                //查询所有的表
            $resp = $this->loginAll($accNumber,$password,$accNumberType);
        } else {
            $resp = $this->loginOne($accNumber,$password,$accNumberType);
        }
        //账号或密码错误
        if (count($resp) == 0)
            return '50005';
        //账号没有通过验证
        if ($resp['status'] == 0)
            return '50009';
        //登录基本信息存入session中
        $_SESSION['user'] = $resp;
        $_SESSION['user']['user_expTime'] = time();
        session_write_close();
        $res['status'] = '0';
        if ($this->table == tableInfoModel::getTemp_register())
            $res['info'] = ['caseId' => 8];                     //表明临时表
        else
            $res['info'] = ['caseId' => $resp['caseId'],'accNumber' => $resp[$this->tableKey]];
        //在登录日志中插入一条记录
        $this->insert(tableInfoModel::getLogin_log(),['accNumber' => $resp[$this->tableKey],'caseId' => $resp['caseId'],'loginTime' => time()]);
        return $res;
    }

    /**
     * 只查询一个表就登录,
     * @param $accNumber   string   登录账号，可以是身份标识符，手机号或邮箱
     * @param $password     string  密码
     * @param $accNumberType    array 包含了accNumber的key值，还有相应的数据表名
     * @return mixed
     */
    private function loginOne($accNumber,$password,$accNumberType)
    {
        $obj = new tableInfoModel();
        $this->table = $accNumberType['table'];
        @$where = ['password' => $password,$accNumberType['key'] => $accNumber];
        $this->tableKey = $obj->getKeyByUser($this->table);
        @$arr = ['id',"{$this->tableKey}",'password','mobile','email','caseId','status'];
        return $this->fetchOneInfo($this->table,$arr,$where);
    }

    /**
     * 查询所有的表--登录
     * @param $accNumber    string 登录账号，可以是身份标识符，手机号或邮箱
     * @param $password     sring 密码
     * @param $accNumberType    string 账号类型
     * @return mixed
     */
    private function loginAll($accNumber,$password,$accNumberType)
    {
        $obj = new tableInfoModel();
        $tableArr = $obj->getUserTable();                                   //获得所有的用户数据表
        foreach ($tableArr as $table) {
            $accNumberType_2 = ['table' => $table,'key' => $accNumberType];   //格式化loginOne的accNumberType
            $resp = $this->loginOne($accNumber,$password,$accNumberType_2);   //查询一个表来登录
            $count = count($resp);
            /*if ($table == tableInfoModel::getTemp_register() && $count)     //如果是临时账号，caseId改成0
                $resp['caseId'] = 0;*/
            if ($count)
                return $resp;
        }
    }

    /**
     * 注册
     * @param $mobile   string 注册手机号
     * @param $email    string  注册邮箱号
     * @param $name     string  注册用户名，如果是公司注册，就为企业名
     * @param $password string  登录密码
     * @param $caseId   string  注册账号类型
     * @param $verifyCode   string  手机验证码
     * @param null $invitation  string 邀请账号
     * @return array|string
     */
    /*public function sign($mobile,$email,$name,$password,$caseId,$verifyCode,$invitation = '')
    {
        $res_1 = verifyModel::verifyMobileCode($verifyCode,$mobile);
        //手机验证码错误或已失效
        if (!$res_1 || !is_bool($res_1))
            return $res_1;
        //手机号已注册
        if (verifyModel::verifyAccNumberIsSigned($mobile))
            return '30008';
        //邮箱已注册
        if (verifyModel::verifyAccNumberIsSigned($email))
            return '30009';
        //插入临时表中
        $tmpId = $this->productTempId();
        if (!$tmpId)
            return '10002';
        $arr = ['tmpId' => $tmpId,'name' => $name,'mobile' => $mobile,'email' => $email,'password' => myMd5($password),'caseId' => $caseId,'recommendId' => $invitation];
        $res = $this->insert(tableInfoModel::getTemp_register(),$arr);
        return $this->formatDatabaseResponse($res);
    }*/

    /**
     * 注册
     * @param $msgCode string   手机验证码
     * @param $mobile  string   手机号
     * @param $password
     * @return array|bool|string
     */
    public function sign($msgCode,$mobile,$password)
    {
        if (!isMobile($mobile))
            return '30005';
        //手机号已注册
        if (verifyModel::verifyAccNumberIsSigned($mobile))
            return '30008';
        $res_1 = verifyModel::verifyMobileCode($msgCode,$mobile);
        //手机验证码错误或已失效
        if (!$res_1 || !is_bool($res_1))
            return $res_1;
        //插入临时数据库
        //插入临时表中
        $tmpId = $this->productTempId();
        if (!$tmpId)
            return '10002';
        $arr = ['tmpId' => $tmpId,'mobile' => $mobile,'password' => myMd5($password),'caseId' => 8,'dateinto' => time()];
        $res = $this->insert(tableInfoModel::getTemp_register(),$arr);
        return $this->formatDatabaseResponse($res);
    }

    /**
     * 注销登录信息
     * @return string
     */
    public function logout()
    {
        //未登录
        if (!$this->getAccNumber())
            return '50002';
        //注销掉所有的信息,必须要加上具体的键值
        unset($_SESSION['user']);
        //为了测试方便，先注释掉
        /*unset($_SESSION['code']);
        unset($_SESSION['code_exptime']);*/
        return '0';
    }

    /**
     * 发送注册验证码短信
     * @param $mobile
     * @return bool|string
     */
    public function sendMobileMsg($mobile,$type)
    {
        //注册验证短信
        $obj = new messageModel($mobile,$type);
        return $obj->sendMsg();
    }

    /**
     *
     * @param $id
     * @return string
     */
    public function getNameById($id)
    {
        $resp = $this->getAccNumberType($id);
        //标识符错误

        if (!is_array($resp) || !count($resp))
            return '50004';
        $arr = ['name'];
        if ($resp['table'] == tableInfoModel::getLeading_company())
            $arr = ['compName'];
        return parent::fetchOneInfo($resp['table'],$arr,[$resp['key'] => $id]);
    }


}