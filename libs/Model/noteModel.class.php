<?php
namespace libs\Model;
class noteModel extends tableModel
{
	private static $table = 'note';
	protected static $note = ['id','noteId','note','caseId'];
}