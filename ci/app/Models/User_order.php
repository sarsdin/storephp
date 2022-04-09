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
    ];
    protected $primaryKey = 'order_no';








}


