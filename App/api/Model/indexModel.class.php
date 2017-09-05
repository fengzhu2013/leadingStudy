<?php
namespace App\api\Model;

use App\common\Model\baseModel;
use App\common\Model\tableInfoModel;
use App\common\Model\verifyModel;

class indexModel extends baseModel
{
    const CLASSNUMS     = 10;               //开班信息，默认一次获取10条
    const NEWSNUMS      = 4;                //新闻信息，默认一次获取4条

    public $_LP;
    public $_LG;
    public $courseId;
    public $addressId;
    public $newsId;
    public $table;
    public $where;
    public function __construct($isVerify = false)
    {
        parent::__construct($isVerify);
        global $_LP;
        global $_LG;
        if (isset($_LP))
            $this->_LP = $_LP;
        if (isset($_LS))
            $this->_LG = $_LG;
    }

    //获得所有的开售的课程名称
    public function getCourses()
    {
        $arr = ['courseId','status','courseName'];
        $res = parent::fetchAllInfo(tableInfoModel::getCourse(),$arr,[]);
        return parent::formatDatabaseResponse($res);
    }

    //获得某个课程的课程信息
    public function getCourseInfo()
    {
        //课程id不能为空
        if (empty($this->_LP))
            return '20001';
    }

    //获得所有的开班信息，如没有课程id，默认56803，即web前端，没有地址，默认1，指上海
    public function getClassesList()
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
    public function getClassInfo()
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
        //获取改课程的学费信息
        $res_2 = parent::fetchOneInfo(tableInfoModel::getTuition(),['tuitionMoney'],$this->where);
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
        $arr = ['id','description'];
        $res = parent::fetchOneInfo($this->table,$arr,$this->where);
        //没有置顶的信息，还是取四条信息，按时间降序
        if (empty($res)) {
            $this->where = ['where2' => ' ORDER BY news_data DESC LIMIT '.self::NEWSNUMS];
        } else {
            $this->where = ['where2' => ' ORDER BY news_data DESC LIMIT '.self::NEWSNUMS -1];
        }
        $res_2 = parent::fetchAllInfo($this->table,$arr,$this->where);
        return parent::formatDatabaseResponse($res_2);
    }

    //获得新闻详细信息
    public function getNewsInfo()
    {
        @$id = $this->_LP['newId'];
        if (!$id)
            return '20001';
        $res = parent::fetchOneInfo(tableInfoModel::getLeading_news(),['*'],['id' => $id]);
        if (empty($res))
            return '50004';
        return parent::formatDatabaseResponse($res);
    }

    //获得所有的招聘信息，按时间排布
    public function getRecruitsList()
    {

    }

    //获得某个招聘职位的详细信息
    public function getRecruitInfo()
    {

    }


}