<?php
namespace libs\Model;
class course_stageModel extends tableModel
{
	private static $table = 'course_stage';
	protected static $course_stage = ['stageId','stageName','courseId'];
}