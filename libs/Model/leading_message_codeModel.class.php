<?php
namespace libs\Model;

class leading_message_codeModel extends tableModel
{
    private $table = 'leading_message_code';
    protected $leading_message_code = ['id','msg_code','create_time','d_count','mobile'];
}
