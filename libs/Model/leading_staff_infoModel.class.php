<?php
namespace libs\Model;
class leading_staff_infoModel extends tableModel
{
	private static $table = 'leading_staff_info';
	protected static $leading_staff_info = ['id','accNumber','name','mobile','email','otherTel','password','workTime','email','caseId','status','rangeId','token','token_exptime'];
}