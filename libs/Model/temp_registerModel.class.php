<?php
namespace libs\Model;
class temp_registerModel extends tableModel
{
	private static $table = temp_register;
	protected static $temp_register = ['id','tmpId','recommendId','caseId','mobile','email','qq','wechat','name','password','dateinto','status','token','token_exptime'];
}