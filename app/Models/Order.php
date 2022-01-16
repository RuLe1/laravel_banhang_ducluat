<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = [
	    'created_at',
	    'updated_at'
	];
    protected $fillable = [
        'order_code',
        'customer_id',
        'shipping_id',
        'order_status',
        'created_at'
    ];
    protected $primaryKey = 'id';
    protected $table = 'order';
}
