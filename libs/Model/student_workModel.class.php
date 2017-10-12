<?php
namespace libs\Model;
class student_workModel extends tableModel
{
	private static $table = 'student_work';
	protected static $student_work = ['id','stuId','compName','compAddress','jobName','salary','treatment','dateWork','workOut','description'];
}