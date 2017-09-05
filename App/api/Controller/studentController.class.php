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

    //修改学生简历信息
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

}