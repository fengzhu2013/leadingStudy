<?php
namespace libs\Model;
class leading_jobModel extends tableModel
{
	private static $table = 'leading_job';
	protected static $leading_job = ['jobId','compId','jobName','status','people','duty','demand','treatment','workAddress','jobDate','eduBacId'];
}