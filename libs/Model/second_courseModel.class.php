<?php
namespace libs\Model;
class second_courseModel extends tableModel
{
	private static $table = 'second_course';
	protected static $second_course = ['id','courseId','secCourseId','description','content','status','startDate','picUrl','vedioUrl'];
}