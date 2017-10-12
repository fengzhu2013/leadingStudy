<?php
namespace App\api\Model;

use App\common\Model\baseModel;
use App\common\Model\tableInfoModel;

class companyModel extends baseModel
{
    private $table;
    private $where;
    private $accNumber;
    private $pages = [];
    public function __construct($isVerify = true)
    {
        parent::__construct($isVerify);
    }

    /**
     * 通过职位id获得所有的职位信息
     * @param $jobId
     * @param array $arr
     * @return mixed
     */
    public function getJobInfoById($jobId,$arr = [])
    {
        $this->table = tableInfoModel::getLeading_job();
        $this->where = ['jobId' => $jobId];
        if (empty($arr))
            $arr = ['*'];
        return parent::fetchOneInfo($this->table,$arr,$this->where);
    }

    /**
     * 获得企业的所有招聘信息
     * @param string $accNumber
     * @param array $arr
     * @return string
     */
    public function getJobList($accNumber = '',$arr = [])
    {
        extract($this->_LP);
        $this->accNumber = $this->getAccNumber();
        if (empty($this->getAccNumber()) && $accNumber)
            $this->accNumber = $accNumber;
        $this->where = ['where2' => ' ORDER BY jobDate DESC'];
        //如果存在企业号，加入搜索条件
        if (!empty($this->accNumber))
            $this->where['compId'] = $this->accNumber;
        //如果存在状态值，加入搜索条件
        if (isset($status))
            $this->where['status'] = $status;
        //默认按时间排序，可以升序或降序
        if (!empty($jobDate))
            $this->where['where2'] = ' ORDER BY jobDate '.$jobDate;
        $this->table = tableInfoModel::getLeading_job();
        //默认获得职位的所有信息
        if (empty($arr))
            $arr = ['*'];
        //有分页信息，获得当前页信息
        if ($this->_LP['page'])
            $this->pages = parent::getPages();
        if (count($this->pages))
            return getPage($this->table,$arr,$this->where,$this->pages['page'],$this->pages['pageSize']);
        return parent::fetchAllInfo($this->table,$arr,$this->where);
    }



}