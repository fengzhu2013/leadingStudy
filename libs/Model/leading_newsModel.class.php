<?php
namespace libs\Model;
class leading_newsModel extends tableModel
{
	private static $table = 'leading_news';
	protected static $leading_news = ['id','title','description','content','news_date','courseId','top','author'];
}