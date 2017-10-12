<?php
namespace libs\Model;
class leading_projectModel extends tableModel
{
	private static $table = 'leading_project';
	protected static $leading_project = ['projectId','projectName','description','status','startTime','endTime','picUrl','url','people','type','relationship'];
}