<?php
namespace libs\Model;
class tuitionModel extends tableModel
{
	private static $table = tuition;
	protected static $tuition = ['id','courseId','caseId','teaching','tuitionCase','tuitionMoney'];
}