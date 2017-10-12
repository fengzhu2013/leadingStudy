<?php
namespace libs\Model;
class student_projectModel extends tableModel
{
	private static $table = 'student_project';
	protected static $student_project = ['id','projectId','stuId','assess','stuDescription','professional'];
}