<?php
namespace libs\Model;
class leading_studentModel extends tableModel
{
	private static $table = leading_student;
	protected static $leading_student = ['id','stuId','name','password','mobile','email','status','caseId','dateinto','token','token_exptime'];
}