<?php
namespace libs\Model;
use framework\libs\core\DB;

class access_tokenModel extends tableModel
{
	private static $table = 'access_token';
	protected static $access_token = ['id','access_token','access_time'];

	public function getLastAccess()
    {
        $where = ['where2' => ' ORDER BY access_time DESC'];
        return DB::fetchOneInfo(self::$table,self::$access_token,$where);
    }

    public function setAccess($arr)
    {
        return DB::insert(self::$table,$arr);
    }



}