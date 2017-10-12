<?php
namespace libs\Model;
class leading_teacher_infoModel extends tableModel
{
	private static $table = 'leading_teacher_info';
	protected static $leading_teacher_info = ['id','teacherId','sex','title','description','picUrl','age'];
}