<?php
namespace App\api\Controller;

use App\api\Model\studentModel;
use App\common\Controller\baseController;

class studentController extends baseController
{
    private $obj;

    public function __construct()
    {
        $this->obj = new studentModel();
        if (!$this->obj->getAccNumber())
            parent::ajaxReturn('50002');            //未登录
        if (!$this->obj->isTure)                         //登录的账号和当前模块不一致
            parent::ajaxReturn('50010');
    }

    /**
     * 获得学生信息
     */
    public function getStudentInfo()
    {
        $response = $this->obj->getStudentInfo();
        parent::ajaxReturn($response);
    }

    //上传头像
    public function uploadPic()
    {
        $response = $this->obj->uploadStudentPic();
        parent::ajaxReturn($response);
    }

    //修改学生密码
    public function modifyStudentPass()
    {
        $response = $this->obj->modifyStudentPass();
        parent::ajaxReturn($response);
    }

    //修改学生基本信息
    public function modifyStudentBaseInfo()
    {
        $response = $this->obj->modifyStudentBaseInfo();
        parent::ajaxReturn($response);
    }

    //修改学生工作信息
    public function modifyStudentWorkInfo()
    {
        $response = $this->obj->modifyStudentWorkInfo();
        parent::ajaxReturn($response);
    }

    //修改学生项目信息
    public function modifyStudentProjectInfo()
    {
        $response = $this->obj->modifyStudentProjectInfo();
        parent::ajaxReturn($response);
    }

    //修改学生教育信息
    public function modifyStudentEducationInfo()
    {
        $response = $this->obj->modifyStudentEducationInfo();
        parent::ajaxReturn($response);
    }

    //添加一条教育信息
    public function addStudentOneEducationInfo()
    {
        $response = $this->obj->addStudentOneEducationInfo();
        parent::ajaxReturn($response);
    }

    //添加一条项目经验
    public function addStudentOneProjectInfo()
    {
        $response = $this->obj->addStudentOneProjectInfo();
        parent::ajaxReturn($response);
    }

    //添加一条工作经验
    public function addStudentOneWorkInfo()
    {
        $response = $this->obj->addStudentOneWorkInfo();
        parent::ajaxReturn($response);
    }

    //获得学员的简历信息
    public function getStudentResumeInfo()
    {
        $response = $this->obj->getStudentResumeInfo();
        parent::ajaxReturn($response);
    }

    //学员查看投递简历记录
    public function getStudentResumeLogInfo()
    {
        $response = $this->obj->getStudentResumeLogInfo();
        parent::ajaxReturn($response);
    }

    //学员投递简历
    public function sendResume()
    {
        $response = $this->obj->sendResume();
        parent::ajaxReturn($response);
    }

}