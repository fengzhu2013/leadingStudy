<?php
namespace libs\Model;
class login_logModel extends tableModel
{
	private static $table = login_log;
	protected static $login_log = ['id','caseId','accNumber','loginTime'];
}