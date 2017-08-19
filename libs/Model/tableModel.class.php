<?php
namespace libs\Model;
use framework\libs\core\DB;
class tableModel
{
    protected static $talbe;
    protected static $tableArr;

    public function getArrByTable($table)
    {
        return static::${$table};
    }

    public function query($sql)
    {
        return DB::query($sql);
    }

    public function insert($table,$arr)
    {
        return DB::insert($table,$arr);
    }

    public function insertSql($sql)
    {
        return DB::insertSql($sql);
    }

    /**
     * @param $table
     * @param $where string
     * @return mixed
     */
    public function deleteRow($table,$where)
    {
        return DB::deleteRow($table,$where);
    }

    /**
     * @param $table
     * @param $where array
     * @return mixed
     */
    public function deleteArr($table,$where)
    {
        return DB::deleteArr($table,$where);
    }

    public function getTableArr($table)
    {
        $tableArr = null;
        if (is_array($table)) {
            $obj_1 = M("$table[0]");
            $tableArr[0] = $obj_1->getArrByTable($table[0]);
            $obj_2 = M("$table[1]");
            $tableArr[1] = $obj_2->getArrByTable($table[1]);
        }
        return $tableArr;
    }

    public function updateInfo($table,$arr,$where)
    {
        $tableArr = $this->getTableArr($table);
        return DB::updateInfo($table,$arr,$where,$tableArr);
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
        $tableArr = $this->getTableArr($table);
        return DB::fetchOneInfo($table,$arr,$where,$tableArr);
    }

    public function fetchAllSql($sql)
    {
        return DB::fetchAllSql($sql);
    }

    public function fetchAllInfo($table,$arr,$where)
    {
        $tableArr = $this->getTableArr($table);
        return DB::fetchAllInfo($table,$arr,$where,$tableArr);
    }

    public function getNums($sql)
    {
        return DB::getNums($sql);
    }

    public function getNum($table,$arr,$where)
    {
        $tableArr = $this->getTableArr($table);
        return DB::getNum($table,$arr,$where,$tableArr);
    }

}