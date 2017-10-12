<?php
namespace libs\Model;
class course_goal_problemModel extends tableModel
{
	private static $table = 'course_goal_problem';
	protected static $course_goal_problem = ['id','courseId','stageId','problem'];
}