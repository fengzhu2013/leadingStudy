<?php
namespace libs\Model;

class leading_forum_commentOnModel extends tableModel
{
    public    static $table = 'leading_forum_commentOn';
    protected static $leading_forum_commentOn = ['id','c_id','status','type','c_date'];
}