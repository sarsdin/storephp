<?php

namespace App\Models;

class Cart extends \CodeIgniter\Model
{
    protected $table = 'cart';  //결제 위한 장바구니
    protected $allowedFields = [
        'cart_no',
        'product_no',
        'cart_owner',
        'product_count',

    ];
    protected $primaryKey = 'cart_no';
}
