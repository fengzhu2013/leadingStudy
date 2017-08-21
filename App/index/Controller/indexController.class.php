<?php
namespace App\index\Controller;
use App\common\Model\commonModel;
use framework\common\Model\imageCodeModel;
use App\common\Model\verifyModel;
use framework\libs\core\DB;
use framework\libs\core\VIEW;
use App\common\Model\tableInfoModel;

class indexController
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
        var_dump($this->instance->uploadPic(tableInfoModel::getLeading_student_info(),['stuId' => '1601321102'],'static/image/upload/student/thumb/'));
    }

    public function testVerifyAccNumberIsLogined()
    {
        var_dump(verifyModel::verifyAccNumberIsLogined('hxq6@5686it.cn'));
    }

    public function testSendMail()
    {
        var_dump($this->instance->sendEMail('359418894@qq.com','仙人掌','13552112345','1',myMd5('123456')));
    }

}