<?php
namespace libs\Model;
class leading_signModel extends tableModel
{
	private static $table = leading_sign;
	protected static $leading_sign = ['id','name','addressId','courseId','mobile','qq','wechat','sign_type','signTime','classId'];
}