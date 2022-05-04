<?php

namespace App\Models;

class Userorder_detail extends \CodeIgniter\Model
{
    protected $table = 'userorder_detail';
    protected $allowedFields = [ //detail안에 order번호와 그에 따른 상품들이 주욱 나열됨
        'order_detail_no',
        'order_no',
        'product_no',
        'product_count',
        'product_price',
        'order_detail_status',
        'refund_check',
        'is_review_created'
    ];
    protected $primaryKey = 'order_detail_no';
}

