<?php
namespace libs\Model;
class teaching_courseModel extends tableModel
{
	private static $table = 'teaching_course';
	protected static $teaching_course = ['id','teacherId','courseId','secCourseId','dateinto'];
}