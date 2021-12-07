<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = [
	    'created_at',
	    'updated_at'
	];
    protected $filable = [
        'customer_name',
        'customer_email',
        'customer_password',
        'customer_phone',
        'customer_vip',
    ];
    protected $primaryKey = 'id';
    protected $table = 'customer';
}
