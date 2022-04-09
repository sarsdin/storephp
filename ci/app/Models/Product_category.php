<?php

namespace App\Models;

class Product_category extends \CodeIgniter\Model
{
    protected $table = 'product_category';
    protected $allowedFields = ['category_code', 'category_name'];
    protected $primaryKey = 'category_code';
}