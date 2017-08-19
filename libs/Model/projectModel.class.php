<?php
namespace libs\Model;
class projectModel extends tableModel
{
	private static $table = project;
	protected static $project = ['projectId','projectName','description','status','startTime','endTime','picUrl','url','people','type'];
}