<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = [
	    'created_at',
	    'updated_at'
	];
    protected $filable = [
        'name_city',
        'type',
    ];
    protected $primaryKey = 'matp';
    protected $table = 'tinhthanhpho';
}
