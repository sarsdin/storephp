<?php

namespace App\Models;

class Order_qa extends \CodeIgniter\Model
{
    protected $table = 'order_qa';
    protected $allowedFields = [
        'order_qa_no',
        'order_no',
        'order_qa_writer',
        'order_qa_content',
        'order_qa_date',

    ];
    protected $primaryKey = 'order_qa_no';
}
