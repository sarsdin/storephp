<?php

namespace App\Models;

class Notice_reply extends \CodeIgniter\Model
{
    protected $table = 'notice_reply';
    protected $allowedFields = [
        'notice_reply_no',
        'notice_no',
        'notice_reply_writer',
        'notice_reply_content',
        'notice_reply_writedate',
        'notice_reply_deletedate',
        'parent_reply_no',
        'parent_reply_writer',
        'reply_order',
        'reply_group'
    ];
    protected $primaryKey = 'notice_reply_no';
}