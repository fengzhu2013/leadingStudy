<?php
namespace libs\Model;
class leading_companyModel extends tableModel
{
	private static $table = leading_company;
	protected static $leading_company = ['id','compId','compName','status','mobile','email','token','token_exptime','password','password','caseId'];
}