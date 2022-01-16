<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = [
	    'created_at',
	    'updated_at'
	];
    protected $fillable = [
        'coupon_name',
        'coupon_code',
        'coupon_time',
        'coupon_condition',
        'coupon_number'
    ];
    protected $primaryKey = 'id';
    protected $table = 'coupon';
}
