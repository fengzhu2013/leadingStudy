<?php
namespace App\api\Controller;

use App\api\Model\indexModel;
use App\common\Controller\baseController;

class indexController extends baseController
{
    private $obj;

    public function __construct()
    {
        $this->obj = new indexModel();
    }


    //获得所有的开售的课程名称
    public function getAllCourse()
    {
        $response = $this->obj->getAllCourse();
        parent::ajaxReturn($response);
    }

    //获得某个课程的课程信息
    public function getOneCourseInfo()
    {
        $response = $this->obj->getOneCourseInfo();
        parent::ajaxReturn($response);
    }

    //获得所有的开班信息，如没有课程id，默认56803，即web前端，没有地址，默认1，指上海
    public function getClassList()
    {
        $response = $this->obj->getClassList();
        parent::ajaxReturn($response);
    }

    //获得某个班级的具体信息
    public function getOneClassInfo()
    {
        $response = $this->obj->getOneClassInfo();
        parent::ajaxReturn($response);
    }

    //获得所有的新闻列表信息
    public function getNewsList()
    {
        $response = $this->obj->getNewsList();
        parent::ajaxReturn($response);
    }

    //获得新闻详细信息
    public function getOneNewsInfo()
    {
        $response = $this->obj->getOneNewsInfo();
        parent::ajaxReturn($response);
    }

    //获得所有的招聘信息，按时间排布
    public function getRecruitList()
    {
        $response = $this->obj->getRecruitList();
        parent::ajaxReturn($response);
    }

    //获得某个招聘职位的详细信息
    public function getOneJobInfo()
    {
        $response = $this->obj->getOneJobInfo();
        parent::ajaxReturn($response);
    }

    //获得某个班级的学员列表信息
    public function getStudentListForClass()
    {
        $response = $this->obj->getStudentListForClass();
        parent::ajaxReturn($response);
    }

    public function getProjectList()
    {
        $response = $this->obj->getProjectList();
        parent::ajaxReturn($response);
    }

    //获得某个项目的详细信息
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






}