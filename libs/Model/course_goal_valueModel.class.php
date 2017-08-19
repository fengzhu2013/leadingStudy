<?php
namespace libs\Model;
class course_goal_valueModel extends tableModel
{
	private static $table = course_goal_value;
	protected static $course_goal_value = ['id','courseId','stageId','value'];
}