<?php
namespace libs\Model;
class course_goal_ablityModel extends tableModel
{
	private static $table = 'course_goal_ablity';
	protected static $course_goal_ablity = ['id','courseId','stageId','ablity'];
}