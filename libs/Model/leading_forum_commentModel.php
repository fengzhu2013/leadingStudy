<?php
namespace libs\Model;

class leading_forum_commentModel extends tableModel
{
    private   static $table = 'leading_forum_comment';
    protected static $leading_forum_comment = ['fc_id','fa_id','fc_accNumber','l_accNumber','content','fc_date'];
}