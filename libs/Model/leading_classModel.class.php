<?php
namespace libs\Model;
class leading_classModel extends tableModel
{
	private static $table = leading_class;
	protected static $leading_class = ['classId','courseId','className','startClassTime','masterId','classType','addressId','endClassTime'];
}