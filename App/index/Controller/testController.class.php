<?php
namespace App\index\Controller;
use App\common\Model\commonModel;
use App\common\Model\messageModel;
use framework\common\Model\imageCodeModel;
use App\common\Model\verifyModel;
use framework\libs\core\DB;
use framework\libs\core\VIEW;
use App\common\Model\tableInfoModel;

class testController
{
    private $obj;
    private $table;
    private $instance;
    public function __construct()
    {
        $this->table = 'leading_student';
        $this->obj = M($this->table);
        $this->instance = new commonModel(false);
    }

    public function index()
	{
		echo 'hello world!';
	}
	public function testCreateFile()
    {
        $createFiles = [];
        $string = " | access_token                |
                    | carousel_figure             |
                    | concern                     |
                    | course                      |
                    | course_content              |
                    | course_goal_ablity          |
                    | course_goal_problem         |
                    | course_goal_value           |
                    | course_project              |
                    | course_stage                |
                    | leading_address             |
                    | leading_class               |
                    | leading_class_teacher       |
                    | leading_company             |
                    | leading_company_info        |
                    | leading_job                 |
                    | leading_news                |
                    | leading_resume_log          |
                    | leading_sign                |
                    | leading_staff_case          |
                    | leading_staff_info          |
                    | leading_student             |
                    | leading_student_info        |
                    | leading_teacher             |
                    | leading_teacher_info        |
                    | login_log                   |
                    | note                        |
                    | project                     |
                    | province                    |
                    | recommend                   |
                    | second_course               |
                    | second_course_sign          |
                    | student_course              |
                    | student_education           |
                    | student_project             |
                    | student_work                |
                    | teacher_courseware          |
                    | teaching_course             |
                    | temp_register               |
                    | tuition                     |
                    | vedio                       |
                    | vedio_download|";
        //1、把字符串分割成数组
        preg_match_all('/[a-z_]{1,}/i',$string,$matches);
        $createFiles = $matches[0];
        print_r($matches);
        exit;
        $i = 0;
/*        foreach ($createFiles as $createFile) {
            $fileName = $createFile.'Model.class.php';
            $filePath = './libs/Model/'.$fileName;          //文件名
            $fileContent = "<?php\r\nnamespace libs\Model;\r\nclass {$createFile}Model extends tableModel\r\n{\r\n\tprivate static ".'$table'." = $createFile;\r\n\tprotected static ".'$'."$createFile = []; \r\n}";
            if (!file_exists($filePath)) {
                $newFile = fopen($filePath,'w+');
                fwrite($newFile,$fileContent);
            }

        }*/
    }

    public function testQuery()
    {
        $sql = "SELECT * FROM ".$this->table." LIMIT 1";
        var_dump($this->obj->query($sql));
    }

    public function testInsert()
    {
        $arr = ['stuId' => '1708321102','name' => 'worry','mobile' => '18976543210','email' => '18976543210@163.com'];
        var_dump($this->obj->insert($this->table,$arr));
    }

    public function testInsertSql()
    {
        $sql = " INSERT INTO `leading_student_info`(stuId,sex) VALUES('1708321102',1);";
        var_dump($this->obj->insertSql($sql));
    }

    public function deleteRow()
    {
        $where = " stuId = '1708321102'";
        var_dump($this->obj->deleteRow($this->table,$where));
    }

    public function testDeleteArr()
    {
        $where = ['stuId' => '1708321102'];
        var_dump($this->obj->deleteArr('leading_student_info',$where));
    }

    public function testDeleteSql()
    {
        $sql = "delete from leading_student_info where stuId = '1708321102'";
        var_dump($this->obj->deleteSql($sql));
        var_dump($this->obj->deleteSql($sql));
    }

    public function testUpdateInfo()
    {
        $table = [$this->table,'leading_student_info'];
        $arr = ['name' => 'Worry_2'];
        $where = ['stuId' => '1708321102'];
        var_dump($this->obj->updateInfo($table,$arr,$where));
    }

    public function testUpdateSql()
    {
        $sql = "update leading_student set name = 'Worry_2' where stuId = '1601321102'";
        var_dump($this->obj->updateSql($sql));
    }

    public function testFetchOneSql()
    {
        $sql = "select * from leading_student where stuId = '1601321102'";
        var_dump($this->obj->fetchOneSql($sql));
    }

    public function testFetchOneInfo()
    {
        $arr = ['id','mobile','password','name'];
        $where = ['stuId' => '1601321102'];
        var_dump($this->obj->fetchOneInfo([$this->table,'leading_student_info'],$arr,$where));
    }

    public function testFetchAllSql()
    {
        $sql = "select * from leading_student limit 8";
        var_dump($this->obj->fetchAllSql($sql));
    }

    public function testFetchAllInfo()
    {
        $arr = ['id','name','stuId'];
        $where = ['where2' => 's.id < 10'];
        var_dump($this->obj->fetchAllInfo([$this->table,'leading_student_info'],$arr,$where));
    }

    public function testGetNums()
    {
        $sql = "select * from leading_student_info";
        var_dump($this->obj->getNums($sql));
    }
    public function testGetNum()
    {
        var_dump($this->obj->getNum('leading_student_info',['id','stuId'],[]));
    }

    public function testGetPage()
    {
        $arr = ['*'];
        $where = ['where2' => ' id < 10 '];
        var_dump(getPage('leading_student_info',$arr,$where,1,8));
    }

    public function testGetPages()
    {
        $arr = ['id','stuId','name','age','sex'];
        $where = ['where2' => ' s.`stuId` = f.`stuId` AND s.`id` < 10 '];
        var_dump(getPage([$this->table,'leading_student_info'],$arr,$where,1,8));
    }

    public function testShowTpl()
    {
        VIEW::display('index.html');
    }

    public function testGetTable()
    {
        var_dump(tableInfoModel::getLeading_company().'<br />');
        var_dump(tableInfoModel::getLeading_student().'<br />');
        var_dump(tableInfoModel::getLeading_staff_info().'<br />');
        var_dump(tableInfoModel::getKeyByUser('student').'<br />');
        $obj = new tableInfoModel();
        var_dump($obj->getTableByCase(2));
    }

    public function testGetImageCode()
    {
        $obj = new imageCodeModel();
        $obj->toString();
    }

    public function testGetCode()
    {
        var_dump($_SESSION);
    }

    public function testCreateStuId()
    {
        $obj = new commonModel(false);
        var_dump($obj->productStuId());
    }

    public function testCreateTeacherId()
    {
        $obj = new commonModel(false);
        var_dump($obj->productTeacherId());
    }

    public function testCreateCompId()
    {
        $obj = new commonModel(false);
        var_dump($obj->productCompId());
    }

    public function testCreateStaffId()
    {
        $obj = new commonModel(false);
        var_dump($obj->productStaffId());
    }

    public function testCreateTmpId()
    {
        $obj = new commonModel(false);
        var_dump($obj->productTempId());
    }

    public function testVerifyIsStuId()
    {
        var_dump($this->instance->verifyIsStuId('1601321101'));
    }

    public function testVerifyIsCompId()
    {
        var_dump($this->instance->verifyIsCompId('com5680001'));
    }

    public function testVerifyAccNumberType()
    {
        var_dump($this->instance->verifyAccNumberType('18917095100'));
    }

    public function testUploadPic()
    {
        //var_dump($this->instance->uploadPic(tableInfoModel::getLeading_teacher_info(),['stuId' => '1601321102'],'static/image/upload/edit/thumb/',null,null,true,340,337));
        var_dump($this->instance->uploadPic(tableInfoModel::getLeading_teacher_info(),['stuId' => '1601321102'],'/Users/hxq568/Desktop/官网/lingsi2.0_9-21 2/img/class/',null,null,true,490,260));
    }

    public function testVerifyAccNumberIsLogined()
    {
        var_dump(verifyModel::verifyAccNumberIsLogined('hxq6@5686it.cn'));
    }

    public function testSendMail()
    {
        var_dump($this->instance->sendEMail('359418894@qq.com','仙人掌','13552112345','1',myMd5('123456')));
    }

    public function testModifyPass()
    {
        var_dump($this->instance->modifyPass(['123456','123456'],'123'));
    }

    public function testLogin()
    {
        var_dump($this->instance->login('1601321102','cheng1','gv3c'));
    }

    public function testGetTimestamp()
    {
        var_dump(strtotime('2017-09-07').'/9/7<br />');
        var_dump(strtotime('2017-09-09').'/9/9<br />');
        var_dump(strtotime('2017-09-16').'/9/16<br />');
        var_dump(strtotime('2017-09-23').'/9/23<br />');
        var_dump(strtotime('2017-10-14').'/10/14<br />');
        var_dump(strtotime('2017-10-27').'/10/27<br />');
        var_dump(strtotime('2017-10-30').'/10/30<br />');
        var_dump(strtotime('2017-10-12').'/10/12<br />');
        var_dump(strtotime('2017-10-19').'/10/19<br />');
        var_dump(strtotime('2017-10-26').'/10/26<br />');
        var_dump(strtotime('2017-10-10').'/10/10<br />');
        var_dump(strtotime('2017-10-17').'/10/17<br />');
        var_dump(strtotime('2017-10-24').'/10/24<br />');
        var_dump(strtotime('2017-11-01').'/11/01<br />');
        var_dump(strtotime('2017-11-27').'/11/27<br />');
        var_dump(strtotime('2017-11-14').'/11/14<br />');
        var_dump(strtotime('2017-11-21').'/11/21<br />');
        var_dump(strtotime('2017-11-28').'/11/28<br />');
        var_dump(strtotime('2017-12-10').'/12/10<br />');
        var_dump(strtotime('2017-12-15').'/12/15<br />');
    }

    public function testSendMobileMsg()
    {
        $obj = new messageModel();
        $obj->testSendMsg();
    }

    public function testMacDown()
    {
        $string = "'00000'     => 'success',
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
        '80002' => '没有修改的权限',";
        preg_match_all("/\d{5}/",$string,$matches);
        preg_match_all("/=>\s'.*'/",$string,$matches1);
        foreach ($matches1[0] as $val) {
            $res[] = str_replace("=> '",null,$val);
        }
        foreach ($res as $val) {
            $res_2[] = str_replace("'",null,$val);
        }
        for ($i = 0;$i < count($res_2);$i++) {
            $str .= '|'.$matches[0][$i].'|'.$res_2[$i].'|<br />';
        }
        var_dump($str);
        exit;
        var_dump($matches);
        var_dump($matches1);
        var_dump($res);
        var_dump($res_2);

    }
    public function getExplode()
    {
        $arr = explode(',','dfadfa');
        var_dump($arr);
    }
}