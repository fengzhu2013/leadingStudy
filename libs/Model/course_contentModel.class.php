<?php
namespace libs\Model;
class course_contentModel extends tableModel
{
	private static $table = course_content;
	protected static $course_content = ['id','courseId','stageId','content','focus'];
}