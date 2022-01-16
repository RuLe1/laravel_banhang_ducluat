<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $dates = [
	    'created_at',
	    'updated_at'
	];
    protected $fillable = [
        'id',
        'gallery_name',
        'gallery_image',
        'product_id'
    ];
    protected $primaryKey = 'id';
    protected $table = 'gallery';
}
