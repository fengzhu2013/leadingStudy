<?php
namespace libs\Model;

class leading_forum_articleModel extends tableModel
{

    private   static $table = 'leading_forum_article';
    protected static $leading_forum_article = ['fa_id','title','keywords','content','picUrl','fa_data','author','url'];
}
