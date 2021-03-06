<?php
namespace App\common\Model;
use framework\libs\core\DB;
use framework\common\Model\paramModel;

class baseModel
{
    const   PAGE        = 1;        //当前页
    const   PAGESIZE    = 8;        //页容量
    const   USEREXPTIME = 21600;    //登录有效时间，6消失，单位秒
    private $user;                  //用户
    private $accNumber;             //登录账号
    private $isVerify;              //是否需要验证登录者身份
    private $isLogined;             //是否登录
    private $userInfo;              //登录者基本信息
    private $table;

    public  $_LP;
    public  $_LG;

    public function __construct($isVerify = true)
    {
        $this->isLogined = false;
        $this->isVerify  = $isVerify;
        if ($this->isVerify) {
            $this->checkIsLogined();
            if ($this->isLogined) {
                $this->getUserAccNumber();
            }
        }
        $obj = new paramModel();
        $this->_LP = $obj->getLP();
        $this->_LG = $obj->getLG();
    }

    private function checkIsLogined()
    {
        if(isset($_SESSION['user']) && !empty($_SESSION['user']) && $_SESSION['user']['user_expTime']){
            if (($_SESSION['user']['user_expTime'] + self::USEREXPTIME) > time()){
                $this->userInfo = $_SESSION['user'];
                $this->isLogined = true;
            }
        }
    }

    private function getUserAccNumber()
    {
        $caseId = $this->userInfo['caseId'];
        $obj = new tableInfoModel();
        $this->table = $obj->getTableByCase($caseId);
        $this->accNumber = $this->userInfo[$obj->getKeyByUser($this->table)];
    }

    public function getUserInfo()
    {
        return $this->userInfo;
    }
    public function getAccNumber()
    {
        return $this->accNumber;
    }

    public function checkParamAcc($accNumber)
    {
        if ($accNumber == $this->accNumber)
            return true;
        return false;
    }



    public function insert($table,$arr)
    {
        $obj = M($table);
        return $obj->insert($table,$arr);
    }

    public function insertSql($sql)
    {
        return DB::insertSql($sql);
    }

    public function deleteRow($table,$where)
    {
        $obj = M($table);
        return $obj->deleteRow($table,$where);
    }

    public function deleteArr($table,$where)
    {
        $obj = M($table);
        return $obj->deleteArr($table,$where);
    }

    public function updateInfo($table,$arr,$where)
    {
        $obj = M($table);
        return $obj->updateInfo($table,$arr,$where);
    }

    public function updateSql($sql)
    {
        return DB::updateSql($sql);
    }

    public function fetchOneSql($sql)
    {
        return DB::fetchOneSql($sql);
    }

    public function fetchOneInfo($table,$arr,$where)
    {
        $obj = M($table);
        return $obj->fetchOneInfo($table,$arr,$where);
    }

    public function fetchAllSql($sql)
    {
        return DB::fethcAllSql($sql);
    }

    public function fetchAllInfo($table,$arr,$where)
    {
        $obj = M($table);
        return $obj->fetchAllInfo($table,$arr,$where);
    }

    public function getNums($sql)
    {
        return DB::getNums($sql);
    }

    public function getNum($table,$arr,$where)
    {
        $obj = M($table);
        return $obj->getNum($table,$arr,$where);
    }


    /**
     * 验证信息是否安全
     * @param array $arr
     * @param array $all
     * @param boolean $type 默认验证 $arr 中的字段是否在$all中，反之亦然
     * @return number
     */
    public function verifyCount($arr,$all,$type = true)
    {
        if ($type)
            $arr   = array_diff_key($arr,array_flip($all));
        else
            $arr   = array_diff_key(array_flip($arr),$all);
        $count = count($arr);
        return $count;
    }

    /**
     * 格式化数据库返回的数据
     * @param $resp
     * @return array
     */
    public function formatDatabaseResponse($resp)
    {
        if (is_string($resp))                   //如果是字符串形式，转换成int
            $resp = intval($resp);
        if (is_int($resp)) {
            if ($resp > 0) {                    //如果大于0
                $data['status'] = 0;
                $data['info']   = $resp;
            } else {                            //等于0，默认failed
                $data['status'] = '10001';
            }
        }
        if (is_array($resp)) {                  //如果是数组
            if (count($resp)) {
                $data['status'] = 0;
                $data['info']   = $resp;
            } else {                            //数组为空，表示没有相关数据
                $data['status'] = '20003';
            }
        }
        return $data;
    }

    /**
     * 获得分页信息
     * @return mixed
     */
    public function getPages()
    {
        global $_LP;
        $pages['page'] = $_LP['page']?intval($_LP['page']):self::PAGE;
        $pages['pageSize'] = $_LP['pageSize']?intval($_LP['pageSize']):self::PAGESIZE;
        return $pages;
    }

    /**
     * 如果要检查登录，是否存在登录账号，不存在返回false
     * @return bool
     */
    public function verifyLogined()
    {
        //如果要检查登录，且不存在已登录的的账号，返回false
        if ($this->isVerify && !$this->getAccNumber())
            return false;
        return true;
    }

}