<?php
namespace App\api\Model;

use App\common\Model\baseModel;
use App\common\Model\commonModel;
use App\common\Model\tableInfoModel;
use App\common\Model\verifyModel;
use libs\Model\concernModel;

class studentModel extends baseModel
{
    const PAGE          = 1;
    const PAGESIZE      = 8;
    const RESUMEDAYS    = 30;                       //查看简历存在多少日内，单位天
    const RESUMEDAYNUMS = 10;                       //每天能投递多少份简历
    const RESUMEMONNUMS = 30;                       //每月能投递多少份简历
    const WORKNUMS      = 10;
    const EDUCATIONNUMS = 5;
    const PROJECTNUMS   = 10;

    private $accNumber;                             //已登录的账号
    private $paramAcc;                              //传入的账号
    private $where;
    private $tables;
    private $table;
    private $concern = [
        'concern'   => 'concerned',
        'concerned' => 'concern'
    ];
    private $_LG;
    private $_LP;
    private $destination = 'static/image/upload/student/thumb/';

    public function __construct($isVerify = true)
    {
        parent::__construct($isVerify);
        $this->accNumber = $this->getAccNumber();
        if ($this->accNumber) {
            $this->where  = ['stuId' => $this->accNumber];
            $this->table  = tableInfoModel::getLeading_student();
            $this->tables = [tableInfoModel::getLeading_student(),tableInfoModel::getLeading_student_info()];
        }
        global $_LP;
        global $_LG;
        if (count($_LP))
            $this->_LP = $_LP;
        if (count($_LG))
            $this->_LG = $_LG;
    }


    /**
     * 获得学生信息
     * @return array|string
     */
    public function getStudentInfo()
    {
        extract($this->_LP);
        //传递参数不全
        if (!$param)
            return '20001';
        //未登录
        if (!$this->getAccNumber())
            return '50001';
        return $this->getStudentInfoByParam($param);
    }

    /**
     * 通过param获得学生信息
     * @param $param    string 信息类型参数
     * @return mixed
     */
    public function getStudentInfoByParam($param)
    {
        switch ($param) {
            case 'center':
                $resp =  $this->getStudentCenterInfo();
                break;
            case 'base':
                $resp = $this->getStudentBaseInfo();
                break;
            case 'course':
                $resp = $this->getStudentCourseInfo();
                break;
            case 'project':
                $resp = $this->getStudentProjectInfo();
                break;
            case 'concern':
                $resp = $this->getStudentConcernOrConcerned($param);
                break;
            case 'concerned':
                $resp = $this->getStudentConcernOrConcerned($param);
                break;
            case 'recommend':
                $resp = $this->getStudentRecommendInfo();
                break;
            case 'work':
                $resp = $this->getStudentWorkInfo();
                break;
            case 'education':
                $resp = $this->getStudentEducationInfo();
                break;
            case 'resume':
                $resp = $this->getStudentResumeInfo();
                break;
            case 'resumeLog':
                $resp = $this->getStudentResumeLogInfo();
                break;
            default:
                $resp =  '20003';                                     //没有相关信息
        }
        if (is_string($resp))
            return $resp;
        else
            return $this->formatDatabaseResponse($resp);
    }

    /**
     * 获得学生的核心信息
     * @return mixed
     */
    public function getStudentCenterInfo()
    {
        return $this->fetchOneInfo($this->tables,['id','picUrl','status','name'],$this->where);
    }

    /**
     * 获得学生的基本信息
     * @return mixed
     */
    public function getStudentBaseInfo()
    {
        return parent::fetchOneInfo($this->tables,['name','mobile','email','sex','age','bloodType','provinceId','homeAddress','description'],$this->where);
    }

    /**
     * 获得学生的课程信息
     * @return array|string
     */
    public function getStudentCourseInfo()
    {
        $pages      = $this->getPages();
        @$courseId  = $this->_LP['courseId'];
        $info       = [];
        if (!$courseId)
            $courseIds = $this->fetchAllInfo(tableInfoModel::getStudent_course(),['courseId'],$this->where);
        if (!$courseId && empty($courseIds))
            return '20001';
        if ($courseId && !is_array($courseId)) {
            return $this->getStudentSelectCourseInfo($courseId,$pages['page'],$pages['pageSize']);
        }
        foreach ($courseIds as $courseId) {
            $info[$courseId['courseId']] = $this->getStudentSelectCourseInfo($courseId['courseId'],$pages['page'],$pages['pageSize']);
        }
        return $info;
    }

    /**
     * 通过courseId获得课程信息
     * @param $courseId
     * @param int $page
     * @param int $pageSize
     * @return mixed
     */
    public function getStudentSelectCourseInfo($courseId,$page = self::PAGE,$pageSize = self::PAGESIZE)
    {
        return getPage(tableInfoModel::getCourse_content(),['id','stageId','content'],['courseId' => $courseId],$page,$pageSize);
    }

    /**
     * 获得学员所有的项目信息
     * @return array
     */
    public function getStudentProjectInfo()
    {
        $table = [tableInfoModel::getProject(),tableInfoModel::getStudent_project()];
        $arr   = ['id','projectId','stuDescription','description','projectName','professional','status','startTime','endTime','picUrl','url'];
        $this->where['where2'] = ' AND s.`projectId` = f.`projectId`';
        return $this->fetchAllInfo($table,$arr,$this->where);
    }


    /**
     * 获得学员关注或被关注信息
     * @param $param
     * @return array
     */
    public function getStudentConcernOrConcerned($param)
    {
        $pages = $this->getPages();
        $where = [$param => $this->accNumber,'where2' => " AND s.`{$this->concern[$param]}` = f.`compId`"];
        $arr   = ['compId','email','compName'];
        $table = [tableInfoModel::getConcern(),tableInfoModel::getLeading_company()];
        return getPage($table,$arr,$where,$pages['page'],$pages['pageSize']);
    }

    /**
     * 获得推荐所有的信息
     * @return array
     */
    public function getStudentRecommendInfo()
    {
        $pages = $this->getPages();
        $where = ['recommendId' => $this->accNumber,'where2' => ' AND s.`stuId` = f.`stuId`'];
        $arr   = ['id','stuId','dateinto','name','mobile'];
        $table = [tableInfoModel::getRecommend(),tableInfoModel::getLeading_student()];
        return getPage($table,$arr,$where,$pages['page'],$pages['pageSize']);
    }


    /**
     * 获得所有学员的工作经历信息
     * @return mixed
     */
    public function getStudentWorkInfo()
    {
        $arr = ['id','workOut','dateWork','salary','compName','jobName','description'];
        return $this->fetchAllInfo(tableInfoModel::getStudent_work(),$arr,$this->where);
    }

    /**
     * 获得学员的教育经历
     * @return mixed
     */
    public function getStudentEducationInfo()
    {
        $arr = ['id','major','eduSchool','dateinto','dateout','highest'];
        return $this->fetchAllInfo(tableInfoModel::getStudent_education(),$arr,$this->where);
    }

    /**
     * 获得学员的简历信息
     * @return mixed
     */
    public function getStudentResumeInfo()
    {
        $info['base']       = $this->getStudentBaseInfo();
        $info['work']       = $this->getStudentWorkInfo();
        $info['education']  = $this->getStudentEducationInfo();
        $info['project']    = $this->getStudentProjectInfo();
        return $info;
    }

    /**
     * 获得学员投递简历记录
     */
    public function getStudentResumeLogInfo()
    {
        //获得页码信息
        $pages = $this->getPages();
        $arr   = ['compId','jobId','jobName','r_status','resumeTime'];
        //获得某个时间段的简历信息
        $time  = time() - self::RESUMEDAYS * 24 * 60 * 60;
        $this->where['where2'] = " AND s.`jobId` = f.`jobId` AND resumeTime > $time ORDER BY resumeTime DESC ";
        $resp  = getPage([tableInfoModel::getLeading_job(),tableInfoModel::getLeading_resume_log()],$arr,$this->where,$pages['page'],$pages['pageSize']);
        var_dump($resp);
        exit;
    }

    /**
     * 上传学生头像
     * @return mixed
     */
    public function uploadStudentPic()
    {
        $obj = new commonModel();
        return $obj->uploadPic(tableInfoModel::getLeading_student_info(),$this->where,$this->destination);
    }

    /**
     * 修改学员密码
     * @return string
     */
    public function modifyStudentPass()
    {
        @$oldPass = $this->_LP['oldPass'];
        @$newPass = [$this->_LP['password_1'],$this->_LP['password_2']];
        $obj      = new commonModel();
        return $obj->modifyPass($newPass,$oldPass);
    }

    /**
     *修改学员基本信息，姓名、手机号、邮箱、家庭地址、籍贯、性别、血型、年龄及个人简介,不能把信息修改为空
     * @return array|string
     */
    public function modifyStudentBaseInfo()
    {
        //传参不能为空
        if (empty($this->_LP))
            return '20001';
        extract(array_filter($this->_LP));
        //如果修改字段有手机号，且已注册
        if ($mobile && verifyModel::verifyAccNumberIsSigned($mobile))
            return '30008';
        //如果修改字段有邮箱，且已注册
        if ($email && verifyModel::verifyAccNumberIsSigned($email))
            return '30009';
        return $this->modifyStudentInfo($this->tables,$this->where);
    }

    /**
     * 修改信息
     * @param $table   array|string 修改的数据表
     * @param $where   array        修改条件
     * @return mixed
     */
    public function modifyStudentInfo($table,$where)
    {
        //判断递交的信息是否安全
        if (!verifyModel::verifyInfoIsTrue($table,array_keys($this->_LP)))
            return '20002';
        $res = parent::fetchOneInfo($table,array_keys($this->_LP),$where);
        //身份标识符错误
        if (!count($res))
            return '50004';
        $arr = array_diff_assoc($this->_LP,$res);
        //不用重复修改
        if (!count($arr))
            return '30001';
        return parent::formatDatabaseResponse(parent::updateInfo($table,$arr,$where));
    }

    /**
     * 修改工作经验信息
     * @return array|string
     */
    public function modifyStudentWorkInfo()
    {
        //传参不能为空
        if (empty($this->_LP))
            return '20001';
        extract(array_filter($this->_LP));
        //没有身份标识符
        if (!$id)
            return '50008';
        $this->where['id'] = $id;
        return $this->modifyStudentInfo(tableInfoModel::getStudent_work(),$this->where);
    }

    /**
     * 修改学员项目经验
     * @return array|string
     */
    public function modifyStudentProjectInfo()
    {
        //传参不能为空
        if (empty($this->_LP))
            return '20001';
        extract(array_filter($this->_LP));
        //没有身份标识符
        if (!$projectId)
            return '50008';
        $this->where['projectId'] = $projectId;
        $res_1 = $this->fetchOneInfo(tableInfoModel::getProject(),['type'],['projectId' => $projectId]);
        //只能修改学员本身的项目，教学项目学员没有修改的权限
        if ($res_1['type'] != 2)
            return '80002';
        return $this->modifyStudentInfo([tableInfoModel::getProject(),tableInfoModel::getStudent_project()],$this->where);
    }

    /**
     * 修改学员教育经验
     * @return array|string
     */
    public function modifyStudentEducationInfo()
    {
        //传参不能为空
        if (empty($this->_LP))
            return '20001';
        extract(array_filter($this->_LP));
        //没有身份标识符
        if (!$id)
            return '50008';
        $this->where['id'] = $id;
        return $this->modifyStudentInfo(tableInfoModel::getStudent_education(),$this->where);
    }

    /**
     * 学员添加一条工作经验
     * @return array|string
     */
    public function addStudentOneWorkInfo()
    {
        if (empty($this->_LP))
            return '20001';
        //获得已有的工作经历数量
        $this->table = tableInfoModel::getStudent_work();
        $count = getNum($this->table,['id'],$this->where);
        //工作经历最多10条
        if ($count >= self::WORKNUMS)
            return '30003';
        //判断递交的信息是否安全
        if (!verifyModel::verifyInfoIsTrue($this->table,$this->_LP))
            return '20002';
        //不能重复添加
        if (!verifyModel::verifyIsRepeat($this->table,$this->_LP))
            return '30002';
        $res_3 = parent::insert($this->table,$this->_LP);
        return parent::formatDatabaseResponse($res_3);
    }

    /**
     * 学员添加一条教育经验
     * @return array|string
     */
    public function addStudentOneEducationInfo()
    {
        if (empty($this->_LP))
            return '20001';
        //获得已有的工作经历数量
        $this->table = tableInfoModel::getStudent_education();
        $count = getNum($this->table,['id'],$this->where);
        //教育经历最多5条
        if ($count >= self::EDUCATIONNUMS)
            return '30003';
        //判断递交的信息是否安全
        if (!verifyModel::verifyInfoIsTrue($this->table,$this->_LP))
            return '20002';
        //不能重复添加
        if (!verifyModel::verifyIsRepeat($this->table,$this->_LP))
            return '30002';
        $res_3 = parent::insert($this->table,$this->_LP);
        return parent::formatDatabaseResponse($res_3);
    }

    /**
     * 学员添加一条项目经验
     * @return array|string
     */
    public function addStudentOneProjectInfo()
    {
        if (empty($this->_LP))
            return '20001';
        //获得已有的工作经历数量
        $this->table = [tableInfoModel::getProject(),tableInfoModel::getStudent_project()];
        $count = getNum($this->table,['id'],$this->where);
        //不能超过最多项目经历
        if ($count >= self::PROJECTNUMS)
            return '30003';
        //判断递交的信息是否安全
        if (!verifyModel::verifyInfoIsTrue($this->table,$this->_LP))
            return '20002';
        //标注是学员自己的项目，不是公司提供的
        $this->_LP['type'] = 2;
        //不能重复添加
        if (!verifyModel::verifyIsRepeat($this->table,$this->_LP))
            return '30002';
        $res_3 = parent::insert($this->table,$this->_LP);
        return parent::formatDatabaseResponse($res_3);
    }




}