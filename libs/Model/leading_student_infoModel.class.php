<?php
namespace libs\Model;
class leading_student_infoModel extends tableModel
{
	private static $table = 'leading_student_info';
	protected static $leading_student_info = ['id','sex','stuId','age','otherMobile','classId','eduBacId','ecardId','bloodType','homeAddress','picUrl','qq','wechat','provinceId','description','dateout','ls_assess'];
}