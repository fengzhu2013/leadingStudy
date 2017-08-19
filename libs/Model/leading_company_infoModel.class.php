<?php
namespace libs\Model;
class leading_company_infoModel extends tableModel
{
	private static $table = leading_company_info;
	protected static $leading_company_info = ['id','compId','unionCode','description','startTime','unionTime','address','picUrl','licenseUrl','tel','legalPerson'];
}