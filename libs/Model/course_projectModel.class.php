<?php
namespace libs\Model;
class course_projectModel extends tableModel
{
	private static $table = 'course_project';
	protected static $course_project = ['id','courseId','projectId','teacherId'];
}