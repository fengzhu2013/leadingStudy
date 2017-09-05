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
    public function getCourses()
    {
        $response = $this->obj->getCourses();
        parent::ajaxReturn($response);
    }

    //获得某个课程的课程信息
    public function getCourseInfo()
    {

    }

    //获得所有的开班信息，如没有课程id，默认56803，即web前端，没有地址，默认1，指上海
    public function getClassesList()
    {
        $response = $this->obj->getClassesList();
        parent::ajaxReturn($response);
    }

    //获得某个班级的具体信息
    public function getClassInfo()
    {
        $response = $this->obj->getClassInfo();
        parent::ajaxReturn($response);
    }

    //获得所有的新闻列表信息
    public function getNewsList()
    {
        $response = $this->obj->getNewsList();
        parent::ajaxReturn($response);
    }

    //获得新闻详细信息
    public function getNewsInfo()
    {
        $response = $this->obj->getNewsInfo();
        parent::ajaxReturn($response);
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