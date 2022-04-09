<?php

namespace App\Models;

class Product_image extends \CodeIgniter\Model
{
    protected $table = 'product_image';
    protected $allowedFields = ['image_no', 'product_no', 'origin_file_name', 'stored_file_name', 'delegate_thumbnail', 'create_date', 'delete_check'];
    protected $primaryKey = 'image_no';
}