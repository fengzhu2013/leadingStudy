<?php
namespace App\api\Model;

use App\common\Model\baseModel;
use App\common\Model\commonModel;
use App\common\Model\tableInfoModel;
use App\common\Model\verifyModel;

class indexModel extends baseModel
{
    const CLASSNUMS     = 10;               //开班信息，默认一次获取10条
    const NEWSNUMS      = 4;                //新闻信息，默认一次获取4条

    public $courseId;
    public $addressId;
    public $newsId;
    public $table;
    public $where;
    public function __construct($isVerify = false)
    {
        parent::__construct($isVerify);
    }

    //获得所有的开售的课程名称
    public function getAllCourse()
    {
        $arr = ['courseId','status','courseName'];
        $res = parent::fetchAllInfo(tableInfoModel::getCourse(),$arr,[]);
        return parent::formatDatabaseResponse($res);
    }

    //获得某个课程的课程信息
    public function getOneCourseInfo()
    {
        //课程id不能为空
        if (empty($this->_LP['courseId']))
            return '20001';
        $pages = parent::getPages();
        $this->table = [tableInfoModel::getCourse_content(),tableInfoModel::getCourse_stage()];
        $arr   = ['id','stageName','content','focus'];
        $where = ['courseId' => $this->_LP['courseId'],'where2' => ' AND s.`stageId` = f.`stageId`'];
        $resp  = getPage($this->table,$arr,$where,$pages['page'],$pages['pageSize']);
        return parent::formatDatabaseResponse($resp);
    }

    //获得所有的开班信息，如没有课程id，默认56803，即web前端，没有地址，默认1，指上海
    public function getClassList()
    {
        @$coursId   = $this->_LP['courseId'];
        @$addressId = $this->_LP['addressId'];
        $this->courseId   = isset($courseId)?$courseId:'';                    //默认web前端
        $this->addressId  = isset($addressId)?$addressId:1;                   //默认地址上海
        //判断课程id是否正确，若不正确，默认为56803
        if ($this->courseId && !verifyModel::verifyCourseIdIsTrue($this->courseId))
            $this->courseId = '56803';
        //判断地址id是否正确，若不正确，默认1
        if (!verifyModel::verifyAddressIdIsTrue($this->addressId))
            $this->addressId = 1;
        $res = $this->getClassesByCourseIdAndAddressId();
        return parent::formatDatabaseResponse($res);
    }

    /**
     * 根据课程id即地址id获取开班信息，如果没有课程id，条件就没有课程id，按开课时间升序
     * @param null $courseId
     * @param null $addressId
     * @return mixed
     */
    public function getClassesByCourseIdAndAddressId($courseId = null,$addressId = null)
    {
        if ($courseId)
            $this->courseId = $courseId;
        if ($addressId)
            $this->addressId = $addressId;
        //搜索条件是开课时间大于当前，且升序
        $this->where = ['addressId' => $this->addressId,'where2' => ' AND startClassTime > '.time().' ORDER BY startClassTime'];
        if ($this->courseId)
            $this->where['courseId'] = $this->courseId;
        return getPage(tableInfoModel::getLeading_class(),['classId','className','startClassTime'],$this->where,1,self::CLASSNUMS);
    }

    //获得某个班级的具体信息
    public function getOneClassInfo()
    {
        @$classId = $this->_LP['classId'];
        //没有传参数
        if (!$classId)
            return '20001';
        $this->where = ['classId' => $classId];
        //获得课程详细信息
        $res = parent::fetchOneInfo(tableInfoModel::getLeading_class(),['*'],$this->where);
        //课程标识符错误
        if (empty($res))
            return '50004';
        $obj   = new commonModel();
        $resp  = $obj->getNameById($res['masterId']);
        $res['masterName'] = $resp['name'];
        //获取改课程的学费信息
        $where = ['courseId' => $res['courseId'],'caseId' => $res['classType'],'teaching' => 1,'tuitionCase' => 1];
        $res_2 = parent::fetchOneInfo(tableInfoModel::getTuition(),['tuitionMoney'],$where);
        if (empty($res_2))
            $res_2 = ['tuitionMoney' => 10000];
        $resp = array_merge($res,$res_2);
        return parent::formatDatabaseResponse($resp);

    }

    //获得所有的新闻列表信息
    public function getNewsList()
    {
        $this->where = ['where2' => ' ORDER BY news_data DESC'];
        $this->table = tableInfoModel::getLeading_news();
        //先获取置顶的列表
        $this->where['top'] = 1;
        $arr = ['id','description','news_data'];
        $res = parent::fetchOneInfo($this->table,$arr,$this->where);
        $pages = parent::getPages();
        //没有置顶的信息，按时间降序
        $this->where = ['where2' => ' ORDER BY news_data DESC'];
        if (!empty($res)) {
            $pages['pageSize'] = $pages['pageSize'] - 1;
        }
        $res_2 = getPage($this->table,$arr,$this->where,$pages['page'],$pages['pageSize']);
        return parent::formatDatabaseResponse($res_2);
    }

    //获得新闻详细信息
    public function getOneNewsInfo()
    {
        @$id = $this->_LP['id'];
        if (!$id)
            return '20001';
        $res = parent::fetchOneInfo(tableInfoModel::getLeading_news(),['*'],['id' => $id]);
        if (empty($res))
            return '50004';
        return parent::formatDatabaseResponse($res);
    }

    //获得所有的招聘信息，按时间排布
    public function getRecruitList()
    {
        if (isset($this->_LP['compId'])) {
            $obj = new commonModel(false);
            $res = $obj->getNameById($this->_LP['compId']);
        }
        //企业标识符错误
        if (isset($this->_LP['compId']) && isset($res['compName']) && empty($res['compName']))
            return '20001';
        //默认当传入企业id时，需要查询的字段
        $arr = ['jobId','jobName','compId','jobDate'];
        //默认查询职位表
        $this->table = tableInfoModel::getLeading_job();
        //如果没有传入企业id，查询职位表和企业表（获得企业名），查询字段要加个企业名
        if (!isset($this->_LP['compId'])) {
            $this->table = [tableInfoModel::getLeading_job(),tableInfoModel::getLeading_company()];
            $arr[]       = 'compName';
            $this->where = ['where2' => ' WHERE s.`compId` = f.`compId` AND s.`status` = 0 ORDER BY jobDate DESC' ];
        }
        //如果传入了企业id，查询条件要加一个compId = '***'
        if (isset($this->_LP['compId']))
            $this->where = ['compId' => $this->_LP['compId'],'status' => 0,'where2' => ' ORDER BY jobDate DESC'];
        $pages = parent::getPages();
        $resp  = getPage($this->table,$arr,$this->where,$pages['page'],$pages['pageSize']);
        //如果存在企业号，把企业名合并到返回数组
        if (isset($this->_LP['compId'])) {
            $resp['data']['compName'] = $res['compName'];
        }
        return parent::formatDatabaseResponse($resp);
    }

    /**
     * 获得某个招聘职位的详细信息
     * @return array|string
     */
    public function getOneJobInfo()
    {
        if (!$this->_LP['jobId'])
            return '20001';
        $obj  = new companyModel(false);
        $resp = $obj->getJobInfoById($this->_LP['jobId']);
        return parent::formatDatabaseResponse($resp);
    }

    /**
     * 获得某个班级的学员列表信息
     * @return mixed|string
     */
    public function getStudentListForClass()
    {
        $obj = new editModel(false);
        return parent::formatDatabaseResponse($obj->getStudentListForClass());
    }


}