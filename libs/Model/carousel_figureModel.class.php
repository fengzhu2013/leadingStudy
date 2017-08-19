<?php
namespace libs\Model;
class carousel_figureModel extends tableModel
{
	private static $table = carousel_figure;
	protected static $carousel_figure = ['id','picId','picName','description','picUrl','courseId','status','pic_type','top'];
}