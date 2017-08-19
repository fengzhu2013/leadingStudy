<?php
namespace libs\Model;
class teacher_coursewareModel extends tableModel
{
	private static $table = teacher_courseware;
	protected static $teacher_courseware = ['id','teacherId','secCourseId','description','url','caseId','dateinto'];
}