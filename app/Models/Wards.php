<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = [
	    'created_at',
	    'updated_at'
	];
    protected $filable = [
        'name_xaphuong',
        'type',
        'maqh'
    ];
    protected $primaryKey = 'xaid';
    protected $table = 'xaphuongthitran';
}
