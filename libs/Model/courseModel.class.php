<?php
namespace libs\Model;
class courseModel extends tableModel
{
	private static $table = 'course';
	protected static $course = ['courseId','courseName','status','description'];
}