<?php
namespace libs\Model;
class access_tokenModel extends tableModel
{
	private static $table = access_token;
	protected static $access_token = ['id','access_token','access_time'];
}