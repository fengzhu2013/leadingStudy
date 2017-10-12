<?php
namespace App\api\Controller;

use App\api\Model\editModel;
use App\common\Controller\baseController;

class editController extends baseController
{
    private $obj;

    public function __construct()
    {
        $this->obj = new editModel();
        if (!$this->obj->getAccNumber())
            parent::ajaxReturn('50002');            //未登录
        if (!$this->obj->isTrue)                         //登录的账号不是编辑员的
            parent::ajaxReturn('50010');
    }

    //获得编辑者的基本信息
    public function getEditBaseInfo()
    {
        $response = $this->obj->getEditBaseInfo();
        parent::ajaxReturn($response);
    }

    //获得一个班级的所有学员信息
    public function getStudentListForClass()
    {
        $response = $this->obj->getStudentListForClass();
        parent::ajaxReturn($response);
    }

    //获得项目列表信息
    public function getProjectList()
    {
        $response = $this->obj->getProjectList();
        parent::ajaxReturn($response);
    }

    //获得一个项目的详细信息
    public function getOneProjectInfo()
    {
        $response = $this->obj->getOneProjectInfo();
        parent::ajaxReturn($response);
    }

    //获得轮播图列表信息
    public function getCarouselList()
    {
        $response = $this->obj->getCarouselList();
        parent::ajaxReturn($response);
    }

    //获得视频列表信息
    public function getVedioList()
    {
        $response = $this->obj->getVedioList();
        parent::ajaxReturn($response);
    }

    //处理临时注册信息
    public function handleTempInfo()
    {
        $response = $this->obj->handleTempInfo();
        parent::ajaxReturn($response);
    }

    //获得注册信息
    public function getRegisterInfo()
    {
        $response = $this->obj->getRegisterInfo();
        parent::ajaxReturn($response);
    }

    //获得所有大🉑️课信息
    public function getCourseList()
    {
        $response = $this->obj->getCourseList();
        parent::ajaxReturn($response);
    }

    //修改大课程信息
    public function modifyCourseInfo()
    {
        $response = $this->obj->modifyCourseInfo();
        parent::ajaxReturn($response);
    }

    //添加一条大课信息
    public function addOneCourse()
    {
        $response = $this->obj->addOneCourse();
        parent::ajaxReturn($response);
    }

    //修改密码
    public function modifyPass()
    {
        $response = $this->obj->modifyPass();
        parent::ajaxReturn($response);
    }

    //展示一个课程下的所有班级
    public function getClassForCourse()
    {
        $response = $this->obj->getClassForCourse();
        parent::ajaxReturn($response);
    }

    //添加一个班级
    public function addOneClass()
    {
        $response = $this->obj->addOneClass();
        parent::ajaxReturn($response);
    }

    //为班级添加教师
    public function addTeacherForClass()
    {
        $response = $this->obj->addTeacherForClass();
        parent::ajaxReturn($response);
    }

    //获得一个班级的详细信息
    public function getClassInfo()
    {
        $response = $this->obj->getClassInfo();
        parent::ajaxReturn($response);
    }

    //修改一个班级信息
    public function modifyClassInfo()
    {
        $response = $this->obj->modifyClassInfo();
        parent::ajaxReturn($response);
    }

    //新增一个项目
    public function addOneProject()
    {
        $response = $this->obj->addOneProject();
        parent::ajaxReturn($response);
    }

    //修改账号状态
    public function modifyAccNumberStatus()
    {
        $response = $this->obj->modifyAccNumberStatus();
        parent::ajaxReturn($response);
    }

    //修改职员的权限
    public function modifyAccNumberRangeId()
    {
        $response = $this->obj->modifyAccNumberRangeId();
        parent::ajaxReturn($response);
    }


}