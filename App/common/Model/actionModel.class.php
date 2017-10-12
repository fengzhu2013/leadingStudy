<?php
namespace App\common\Model;

use libs\Model\course_goal_problemModel;

class actionModel extends baseModel
{
    private $accNumber;

    private $table;

    private $where;

    public function __construct($isVerify = false)
    {
        parent::__construct($isVerify);
    }

    /**
     * 获得班级的一条信息
     * @param $classId
     * @param array $arr
     * @return mixed
     */
    public function getClassInfoById($classId,$arr = [])
    {
        $this->table = tableInfoModel::getLeading_class();
        if (empty($arr))
            $arr = ['*'];
        $this->where = ['classId' => $classId];
        return parent::fetchOneInfo($this->table,$arr,$this->where);
    }

    public function formatMoreConditions($conditions,$delimiter)
    {

    }
}
