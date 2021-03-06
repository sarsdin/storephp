<?php

namespace App\Models;

class Deliver_address extends \CodeIgniter\Model
{
    protected $table = 'deliver_address';
    protected $allowedFields = [
        'address_no',
        'user_id',
        'user_address1',
        'user_address2',
        'user_address3',
        'user_name',
        'user_phone',
        'basic_address'
    ];
    protected $primaryKey = 'address_no';
}
