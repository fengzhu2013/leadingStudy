<?php
namespace libs\Model;
class student_courseModel extends tableModel
{
	private static $table = student_course;
	protected static $student_course = ['id','stuId','courseId','secCourseId','dateinto'];
}