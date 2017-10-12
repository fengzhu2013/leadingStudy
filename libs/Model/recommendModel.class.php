<?php
namespace libs\Model;
class recommendModel extends tableModel
{
	private static $table = 'recommend';
	protected static $recommend = ['id','recommendId','stuId','dateinto'];
}