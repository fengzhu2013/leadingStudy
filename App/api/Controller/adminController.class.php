<?php
namespace App\api\Controller;

use App\admin\Model\adminModel;
use App\common\Controller\baseController;

class adminController extends baseController
{
    private $obj;

    public function __construct()
    {
        $this->obj = new adminModel();
    }

    //注册
    public function sign()
    {
        $response = $this->obj->sign();
        parent::ajaxReturn($response);
    }








}