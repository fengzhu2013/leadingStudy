<?php
namespace libs\Model;
class concernModel extends tableModel
{
	private static $table = concern;
	protected static $concern = ['id','concern','concerned','conTime'];
}