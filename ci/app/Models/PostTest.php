<?php

namespace App\Models;

use CodeIgniter\Model;

class PostTest extends Model
{
    /**
     * table name
     */
    protected $table = "posts";


    /**
     * allowed Field
     */
    protected $allowedFields = [
        'title',
        'content'
    ];
}
