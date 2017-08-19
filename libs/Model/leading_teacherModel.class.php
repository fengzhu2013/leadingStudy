<?php
namespace libs\Model;
class leading_teacherModel extends tableModel
{
	private static $table = leading_teacher;
	protected static $leading_teacher = ['id','teacherId','name','mobile','email','password','caseId','token','token_exptime','status','dateinto'];
}