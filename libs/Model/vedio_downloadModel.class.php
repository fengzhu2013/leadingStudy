<?php
namespace libs\Model;
class vedio_downloadModel extends tableModel
{
	private static $table = vedio_download;
	protected static $vedio_download = ['id','vedioId','accNumber','downTime','caseId'];
}