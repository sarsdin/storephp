<?php

namespace App\Models;

class User_order extends \CodeIgniter\Model
{
    protected $table = 'user_order';
    protected $allowedFields = [
        'order_no',
        'user_id',
        'order_date',
        'address1',
        'address2',
        'address3',
        'receiver_name',
        'receiver_phone',
        'request',
        'receipt_id',
        'purchased_at',
        'method',
        'product_name',
        'card_name',
        'verify_valid',
        'is_cancel',
        'card_no',
        'product_image',
        'product_price',
        'order_state',
        'cancel_msg',
        'transport_code'

    ];
    protected $primaryKey = 'order_no';








}
