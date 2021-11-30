<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = [
	    'created_at',
	    'updated_at'
	];
    protected $filable = [
        'slider_name',
        'slider_image',
        'slider_desc',
        'status'
    ];
    protected $primaryKey = 'id';
    protected $table = 'slider';
}
