<?php
namespace App\api\Model;

use App\common\Model\actionModel;
use App\common\Model\baseModel;
use App\common\Model\tableInfoModel;

class editModel extends baseModel
{
    private $table;
    private $where;

    public function __construct($isVerify = true)
    {
        parent::__construct($isVerify);
    }

    public function getStudentListForClass()
    {
        //不存在classId
        if (!$this->_LP['classId'])
            return '20001';
        $obj         = new actionModel();
        $res         = $obj->getClassInfoById($this->_LP['classId'],['ClassName']);
        //classId 错误
        if (!count($res))
            return '50004';
        $this->table = [tableInfoModel::getLeading_student(),tableInfoModel::getLeading_student_info()];
        $this->where = ['classId' => $this->_LP['classId'],'where2' => ' AND s.`stuId`= f.`stuId` '];
        $pages       = parent::getPages();
        $arr         = ['stuId','name','dateinto'];
        return getPage($this->table,$arr,$this->where,$pages['page'],$pages['pageSize']);
    }
}