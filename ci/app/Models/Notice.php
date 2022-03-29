<?php

namespace App\Models;

class Notice extends \CodeIgniter\Model
{
    protected $table = 'notice';
    protected $allowedFields = ['notice_no', 'notice_writer', 'notice_title', 'notice_content', 'notice_date', 'notice_hit'];
    protected $primaryKey = 'notice_no';




}