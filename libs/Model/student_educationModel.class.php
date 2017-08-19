<?php
namespace libs\Model;
class student_educationModel extends tableModel
{
	private static $table = student_education;
	protected static $student_education = ['id','stuId','major','eduSchool','dateinto','dateout','highest'];
}