<?php
namespace libs\Model;
class vedioModel extends tableModel
{
	private static $table = vedio;
	protected static $vedio = ['id','vedioId','vedioName','description','vedioUrl','courseId','secCourseId','status','dateinto','author'];
}