<?php

namespace App\Models;

class Product extends \CodeIgniter\Model
{
    protected $table = 'product';
    protected $allowedFields = ['product_no', 'category_code', 'product_name', 'product_price', 'product_stock', 'product_desc', 'product_date', 'product_hit', 'product_purchasehit', 'product_spec' ];
    protected $primaryKey = 'product_no';
















}