<?php
namespace App\index\Controller;

use App\common\Controller\baseController;

class indexController extends baseController {

    public function __construct()
    {

    }

    public function index()
    {
        $str = '中文a字符1';
        echo strlen($str);
        echo '<br />';
        echo mb_strlen($str,'UTF8');
    }

    public function test()
    {

    }
}