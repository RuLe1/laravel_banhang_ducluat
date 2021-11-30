<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = [
	    'created_at',
	    'updated_at'
	];
    protected $filable = [
        'name_quanhuyen',
        'type',
        'matp'
    ];
    protected $primaryKey = 'maqh';
    protected $table = 'quanhuyen';
}
