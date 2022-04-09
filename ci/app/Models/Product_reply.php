<?php

namespace App\Models;

class Product_reply extends \CodeIgniter\Model
{
    protected $table = 'product_reply';
    protected $allowedFields = [
        'reply_no',
        'product_no',
        'content',
        'writer',
        'write_date',
        'delete_date',
        'parent_reply_no',
        'parent_reply_writer',
        'reply_order',
        'reply_group'
    ];
    protected $primaryKey = 'reply_no';









}